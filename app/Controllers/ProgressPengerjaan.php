<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProgressPengerjaan extends BaseController
{
    public function index()
    {
        return view('progress_pengerjaan/progress_pengerjaan', [
            'title'       => 'Progress Pengerjaan Work Permit',
        ]);
    }
}
