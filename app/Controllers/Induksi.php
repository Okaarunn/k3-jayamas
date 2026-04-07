<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// image excel
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

    //    get plant user id
    private function currentUserPlantId(): ?int
    {
        $user = $this->db->table('users')
            ->select('plant_id')
            ->where('id', user_id())
            ->get()->getRow();

        return $user->plant_id ?? null;
    }

    // get data induksi where plant id
    private function getInduksi(int $id = 0)
    {
        $builder = $this->db->table('induksi i');
        $builder->select('i.*, u.username as created_by_username, u.plant_id as creator_plant_id, pl.nama_plant, pl.kode_plant');
        $builder->join('users u', 'u.id = i.created_by', 'left');
        $builder->join('plant pl', 'pl.id = u.plant_id', 'left');
        $builder->where('i.deleted_at IS NULL');

        // non-admin hanya lihat data dari plant sendiri
        if (! in_groups('administrator')) {
            $builder->where('u.plant_id', $this->currentUserPlantId());
        }

        if ($id > 0) {
            $builder->where('i.id', $id);
            return $builder->get()->getRow();
        }

        return $builder->orderBy('i.tanggal_induksi', 'DESC')->get()->getResult();
    }

    // can modify if user is admin or creator from same plant
    private function canModify(object $row): bool
    {
        if (in_groups('administrator')) {
            return true;
        }

        $myPlantId      = (int) $this->currentUserPlantId();
        $creator        = $this->db->table('users')
            ->select('plant_id')
            ->where('id', $row->created_by)
            ->get()->getRow();
        $creatorPlantId = (int) ($creator->plant_id ?? 0);

        return $myPlantId !== 0 && $myPlantId === $creatorPlantId;
    }


    // upload file
    private function uploadFile(string $fieldName, string $uploadDir = 'uploads/induksi/'): array
    {
        $file = $this->request->getFile($fieldName);

        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return [null, null, null, null];
        }

        $uploadPath = FCPATH . $uploadDir;
        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $origName = $file->getClientName();
        $mime     = $file->getClientMimeType(); // sebelum move()
        $size     = $file->getSize();
        $newName  = $file->getRandomName();

        $file->move($uploadPath, $newName);

        return [$newName, $origName, $mime, $size];
    }


    // delete file
    private function deleteFile(?string $filename, string $uploadDir = 'uploads/induksi/'): void
    {
        if (empty($filename)) return;

        $path = FCPATH . $uploadDir . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
    }


    // send data induksi to view
    public function index()
    {
        $data = [
            'title'     => 'Data Induksi K3',
            'induksi'   => $this->getInduksi(),
            'myPlantId' => $this->currentUserPlantId(),
        ];
        return view('induksi/induksi', $data);
    }


    // form create
    public function create()
    {
        $data = [
            'title'  => 'Tambah Induksi',
            'errors' => session()->getFlashdata('errors') ?? [],
        ];
        return view('induksi/create', $data);
    }


    // insert data induksi
    public function store()
    {
        $rules = [
            'tanggal_induksi' => 'required|valid_date[Y-m-d]',
            'jumlah_peserta'  => 'required|integer|greater_than[0]',
            'keterangan'      => 'permit_empty|max_length[1000]',
        ];
        // UPLOAD FILE
        [$filename, $origName, $mime, $size] = $this->uploadFile('dokumentasi');
        [$absensiFilename, $absensiOrigName, $absensiMime, $absensiSize] = $this->uploadFile('dokumentasi_absensi');

        // INSERT
        $this->db->table('induksi')->insert([
            'tanggal_induksi'                   => $this->request->getPost('tanggal_induksi'),
            'jumlah_peserta'                    => (int) $this->request->getPost('jumlah_peserta'),
            'keterangan'                        => $this->request->getPost('keterangan'),

            'dokumentasi_filename'              => $filename,
            'dokumentasi_original_name'         => $origName,
            'dokumentasi_mime'                  => $mime,
            'dokumentasi_size'                  => $size,

            'dokumentasi_absensi_filename'      => $absensiFilename,
            'dokumentasi_absensi_original_name' => $absensiOrigName,
            'dokumentasi_absensi_mime'          => $absensiMime,
            'dokumentasi_absensi_size'          => $absensiSize,

            'created_by' => user_id(),
            'updated_by' => user_id(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Data induksi berhasil ditambahkan.');
        return redirect()->to('/induksi');
    }

    // form edit
    public function edit(int $id = 0)
    {
        $row = $this->getInduksi($id);

        if (empty($row)) {
            session()->setFlashdata('error', 'Data induksi tidak ditemukan.');
            return redirect()->to('/induksi');
        }

        if (! $this->canModify($row)) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses untuk mengedit data dari plant lain.');
            return redirect()->to('/induksi');
        }

        $data = [
            'title'   => 'Edit Induksi',
            'induksi' => $row,
            'errors'  => session()->getFlashdata('errors') ?? [],
        ];
        return view('induksi/edit', $data);
    }

    // update data induksi
    public function update(int $id = 0)
    {
        $row = $this->getInduksi($id);

        if (empty($row)) {
            session()->setFlashdata('error', 'Data induksi tidak ditemukan.');
            return redirect()->to('/induksi');
        }

        if (! $this->canModify($row)) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses untuk mengubah data dari plant lain.');
            return redirect()->to('/induksi');
        }

        $rules = [
            'tanggal_induksi'     => 'required|valid_date[Y-m-d]',
            'jumlah_peserta'      => 'required|integer|greater_than[0]',
            'keterangan'          => 'permit_empty|max_length[1000]',
            'dokumentasi'         => 'permit_empty|uploaded[dokumentasi]|max_size[dokumentasi,5120]|ext_in[dokumentasi,jpg,jpeg,png,pdf]',
            'dokumentasi_absensi' => 'permit_empty|uploaded[dokumentasi_absensi]|max_size[dokumentasi_absensi,5120]|ext_in[dokumentasi_absensi,jpg,jpeg,png,pdf]',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $updateData = [
            'tanggal_induksi' => $this->request->getPost('tanggal_induksi'),
            'jumlah_peserta'  => (int) $this->request->getPost('jumlah_peserta'),
            'keterangan'      => $this->request->getPost('keterangan'),
            'updated_by'      => user_id(),
            'updated_at'      => date('Y-m-d H:i:s'),
        ];

        // Dokumentasi utama — ganti jika ada upload baru
        $file = $this->request->getFile('dokumentasi');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $this->deleteFile($row->dokumentasi_filename);
            [$f, $o, $m, $s] = $this->uploadFile('dokumentasi');
            $updateData['dokumentasi_filename']      = $f;
            $updateData['dokumentasi_original_name'] = $o;
            $updateData['dokumentasi_mime']          = $m;
            $updateData['dokumentasi_size']          = $s;
        }

        // Dokumentasi absensi — ganti jika ada upload baru
        $fileAbsensi = $this->request->getFile('dokumentasi_absensi');
        if ($fileAbsensi && $fileAbsensi->isValid() && ! $fileAbsensi->hasMoved()) {
            $this->deleteFile($row->dokumentasi_absensi_filename);
            [$f, $o, $m, $s] = $this->uploadFile('dokumentasi_absensi');
            $updateData['dokumentasi_absensi_filename']      = $f;
            $updateData['dokumentasi_absensi_original_name'] = $o;
            $updateData['dokumentasi_absensi_mime']          = $m;
            $updateData['dokumentasi_absensi_size']          = $s;
        }

        $this->db->table('induksi')->where('id', $id)->update($updateData);

        session()->setFlashdata('success', 'Data induksi berhasil diperbarui.');
        return redirect()->to('/induksi');
    }

    // delete induksi soft delete
    public function delete(int $id = 0)
    {
        $row = $this->getInduksi($id);

        if (empty($row)) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to('/induksi');
        }

        if (! $this->canModify($row)) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses untuk menghapus data dari plant lain.');
            return redirect()->to('/induksi');
        }

        $this->db->table('induksi')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Data induksi berhasil dihapus.');
        return redirect()->to('/induksi');
    }

    // export excel
    public function export()
    {
        $data = $this->getInduksi();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        // Header kolom
        $headers = [
            'No',
            'Tanggal Induksi',
            'Jumlah Peserta',
            'Keterangan',
            'Dicatat Oleh',
            'Plant',
            'Dibuat',
            'Dokumentasi',
            'Dokumentasi Absensi'
        ];

        foreach ($headers as $col => $label) {
            $colLetter = chr(65 + $col); // Convert 0-6 to A-G
            $sheet->setCellValue($colLetter . '1', $label);
        }

        // Style header
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE8EAF6');

        // Isi data
        $rowNum = 2;
        $no     = 1;
        $imgHeight = 100;
        $rowHeight = $imgHeight * 0.80;

        foreach ($data as $row) {
            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValue('B' . $rowNum, date('d-m-Y', strtotime($row->tanggal_induksi)));
            $sheet->setCellValue('C' . $rowNum, $row->jumlah_peserta);
            $sheet->setCellValue('D' . $rowNum, $row->keterangan ?? '-');
            $sheet->setCellValue('E' . $rowNum, $row->created_by_username ?? '-');
            $sheet->setCellValue('F' . $rowNum, ucwords(strtolower($row->nama_plant ?? '-')));
            $sheet->setCellValue('G' . $rowNum, $row->created_at);

            $sheet->getRowDimension($rowNum)->setRowHeight($rowHeight);

            // dokumentasi
            if (! empty($row->dokumentasi_filename)) {
                $pathBefore = FCPATH . 'uploads/induksi/' . $row->dokumentasi_filename;

                if (file_exists($pathBefore)) {
                    $drawing = new Drawing();
                    $drawing->setPath($pathBefore);
                    $drawing->setHeight($imgHeight);
                    $drawing->setCoordinates('H' . $rowNum);
                    $drawing->setOffsetX(2);
                    $drawing->setOffsetY(2);
                    $drawing->setWorksheet($sheet);
                }
            }

            if (! empty($row->dokumentasi_absensi_filename)) {
                $pathBefore = FCPATH . 'uploads/induksi/' . $row->dokumentasi_absensi_filename;

                if (file_exists($pathBefore)) {
                    $drawing = new Drawing();
                    $drawing->setPath($pathBefore);
                    $drawing->setHeight($imgHeight);
                    $drawing->setCoordinates('I' . $rowNum);
                    $drawing->setOffsetX(2);
                    $drawing->setOffsetY(2);
                    $drawing->setWorksheet($sheet);
                }
            }

            $rowNum++;
        }

        // Auto size semua kolom
        for ($col = 0; $col < count($headers); $col++) {
            $colLetter = chr(65 + $col);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);

        // Wrap text kolom keterangan
        $sheet->getStyle('D2:D' . $rowNum)
            ->getAlignment()->setWrapText(true);

        // Freeze baris header
        $sheet->freezePane('A2');

        $filename = 'induksi_k3_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // export pdf
    public function exportPdf()
    {
        $data = $this->getInduksi();

        $html = view('induksi/export_pdf', ['induksi' => $data]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isLocalFileEnabled', true);

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('induksi_k3_' . date('Ymd_His') . '.pdf', [
            'Attachment' => true
        ]);
    }
}
