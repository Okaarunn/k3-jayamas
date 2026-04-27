<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ChecklistWorkPermitModel;
use App\Models\IzinLemburModel;
use App\Models\JobSafetyAnalystModel;
use App\Models\PekerjaanModel;
use App\Models\PlantModel;
use App\Models\WorkPermitModel;

class WorkPermit extends BaseController
{
    private function generateNoWp(int $plantId): string
    {
        $plantModel = new PlantModel();
        $plant = $plantModel->find($plantId);

        $namaPlant = strtolower($plant['nama_plant'] ?? '');

        if (str_contains($namaPlant, 'krian')) {
            $kode = 'JMI1';
        } elseif (str_contains($namaPlant, 'mojoagung')) {
            $kode = 'JMI2';
        } elseif (str_contains($namaPlant, 'batang')) {
            $kode = 'JMI3';
        } else {
            $kode = 'JMI1';
        }

        $tahun = date('Y');

        $workPermitModel = new WorkPermitModel();
        $last = $workPermitModel
            ->like('no_wp', "K3/{$kode}/WP/", 'after')
            ->like('no_wp', "/{$tahun}", 'before')
            ->orderBy('id', 'DESC')
            ->first();

        $urutan = 1;
        if ($last) {
            // Format: K3/JMI1/WP/001/2026 → ambil bagian ke-4
            $parts = explode('/', $last['no_wp']);
            $urutan = (int) ($parts[3] ?? 0) + 1;
        }

        return sprintf('K3/%s/WP/%03d/%s', $kode, $urutan, $tahun);
    }

    private function generateNoLembur(int $plantId): string
    {
        $plantModel = new PlantModel();
        $plant = $plantModel->find($plantId);

        $namaPlant = strtolower($plant['nama_plant'] ?? '');

        if (str_contains($namaPlant, 'krian')) {
            $kode = 'JMI1';
        } elseif (str_contains($namaPlant, 'mojoagung')) {
            $kode = 'JMI2';
        } elseif (str_contains($namaPlant, 'batang')) {
            $kode = 'JMI3';
        } else {
            $kode = 'JMI1';
        }

        $tahun = date('Y');

        $izinLemburModel = new IzinLemburModel();
        $last = $izinLemburModel
            ->like('no_lembur', "K3/{$kode}/LEMBUR/", 'after')
            ->like('no_lembur', "/{$tahun}", 'before')
            ->orderBy('id', 'DESC')
            ->first();

        $urutan = 1;
        if ($last) {
            // Format: K3/JMI1/LEMBUR/001/2026
            $parts = explode('/', $last['no_lembur']);
            $urutan = (int) ($parts[3] ?? 0) + 1;
        }

        return sprintf('K3/%s/LEMBUR/%03d/%s', $kode, $urutan, $tahun);
    }

    public function index()
    {
        $pekerjaanModel = new PekerjaanModel();
        $plantModel     = new PlantModel();

        return view('work_permit/index', [
            'title'      => 'Work Permit Request K3',
            'pekerjaans' => $pekerjaanModel->findAll(),
            'plants'     => $plantModel->findAll(),
        ]);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $plantId   = (int) $this->request->getPost('plant_id');
            $no_wp     = $this->generateNoWp($plantId);
            $no_lembur = $this->generateNoLembur($plantId);

            $tipe        = $this->request->getPost('tipe_pengaju');
            $namaPengaju = $this->request->getPost('nama_pengaju');

            $departemen  = $tipe === 'internal'
                ? $namaPengaju
                : $this->request->getPost('departemen');

            // ===== 1. INSERT KE WORK PERMIT TABLE =====
            $wpModel = new WorkPermitModel();

            $wpModel->insert([
                'no_wp'                  => $no_wp,
                'tipe_pengaju'           => $tipe,
                'plant_id'               => $plantId,
                'nama_pengaju'           => $namaPengaju,
                'alamat_vendor'          => $this->request->getPost('alamat_vendor') ?? null,
                'notelp_vendor'          => $this->request->getPost('notelp_vendor') ?? null,
                'nama_pekerja_vendor'    => $this->request->getPost('nama_pekerja_vendor') ?? null,
                'jabatan_pekerja_vendor' => $this->request->getPost('jabatan_pekerja_vendor') ?? null,
                'no_ktp_pic_vendor'      => $this->request->getPost('no_ktp_pic_vendor') ?? null,
                'departemen'             => $departemen,
                'lokasi_kerja'           => $this->request->getPost('lokasi_kerja'),
                'tanggal'                => $this->request->getPost('tanggal'),
                'pekerjaan_id'           => $this->request->getPost('pekerjaan_id'),
                'jam_mulai'              => $this->request->getPost('jam_mulai'),
                'jam_selesai'            => $this->request->getPost('jam_selesai'),
            ]);

            // Ambil ID yang baru di-insert
            $workPermitId = $wpModel->getInsertID();

            // ===== 2. INSERT KE CHECKLIST WORK PERMIT TABLE =====
            $checklistModel = new ChecklistWorkPermitModel();

            $checklistModel->insert([
                'work_permit_id'             => $workPermitId,
                'pemeriksaan_bahaya'         => (int) ($this->request->getPost('pemeriksaan_bahaya') ?? 0),
                'penyediaan_apd'             => (int) ($this->request->getPost('penyediaan_apd') ?? 0),
                'alat_pernapasan'            => (int) ($this->request->getPost('alat_pernapasan') ?? 0),
                'pemeriksaan_kelayakan'      => (int) ($this->request->getPost('pemeriksaan_kelayakan') ?? 0),
                'tanda_peringatan'           => (int) ($this->request->getPost('tanda_peringatan') ?? 0),
                'perlengkapan_k3'            => (int) ($this->request->getPost('perlengkapan_k3') ?? 0),
                'penaikan_penurunan_peralatan' => (int) ($this->request->getPost('penaikan_penurunan_peralatan') ?? 0),
                'peralatan_terhubung_dengan_badan' => (int) ($this->request->getPost('peralatan_terhubung_dengan_badan') ?? 0),
                'pengecekan_alat'            => (int) ($this->request->getPost('pengecekan_alat') ?? 0),
                'peralatan_mengagetkan'      => (int) ($this->request->getPost('peralatan_mengagetkan') ?? 0),
                'konfirmasi_pekerja'         => (int) ($this->request->getPost('konfirmasi_pekerja') ?? 0),
                'monitoring_pekerjaan'       => (int) ($this->request->getPost('monitoring_pekerjaan') ?? 0),
                'monitoring_kebersihan'      => (int) ($this->request->getPost('monitoring_kebersihan') ?? 0),
                'izin_bahan_kimia'           => (int) ($this->request->getPost('izin_bahan_kimia') ?? 0),
                'tersedia_apar'              => (int) ($this->request->getPost('tersedia_apar') ?? 0),

                'penggunaan_apd'         => $this->request->getPost('penggunaan_apd'),

                'pencegahan_tambahan'         => $this->request->getPost('pencegahan_tambahan'),

                'pengawasan'         => $this->request->getPost('pengawasan'),

                'bagian_pekerjaan'         => $this->request->getPost('bagian_pekerjaan'),

                'mengetahui_ak3'         => $this->request->getPost('mengetahui_ak3'),

                'penanggung_jawab'         => $this->request->getPost('penanggung_jawab_checklist'),
            ]);

            // ===== 3. INSERT KE JOB SAFETY ANALYST TABLE =====
            $jsaModel = new JobSafetyAnalystModel();

            $tahapPekerjaan   = $this->request->getPost('tahap_pekerjaan') ?? [];
            $bahayaPekerjaan  = $this->request->getPost('bahaya_pekerjaan') ?? [];
            $resikoPekerjaan  = $this->request->getPost('resiko_pekerjaan') ?? [];
            $pengendalian     = $this->request->getPost('pengendalian') ?? [];
            $penanggungjawab  = $this->request->getPost('penanggung_jawab') ?? [];

            foreach ($tahapPekerjaan as $i => $t) {

                if (!empty($t)) {

                    $jsaModel->insert([
                        'work_permit_id'   => $workPermitId,
                        'tahap_pekerjaan'  => $t,
                        'bahaya_pekerjaan' => $bahayaPekerjaan[$i] ?? null,
                        'resiko_pekerjaan' => $resikoPekerjaan[$i] ?? null,
                        'pengendalian'     => $pengendalian[$i] ?? null,
                        'penanggung_jawab' => $penanggungjawab[$i] ?? null,
                    ]);
                }
            }

            // ===== 4. INSERT KE IZIN LEMBUR TABLE (JIKA ADA) =====
            $adaLembur = $this->request->getPost('ada_lembur');
            if ($adaLembur !== null && (int)$adaLembur === 1) {
                $izinLemburModel = new IzinLemburModel();

                $izinLemburModel->insert([
                    'no_lembur'                          => $no_lembur,
                    'work_permit_id'                     => $workPermitId,
                    'tanggal_lembur'                     => $this->request->getPost('tanggal_lembur'),
                    'hari'                               => $this->request->getPost('hari'),
                    'jam_mulai_lembur'                   => $this->request->getPost('jam_mulai_lembur'),
                    'jam_selesai_lembur'                 => $this->request->getPost('jam_selesai_lembur'),
                    'uraian_pekerjaan'                   => $this->request->getPost('uraian_pekerjaan') ?? '',
                    'alasan_lembur'                      => $this->request->getPost('alasan_lembur') ?? '',
                    'peralatan_digunakan'                => $this->request->getPost('peralatan_digunakan') ?? '',
                    'potensi_bahaya'                     => $this->request->getPost('potensi_bahaya_lembur') ?? '',
                    'apd_digunakan'                      => $this->request->getPost('apd_digunakan') ?? '',
                    'nama_penanggung_jawab_vendor'       => $this->request->getPost('nama_penanggung_jawab_vendor') ?? '',
                    'jabatan_penanggung_jawab_vendor'    => $this->request->getPost('jabatan_penanggung_jawab_vendor') ?? '',
                    'nama_penanggung_jawab_perusahaan'   => $this->request->getPost('nama_penanggung_jawab_perusahaan') ?? '',
                    'jabatan_penanggung_jawab_perusahaan' => $this->request->getPost('jabatan_penanggung_jawab_perusahaan') ?? '',
                    'dibuat_oleh'                        => $this->request->getPost('dibuat_oleh') ?? '',
                ]);
            }

            $db->transComplete();

            return redirect()->to('/work-permit-request')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $e) {
            $db->transRollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
