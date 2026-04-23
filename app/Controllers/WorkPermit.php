<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class WorkPermit extends BaseController
{
    public function index()
    {
        return view('work_permit/index', [
            'title'     => 'Work Permit Request K3',
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
