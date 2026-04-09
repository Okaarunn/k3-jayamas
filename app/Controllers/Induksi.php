<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Dompdf\Options;
use Dompdf\Dompdf;

class Induksi extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function currentUserPlantId(): ?int
    {
        $user = $this->db->table('users')
            ->select('plant_id')
            ->where('id', user_id())
            ->get()->getRow();

        return $user->plant_id ?? null;
    }

    // JOIN dengan tabel absensi
    private function getInduksi(int $id = 0)
    {
        $builder = $this->db->table('induksi i');
        $builder->select('
            i.*, 
            u.username as created_by_username, 
            u.plant_id as creator_plant_id, 
            pl.nama_plant, 
            GROUP_CONCAT(ia.filename) as absensi_files
        ');
        $builder->join('users u', 'u.id = i.created_by', 'left');
        $builder->join('plant pl', 'pl.id = u.plant_id', 'left');


        $builder->join('induksi_absensi ia', 'ia.induksi_id = i.id', 'left');
        $builder->where('i.deleted_at IS NULL');
        $builder->groupBy('i.id');

        if (!in_groups('administrator')) {
            $builder->where('u.plant_id', $this->currentUserPlantId());
        }

        if ($id > 0) {
            $builder->where('i.id', $id);
            return $builder->get()->getRow();
        }

        $result = $builder->orderBy('i.tanggal_induksi', 'DESC')->get()->getResult();

        // ambil absensi per induksi
        foreach ($result as $row) {
            // absensi
            $row->absensi = $this->db->table('induksi_absensi')
                ->where('induksi_id', $row->id)
                ->get()
                ->getResult();

            // dokumentasi
            $row->dokumentasi = $this->db->table('induksi_dokumentasi')
                ->where('induksi_id', $row->id)
                ->get()
                ->getResult();
        }

        return $result;
    }

    private function canModify(object $row): bool
    {
        if (in_groups('administrator')) return true;

        $myPlantId = (int) $this->currentUserPlantId();
        return $myPlantId === (int) $row->creator_plant_id;
    }

    private function uploadFile(string $fieldName, string $uploadDir = 'uploads/induksi/')
    {
        $files = $this->request->getFiles();
        $results = [];

        if (!isset($files[$fieldName])) return [];

        foreach ($files[$fieldName] as $file) {
            if (!$file->isValid() || $file->hasMoved()) continue;

            $uploadPath = FCPATH . $uploadDir;
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0755, true);

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            $results[] = [
                'filename' => $newName,
                'original' => $file->getClientName(),
                'mime'     => $file->getClientMimeType(),
                'size'     => $file->getSize()
            ];
        }

        return $results;
    }

    private function deleteFile(?string $filename)
    {
        if (!$filename) return;

        $path = FCPATH . 'uploads/induksi/' . $filename;
        if (file_exists($path)) unlink($path);
    }

    public function index()
    {
        return view('induksi/induksi', [
            'title'     => 'Data Induksi K3',
            'induksi'   => $this->getInduksi(),
            'myPlantId' => $this->currentUserPlantId(),
        ]);
    }

    public function create()
    {
        return view('induksi/create', [
            'title'  => 'Tambah Induksi',
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function store()
    {
        $this->db->transStart();

        // insert induksi utama
        $this->db->table('induksi')->insert([
            'tanggal_induksi' => $this->request->getPost('tanggal_induksi'),
            'jumlah_peserta'  => (int) $this->request->getPost('jumlah_peserta'),
            'keterangan'      => $this->request->getPost('keterangan'),
            'created_by'      => user_id(),
            'updated_by'      => user_id(),
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
        ]);

        $induksiId = $this->db->insertID();

        // dokumentasi
        $dokumentasi = $this->uploadFile('dokumentasi');

        foreach ($dokumentasi as $f) {
            $this->db->table('induksi_dokumentasi')->insert([
                'induksi_id'   => $induksiId,
                'filename'     => $f['filename'],
                'original_name' => $f['original'],
                'mime'         => $f['mime'],
                'size'         => $f['size'],
            ]);
        }

        // absensi
        $absensi = $this->uploadFile('absensi');
        foreach ($absensi as $f) {
            $this->db->table('induksi_absensi')->insert([
                'induksi_id'   => $induksiId,
                'filename'     => $f['filename'],
                'original_name' => $f['original'],
                'mime'         => $f['mime'],
                'size'         => $f['size'],
            ]);
        }
        $this->db->transComplete();

        return redirect()->to('/induksi')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $row = $this->getInduksi($id);

        if (!$row || !$this->canModify($row)) {
            return redirect()->to('/induksi')->with('error', 'Tidak ada akses');
        }

        $documentations = $this->db->table('induksi_dokumentasi')
            ->where('induksi_id', $id)
            ->get()
            ->getResult();

        $absensi = $this->db->table('induksi_absensi')
            ->where('induksi_id', $id)
            ->get()
            ->getResult();

        return view('induksi/edit', [
            'induksi' => $row,
            'documentations'   => $documentations,
            'absensi' => $absensi,
            'title'   => 'Edit Induksi'
        ]);
    }

    public function update($id)
    {
        $row = $this->getInduksi($id);

        if (!$row || !$this->canModify($row)) {
            return redirect()->to('/induksi')->with('error', 'Tidak ada akses');
        }

        $this->db->transStart();

        $this->db->table('induksi')->where('id', $id)->update([
            'tanggal_induksi' => $this->request->getPost('tanggal_induksi'),
            'jumlah_peserta'  => $this->request->getPost('jumlah_peserta'),
            'keterangan'      => $this->request->getPost('keterangan'),
            'updated_by'      => user_id(),
            'updated_at'      => date('Y-m-d H:i:s'),
        ]);

        $deleteIds = $this->request->getPost('delete_absensi_ids');
        if (!empty($deleteIds)) {
            if (!is_array($deleteIds)) {
                $deleteIds = [$deleteIds];
            }

            foreach ($deleteIds as $deleteId) {
                $fileRow = $this->db->table('induksi_absensi')
                    ->select('filename')
                    ->where('id', $deleteId)
                    ->where('induksi_id', $id)
                    ->get()
                    ->getRow();

                if ($fileRow) {
                    $this->deleteFile($fileRow->filename);
                    $this->db->table('induksi_absensi')->where('id', $deleteId)->delete();
                }
            }
        }

        $deleteDocIds = $this->request->getPost('delete_dokumentasi_ids');
        if (!empty($deleteDocIds)) {
            if (!is_array($deleteDocIds)) {
                $deleteDocIds = [$deleteDocIds];
            }

            foreach ($deleteDocIds as $deleteId) {
                $fileRow = $this->db->table('induksi_dokumentasi')
                    ->select('filename')
                    ->where('id', $deleteId)
                    ->where('induksi_id', $id)
                    ->get()
                    ->getRow();

                if ($fileRow) {
                    $this->deleteFile($fileRow->filename);
                    $this->db->table('induksi_dokumentasi')->where('id', $deleteId)->delete();
                }
            }
        }

        // upload tambahan absensi baru (tidak hapus lama)
        $files = $this->uploadFile('absensi');

        foreach ($files as $f) {
            $this->db->table('induksi_absensi')->insert([
                'induksi_id'   => $id,
                'filename'     => $f['filename'],
                'original_name' => $f['original'],
                'mime'         => $f['mime'],
                'size'         => $f['size'],
            ]);
        }

        // upload tambahan dokumentasi baru (tidak hapus lama)
        $docFiles = $this->uploadFile('dokumentasi');

        foreach ($docFiles as $f) {
            $this->db->table('induksi_dokumentasi')->insert([
                'induksi_id'   => $id,
                'filename'     => $f['filename'],
                'original_name' => $f['original'],
                'mime'         => $f['mime'],
                'size'         => $f['size'],
            ]);
        }

        $this->db->transComplete();

        return redirect()->to('/induksi')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $row = $this->getInduksi($id);

        if (!$row || !$this->canModify($row)) {
            return redirect()->to('/induksi')->with('error', 'Tidak ada akses');
        }

        $this->db->table('induksi')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/induksi')->with('success', 'Data dihapus');
    }

    public function export()
    {
        $data = $this->getInduksi();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Peserta');
        $sheet->setCellValue('D1', 'Keterangan');
        $sheet->setCellValue('E1', 'Dicatat Oleh');
        $sheet->setCellValue('F1', 'Dokumentasi');
        $sheet->setCellValue('G1', 'Absensi');

        // STYLE HEADER (bold)
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $rowNum = 2;
        $no = 1;
        $imgHeight = 60; // smaller for multiple images
        $offsetIncrement = 65; // space between images

        foreach ($data as $row) {
            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValue('B' . $rowNum, $row->tanggal_induksi);
            $sheet->setCellValue('C' . $rowNum, $row->jumlah_peserta);
            $sheet->setCellValue('D' . $rowNum, $row->keterangan);
            $sheet->setCellValue('E' . $rowNum, $row->created_by_username ?? '-');

            // height row
            $rowHeight = 50;
            $sheet->getRowDimension($rowNum)->setRowHeight($rowHeight);

            // Dokumentasi - all images
            $offsetY = 2;
            if (!empty($row->dokumentasi)) {
                foreach ($row->dokumentasi as $doc) {
                    $path = FCPATH . 'uploads/induksi/' . $doc->filename;
                    if (file_exists($path)) {
                        $drawing = new Drawing();
                        $drawing->setPath($path);
                        $drawing->setHeight($imgHeight);
                        $drawing->setCoordinates('E' . $rowNum);
                        $drawing->setOffsetX(2);
                        $drawing->setOffsetY($offsetY);
                        $drawing->setWorksheet($sheet);
                        $offsetY += $offsetIncrement;
                    }
                }
            }

            // Absensi - all images in flex layout
            if (!empty($row->absensi)) {
                $count = count($row->absensi);
                foreach ($row->absensi as $index => $abs) {
                    $path = FCPATH . 'uploads/induksi/' . $abs->filename;
                    if (file_exists($path)) {
                        $drawing = new Drawing();
                        $drawing->setPath($path);
                        $drawing->setHeight($imgHeight);
                        $drawing->setCoordinates('F' . $rowNum);
                        // Flex layout: 2 per row
                        $col = $index % 2;
                        $rowOffset = floor($index / 2);
                        $drawing->setOffsetX(2 + $col * $offsetIncrement);
                        $drawing->setOffsetY(2 + $rowOffset * $offsetIncrement);
                        $drawing->setWorksheet($sheet);
                    }
                }
            }

            $rowNum++;
        }

        // AUTO SIZE COLUMN
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);

        $writer = new Xlsx($spreadsheet);

        // FILE NAME
        $filename = 'induksi_k3_' . date('Ymd_His') . '.xlsx';

        // HEADER DOWNLOAD
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function exportPdf()
    {
        $data = $this->getInduksi();

        $html = view('induksi/export_pdf', ['induksi' => $data]);

        $options = new Options();
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream('induksi_k3_' . date('Ymd_His') . '.pdf', [
            'Attachment' => true
        ]);
    }
}
