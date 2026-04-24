<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class IzinLembur extends BaseController
{

    // generate no lembur
    private function generateNoLembur()
    {
        $year = date('Y');

        $db = \Config\Database::connect();

        $last = $db->table('izin_lembur')
            ->like('no_lembur', "K3/JMI2/LEMBUR", 'after')
            ->like('no_lembur', $year, 'before')
            ->orderBy('id', 'DESC')
            ->get()
            ->getRow();

        if ($last) {
            $lastNumber = (int) explode('/', $last->no_lembur)[3];
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return "K3/JMI1/LEMBUR/{$formattedNumber}/{$year}";
    }

    public function index()
    {
        //
    }
}
