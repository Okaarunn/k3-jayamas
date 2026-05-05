<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\ProgressPengerjaanModel;
use App\Models\WorkPermitModel;

class ProgressPengerjaan extends BaseController
{

    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function currentUserPlantId(): ?int
    {
        $user = $this->db->table('users')
            ->select('plant_id')
            ->where('id', user_id())
            ->get()->getRow();

        return $user ? (int)$user->plant_id : null;
    }

    public function index()
    {
        $progressModel = new ProgressPengerjaanModel();
        $myPlantId = $this->currentUserPlantId();

        $builder = $progressModel
            ->select('
                progress_pengerjaan.*, 
                work_permit.no_wp,
                work_permit.nama_pengaju,
                work_permit.tgl_mulai, 
                work_permit.tgl_selesai, 
                work_permit.nama_pekerjaan, 
                izin_lembur.no_lembur,
                plant.nama_plant
            ')
            ->join('work_permit', 'work_permit.id = progress_pengerjaan.work_permit_id', 'left')
            ->join('izin_lembur', 'izin_lembur.id = progress_pengerjaan.izin_lembur_id', 'left')
            ->join('plant', 'plant.id = work_permit.plant_id', 'left');

        // PROTEKSI: Jika bukan admin, hanya tampilkan plant yang sesuai
        if (!in_groups('administrator')) {
            $builder->where('work_permit.plant_id', $myPlantId);
        }

        $progressPengerjaan = $builder->findAll();

        return view('progress_pengerjaan/progress_pengerjaan', [
            'title'        => 'Progress Pengerjaan Work Permit',
            'progressPengerjaans' => $progressPengerjaan,
        ]);
    }

    public function finishBatch()
    {
        $ids = $this->request->getPost('ids');

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Silakan pilih minimal satu pekerjaan yang sedang ongoing.');
        }

        $progressModel = new ProgressPengerjaanModel();
        $workPermitModel = new WorkPermitModel();

        $this->db->transStart();

        $selectedProgress = $progressModel->whereIn('id', $ids)
            ->where('status_pengerjaan', 'ongoing')
            ->findAll();

        if (empty($selectedProgress)) {
            return redirect()->back()->with('error', 'Data yang dipilih sudah selesai atau tidak ditemukan.');
        }

        foreach ($selectedProgress as $row) {
            $progressModel->update($row['id'], [
                'status_pengerjaan' => 'finished',
                'updated_by'        => user_id(),
                'updated_at'        => date('Y-m-d H:i:s')
            ]);

            $workPermitModel->update($row['work_permit_id'], [
                'tgl_selesai' => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ]);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memproses data.');
        }

        return redirect()->back()->with('success', count($selectedProgress) . ' pekerjaan berhasil diselesaikan.');
    }

    public function finishSingle()
    {
        $id = $this->request->getPost('id'); // ID dari tabel progress_pengerjaan

        if (empty($id)) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $progressModel = new ProgressPengerjaanModel();
        $workPermitModel = new \App\Models\WorkPermitModel();

        // Cari data progress untuk mendapatkan work_permit_id
        $progress = $progressModel->find($id);

        if (!$progress || $progress['status_pengerjaan'] !== 'ongoing') {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau sudah selesai.');
        }

        $this->db->transStart();

        // 1. Update tabel progress_pengerjaan
        $progressModel->update($id, [
            'status_pengerjaan' => 'finished',
            'updated_by'        => user_id(),
            'updated_at'        => date('Y-m-d H:i:s')
        ]);

        // 2. Update tabel work_permit (mengisi tgl_selesai)
        $workPermitModel->update($progress['work_permit_id'], [
            'tgl_selesai' => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s')
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memperbarui status pengerjaan.');
        }

        return redirect()->back()->with('success', 'Pekerjaan berhasil ditandai selesai.');
    }
}
