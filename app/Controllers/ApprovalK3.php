<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WorkPermitModel;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\PageMargins;



class ApprovalK3 extends BaseController
{
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
            ->findAll();

        return view('approvalk3/approvalk3', [
            'title'       => 'Work Permit Approval K3',
            'workPermits' => $workPermits,
        ]);
    }

    public function approve(int $id)
    {
        $workPermitModel = new WorkPermitModel();

        $workPermit = $workPermitModel->find($id);

        if (!$workPermit) {
            return redirect()->back()->with('error', 'Work Permit tidak ditemukan.');
        }

        $workPermitModel->update($id, [
            'approved_k3_by' => user_id(),
            'status' => 'approved',
        ]);

        return redirect()->to('/approval-k3')->with('success', 'Work Permit berhasil disetujui.');
    }


    public function preview(int $id)
    {
        $db = \Config\Database::connect();
        $workPermitModel = new WorkPermitModel();

        $workPermit = $workPermitModel
            ->select('
            work_permit.*,
            pekerjaan.nama_pekerjaan,
            plant.nama_plant,
            u1.username as approved_k3_nama,
            u2.username as approved_p2k3_nama,
            izin_lembur.id as lembur_id,
            cwp.*
        ')
            ->join('pekerjaan', 'pekerjaan.id = work_permit.pekerjaan_id', 'left')
            ->join('plant', 'plant.id = work_permit.plant_id', 'left')
            ->join('users as u1', 'u1.id = work_permit.approved_k3_by', 'left')
            ->join('users as u2', 'u2.id = work_permit.approved_p2k3_by', 'left')
            ->join('izin_lembur', 'izin_lembur.work_permit_id = work_permit.id', 'left')
            ->join('checklist_work_permit as cwp', 'cwp.work_permit_id = work_permit.id', 'left')
            ->where('work_permit.id', $id)
            ->first();



        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Work Permit');

        /*
    |--------------------------------------------------------------------------
    | SETUP KOLOM
    |--------------------------------------------------------------------------
    */
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

        /*
    |--------------------------------------------------------------------------
    | STYLE UMUM
    |--------------------------------------------------------------------------
    */
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

        /*
    |--------------------------------------------------------------------------
    | HEADER
    |--------------------------------------------------------------------------
    */
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

        /*
    |--------------------------------------------------------------------------
    | CHECKLIST JENIS PEKERJAAN
    |--------------------------------------------------------------------------
    */
        $allPekerjaan = $db->table('pekerjaan')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        $checkbox = fn($checked) => $checked ? '☑' : '☐';

        $row = 3;
        $cols = ['B', 'D', 'F'];
        $colIndex = 0;

        foreach ($allPekerjaan as $p) {
            $isChecked = ((int)$p['id'] === (int)$workPermit['pekerjaan_id']);

            $sheet->setCellValue(
                $cols[$colIndex] . $row,
                $checkbox($isChecked) . ' ' . $p['nama_pekerjaan']
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
            'Pekerjaan'    => $workPermit['nama_pekerjaan'] ?? '-',
        ];

        $identitasKanan = [
            'No.'         => $workPermit['no_wp'] ?? '-',
            'Tanggal'     => $workPermit['tanggal'] ?? '-',
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

        // Mengisi data Pengawas (Kolom B:D)
        $rPengawas = $pengawasRowStart + 1;
        $sheet->mergeCells("B{$rPengawas}:D{$rPengawas}");
        if ($pengawas) {
            $sheet->setCellValue("B{$rPengawas}", "- " . $pengawas . " /");
        } else {
            $sheet->setCellValue("B{$rPengawas}", "-               /");
        }

        $currentRow = $endAllBoxRow + 1;

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
        $filename = 'Work_Permit_' . $id . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
