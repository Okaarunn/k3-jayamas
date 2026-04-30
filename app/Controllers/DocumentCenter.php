<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DocumentCenter extends BaseController
{
    public function index()
    {
        return view('document_center/document_center', [
            'title'       => 'Document Center K3',
        ]);
    }
}
