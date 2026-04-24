<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PekerjaanModel;
use CodeIgniter\HTTP\ResponseInterface;

class Pekerjaan extends BaseController
{
    public function index()
    {
        // get data pekerjaan
        $pekerjaanModel = new PekerjaanModel();
        $pekerjaan = $pekerjaanModel->findAll();
    }
}
