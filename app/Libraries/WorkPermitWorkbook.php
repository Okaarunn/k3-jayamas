<?php

namespace App\Libraries;

use App\Models\WorkPermitModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class WorkPermitWorkbook
{
    private $db;
    private $workPermitModel;

    public function __construct()
    {
        $this->db              = \Config\Database::connect();
        $this->workPermitModel = new WorkPermitModel();
    }

    // get work permit data
    private function getWorkPermitData(int $id): array
    {
        return (array) $this->workPermitModel
            ->select('
                work_permit.*,
                kategori_pekerjaan.nama_kategori_pekerjaan,
                plant.nama_plant,
                u1.username as approved_k3_nama,
                u2.username as approved_p2k3_nama,
                u3.username as rejected_k3_nama,
                u4.username as rejected_p2k3_nama,
                izin_lembur.id as lembur_id,
                progress_pengerjaan.status_pengerjaan,
                cwp.*
            ')
            ->join('kategori_pekerjaan', 'kategori_pekerjaan.id = work_permit.kategori_pekerjaan_id', 'left')
            ->join('plant', 'plant.id = work_permit.plant_id', 'left')
            ->join('users as u1', 'u1.id = work_permit.approved_k3_by', 'left')
            ->join('users as u2', 'u2.id = work_permit.approved_p2k3_by', 'left')
            ->join('users as u3', 'u3.id = work_permit.rejected_k3_by', 'left')
            ->join('users as u4', 'u4.id = work_permit.rejected_p2k3_by', 'left')
            ->join('izin_lembur', 'izin_lembur.work_permit_id = work_permit.id', 'left')
            ->join('checklist_work_permit as cwp', 'cwp.work_permit_id = work_permit.id', 'left')
            ->join('progress_pengerjaan', 'progress_pengerjaan.work_permit_id = work_permit.id', 'left')
            ->where('work_permit.id', $id)
            ->first();
    }

    // get jsa data
    private function getJsaData(int $workPermitId): array
    {
        return $this->db->table('job_safety_analyst')
            ->where('work_permit_id', $workPermitId)
            ->get()->getResultArray();
    }

    // get izin lembur data
    private function getLemburData(int $workPermitId): array
    {
        $row = $this->db->table('izin_lembur')
            ->where('work_permit_id', $workPermitId)
            ->get()->getRowArray();
        return $row ?: [];
    }

    public function getKeputusanAkhir(array $wp): string
    {
        if (!empty($wp['approved_p2k3_by'])) {
            return 'Diterima';
        }

        if (!empty($wp['rejected_k3_by']) || !empty($wp['rejected_p2k3_by'])) {
            return 'Ditolak';
        }

        return 'Menunggu';
    }

    private function getReviewerK3(array $wp): string
    {
        if (!empty($wp['rejected_k3_by'])) {
            return $wp['rejected_k3_nama'] ?? '-';
        }

        if (!empty($wp['approved_k3_by'])) {
            return $wp['approved_k3_nama'] ?? '-';
        }

        return '-';
    }

    private function getReviewerP2K3(array $wp): string
    {
        if (!empty($wp['approved_p2k3_by'])) {
            return $wp['approved_p2k3_nama'] ?? '-';
        }

        if (!empty($wp['rejected_p2k3_by'])) {
            return $wp['rejected_p2k3_nama'] ?? '-';
        }

        return '-';
    }

    private function getStatusLabel($approved, $rejected, $labelOk = 'Approved', $labelReject = 'Rejected'): string
    {
        if (!empty($rejected)) return $labelReject;
        if (!empty($approved)) return $labelOk;
        return 'Pending';
    }

    // styles
    private function styleCenter(): array
    {
        return [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ];
    }

    // thin border
    private function styleThinBorder(): array
    {
        return [
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ];
    }


    private function applyOutline($sheet, string $range): void
    {
        $sheet->getStyle($range)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
    }

    private function addKeteranganPenolakan($sheet, array $workPermit, int &$currentRow): void
    {
        $alasan = trim($workPermit['keterangan_ditolak'] ?? '');
        $isRejected = !empty($workPermit['rejected_k3_by']) || !empty($workPermit['rejected_p2k3_by']);

        // Kalau tidak ditolak atau tidak ada alasan, skip
        if (!$isRejected || $alasan === '') {
            return;
        }

        // Judul
        $sheet->mergeCells('B' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('B' . $currentRow, 'KETERANGAN PENOLAKAN');
        $sheet->getStyle('B' . $currentRow)->getFont()->setBold(true);
        $this->applyOutline($sheet, 'B' . $currentRow . ':G' . $currentRow);
        $sheet->getRowDimension($currentRow)->setRowHeight(18);
        $currentRow++;

        // Isi alasan
        $sheet->mergeCells('B' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('B' . $currentRow, $alasan);
        $sheet->getStyle('B' . $currentRow)
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_TOP);

        $this->applyOutline($sheet, 'B' . $currentRow . ':G' . $currentRow);

        // Auto height biar fleksibel
        $sheet->getRowDimension($currentRow)->setRowHeight(-1);

        $currentRow++;
    }

    // sheet 1 work permit
    private function buildWorkPermitSheet($spreadsheet, array $workPermit): void
    {
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Work Permit');

        $widths = ['A' => 2, 'B' => 22, 'C' => 18, 'D' => 22, 'E' => 18, 'F' => 8, 'G' => 13, 'H' => 2];
        foreach ($widths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }
        $sheet->getDefaultRowDimension()->setRowHeight(18);

        $center    = $this->styleCenter();
        $thinBorder = $this->styleThinBorder();
        $fmtTs     = fn($ts) => !empty($ts) ? date('d M Y H:i:s', strtotime($ts)) : '-';

        // ── Header ──
        $sheet->mergeCells('B1:E1');
        $sheet->setCellValue('B1', 'PT. Jayamas Medica Industri, Tbk');
        $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(11);

        $sheet->mergeCells('F1:G1');
        $sheet->setCellValue('F1', $workPermit['no_wp'] ?? '-');
        $sheet->getStyle('F1:G1')->applyFromArray($center);

        $sheet->mergeCells('B2:G2');
        $sheet->setCellValue('B2', 'WORK PERMIT / IJIN KERJA');
        $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('B2:G2')->applyFromArray($center);
        $sheet->getStyle('B1:G2')->applyFromArray($thinBorder);

        // ── Checklist Kategori Pekerjaan ──
        $allKategori = $this->db->table('kategori_pekerjaan')->orderBy('id', 'ASC')->get()->getResultArray();
        $checkbox    = fn($checked) => $checked ? '☑' : '☐';
        $row         = 3;
        $cols        = ['B', 'D', 'F'];
        $colIndex    = 0;

        foreach ($allKategori as $k) {
            $isChecked = ((int)$k['id'] === (int)$workPermit['kategori_pekerjaan_id']);
            $sheet->setCellValue($cols[$colIndex] . $row, $checkbox($isChecked) . ' ' . $k['nama_kategori_pekerjaan']);
            $colIndex++;
            if ($colIndex > 2) {
                $colIndex = 0;
                $row++;
            }
        }
        $sheet->getStyle('B3:G' . $row)->getFont()->setSize(10);

        // ── Identitas ──
        $startRow = $row + 1;

        $identitasKiri  = [
            'Asal Plant'     => $workPermit['nama_plant']    ?? '-',
            'Nama Pengaju'   => $workPermit['nama_pengaju']  ?? '-',
            'Lokasi Kerja'   => $workPermit['lokasi_kerja']  ?? '-',
            'Nama Pekerjaan' => $workPermit['nama_pekerjaan'] ?? '-',
        ];

        $keputusan = $this->getKeputusanAkhir($workPermit);

        $identitasKanan = [
            'Keputusan Akhir'         => $keputusan,
            'Tanggal'     => $workPermit['tgl_mulai']  ?? '-',
            'Jam Mulai'   => $workPermit['jam_mulai']  ?? '-',
            'Jam Selesai' => $workPermit['jam_selesai'] ?? '-',
        ];

        $i = 0;
        foreach ($identitasKiri as $label => $value) {
            $sheet->setCellValue('B' . ($startRow + $i), $label);
            $sheet->setCellValue('C' . ($startRow + $i), ': ' . $value);
            $i++;
        }
        $i = 0;
        foreach ($identitasKanan as $label => $value) {
            $sheet->setCellValue('E' . ($startRow + $i), $label);
            $sheet->setCellValue('F' . ($startRow + $i), ': ' . $value);
            $i++;
        }

        // ── Checklist Safety ──
        $checklistMaster = [
            'pemeriksaan_bahaya'           => 'Pemeriksaan bahaya di tempat kerja (analisa resiko / HIRA)',
            'penyediaan_apd'               => 'Penyediaan APD yang diperlukan (safety helmet, safety shoes, body harness, dll.)',
            'alat_pernapasan'              => 'Alat pernapasan buatan (respirator, masker kain)',
            'pemeriksaan_kelayakan'        => 'Pemeriksaan kelayakan peralatan yang digunakan (tangga, perancah, APD, dll.)',
            'tanda_peringatan'             => 'Rambu / tanda peringatan untuk mencegah resiko orang yang berada di bawah area kerja',
            'perlengkapan_p3k'             => 'Perlengkapan P3K',
            'penaikan_penurunan_peralatan' => 'Penaikan dan penurunan peralatan kerja dengan alat bantu (tali, tool box, dll.)',
            'peralatan_terhubung_badan'    => 'Peralatan kerja terhubung dengan badan pekerja untuk mencegah alat terjatuh',
            'pengecekan_alat_listrik'      => 'Diperlukan pengecekan alat-alat yang dialiri listrik',
            'peralatan_berisiko_dimatikan' => 'Semua peralatan berisiko sudah dimatikan (bel, sirine, cerobong asap, dll.)',
            'informasi_ke_pekerja_sekitar' => 'Memberikan informasi kepada pekerja di sekitar area kerja',
            'monitoring_pekerjaan'         => 'Monitoring selama pekerjaan berlangsung',
            'monitoring_kebersihan'        => 'Menjaga kebersihan dan kerapihan tempat kerja selama dan sesudah bekerja',
            'izin_penanganan_bahan_kimia'  => 'Diperlukan izin kerja Penanganan Bahan Kimia',
            'tersedia_apar'                => 'Tersedia APAR di tempat kerja',
        ];

        $checklistRow = $startRow + 5;

        $sheet->mergeCells('B' . $checklistRow . ':E' . $checklistRow);
        $sheet->setCellValue('B' . $checklistRow, 'Hal-hal yang perlu dilakukan sebelum kerja');
        $sheet->getStyle('B' . $checklistRow)->getFont()->setBold(true);
        $sheet->mergeCells('F' . $checklistRow . ':G' . $checklistRow);
        $sheet->setCellValue('F' . $checklistRow, 'Beri Tanda √');
        $sheet->getStyle('F' . $checklistRow)->getFont()->setBold(true);
        $sheet->getStyle('B' . $checklistRow . ':G' . $checklistRow)->applyFromArray($center);
        $sheet->getStyle('B' . $checklistRow . ':G' . $checklistRow)->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('B' . $checklistRow . ':G' . $checklistRow)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

        $sheet->setCellValue('F' . ($checklistRow + 1), 'Ya');
        $sheet->setCellValue('G' . ($checklistRow + 1), 'Tidak');
        $sheet->getStyle('F' . ($checklistRow + 1) . ':G' . ($checklistRow + 1))->getFont()->setBold(true);
        $sheet->getStyle('F' . ($checklistRow + 1) . ':G' . ($checklistRow + 1))->applyFromArray($center);
        $sheet->getStyle('B' . ($checklistRow + 1) . ':G' . ($checklistRow + 1))->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

        $currentRow = $checklistRow + 2;

        foreach ($checklistMaster as $field => $label) {
            $sheet->mergeCells('B' . $currentRow . ':E' . $currentRow);
            $sheet->setCellValue('B' . $currentRow, '• ' . $label);
            $value = (int)($workPermit[$field] ?? 0);
            $sheet->setCellValue('F' . $currentRow, $value === 1 ? '√' : '');
            $sheet->setCellValue('G' . $currentRow, $value === 0 ? '√' : '');
            $sheet->getStyle('F' . $currentRow . ':G' . $currentRow)->applyFromArray($center);
            $sheet->getStyle('B' . $currentRow . ':G' . $currentRow)->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B' . $currentRow . ':G' . $currentRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getRowDimension($currentRow)->setRowHeight(20);
            $currentRow++;
        }

        // ── APD, Pencegahan, Pekerja, Pengawas ──
        $boxRowStart      = $currentRow;
        $endTopBoxRow     = $boxRowStart + 4;
        $pengawasRowStart = $boxRowStart + 5;
        $endAllBoxRow     = $boxRowStart + 6;

        $this->applyOutline($sheet, "B{$boxRowStart}:C{$endTopBoxRow}");
        $this->applyOutline($sheet, "D{$boxRowStart}:D{$endTopBoxRow}");
        $this->applyOutline($sheet, "E{$boxRowStart}:G{$endAllBoxRow}");
        $this->applyOutline($sheet, "B{$pengawasRowStart}:D{$endAllBoxRow}");

        $sheet->mergeCells("B{$boxRowStart}:C{$boxRowStart}");
        $sheet->setCellValue("B{$boxRowStart}", "APD Yang Digunakan :");
        $sheet->getStyle("B{$boxRowStart}")->getFont()->setBold(true);
        $sheet->setCellValue("D{$boxRowStart}", "Pencegah tambahan");
        $sheet->getStyle("D{$boxRowStart}")->getFont()->setBold(true);
        $sheet->mergeCells("E{$boxRowStart}:G{$boxRowStart}");
        $sheet->setCellValue("E{$boxRowStart}", "Yang Melakukan Pekerja: / Bagian");
        $sheet->getStyle("E{$boxRowStart}")->getFont()->setBold(true);
        $sheet->mergeCells("B{$pengawasRowStart}:D{$pengawasRowStart}");
        $sheet->setCellValue("B{$pengawasRowStart}", "Yang Mengawasi :");
        $sheet->getStyle("B{$pengawasRowStart}")->getFont()->setBold(true);

        $apdList       = array_values(array_filter(array_map('trim', explode(',', $workPermit['penggunaan_apd']      ?? ''))));
        $pencegahanList = array_values(array_filter(array_map('trim', explode(',', $workPermit['pencegahan_tambahan'] ?? ''))));
        $pekerjaList   = array_values(array_filter(array_map('trim', explode(',', $workPermit['bagian_pekerjaan']    ?? ''))));
        $pengawas      = trim($workPermit['pengawasan'] ?? '');

        for ($i = 0; $i < 4; $i++) {
            $r = $boxRowStart + 1 + $i;
            $sheet->mergeCells("B{$r}:C{$r}");
            $sheet->setCellValue("B{$r}", "- " . ($apdList[$i] ?? ''));
            $sheet->setCellValue("D{$r}", "- " . ($pencegahanList[$i] ?? ''));
            $sheet->mergeCells("E{$r}:G{$r}");
            if (isset($pekerjaList[$i])) {
                $pData  = str_replace(')', '', $pekerjaList[$i]);
                $pParts = explode('(', $pData);
                $sheet->setCellValue("E{$r}", "- " . trim($pParts[0]) . " / " . trim($pParts[1] ?? ''));
            } else {
                $sheet->setCellValue("E{$r}", "-               /");
            }
        }

        for ($i = 4; $i < 6; $i++) {
            $r = $boxRowStart + 1 + $i;
            $sheet->mergeCells("E{$r}:G{$r}");
            if (isset($pekerjaList[$i])) {
                $pData  = str_replace(')', '', $pekerjaList[$i]);
                $pParts = explode('(', $pData);
                $sheet->setCellValue("E{$r}", "- " . trim($pParts[0]) . " / " . trim($pParts[1] ?? ''));
            } else {
                $sheet->setCellValue("E{$r}", "-               /");
            }
        }

        $rPengawas = $pengawasRowStart + 1;
        $sheet->mergeCells("B{$rPengawas}:D{$rPengawas}");
        if ($pengawas) {
            $result = implode(' / ', array_map('trim', explode(',', $pengawas)));
            $sheet->setCellValue("B{$rPengawas}", "- {$result} /");
        } else {
            $sheet->setCellValue("B{$rPengawas}", "-               /");
        }

        $currentRow = $endAllBoxRow + 1;

        // ── Pengesahan ──
        $sheet->mergeCells('B' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('B' . $currentRow, 'PENGESAHAN');
        $sheet->getStyle('B' . $currentRow)->getFont()->setBold(true);
        $this->applyOutline($sheet, 'B' . $currentRow . ':G' . $currentRow);
        $sheet->getRowDimension($currentRow)->setRowHeight(18);
        $currentRow++;

        $disclaimer = 'Izin ini hanya berlaku sesuai dengan waktu di atas dan jika poin-poin di atas dipatuhi, dan otomatis tidak berlaku jika terjadi keadaan gawat darurat';
        $sheet->mergeCells('B' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('B' . $currentRow, $disclaimer);
        $sheet->getStyle('B' . $currentRow)->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER);
        $this->applyOutline($sheet, 'B' . $currentRow . ':G' . $currentRow);
        $sheet->getRowDimension($currentRow)->setRowHeight(28);
        $currentRow++;

        $namaPlant = ucwords(strtolower($workPermit['nama_plant'] ?? ''));
        $tglMulai  = !empty($workPermit['tgl_mulai']) ? date('d/m/Y', strtotime($workPermit['tgl_mulai'])) : '-';

        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->mergeCells('E' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('E' . $currentRow, $namaPlant . ',  ' . $tglMulai);
        $sheet->getStyle('E' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension($currentRow)->setRowHeight(18);
        $currentRow++;



        $reviewerK3   = $this->getReviewerK3($workPermit);
        $reviewerP2K3 = $this->getReviewerP2K3($workPermit);

        $pengesahanKiri = [
            ['label' => 'Mengetahui',        'nama' => ucwords(strtolower($workPermit['mengetahui_ak3'] ?? '-'))],
            ['label' => 'Penanggung Jawab',  'nama' => ucwords(strtolower($workPermit['penanggung_jawab'] ?? '-'))],
            ['label' => 'Review (K3)',       'nama' => ucwords(strtolower($reviewerK3))],
            ['label' => 'Review (P2K3)',     'nama' => ucwords(strtolower($reviewerP2K3))],
        ];

        $pengesahanKanan = [
            ['role' => 'AK3',              'status' => 'Submitted: ' . $fmtTs($workPermit['created_at'])],
            ['role' => 'Supervisor Kerja', 'status' => 'Submitted: ' . $fmtTs($workPermit['created_at'])],
            ['role' => 'K3',               'status' => 'Verified: '  . $fmtTs($workPermit['verified_k3_at'])],
            ['role' => 'P2K3',             'status' => 'Verified: '  . $fmtTs($workPermit['verified_p2k3_at'])],
        ];

        foreach ($pengesahanKiri as $i => $item) {
            $r = $currentRow + $i;
            $sheet->setCellValue('B' . $r, $item['label']);
            $sheet->getStyle('B' . $r)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->mergeCells('C' . $r . ':D' . $r);
            $sheet->setCellValue('C' . $r, $item['nama']);
            $sheet->getStyle('C' . $r)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->setCellValue('F' . $r, $pengesahanKanan[$i]['role']);
            $sheet->getStyle('F' . $r)->getFont()->setBold(true);
            $sheet->getStyle('F' . $r)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->mergeCells('E' . $r . ':G' . $r);
            $sheet->setCellValue('E' . $r, $pengesahanKanan[$i]['status']);
            $sheet->getStyle('E' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);
            $this->applyOutline($sheet, 'B' . $r . ':G' . $r);
            $sheet->getRowDimension($r)->setRowHeight(18);
        }
        $currentRow += count($pengesahanKiri);

        $this->addKeteranganPenolakan($sheet, $workPermit, $currentRow);

        // ── Penutup ──
        $sheet->mergeCells('B' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('B' . $currentRow, 'PENUTUP');
        $sheet->getStyle('B' . $currentRow)->getFont()->setBold(true);
        $this->applyOutline($sheet, 'B' . $currentRow . ':G' . $currentRow);
        $sheet->getRowDimension($currentRow)->setRowHeight(18);
        $currentRow++;

        $sheet->mergeCells('B' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('B' . $currentRow, 'Progress Pengerjaan :');
        $sheet->getStyle('B' . $currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $this->applyOutline($sheet, 'B' . $currentRow . ':G' . $currentRow);
        $sheet->getRowDimension($currentRow)->setRowHeight(18);
        $currentRow++;

        $tglSelesai = !empty($workPermit['tgl_selesai']) ? date('d/M/Y', strtotime($workPermit['tgl_selesai'])) : '-';
        $jamSelesai = !empty($workPermit['jam_selesai']) ? date('H:i:s', strtotime($workPermit['jam_selesai'])) : '-';

        $penutupKiri = [
            ['label' => 'Penanggung Jawab', 'nilai' => ucwords(strtolower($workPermit['penanggung_jawab'] ?? '-'))],
            ['label' => 'Tanggal',          'nilai' => $tglSelesai],
            ['label' => 'Jam',              'nilai' => $jamSelesai],
        ];
        $penutupKanan = [
            ['role' => 'Supervisor Kerja', 'status' => 'Submitted: ' . $fmtTs($workPermit['created_at'])],
            ['role' => 'K3',               'status' => 'Verified: '  . $fmtTs($workPermit['verified_k3_at'])],
            ['role' => 'P2K3',             'status' => 'Approved: '  . $fmtTs($workPermit['verified_p2k3_at'])],
        ];

        foreach ($penutupKiri as $i => $item) {
            $r = $currentRow + $i;
            $sheet->setCellValue('B' . $r, $item['label']);
            $sheet->getStyle('B' . $r)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->setCellValue('C' . $r, $item['nilai']);
            $sheet->getStyle('C' . $r)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            if (isset($penutupKanan[$i])) {
                $sheet->setCellValue('F' . $r, $penutupKanan[$i]['role']);
                $sheet->getStyle('F' . $r)->getFont()->setBold(true);
                $sheet->getStyle('F' . $r)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->mergeCells('E' . $r . ':G' . $r);
                $sheet->setCellValue('E' . $r, $penutupKanan[$i]['status']);
                $sheet->getStyle('E' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);
            }
            $this->applyOutline($sheet, 'B' . $r . ':G' . $r);
            $sheet->getRowDimension($r)->setRowHeight(18);
        }
        $currentRow += count($penutupKiri);

        $sheet->getRowDimension($currentRow)->setRowHeight(8);
        $currentRow++;

        $statusPengerjaan = strtoupper($workPermit['status_pengerjaan'] ?? 'ONGOING');
        $closedBy         = $statusPengerjaan === 'FINISHED'
            ? 'CLOSED by: ' . ucwords(strtolower($workPermit['approved_k3_nama'] ?? '-'))
            : 'ONGOING';
        $closedAt         = $statusPengerjaan === 'FINISHED'
            ? 'Closed: ' . $fmtTs($workPermit['verified_p2k3_at'])
            : '-';

        $sheet->setCellValue('B' . $currentRow, 'Status');
        $sheet->getStyle('B' . $currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->mergeCells('C' . $currentRow . ':D' . $currentRow);
        $sheet->setCellValue('C' . $currentRow, $closedBy);
        $sheet->getStyle('C' . $currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue('F' . $currentRow, 'submit time');
        $sheet->getStyle('F' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('F' . $currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->mergeCells('E' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('E' . $currentRow, $closedAt);
        $sheet->getStyle('E' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);
        $this->applyOutline($sheet, 'B' . $currentRow . ':G' . $currentRow);
        $sheet->getRowDimension($currentRow)->setRowHeight(18);
        $currentRow++;

        // ── Page Setup ──
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT)->setPaperSize(PageSetup::PAPERSIZE_A4)->setFitToWidth(1)->setFitToHeight(0);
        $sheet->getPageMargins()->setTop(0.3)->setBottom(0.3)->setLeft(0.25)->setRight(0.25);
        $sheet->getPageSetup()->setScale(95);
        $sheet->getStyle('B1:G' . ($currentRow - 1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
    }

    // sheet 2 JSA
    private function buildJsaSheet($spreadsheet, array $workPermit, array $jsaRows): void
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('JSA');

        // ── Lebar kolom ──
        $sheet->getColumnDimension('A')->setWidth(2);
        $sheet->getColumnDimension('B')->setWidth(6);    // No
        $sheet->getColumnDimension('C')->setWidth(26);   // Tahap Pekerjaan
        $sheet->getColumnDimension('D')->setWidth(22);   // Bahaya
        $sheet->getColumnDimension('E')->setWidth(22);   // Resiko
        $sheet->getColumnDimension('F')->setWidth(28);   // Pengendalian
        $sheet->getColumnDimension('G')->setWidth(18);   // Penanggung Jawab
        $sheet->getDefaultRowDimension()->setRowHeight(12);

        $center     = $this->styleCenter();
        $thinBorder = $this->styleThinBorder();
        $fmtTs      = fn($ts) => !empty($ts) ? date('d/M/Y', strtotime($ts)) : '-';

        $noJsa = str_replace('WP/', 'WP-JSA/', $workPermit['no_wp'] ?? '-');

        // ── Baris 1: Nama perusahaan (kiri) + No. JSA (kanan) ──
        $sheet->mergeCells('B1:E1');
        $sheet->setCellValue('B1', 'PT. Jayamas Medica Industri, Tbk');
        $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('B1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->mergeCells('F1:G1');
        $sheet->setCellValue('F1', $noJsa);
        $sheet->getStyle('F1:G1')->applyFromArray($center);
        $sheet->getStyle('B1:G1')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getRowDimension(1)->setRowHeight(18);

        // ── Baris 2: Purpose ──
        $sheet->mergeCells('B2:G2');
        $sheet->setCellValue('B2', 'Purpose    Mencatat analisis safety dari project yang akan dilakukan');
        $sheet->getStyle('B2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B2:G2')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getRowDimension(2)->setRowHeight(18);

        // ── Baris 3: Tanggal Pekerjaan ──
        $sheet->mergeCells('B3:G3');
        $sheet->setCellValue('B3', 'Tanggal Pekerjaan : ' . $fmtTs($workPermit['tgl_mulai']));
        $sheet->getStyle('B3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B3:G3')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getRowDimension(3)->setRowHeight(18);

        // ── Baris 4: Tanggal Selesai ──
        $sheet->mergeCells('B4:G4');
        $sheet->setCellValue('B4', 'Tanggal Selesai : ' . $fmtTs($workPermit['tgl_selesai']));
        $sheet->getStyle('B4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B4:G4')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getRowDimension(4)->setRowHeight(18);

        // ── Baris 5: Nama Pekerjaan ──
        $sheet->mergeCells('B5:G5');
        $sheet->setCellValue('B5', 'Nama Pekerjaan : ' . ($workPermit['nama_pekerjaan'] ?? '-'));
        $sheet->getStyle('B5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B5:G5')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getRowDimension(5)->setRowHeight(18);

        // ── Baris 6: Header tabel JSA ──
        $headerRow = 6;
        $headers   = ['No.', 'Tahap Pekerjaan', 'Bahaya Pekerjaan', 'Resiko Pekerjaan', 'Pengendalian', 'Penanggung Jawab'];
        $cols      = ['B', 'C', 'D', 'E', 'F', 'G'];

        foreach ($headers as $idx => $header) {
            $sheet->setCellValue($cols[$idx] . $headerRow, $header);
            $sheet->getStyle($cols[$idx] . $headerRow)->getFont()->setBold(true);
            $sheet->getStyle($cols[$idx] . $headerRow)->applyFromArray($center);
            $sheet->getStyle($cols[$idx] . $headerRow)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('D9E1F2');
        }
        $sheet->getStyle('B' . $headerRow . ':G' . $headerRow)->applyFromArray($thinBorder);
        $sheet->getRowDimension($headerRow)->setRowHeight(20);

        // ── Isi baris JSA (minimal 10 baris) ──
        $dataRow  = $headerRow + 1;
        $minRows  = 10;
        $total    = max(count($jsaRows), $minRows);

        for ($i = 0; $i < $total; $i++) {
            $jsa = $jsaRows[$i] ?? null;

            $sheet->setCellValue('B' . $dataRow, $i + 1);
            $sheet->getStyle('B' . $dataRow)->applyFromArray($center);

            $sheet->setCellValue('C' . $dataRow, $jsa ? ($jsa['tahap_pekerjaan']  ?? '-') : '-');
            $sheet->setCellValue('D' . $dataRow, $jsa ? ($jsa['bahaya_pekerjaan'] ?? '-') : '-');
            $sheet->setCellValue('E' . $dataRow, $jsa ? ($jsa['resiko_pekerjaan'] ?? '-') : '-');
            $sheet->setCellValue('F' . $dataRow, $jsa ? ($jsa['pengendalian']     ?? '-') : '-');
            $sheet->setCellValue('G' . $dataRow, $jsa ? ($jsa['penanggung_jawab'] ?? '-') : '-');

            $sheet->getStyle('B' . $dataRow . ':G' . $dataRow)
                ->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B' . $dataRow . ':G' . $dataRow)->applyFromArray($thinBorder);
            $sheet->getRowDimension($dataRow)->setRowHeight(-1); // auto-fit
            $dataRow++;
        }

        // ── Anggota Team ──
        $sheet->getRowDimension($dataRow)->setRowHeight(6);
        $dataRow++;

        $sheet->mergeCells('B' . $dataRow . ':G' . $dataRow);
        $sheet->setCellValue('B' . $dataRow, 'Anggota Team :');
        $sheet->getStyle('B' . $dataRow)->getFont()->setBold(true);
        $sheet->getStyle('B' . $dataRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B' . $dataRow . ':G' . $dataRow)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getRowDimension($dataRow)->setRowHeight(18);
        $dataRow++;

        $sheet->mergeCells('B' . $dataRow . ':G' . $dataRow);
        $sheet->setCellValue('B' . $dataRow, trim($workPermit['bagian_pekerjaan'] ?? '-'));
        $sheet->getStyle('B' . $dataRow)->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B' . $dataRow . ':G' . $dataRow)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getRowDimension($dataRow)->setRowHeight(28);
        $dataRow++;

        // ── Supervisor Kerja & AK3 Umum ──
        $sheet->getRowDimension($dataRow)->setRowHeight(6);
        $dataRow++;

        $signatoryData = [
            ['Supervisor Kerja', $workPermit['penanggung_jawab'] ?? '-'],
            ['AK3 Umum',         $workPermit['mengetahui_ak3']  ?? '-'],
        ];

        foreach ($signatoryData as $sig) {
            $sheet->mergeCells('B' . $dataRow . ':C' . $dataRow);
            $sheet->setCellValue('B' . $dataRow, $sig[0] . ' :');
            $sheet->getStyle('B' . $dataRow)->getFont()->setBold(true);
            $sheet->getStyle('B' . $dataRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->mergeCells('D' . $dataRow . ':G' . $dataRow);
            $sheet->setCellValue('D' . $dataRow, $sig[1]);
            $sheet->getStyle('D' . $dataRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B' . $dataRow . ':G' . $dataRow)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getRowDimension($dataRow)->setRowHeight(18);
            $dataRow++;
        }

        // ── Status ──
        $sheet->getRowDimension($dataRow)->setRowHeight(6);
        $dataRow++;

        $statusPengerjaan = strtoupper($workPermit['status_pengerjaan'] ?? 'ONGOING');
        $fmtTsFull        = fn($ts) => !empty($ts) ? date('d M Y H:i:s', strtotime($ts)) : '-';
        $statusText       = $statusPengerjaan === 'FINISHED'
            ? 'Closed: ' . $fmtTsFull($workPermit['verified_p2k3_at'])
            : 'ONGOING';

        $sheet->mergeCells('B' . $dataRow . ':C' . $dataRow);
        $sheet->setCellValue('B' . $dataRow, 'STATUS :');
        $sheet->getStyle('B' . $dataRow)->getFont()->setBold(true);
        $sheet->getStyle('B' . $dataRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->mergeCells('D' . $dataRow . ':G' . $dataRow);
        $sheet->setCellValue('D' . $dataRow, $statusText);
        $sheet->getStyle('D' . $dataRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B' . $dataRow . ':G' . $dataRow)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getRowDimension($dataRow)->setRowHeight(18);
        $dataRow++;

        // ── Border luar keseluruhan ──
        $sheet->getStyle('B1:G' . ($dataRow - 1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        // ── Page Setup ──
        $sheet->getPageSetup()
            ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(PageSetup::PAPERSIZE_A4)
            ->setFitToWidth(1)
            ->setFitToHeight(0);
        $sheet->getPageMargins()->setTop(0.3)->setBottom(0.3)->setLeft(0.25)->setRight(0.25);
        $sheet->getPageSetup()->setScale(95);
    }

    // shee 3 lembur
    private function buildLemburSheet($spreadsheet, array $workPermit, array $lembur): void
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Izin Lembur');

        $sheet->getColumnDimension('A')->setWidth(2);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getDefaultRowDimension()->setRowHeight(18);

        $center     = $this->styleCenter();
        $thinBorder = $this->styleThinBorder();

        // ── Header ──
        $sheet->mergeCells('B1:C1');
        $sheet->setCellValue('B1', 'PT. Jayamas Medica Industri, Tbk');
        $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('B1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->mergeCells('D1:E1');
        $sheet->setCellValue('D1', $lembur['no_lembur'] ?? '-');
        $sheet->getStyle('D1:E1')->applyFromArray($center);

        $sheet->mergeCells('B2:E2');
        $sheet->setCellValue('B2', 'IZIN LEMBUR');
        $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('B2:E2')->applyFromArray($center);
        $sheet->getStyle('B1:E2')->applyFromArray($thinBorder);

        if (empty($lembur)) {
            $sheet->mergeCells('B3:E3');
            $sheet->setCellValue('B3', 'Tidak ada data izin lembur untuk work permit ini.');
            $sheet->getStyle('B3')->applyFromArray($center);
            $this->applyOutline($sheet, 'B3:E3');
            return;
        }

        // ── Data Lembur ──
        $fields = [
            ['No. Lembur',          $lembur['no_lembur']      ?? '-'],
            ['Tanggal Lembur',      !empty($lembur['tanggal_lembur']) ? date('d/m/Y', strtotime($lembur['tanggal_lembur'])) : '-'],
            ['Hari',                $lembur['hari']           ?? '-'],
            ['Jam Mulai',           $lembur['jam_mulai_lembur']  ?? '-'],
            ['Jam Selesai',         $lembur['jam_selesai_lembur'] ?? '-'],
            ['Uraian Pekerjaan',    $lembur['uraian_pekerjaan']   ?? '-'],
            ['Alasan Lembur',       $lembur['alasan_lembur']      ?? '-'],
            ['Peralatan Digunakan', $lembur['peralatan_digunakan'] ?? '-'],
            ['Potensi Bahaya',      $lembur['potensi_bahaya']     ?? '-'],
            ['APD Digunakan',       $lembur['apd_digunakan']      ?? '-'],
        ];

        $currentRow = 3;
        foreach ($fields as $field) {
            // Kolom B: label + titik dua
            $sheet->setCellValue('B' . $currentRow, $field[0] . ' :');
            $sheet->getStyle('B' . $currentRow)->getFont()->setBold(true);
            $sheet->getStyle('B' . $currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            // Kolom C:E merge: nilai
            $sheet->mergeCells('C' . $currentRow . ':E' . $currentRow);
            $sheet->setCellValue('C' . $currentRow, $field[1]);
            $sheet->getStyle('C' . $currentRow)->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->getStyle('B' . $currentRow . ':E' . $currentRow)->applyFromArray($thinBorder);
            $sheet->getRowDimension($currentRow)->setRowHeight(-1);
            $currentRow++;
        }

        // ── Penanggung Jawab ──
        $sheet->getRowDimension($currentRow)->setRowHeight(8);
        $currentRow++;

        // Header PJ
        $sheet->mergeCells('B' . $currentRow . ':E' . $currentRow);
        $sheet->setCellValue('B' . $currentRow, 'Penanggung Jawab');
        $sheet->getStyle('B' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('B' . $currentRow . ':E' . $currentRow)
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('D9E1F2');
        $sheet->getStyle('B' . $currentRow . ':E' . $currentRow)->applyFromArray($thinBorder);
        $currentRow++;

        // Sub header
        $sheet->setCellValue('B' . $currentRow, 'Pihak');
        $sheet->setCellValue('C' . $currentRow, 'Nama');
        $sheet->mergeCells('D' . $currentRow . ':E' . $currentRow);
        $sheet->setCellValue('D' . $currentRow, 'Jabatan');
        foreach (['B', 'C', 'D'] as $col) {
            $sheet->getStyle($col . $currentRow)->getFont()->setBold(true);
            $sheet->getStyle($col . $currentRow)->applyFromArray($center);
        }
        $sheet->getStyle('B' . $currentRow . ':E' . $currentRow)->applyFromArray($thinBorder);
        $currentRow++;

        $pjData = [
            ['Vendor',     'nama_penanggung_jawab_vendor',     'jabatan_penanggung_jawab_vendor'],
            ['Perusahaan', 'nama_penanggung_jawab_perusahaan', 'jabatan_penanggung_jawab_perusahaan'],
        ];

        foreach ($pjData as $pj) {
            $sheet->setCellValue('B' . $currentRow, $pj[0]);
            $sheet->getStyle('B' . $currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->setCellValue('C' . $currentRow, $lembur[$pj[1]] ?? '-');
            $sheet->getStyle('C' . $currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->mergeCells('D' . $currentRow . ':E' . $currentRow);
            $sheet->setCellValue('D' . $currentRow, $lembur[$pj[2]] ?? '-');
            $sheet->getStyle('D' . $currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->getStyle('B' . $currentRow . ':E' . $currentRow)->applyFromArray($thinBorder);
            $sheet->getRowDimension($currentRow)->setRowHeight(18);
            $currentRow++;
        }

        // ── Dibuat Oleh ──
        $sheet->getRowDimension($currentRow)->setRowHeight(8);
        $currentRow++;

        $sheet->setCellValue('B' . $currentRow, 'Dibuat Oleh :');
        $sheet->getStyle('B' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('B' . $currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->mergeCells('C' . $currentRow . ':E' . $currentRow);
        $sheet->setCellValue('C' . $currentRow, $lembur['dibuat_oleh'] ?? '-');
        $sheet->getStyle('C' . $currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('B' . $currentRow . ':E' . $currentRow)->applyFromArray($thinBorder);
        $sheet->getRowDimension($currentRow)->setRowHeight(18);
        $currentRow++;

        // ── Border luar ──
        $sheet->getStyle('B1:E' . ($currentRow - 1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        // ── Page Setup ──
        $sheet->getPageSetup()
            ->setOrientation(PageSetup::ORIENTATION_PORTRAIT)
            ->setPaperSize(PageSetup::PAPERSIZE_A4)
            ->setFitToWidth(1)
            ->setFitToHeight(0);
        $sheet->getPageMargins()->setTop(0.3)->setBottom(0.3)->setLeft(0.25)->setRight(0.25);
        $sheet->getPageSetup()->setScale(95);
    }

    // get file name
    public function getFilename(int $id): string
    {
        $data = $this->getWorkPermitData($id);
        $noWp = $data['no_wp'] ?? $id;

        return 'WorkPermit_' . str_replace('/', '-', $noWp) . '.xlsx';
    }

    // generate spreadsheet for email
    public function generate(int $id): string
    {
        $spreadsheet = $this->build($id);

        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        return ob_get_clean();
    }

    // preview to download file
    public function download(int $id): void
    {
        $spreadsheet = $this->build($id);
        $filename    = $this->getFilename($id);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // build excel
    private function build(int $id): Spreadsheet
    {
        $workPermit = $this->getWorkPermitData($id);

        if (!$workPermit) {
            throw new \RuntimeException('Work permit id=' . $id . ' tidak ditemukan.');
        }

        $jsaRows     = $this->getJsaData($id);
        $lembur      = $this->getLemburData($id);
        $spreadsheet = new Spreadsheet();

        $this->buildWorkPermitSheet($spreadsheet, $workPermit);
        $this->buildJsaSheet($spreadsheet, $workPermit, $jsaRows);
        $this->buildLemburSheet($spreadsheet, $workPermit, $lembur);

        $spreadsheet->setActiveSheetIndex(0);

        return $spreadsheet;
    }
}
