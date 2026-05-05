<?php

namespace App\Libraries;

use App\Models\WorkPermitModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\PageMargins;

class WorkPermitExcel
{
    public function generate(int $id)
    {
        $db = \Config\Database::connect();
        $workPermitModel = new WorkPermitModel();

        $workPermit = $workPermitModel
            ->select('
            work_permit.*,
            kategori_pekerjaan.nama_kategori_pekerjaan,
            plant.nama_plant,
            u1.username as approved_k3_nama,
            u2.username as approved_p2k3_nama,
            izin_lembur.id as lembur_id,
            progress_pengerjaan.status_pengerjaan,
            cwp.*
        ')
            ->join('kategori_pekerjaan', 'kategori_pekerjaan.id = work_permit.kategori_pekerjaan_id', 'left')
            ->join('plant', 'plant.id = work_permit.plant_id', 'left')
            ->join('users as u1', 'u1.id = work_permit.approved_k3_by', 'left')
            ->join('users as u2', 'u2.id = work_permit.approved_p2k3_by', 'left')
            ->join('izin_lembur', 'izin_lembur.work_permit_id = work_permit.id', 'left')
            ->join('checklist_work_permit as cwp', 'cwp.work_permit_id = work_permit.id', 'left')
            ->join('progress_pengerjaan', 'progress_pengerjaan.work_permit_id = work_permit.id', 'left')
            ->where('work_permit.id', $id)
            ->first();





        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Work Permit');

        //    kolom
        $widths = [
            'A' => 2,
            'B' => 22,
            'C' => 18,
            'D' => 22,
            'E' => 18,
            'F' => 8,
            'G' => 13,
        ];

        foreach ($widths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        $sheet->getDefaultRowDimension()->setRowHeight(18);

        //    style
        $center = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ];

        $leftCenter = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ];

        $thinBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        //  header
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

        //    checklist k3
        $allKategoriPekerjaan = $db->table('kategori_pekerjaan')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        $checkbox = fn($checked) => $checked ? '☑' : '☐';

        $row = 3;
        $cols = ['B', 'D', 'F'];
        $colIndex = 0;

        foreach ($allKategoriPekerjaan as $k) {
            $isChecked = ((int)$k['id'] === (int)$workPermit['kategori_pekerjaan_id']);

            $sheet->setCellValue(
                $cols[$colIndex] . $row,
                $checkbox($isChecked) . ' ' . $k['nama_kategori_pekerjaan']
            );

            $colIndex++;

            if ($colIndex > 2) {
                $colIndex = 0;
                $row++;
            }
        }

        $sheet->getStyle('B3:G' . $row)->getFont()->setSize(10);

        /*
    |--------------------------------------------------------------------------
    | IDENTITAS
    |--------------------------------------------------------------------------
    */
        $startRow = $row + 1;

        $identitasKiri = [
            'Asal Plant'   => $workPermit['nama_plant'] ?? '-',
            'Nama Pengaju' => $workPermit['nama_pengaju'] ?? '-',
            'Lokasi Kerja' => $workPermit['lokasi_kerja'] ?? '-',
            'Nama Pekerjaan' => $workPermit['nama_pekerjaan'] ?? '-',
        ];

        $identitasKanan = [
            'No.'         => $workPermit['no_wp'] ?? '-',
            'Tanggal'     => $workPermit['tgl_mulai'] ?? '-',
            'Jam Mulai'   => $workPermit['jam_mulai'] ?? '-',
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

        /*
    |--------------------------------------------------------------------------
    | CHECKLIST SAFETY
    |--------------------------------------------------------------------------
    */
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

        // Header utama
        $sheet->mergeCells('B' . $checklistRow . ':E' . $checklistRow);
        $sheet->setCellValue('B' . $checklistRow, 'Hal-hal yang perlu dilakukan sebelum kerja');
        $sheet->getStyle('B' . $checklistRow)->getFont()->setBold(true);

        $sheet->mergeCells('F' . $checklistRow . ':G' . $checklistRow);
        $sheet->setCellValue('F' . $checklistRow, 'Beri Tanda √');
        $sheet->getStyle('F' . $checklistRow)->getFont()->setBold(true);

        $sheet->getStyle('B' . $checklistRow . ':G' . $checklistRow)
            ->applyFromArray($center);

        // Border top & bottom header utama
        $sheet->getStyle('B' . $checklistRow . ':G' . $checklistRow)
            ->getBorders()
            ->getTop()
            ->setBorderStyle(Border::BORDER_THIN);

        $sheet->getStyle('B' . $checklistRow . ':G' . $checklistRow)
            ->getBorders()
            ->getBottom()
            ->setBorderStyle(Border::BORDER_THIN);

        // Sub header
        $sheet->setCellValue('F' . ($checklistRow + 1), 'Ya');
        $sheet->setCellValue('G' . ($checklistRow + 1), 'Tidak');

        $sheet->getStyle('F' . ($checklistRow + 1) . ':G' . ($checklistRow + 1))
            ->getFont()->setBold(true);

        $sheet->getStyle('F' . ($checklistRow + 1) . ':G' . ($checklistRow + 1))
            ->applyFromArray($center);

        // Border bottom sub-header
        $sheet->getStyle('B' . ($checklistRow + 1) . ':G' . ($checklistRow + 1))
            ->getBorders()
            ->getBottom()
            ->setBorderStyle(Border::BORDER_THIN);

        $currentRow = $checklistRow + 2;

        foreach ($checklistMaster as $field => $label) {
            // Deskripsi checklist
            $sheet->mergeCells('B' . $currentRow . ':E' . $currentRow);
            $sheet->setCellValue('B' . $currentRow, '• ' . $label);

            $value = (int)($workPermit[$field] ?? 0);

            // Kolom Ya / Tidak
            $sheet->setCellValue('F' . $currentRow, $value === 1 ? '√' : '');
            $sheet->setCellValue('G' . $currentRow, $value === 0 ? '√' : '');

            // Alignment kolom Ya / Tidak
            $sheet->getStyle('F' . $currentRow . ':G' . $currentRow)
                ->applyFromArray($center);

            // Alignment seluruh baris
            $sheet->getStyle('B' . $currentRow . ':G' . $currentRow)
                ->getAlignment()
                ->setWrapText(true)
                ->setVertical(Alignment::VERTICAL_CENTER);

            // Border seluruh baris (B sampai G)
            $sheet->getStyle('B' . $currentRow . ':G' . $currentRow)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $sheet->getRowDimension($currentRow)->setRowHeight(20);

            $currentRow++;
        }


        /*
        |--------------------------------------------------------------------------
        | BAGIAN APD, PENCEGAHAN, PEKERJA, DAN PENGAWAS (KOLOM E-G)
        |--------------------------------------------------------------------------
        */
        $boxRowStart = $currentRow;

        // Menentukan batas baris untuk setiap kotak
        $endTopBoxRow = $boxRowStart + 4; // 5 baris untuk kotak atas
        $pengawasRowStart = $boxRowStart + 5; // Baris mulai untuk pengawas
        $endAllBoxRow = $boxRowStart + 6; // Total batas bawah

        // Set outline border untuk masing-masing kotak (Disesuaikan dengan permintaan kolom E-G)
        $sheet->getStyle("B{$boxRowStart}:C{$endTopBoxRow}")->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("D{$boxRowStart}:D{$endTopBoxRow}")->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("E{$boxRowStart}:G{$endAllBoxRow}")->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("B{$pengawasRowStart}:D{$endAllBoxRow}")->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        // Header Kotak
        $sheet->mergeCells("B{$boxRowStart}:C{$boxRowStart}");
        $sheet->setCellValue("B{$boxRowStart}", "APD Yang Digunakan :");
        $sheet->getStyle("B{$boxRowStart}")->getFont()->setBold(true);

        // Pencegah tambahan kini hanya di kolom D (tanpa merge)
        $sheet->setCellValue("D{$boxRowStart}", "Pencegah tambahan");
        $sheet->getStyle("D{$boxRowStart}")->getFont()->setBold(true);

        // Pekerja kini menggunakan kolom E hingga G
        $sheet->mergeCells("E{$boxRowStart}:G{$boxRowStart}");
        $sheet->setCellValue("E{$boxRowStart}", "Yang Melakukan Pekerja: / Bagian");
        $sheet->getStyle("E{$boxRowStart}")->getFont()->setBold(true);

        // Pengawas kini menempati kolom B hingga D
        $sheet->mergeCells("B{$pengawasRowStart}:D{$pengawasRowStart}");
        $sheet->setCellValue("B{$pengawasRowStart}", "Yang Mengawasi :");
        $sheet->getStyle("B{$pengawasRowStart}")->getFont()->setBold(true);

        // Ekstrak data menjadi array
        $apdList = array_values(array_filter(array_map('trim', explode(',', $workPermit['penggunaan_apd'] ?? ''))));
        $pencegahanList = array_values(array_filter(array_map('trim', explode(',', $workPermit['pencegahan_tambahan'] ?? ''))));
        $pekerjaList = array_values(array_filter(array_map('trim', explode(',', $workPermit['bagian_pekerjaan'] ?? ''))));
        $pengawas = trim($workPermit['pengawasan'] ?? '');

        // Mengisi baris untuk APD, Pencegahan, dan Pekerja (Kotak Atas)
        for ($i = 0; $i < 4; $i++) {
            $r = $boxRowStart + 1 + $i;

            // Isi APD (Kolom B:C)
            $sheet->mergeCells("B{$r}:C{$r}");
            $apdText = isset($apdList[$i]) ? $apdList[$i] : '';
            $sheet->setCellValue("B{$r}", "- " . $apdText);

            // Isi Pencegahan (Kolom D saja)
            $pencegahText = isset($pencegahanList[$i]) ? $pencegahanList[$i] : '';
            $sheet->setCellValue("D{$r}", "- " . $pencegahText);

            // Isi Pekerja (Kolom E:G)
            $sheet->mergeCells("E{$r}:G{$r}");
            if (isset($pekerjaList[$i])) {
                $pData = str_replace(')', '', $pekerjaList[$i]);
                $pParts = explode('(', $pData);
                $name = trim($pParts[0]);
                $bagian = isset($pParts[1]) ? trim($pParts[1]) : '';
                $sheet->setCellValue("E{$r}", "- {$name} / {$bagian}");
            } else {
                $sheet->setCellValue("E{$r}", "-               /");
            }
        }

        // Tambahan baris khusus untuk Pekerja (Kolom E:G) agar sejajar ke bawah
        for ($i = 4; $i < 6; $i++) {
            $r = $boxRowStart + 1 + $i;
            $sheet->mergeCells("E{$r}:G{$r}");

            if (isset($pekerjaList[$i])) {
                $pData = str_replace(')', '', $pekerjaList[$i]);
                $pParts = explode('(', $pData);
                $name = trim($pParts[0]);
                $bagian = isset($pParts[1]) ? trim($pParts[1]) : '';
                $sheet->setCellValue("E{$r}", "- {$name} / {$bagian}");
            } else {
                $sheet->setCellValue("E{$r}", "-               /");
            }
        }
        $rPengawas = $pengawasRowStart + 1;
        $sheet->mergeCells("B{$rPengawas}:D{$rPengawas}");

        if ($pengawas) {
            // pecah string jadi array
            $listPengawas = explode(',', $pengawas);

            // rapikan spasi
            $listPengawas = array_map('trim', $listPengawas);

            // gabungkan dengan separator " / "
            $result = implode(' / ', $listPengawas);

            $sheet->setCellValue("B{$rPengawas}", "- {$result} /");
        } else {
            $sheet->setCellValue("B{$rPengawas}", "-               /");
        }

        $currentRow = $endAllBoxRow + 1;

        /*
        |--------------------------------------------------------------------------
        | III. PENGESAHAN
        |--------------------------------------------------------------------------
        */

        // Header seksi
        $sheet->mergeCells('B' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('B' . $currentRow, 'PENGESAHAN');
        $sheet->getStyle('B' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('B' . $currentRow . ':G' . $currentRow)
            ->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getRowDimension($currentRow)->setRowHeight(18);
        $currentRow++;

        // Teks disclaimer
        $disclaimer = 'Izin ini hanya berlaku sesuai dengan waktu di atas dan jika poin-poin di atas dipatuhi, '
            . 'dan otomatis tidak berlaku jika terjadi keadaan gawat darurat';
        $sheet->mergeCells('B' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('B' . $currentRow, $disclaimer);
        $sheet->getStyle('B' . $currentRow)
            ->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B' . $currentRow . ':G' . $currentRow)
            ->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getRowDimension($currentRow)->setRowHeight(28);
        $currentRow++;

        // Baris lokasi + tanggal (rata kanan)
        $namaPlant = ucwords(strtolower($workPermit['nama_plant'] ?? ''));
        $tglMulai  = !empty($workPermit['tgl_mulai'])
            ? date('d/m/Y', strtotime($workPermit['tgl_mulai']))
            : '-';

        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->mergeCells('E' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('E' . $currentRow, $namaPlant . ',  ' . $tglMulai);
        $sheet->getStyle('E' . $currentRow)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension($currentRow)->setRowHeight(18);
        $currentRow++;

        // Helper format timestamp
        $fmtTs = fn($ts) => !empty($ts) ? date('d M Y H:i:s', strtotime($ts)) : '-';

        // Data 4 baris pengesahan
        $pengesahanKiri = [
            ['label' => 'Mengetahui',        'nama' => ucwords(strtolower($workPermit['mengetahui_ak3']     ?? '-'))],
            ['label' => 'Penanggung Jawab',  'nama' => ucwords(strtolower($workPermit['penanggung_jawab']   ?? '-'))],
            ['label' => 'Di Review',         'nama' => ucwords(strtolower($workPermit['approved_k3_nama']   ?? '-'))],
            ['label' => 'Yang Memberi Izin', 'nama' => ucwords(strtolower($workPermit['approved_p2k3_nama'] ?? '-'))],
        ];

        $pengesahanKanan = [
            ['role' => 'AK3',              'status' => 'Submitted: ' . $fmtTs($workPermit['created_at'])],
            ['role' => 'Supervisor Kerja', 'status' => 'Submitted: ' . $fmtTs($workPermit['created_at'])],
            ['role' => 'K3',               'status' => 'Verified: '  . $fmtTs($workPermit['verified_k3_at'])],
            ['role' => 'P2K3',             'status' => 'Approved: '  . $fmtTs($workPermit['verified_p2k3_at'])],
        ];

        foreach ($pengesahanKiri as $i => $item) {
            $r = $currentRow + $i;

            // Kolom B  : label (Mengetahui, dst.)
            $sheet->setCellValue('B' . $r, $item['label']);
            $sheet->getStyle('B' . $r)
                ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            // Kolom C  : titik dua


            // Kolom D  : nilai nama (merge D sampai sebelum kolom kanan)
            $sheet->mergeCells('C' . $r . ':D' . $r);
            $sheet->setCellValue('C' . $r, $item['nama']);
            $sheet->getStyle('C' . $r)
                ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            // Kolom F  : role (bold)
            $sheet->setCellValue('F' . $r, $pengesahanKanan[$i]['role']);
            $sheet->getStyle('F' . $r)->getFont()->setBold(true);
            $sheet->getStyle('F' . $r)
                ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            // Kolom G  : status + timestamp
            $sheet->mergeCells('E' . $r . ':G' . $r);
            $sheet->setCellValue('E' . $r, $pengesahanKanan[$i]['status']);
            $sheet->getStyle('E' . $r)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT)
                ->setVertical(Alignment::VERTICAL_CENTER);

            // Border outline per baris, tanpa border di tengah
            $sheet->getStyle('B' . $r . ':G' . $r)
                ->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

            $sheet->getRowDimension($r)->setRowHeight(18);
        }

        $currentRow += count($pengesahanKiri);



        // Header seksi
        $sheet->mergeCells('B' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('B' . $currentRow, 'PENUTUP');
        $sheet->getStyle('B' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('B' . $currentRow . ':G' . $currentRow)
            ->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getRowDimension($currentRow)->setRowHeight(18);
        $currentRow++;

        // Teks pembuka
        $sheet->mergeCells('B' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('B' . $currentRow, 'Progress Pengerjaan :');
        $sheet->getStyle('B' . $currentRow)
            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B' . $currentRow . ':G' . $currentRow)
            ->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getRowDimension($currentRow)->setRowHeight(18);
        $currentRow++;

        // Data kiri: Penanggung Jawab, Tanggal, Jam
        $tglSelesai = !empty($workPermit['tgl_selesai'])
            ? date('d/M/Y', strtotime($workPermit['tgl_selesai']))
            : '-';

        $jamSelesai = !empty($workPermit['jam_selesai'])
            ? date('H:i:s', strtotime($workPermit['jam_selesai']))
            : '-';

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

            // Kolom B : label
            $sheet->setCellValue('B' . $r, $item['label']);
            $sheet->getStyle('B' . $r)
                ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


            // Kolom C : nilai
            $sheet->mergeCells('D' . $r . ':D' . $r);
            $sheet->setCellValue('C' . $r, $item['nilai']);
            $sheet->getStyle('C' . $r)
                ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            // Kolom kanan: role + status (hanya 3 baris pertama)
            if (isset($penutupKanan[$i])) {
                $sheet->setCellValue('F' . $r, $penutupKanan[$i]['role']);
                $sheet->getStyle('F' . $r)->getFont()->setBold(true);
                $sheet->getStyle('F' . $r)
                    ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->mergeCells('E' . $r . ':G' . $r);
                $sheet->setCellValue('E' . $r, $penutupKanan[$i]['status']);
                $sheet->getStyle('E' . $r)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT)
                    ->setVertical(Alignment::VERTICAL_CENTER);
            }

            $sheet->getStyle('B' . $r . ':G' . $r)
                ->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getRowDimension($r)->setRowHeight(18);
        }

        $currentRow += count($penutupKiri);

        // Baris kosong pemisah
        $sheet->getRowDimension($currentRow)->setRowHeight(8);
        $currentRow++;

        // Baris Status
        $statusPengerjaan = strtoupper($workPermit['status_pengerjaan'] ?? 'ONGOING');
        $statusLabel      = $statusPengerjaan === 'FINISHED' ? 'CLOSED' : 'ONGOING';

        // Ambil nama yang menutup (approved_k3_nama jika finished, atau kosong)
        $closedBy = $statusPengerjaan === 'FINISHED'
            ? 'CLOSED by: ' . ucwords(strtolower($workPermit['approved_k3_nama'] ?? '-'))
            : 'ONGOING';

        $sheet->setCellValue('B' . $currentRow, 'Status');
        $sheet->getStyle('B' . $currentRow)
            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);



        $sheet->mergeCells('C' . $currentRow . ':D' . $currentRow);
        $sheet->setCellValue('C' . $currentRow, $closedBy);
        $sheet->getStyle('C' . $currentRow)
            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->setCellValue('F' . $currentRow, 'submit time');
        $sheet->getStyle('F' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('F' . $currentRow)
            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $closedAt = $statusPengerjaan === 'FINISHED'
            ? 'Closed: ' . $fmtTs($workPermit['verified_p2k3_at'])
            : '-';

        $sheet->mergeCells('E' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('E' . $currentRow, $closedAt);
        $sheet->getStyle('E' . $currentRow)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('B' . $currentRow . ':G' . $currentRow)
            ->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getRowDimension($currentRow)->setRowHeight(18);
        $currentRow++;

        /*
    |--------------------------------------------------------------------------
    | PAGE SETUP
    |--------------------------------------------------------------------------
    */
        $sheet->getPageSetup()
            ->setOrientation(PageSetup::ORIENTATION_PORTRAIT)
            ->setPaperSize(PageSetup::PAPERSIZE_A4)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        $sheet->getPageMargins()
            ->setTop(0.3)
            ->setBottom(0.3)
            ->setLeft(0.25)
            ->setRight(0.25);

        $sheet->getPageSetup()->setScale(95);


        /*
|--------------------------------------------------------------------------
| BORDER LUAR SAJA
|--------------------------------------------------------------------------
*/
        $lastRow = $currentRow - 1; // baris terakhir dari checklist

        $sheet->getStyle('B1:G' . $lastRow)
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(Border::BORDER_THIN);

        /*
    |--------------------------------------------------------------------------
    | OUTPUT
    |--------------------------------------------------------------------------
    */
        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $data = ob_get_clean();

        return $data;
    }
}
