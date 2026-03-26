<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Induksi extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // get data induksi with created by users
    private function getInduksi(int $id = 0)
    {
        $builder = $this->db->table('induksi i');
        $builder->select('i.*, u.username as created_by_username');
        $builder->join('users u', 'u.id = i.created_by', 'left');
        $builder->where('i.deleted_at IS NULL');

        if ($id > 0) {
            $builder->where('i.id', $id);
            return $builder->get()->getRow();
        }

        return $builder->orderBy('i.tanggal_induksi', 'DESC')->get()->getResult();
    }

    //    get data induksi
    public function index()
    {
        $data = [
            'title'   => 'Data Induksi K3',
            'induksi' => $this->getInduksi(),
        ];
        return view('induksi/induksi', $data);
    }

    // create data
    public function create()
    {
        $data = [
            'title'  => 'Tambah Induksi',
            'errors' => session()->getFlashdata('errors') ?? [],
        ];
        return view('induksi/create', $data);
    }

    // store data induksi
    public function store()
    {
        // data validation
        $rules = [
            'tanggal_induksi' => 'required|valid_date[Y-m-d]',
            'jumlah_peserta'  => 'required|integer|greater_than[0]',
            'keterangan'      => 'permit_empty|max_length[1000]',
            'dokumentasi'     => 'permit_empty|uploaded[dokumentasi]|max_size[dokumentasi,5120]|ext_in[dokumentasi,jpg,jpeg,png,pdf]',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $filename = null;
        $origName = null;
        $mime     = null;
        $size     = null;

        // file

        $file = $this->request->getFile('dokumentasi');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName    = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/induksi/';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // get data file
            $origName = $file->getClientName();
            $mime     = $file->getClientMimeType();
            $size     = $file->getSize();

            // move file to upload path with new file name
            $file->move($uploadPath, $newName);
            $filename = $newName;
        }

        // insert data
        $this->db->table('induksi')->insert([
            'tanggal_induksi'           => $this->request->getPost('tanggal_induksi'),
            'jumlah_peserta'            => (int) $this->request->getPost('jumlah_peserta'),
            'keterangan'                => $this->request->getPost('keterangan'),
            'dokumentasi_filename'      => $filename,
            'dokumentasi_original_name' => $origName,
            'dokumentasi_mime'          => $mime,
            'dokumentasi_size'          => $size,
            'created_by'                => user_id(),
            'updated_by'                => user_id(),
            'created_at'                => date('Y-m-d H:i:s'),
            'updated_at'                => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Data induksi berhasil ditambahkan.');
        return redirect()->to('/induksi');
    }

    // edit data induksi
    public function edit(int $id = 0)
    {
        $row = $this->getInduksi($id);

        if (empty($row)) {
            session()->setFlashdata('error', 'Data induksi tidak ditemukan.');
            return redirect()->to('/induksi');
        }

        $data = [
            'title'   => 'Edit Induksi',
            'induksi' => $row,
            'errors'  => session()->getFlashdata('errors') ?? [],
        ];
        return view('induksi/edit', $data);
    }

    // update induksi
    public function update(int $id = 0)
    {
        // get data id induksi
        $row = $this->getInduksi($id);
        if (empty($row)) {
            session()->setFlashdata('error', 'Data induksi tidak ditemukan.');
            return redirect()->to('/induksi');
        }

        // data validation
        $rules = [
            'tanggal_induksi' => 'required|valid_date[Y-m-d]',
            'jumlah_peserta'  => 'required|integer|greater_than[0]',
            'keterangan'      => 'permit_empty|max_length[1000]',
            'dokumentasi'     => 'permit_empty|uploaded[dokumentasi]|max_size[dokumentasi,5120]|ext_in[dokumentasi,jpg,jpeg,png,pdf]',
        ];

        // validation notification 
        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        // get data request
        $updateData = [
            'tanggal_induksi' => $this->request->getPost('tanggal_induksi'),
            'jumlah_peserta'  => (int) $this->request->getPost('jumlah_peserta'),
            'keterangan'      => $this->request->getPost('keterangan'),
            'updated_by'      => user_id(),
            'updated_at'      => date('Y-m-d H:i:s'),
        ];

        // if user input new file
        $file = $this->request->getFile('dokumentasi');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            // delete path old file
            if (! empty($row->dokumentasi_filename)) {
                $oldPath = FCPATH . '/uploads/induksi/' . $row->dokumentasi_filename;
                if (file_exists($oldPath)) unlink($oldPath);
            }

            // new file name
            $newName    = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/induksi/';
            if (! is_dir($uploadPath)) mkdir($uploadPath, 0755, true);

            // get data file
            $origName = $file->getClientName();
            $mime     = $file->getClientMimeType();
            $size     = $file->getSize();

            // move file to upload path
            $file->move($uploadPath, $newName);

            $updateData['dokumentasi_filename']      = $newName;
            $updateData['dokumentasi_original_name'] = $origName;
            $updateData['dokumentasi_mime']          = $mime;
            $updateData['dokumentasi_size']          = $size;
        }

        $this->db->table('induksi')->where('id', $id)->update($updateData);

        session()->setFlashdata('success', 'Data induksi berhasil diperbarui.');
        return redirect()->to('/induksi');
    }


    // delete data induksi
    public function delete(int $id = 0)
    {

        // get data induksi by id
        $row = $this->getInduksi($id);
        if (empty($row)) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to('/induksi');
        }

        // delete data
        $this->db->table('induksi')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Data induksi berhasil dihapus.');
        return redirect()->to('/induksi');
    }

    //   export csv
    public function export()
    {
        $data = $this->getInduksi();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="induksi_k3_' . date('Ymd_His') . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['No', 'Tanggal Induksi', 'Jumlah Peserta', 'Keterangan', 'Dokumentasi', 'Dicatat Oleh', 'Dibuat']);

        $i = 1;
        foreach ($data as $row) {
            fputcsv($output, [
                $i++,
                $row->tanggal_induksi,
                $row->jumlah_peserta,
                $row->keterangan,
                $row->dokumentasi_original_name ?? '-',
                $row->created_by_username ?? '-',
                $row->created_at,
            ]);
        }

        fclose($output);
        exit;
    }
}
