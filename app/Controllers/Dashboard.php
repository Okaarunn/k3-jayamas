<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => $this->role . ' | Dashboard'
        ];
        return view('dashboard', $data);
    }
}
