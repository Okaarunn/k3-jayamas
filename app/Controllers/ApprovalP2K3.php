<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WorkPermitModel;
use CodeIgniter\HTTP\ResponseInterface;

class ApprovalP2K3 extends BaseController
{

    // get work permit yang sudah di approve k3
    public function index()
    {
        $workPermitModel = new WorkPermitModel();
        $workPermits = $workPermitModel
            ->select('
                work_permit.*,
                pekerjaan.nama_pekerjaan,
                plant.nama_plant,
                u1.username as approved_k3_nama,
                u2.username as approved_p2k3_nama,
                izin_lembur.id as lembur_id
            ')
            ->join('pekerjaan', 'pekerjaan.id = work_permit.pekerjaan_id', 'left')
            ->join('plant', 'plant.id = work_permit.plant_id', 'left')
            ->join('users as u1', 'u1.id = work_permit.approved_k3_by', 'left')
            ->join('users as u2', 'u2.id = work_permit.approved_p2k3_by', 'left')
            ->join('izin_lembur', 'izin_lembur.work_permit_id = work_permit.id', 'left')
            ->where('work_permit.approved_k3_by IS NOT NULL')->findAll();

        return view('approvalp2k3/approvalp2k3', [
            'title'       => 'Work Permit Approval P2K3',
            'workPermits' => $workPermits,
        ]);
    }
}
