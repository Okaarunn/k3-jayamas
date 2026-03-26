<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

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

    // get data induksi with created by users
    private function getPatrol(int $id = 0)
    {
        $builder = $this->db->table('patrol p');
        $builder->select('p.*, u.username as created_by_username');
        $builder->join('users u', 'u.id = p.created_by', 'left');
        $builder->where('p.deleted_at IS NULL');

        if ($id > 0) {
            $builder->where('p.id', $id);
            return $builder->get()->getRow();
        }

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


    // get all patrol 
    public function index()
    {
        $data = [
            'title' => 'Data Patrol K3',
            'patrol' => $this->getPatrol()
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

        // insert data induksi
        $this->db->table('patrol')->insert([
            'nama_petugas'              => $this->request->getPost('nama_petugas'),
            'tanggal_patrol'            => $this->request->getPost('tanggal_patrol'),
            'tanggal_penyelesaian'      => $this->request->getPost('tanggal_penyelesaian') ?: null,
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

        // update data patrol
        $updateData = [
            'nama_petugas'         => $this->request->getPost('nama_petugas'),
            'tanggal_patrol'       => $this->request->getPost('tanggal_patrol'),
            'tanggal_penyelesaian' => $this->request->getPost('tanggal_penyelesaian') ?: null,
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

        $this->db->table('patrol')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Laporan patrol berhasil dihapus.');
        return redirect()->to('/patrol');
    }

    // export csv
    public function export()
    {
        $data = $this->getPatrol();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="patrol_k3_' . date('Ymd_His') . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['No', 'Kode', 'Nama Petugas', 'Tanggal Patrol', 'Tanggal Penyelesaian', 'Keterangan', 'Dicatat Oleh']);

        $i = 1;
        foreach ($data as $row) {
            fputcsv($output, [
                $i++,
                $row->kode,
                $row->nama_petugas,
                $row->tanggal_patrol,
                $row->tanggal_penyelesaian ?? '-',
                $row->keterangan,
                $row->created_by_username ?? '-',
            ]);
        }

        fclose($output);
        exit;
    }
}
