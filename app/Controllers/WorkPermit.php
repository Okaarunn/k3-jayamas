<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PekerjaanModel;
use CodeIgniter\HTTP\ResponseInterface;

class WorkPermit extends BaseController
{
    public function index()
    {

        // pekerjaan
        $pekerjaanModel = new PekerjaanModel();
        $pekerjaan = $pekerjaanModel->findAll();

        return view('work_permit/index', [
            'title'      => 'Work Permit Request K3',
            'pekerjaans' => $pekerjaan,
        ]);
    }

    public function create()
    {
        return view('work_permit/create', [
            'title'     => 'Buat Work Permit Request',
            'errors'    => [],
        ]);
    }

    public function store()
    {
        // Sementara ini hanya menampilkan pesan sukses
        // Nanti akan diintegrasikan dengan model dan database
        return redirect()->to('/work-permit-request')->with('message', 'Work Permit Request berhasil dikirim!');
    }
}
