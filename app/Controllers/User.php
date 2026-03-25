<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class User extends BaseController
{
    public function index()
    {
        $data = [
            'title' => $this->role . ' | Dashboard'
        ];
        return view('user/index', $data);
    }
}
