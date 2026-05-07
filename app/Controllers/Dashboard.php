<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProgressPengerjaanModel;
use App\Models\WorkPermitModel;

class Dashboard extends BaseController
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
        return $user->plant_id ?? null;
    }

    public function index()
    {
        $plantId = $this->currentUserPlantId();
        $isAdmin = in_groups('administrator');

        // resume cards

        // Induksi total
        $induksiBuilder = $this->db->table('induksi i')
            ->join('users u', 'u.id = i.created_by', 'left')
            ->where('i.deleted_at IS NULL');
        if (!$isAdmin) {
            $induksiBuilder->where('u.plant_id', $plantId);
        }
        $totalInduksi = $induksiBuilder->countAllResults();

        // Patrol total
        $patrolBuilder = $this->db->table('patrol p')
            ->join('users u', 'u.id = p.created_by', 'left')
            ->where('p.deleted_at IS NULL');
        if (!$isAdmin) {
            $patrolBuilder->where('u.plant_id', $plantId);
        }
        $totalPatrol = $patrolBuilder->countAllResults();

        // Patrol selesai
        $patrolSelesaiBuilder = $this->db->table('patrol p')
            ->join('users u', 'u.id = p.created_by', 'left')
            ->where('p.deleted_at IS NULL')
            ->where('p.status_patrol', 1);
        if (!$isAdmin) {
            $patrolSelesaiBuilder->where('u.plant_id', $plantId);
        }
        $totalSelesai      = $patrolSelesaiBuilder->countAllResults();
        $totalBelumSelesai = $totalPatrol - $totalSelesai;

        // Users (admin only)
        $totalUsers = $isAdmin
            ? $this->db->table('users')->where('deleted_at IS NULL')->countAllResults()
            : null;

        // Work Permit total
        $wpTotalBuilder = $this->db->table('work_permit');
        if (!$isAdmin) {
            $wpTotalBuilder->where('plant_id', $plantId);
        }
        $totalApproval = $wpTotalBuilder->countAllResults();

        // Work Permit belum disetujui
        $wpBelumDisetujuiBuilder = $this->db->table('work_permit')
            ->where('status_approval', 'pending');
        if (!$isAdmin) {
            $wpBelumDisetujuiBuilder->where('plant_id', $plantId);
        }
        $totalWpBelumDiSetujui = $wpBelumDisetujuiBuilder->countAllResults();

        // Work Permit ditolak
        $wpDitolakBuilder = $this->db->table('work_permit')
            ->whereIn('status_approval', ['reject_by_k3', 'reject_by_p2k3']);
        if (!$isAdmin) {
            $wpDitolakBuilder->where('plant_id', $plantId);
        }
        $totalWpDiTolak = $wpDitolakBuilder->countAllResults();

        // Progress ongoing
        $progressOngoingBuilder = $this->db->table('progress_pengerjaan');
        if (!$isAdmin) {
            $progressOngoingBuilder->where('plant_id', $plantId);
        }
        $totalStatusPengerjaanOnGoing = $progressOngoingBuilder
            ->where('status_pengerjaan', 'ongoing')
            ->countAllResults();

        // Progress finished
        $progressFinishedBuilder = $this->db->table('progress_pengerjaan');
        if (!$isAdmin) {
            $progressFinishedBuilder->where('plant_id', $plantId);
        }
        $totalStatusPengerjaanFinish = $progressFinishedBuilder
            ->where('status_pengerjaan', 'finished')
            ->countAllResults();

        // grafik iduksi
        $induksiChartBuilder = $this->db->table('induksi i')
            ->select("DATE_FORMAT(i.tanggal_induksi, '%Y-%m') as bulan, SUM(i.jumlah_peserta) as total_peserta")
            ->join('users u', 'u.id = i.created_by', 'left')
            ->where('i.deleted_at IS NULL')
            ->where('i.tanggal_induksi >=', date('Y-m-d', strtotime('-11 months', strtotime(date('Y-m-01')))))
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC');
        if (!$isAdmin) {
            $induksiChartBuilder->where('u.plant_id', $plantId);
        }
        $induksiChartRaw = $induksiChartBuilder->get()->getResult();

        $induksiLabels = [];
        $induksiValues = [];
        $induksiMap    = [];
        foreach ($induksiChartRaw as $row) {
            $induksiMap[$row->bulan] = (int) $row->total_peserta;
        }
        for ($m = 11; $m >= 0; $m--) {
            $key             = date('Y-m', strtotime("-{$m} months"));
            $induksiLabels[] = date('M Y', strtotime("-{$m} months"));
            $induksiValues[] = $induksiMap[$key] ?? 0;
        }

        //    grafik patrol
        $patrolChartBuilder = $this->db->table('patrol p')
            ->select("DATE_FORMAT(p.tanggal_patrol, '%Y-%m') as bulan, COUNT(*) as total")
            ->join('users u', 'u.id = p.created_by', 'left')
            ->where('p.deleted_at IS NULL')
            ->where('p.tanggal_patrol >=', date('Y-m-d', strtotime('-11 months', strtotime(date('Y-m-01')))))
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC');
        if (!$isAdmin) {
            $patrolChartBuilder->where('u.plant_id', $plantId);
        }
        $patrolChartRaw = $patrolChartBuilder->get()->getResult();

        $patrolLabels = [];
        $patrolValues = [];
        $patrolMap    = [];
        foreach ($patrolChartRaw as $row) {
            $patrolMap[$row->bulan] = (int) $row->total;
        }
        for ($m = 11; $m >= 0; $m--) {
            $key            = date('Y-m', strtotime("-{$m} months"));
            $patrolLabels[] = date('M Y', strtotime("-{$m} months"));
            $patrolValues[] = $patrolMap[$key] ?? 0;
        }

        // aktivitas terbaru
        $induksiActivity = $this->db->table('induksi i')
            ->select("'induksi' as tipe, i.id, i.tanggal_induksi as tanggal, i.keterangan as deskripsi, u.username, pl.nama_plant, i.created_at")
            ->join('users u', 'u.id = i.created_by', 'left')
            ->join('plant pl', 'pl.id = u.plant_id', 'left')
            ->where('i.deleted_at IS NULL');
        if (!$isAdmin) {
            $induksiActivity->where('u.plant_id', $plantId);
        }

        $patrolActivity = $this->db->table('patrol p')
            ->select("'patrol' as tipe, p.id, p.tanggal_patrol as tanggal, p.temuan as deskripsi, u.username, pl.nama_plant, p.created_at")
            ->join('users u', 'u.id = p.created_by', 'left')
            ->join('plant pl', 'pl.id = u.plant_id', 'left')
            ->where('p.deleted_at IS NULL');
        if (!$isAdmin) {
            $patrolActivity->where('u.plant_id', $plantId);
        }

        $induksiRows = $induksiActivity->orderBy('i.created_at', 'DESC')->limit(10)->get()->getResult();
        $patrolRows  = $patrolActivity->orderBy('p.created_at', 'DESC')->limit(10)->get()->getResult();

        $activities = array_merge($induksiRows, $patrolRows);
        usort($activities, fn($a, $b) => strtotime($b->created_at) - strtotime($a->created_at));
        $activities = array_slice($activities, 0, 10);

        // return view
        return view('dashboard', [
            'title'                        => 'Dashboard K3 Jayamas Medica Industri',
            'totalInduksi'                 => $totalInduksi,
            'totalPatrol'                  => $totalPatrol,
            'totalSelesai'                 => $totalSelesai,
            'totalBelumSelesai'            => $totalBelumSelesai,
            'totalUsers'                   => $totalUsers,
            'totalApproval'                => $totalApproval,
            'totalWpBelumDiSetujui'        => $totalWpBelumDiSetujui,
            'totalWpDiTolak'               => $totalWpDiTolak,
            'totalStatusPengerjaanOnGoing' => $totalStatusPengerjaanOnGoing,
            'totalStatusPengerjaanFinish'  => $totalStatusPengerjaanFinish,
            'induksiLabels'                => json_encode($induksiLabels),
            'induksiValues'                => json_encode($induksiValues),
            'patrolLabels'                 => json_encode($patrolLabels),
            'patrolValues'                 => json_encode($patrolValues),
            'activities'                   => $activities,
        ]);
    }
}
