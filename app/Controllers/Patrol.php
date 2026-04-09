<?php

namespace App\Controllers;

use App\Controllers\BaseController;

// php office
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// image excel
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use Dompdf\Options;
use Dompdf\Dompdf;

class Patrol extends BaseController
{

    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // create code patrol
    private function generateCode($id)
    {
        return 'K3-' . str_pad($id, 4, '0', STR_PAD_LEFT);
    }

    // get user plant
    private function currentUserPlantId(): ?int
    {
        $user = $this->db->table('users')
            ->select('plant_id')
            ->where('id', user_id())
            ->get()->getRow();

        return $user->plant_id;
    }
    // get data patrol with created by users
    private function getPatrol(int $id = 0)
    {
        $builder = $this->db->table('patrol p');
        $builder->select('p.*, u.username as created_by_username, pl.nama_plant, pl.kode_plant');
        $builder->join('users u', 'u.id = p.created_by', 'left');
        $builder->join('plant pl', 'pl.id = u.plant_id', 'left');
        $builder->where('p.deleted_at IS NULL');

        if (!in_groups('administrator')) {
            $builder->where('u.plant_id', $this->currentUserPlantId());
        }

        if ($id > 0) {
            $builder->where('p.id', $id);
            return $builder->get()->getRow();
        }

        $builder->select('p.*, u.username as created_by_username, u.plant_id as creator_plant_id, pl.nama_plant, pl.kode_plant');

        return $builder->orderBy('p.tanggal_patrol', 'DESC')->get()->getResult();
    }

    // upload file
    private function uploadFoto(string $fieldName): array
    {
        $file = $this->request->getFile($fieldName);

        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return [null, null, null, null];
        }

        // define upload path
        $uploadPath = FCPATH . 'uploads/patrol/';
        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // get data file
        $newName  = $file->getRandomName();
        $origName = $file->getClientName();
        $mime     = $file->getClientMimeType();
        $size     = $file->getSize();


        // move file to upload path
        $file->move($uploadPath, $newName);

        return [$newName, $origName, $mime, $size];
    }

    // check plant edit/delete data
    private function canModify(object $row): bool
    {
        if (in_groups('administrator')) {
            return true;
        }

        $myPlantId = (int) $this->currentUserPlantId();

        $creator = $this->db->table('users')
            ->select('plant_id')
            ->where('id', $row->created_by)
            ->get()->getRow();

        $creatorPlantId = (int) ($creator->plant_id ?? 0);

        return $myPlantId !== 0 && $myPlantId === $creatorPlantId;
    }

    // get status patrol (0 = belum selesai, 1 = selesai)
    private function getStatusPatrol($tanggalPenyelesaian): int
    {
        return empty($tanggalPenyelesaian) ? 0 : 1;
    }

    // get data patrol 
    public function index()
    {
        $data = [
            'title' => 'Data Patrol K3',
            'patrol' => $this->getPatrol(),
            'myPlantId' => $this->currentUserPlantId()
        ];

        return view('patrol/patrol', $data);
    }

    // create patrol
    public function create()
    {
        // get last data id
        $last = $this->db->table('patrol')
            ->select('id')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

        // add 1 
        $nextId = ($last->id ?? 0) + 1;

        $data = [
            'title'  => 'Tambah Laporan Patrol',
            'errors' => session()->getFlashdata('errors') ?? [],
            'kode'   => $this->generateCode($nextId),
        ];

        return view('patrol/create', $data);
    }

    // store patrol
    public function store()
    {
        // data validation
        $rules = [
            'nama_petugas'         => 'required|max_length[100]',
            'tanggal_patrol'       => 'required|valid_date[Y-m-d]',
            'tanggal_penyelesaian' => 'permit_empty|valid_date[Y-m-d]',
            'keterangan'           => 'permit_empty|max_length[2000]',
            'foto_before'          => 'permit_empty|uploaded[foto_before]|max_size[foto_before,5120]|ext_in[foto_before,jpg,jpeg,png]',
            'foto_after'           => 'permit_empty|uploaded[foto_after]|max_size[foto_after,5120]|ext_in[foto_after,jpg,jpeg,png]',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        [$beforeFile, $beforeOrig, $beforeMime, $beforeSize] = $this->uploadFoto('foto_before');
        [$afterFile,  $afterOrig,  $afterMime,  $afterSize]  = $this->uploadFoto('foto_after');

        $tanggalSelesai = $this->request->getPost('tanggal_penyelesaian') ?: null;
        $statusPatrol   = $this->getStatusPatrol($tanggalSelesai);

        // insert data induksi
        $this->db->table('patrol')->insert([
            'nama_petugas'              => $this->request->getPost('nama_petugas'),
            'tanggal_patrol'            => $this->request->getPost('tanggal_patrol'),
            'tanggal_penyelesaian'      => $this->request->getPost('tanggal_penyelesaian') ?: null,
            'status_patrol'             => $statusPatrol,
            'keterangan'                => $this->request->getPost('keterangan'),
            'foto_before_filename'      => $beforeFile,
            'foto_before_original_name' => $beforeOrig,
            'foto_before_mime'          => $beforeMime,
            'foto_before_size'          => $beforeSize,
            'foto_after_filename'       => $afterFile,
            'foto_after_original_name'  => $afterOrig,
            'foto_after_mime'           => $afterMime,
            'foto_after_size'           => $afterSize,
            'created_by'                => user_id(),
            'updated_by'                => user_id(),
            'created_at'                => date('Y-m-d H:i:s'),
            'updated_at'                => date('Y-m-d H:i:s'),
        ]);

        $id = $this->db->insertID();

        // generate unique code
        $kode = $this->generateCode($id);

        // update code
        $this->db->table('patrol')
            ->where('id', $id)
            ->update(['kode' => $kode]);

        session()->setFlashdata('success', 'Laporan patrol berhasil ditambahkan.');
        return redirect()->to('/patrol');
    }

    // edit patrol
    public function edit(int $id = 0)
    {
        // get patrol data id
        $row = $this->getPatrol($id);

        if (empty($row)) {
            session()->setFlashdata('error', 'Data patrol tidak ditemukan.');
            return redirect()->to('/patrol');
        }

        // check access plant
        if (! $this->canModify($row)) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses untuk mengedit data patrol dari plant lain.');
            return redirect()->to('/patrol');
        }


        $data = [
            'title'  => 'Edit Laporan Patrol',
            'patrol' => $row,
            'errors' => session()->getFlashdata('errors') ?? [],
        ];
        return view('patrol/edit', $data);
    }

    public function update(int $id = 0)
    {
        // get data id
        $row = $this->getPatrol($id);
        if (empty($row)) {
            session()->setFlashdata('error', 'Data patrol tidak ditemukan.');
            return redirect()->to('/patrol');
        }

        // check access plant
        if (! $this->canModify($row)) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses untuk mengubah data patrol dari plant lain.');
            return redirect()->to('/patrol');
        }

        // data validation
        $rules = [
            'nama_petugas'         => 'required|max_length[100]',
            'tanggal_patrol'       => 'required|valid_date[Y-m-d]',
            'tanggal_penyelesaian' => 'permit_empty|valid_date[Y-m-d]',
            'keterangan'           => 'permit_empty|max_length[2000]',
            'foto_before'          => 'permit_empty|uploaded[foto_before]|max_size[foto_before,5120]|ext_in[foto_before,jpg,jpeg,png]',
            'foto_after'           => 'permit_empty|uploaded[foto_after]|max_size[foto_after,5120]|ext_in[foto_after,jpg,jpeg,png]',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $tanggalSelesai = $this->request->getPost('tanggal_penyelesaian') ?: null;
        $statusPatrol   = $this->getStatusPatrol($tanggalSelesai);

        // update data patrol
        $updateData = [
            'nama_petugas'         => $this->request->getPost('nama_petugas'),
            'tanggal_patrol'       => $this->request->getPost('tanggal_patrol'),
            'tanggal_penyelesaian' => $this->request->getPost('tanggal_penyelesaian') ?: null,
            'status_patrol'        => $statusPatrol,
            'keterangan'           => $this->request->getPost('keterangan'),
            'updated_by'           => user_id(),
            'updated_at'           => date('Y-m-d H:i:s'),
        ];

        // image before: change if there is a new upload
        $fileBefore = $this->request->getFile('foto_before');
        if ($fileBefore && $fileBefore->isValid() && ! $fileBefore->hasMoved()) {
            if (! empty($row->foto_before_filename)) {
                $old = FCPATH . 'uploads/patrol/' . $row->foto_before_filename;
                if (file_exists($old)) unlink($old);
            }
            [$f, $o, $m, $s] = $this->uploadFoto('foto_before');
            $updateData['foto_before_filename']      = $f;
            $updateData['foto_before_original_name'] = $o;
            $updateData['foto_before_mime']          = $m;
            $updateData['foto_before_size']          = $s;
        }

        // image after: change if there is a new upload
        $fileAfter = $this->request->getFile('foto_after');
        if ($fileAfter && $fileAfter->isValid() && ! $fileAfter->hasMoved()) {
            if (! empty($row->foto_after_filename)) {
                $old = FCPATH . 'uploads/patrol/' . $row->foto_after_filename;
                if (file_exists($old)) unlink($old);
            }
            [$f, $o, $m, $s] = $this->uploadFoto('foto_after');
            $updateData['foto_after_filename']      = $f;
            $updateData['foto_after_original_name'] = $o;
            $updateData['foto_after_mime']          = $m;
            $updateData['foto_after_size']          = $s;
        }

        $this->db->table('patrol')->where('id', $id)->update($updateData);

        session()->setFlashdata('success', 'Laporan patrol berhasil diperbarui.');
        return redirect()->to('/patrol');
    }

    // delete patrol
    public function delete(int $id = 0)
    {
        // get patrol data id
        $row = $this->getPatrol($id);
        if (empty($row)) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to('/patrol');
        }

        // check access plant
        if (! $this->canModify($row)) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses untuk menghapus data patrol dari plant lain.');
            return redirect()->to('/patrol');
        }

        $this->db->table('patrol')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Laporan patrol berhasil dihapus.');
        return redirect()->to('/patrol');
    }

    // export excel
    public function export()
    {
        $data = $this->getPatrol();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // HEADER
        $headers = [
            'No',
            'Kode',
            'Nama Petugas',
            'Tanggal Patrol',
            'Tanggal Penyelesaian',
            'Keterangan',
            'Dicatat Oleh',
            'Plant',
            'Foto Before',
            'Foto After',
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // STYLE HEADER (bold)
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);

        // DATA
        $rowNum = 2;
        $no = 1;
        $imgHeight = 70; // px — samakan dengan setHeight()
        $rowHeight = $imgHeight * 0.75; // konversi px ke points (1pt ≈ 1.33px)

        foreach ($data as $row) {
            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValue('B' . $rowNum, $row->kode);
            $sheet->setCellValue('C' . $rowNum, $row->nama_petugas);
            $sheet->setCellValue('D' . $rowNum, $row->tanggal_patrol);
            $sheet->setCellValue('E' . $rowNum, $row->tanggal_penyelesaian ?? '-');
            $sheet->setCellValue('F' . $rowNum, $row->keterangan);
            $sheet->setCellValue('G' . $rowNum, $row->created_by_username ?? '-');
            $sheet->setCellValue('H' . $rowNum, $row->nama_plant ?? '-');

            // Set tinggi baris agar gambar tidak bertumpuk
            $sheet->getRowDimension($rowNum)->setRowHeight($rowHeight);

            // Foto Before
            if (! empty($row->foto_before_filename)) {
                $pathBefore = FCPATH . 'uploads/patrol/' . $row->foto_before_filename;

                if (file_exists($pathBefore)) {
                    $drawing = new Drawing();
                    $drawing->setPath($pathBefore);
                    $drawing->setHeight($imgHeight);
                    $drawing->setCoordinates('I' . $rowNum);
                    $drawing->setOffsetX(2);   // jarak dari tepi kiri cell
                    $drawing->setOffsetY(2);   // jarak dari tepi atas cell
                    $drawing->setWorksheet($sheet);
                }
            }

            // Foto After
            if (! empty($row->foto_after_filename)) {
                $pathAfter = FCPATH . 'uploads/patrol/' . $row->foto_after_filename;

                if (file_exists($pathAfter)) {
                    $drawing = new Drawing();
                    $drawing->setPath($pathAfter);
                    $drawing->setHeight($imgHeight);
                    $drawing->setCoordinates('J' . $rowNum);
                    $drawing->setOffsetX(2);
                    $drawing->setOffsetY(2);
                    $drawing->setWorksheet($sheet);
                }
            }

            $rowNum++;
        }

        // AUTO SIZE COLUMN
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);

        // FILE NAME
        $filename = 'patrol_k3_' . date('Ymd_His') . '.xlsx';

        // HEADER DOWNLOAD
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
        $data = $this->getPatrol();

        $html = view('patrol/export_pdf', [
            'data' => $data
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isLocalFileEnabled', true);

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('patrol_k3_' . date('Ymd_His') . '.pdf', [
            'Attachment' => true
        ]);
    }
}
