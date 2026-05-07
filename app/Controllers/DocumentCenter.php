<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\WorkPermitWorkbook;
use App\Models\DocumentCenterModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DocumentCenter extends BaseController
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

        $documentCenterModel = new DocumentCenterModel();

        $myPlantId = $this->currentUserPlantId();

        $builder = $documentCenterModel
            ->select('
                document_center.work_permit_id,
                work_permit.no_wp,
                work_permit.nama_pengaju,
                work_permit.tgl_mulai,
                work_permit.tgl_selesai,
                work_permit.nama_pekerjaan,
                work_permit.lokasi_kerja,
                plant.nama_plant,
                izin_lembur.no_lembur,
                progress_pengerjaan.status_pengerjaan
            ')
            ->join('work_permit', 'work_permit.id = document_center.work_permit_id', 'left')
            ->join('plant', 'plant.id = work_permit.plant_id', 'left')
            ->join('izin_lembur', 'izin_lembur.id = document_center.izin_lembur_id', 'left')
            ->join('progress_pengerjaan', 'progress_pengerjaan.id = document_center.progress_pengerjaan_id', 'left')
            ->orderBy('work_permit.created_at', 'DESC');


        if (!in_groups('administrator')) {
            $builder->where('work_permit.plant_id', $myPlantId);
        }

        $documentCenters = $builder->findAll();


        return view('document_center/document_center', [
            'title'           => 'Document Center K3',
            'documentCenters' => $documentCenters,
        ]);
    }

    // export excel
    public function exportExcel()
    {
        $isAdmin   = in_groups('administrator');
        $myPlantId = $this->currentUserPlantId();

        // Gunakan db builder langsung, bukan model
        $builder = $this->db->table('document_center')
            ->select('
            work_permit.no_wp,
            work_permit.nama_pengaju,
            work_permit.tgl_mulai,
            work_permit.tgl_selesai,
            work_permit.nama_pekerjaan,
            work_permit.lokasi_kerja,
            plant.nama_plant,
            izin_lembur.no_lembur,
            progress_pengerjaan.status_pengerjaan
        ')
            ->join('work_permit',         'work_permit.id = document_center.work_permit_id',              'left')
            ->join('plant',               'plant.id = work_permit.plant_id',                              'left')
            ->join('izin_lembur',         'izin_lembur.id = document_center.izin_lembur_id',              'left')
            ->join('progress_pengerjaan', 'progress_pengerjaan.id = document_center.progress_pengerjaan_id', 'left')
            ->orderBy('work_permit.created_at', 'DESC');


        if (! $isAdmin) {
            $builder->where('work_permit.plant_id', $myPlantId);
        }

        $data = $builder->get()->getResultObject(); // <-- bukan findAll()

        // ── Spreadsheet ──────────────────────────────────────────
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Document Center');

        // ── Header kolom ─────────────────────────────────────────
        $headers = [
            'A' => '#',
            'B' => 'NO WP/JSA',
            'C' => 'No Lembur',
            'D' => 'Identitas Pengaju',
            'E' => 'Tanggal Mulai',
            'F' => 'Tanggal Selesai',
            'G' => 'Pekerjaan',
            'H' => 'Lokasi',
            'I' => 'Status',
        ];

        // Tambahkan kolom Plant untuk administrator
        if ($isAdmin) {
            $headers['J'] = 'Plant';
        }

        foreach ($headers as $col => $label) {
            $sheet->setCellValue($col . '1', $label);
        }

        // ── Style header ─────────────────────────────────────────
        $lastCol        = $isAdmin ? 'J' : 'I';
        $headerRange    = 'A1:' . $lastCol . '1';

        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold'  => true,
                'name'  => 'Arial',
                'size'  => 11,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF2E7D32'], // hijau gelap K3
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color'       => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // ── Isi data ──────────────────────────────────────────────
        $rowNum = 2;
        $no     = 1;

        foreach ($data as $row) {
            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValue('B' . $rowNum, $row->no_wp         ?? '-');
            $sheet->setCellValue('C' . $rowNum, $row->no_lembur     ?? '-');
            $sheet->setCellValue('D' . $rowNum, $row->nama_pengaju  ?? '-');
            $sheet->setCellValue('E' . $rowNum, $row->tgl_mulai     ?? '-');
            $sheet->setCellValue('F' . $rowNum, $row->tgl_selesai   ?? '-');
            $sheet->setCellValue('G' . $rowNum, $row->nama_pekerjaan ?? '-');
            $sheet->setCellValue('H' . $rowNum, $row->lokasi_kerja  ?? '-');
            $sheet->setCellValue('I' . $rowNum, $row->status_pengerjaan ?? '-');

            if ($isAdmin) {
                $sheet->setCellValue('J' . $rowNum, $row->nama_plant ?? '-');
            }

            // Tinggi baris data
            $sheet->getRowDimension($rowNum)->setRowHeight(20);

            // Border & alignment baris data
            $sheet->getStyle('A' . $rowNum . ':' . $lastCol . $rowNum)->applyFromArray([
                'font' => [
                    'name' => 'Arial',
                    'size' => 10,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color'       => ['argb' => 'FFAAAAAA'],
                    ],
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Zebra stripe (baris genap abu-abu muda)
            if ($rowNum % 2 === 0) {
                $sheet->getStyle('A' . $rowNum . ':' . $lastCol . $rowNum)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF5F5F5');
            }

            $rowNum++;
        }

        // ── Auto size kolom ───────────────────────────────────────
        foreach (array_keys($headers) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Kolom '#' tidak perlu lebar besar
        $sheet->getColumnDimension('A')->setWidth(5);

        // ── Freeze baris header ───────────────────────────────────
        $sheet->freezePane('A2');

        // ── Writer & download ─────────────────────────────────────
        $writer   = new Xlsx($spreadsheet);
        $filename = 'document_center_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // (opsional) catat log jika helper tersedia
        if (function_exists('write_log')) {
            write_log(
                module: 'document_center',
                action: 'export',
                description: 'Export data document center ke Excel'
            );
        }

        $writer->save('php://output');
        exit;
    }

    // export pdf
    public function exportPdf()
    {
        $isAdmin   = in_groups('administrator');
        $myPlantId = $this->currentUserPlantId();

        $builder = $this->db->table('document_center')
            ->select('
            work_permit.no_wp,
            work_permit.nama_pengaju,
            work_permit.tgl_mulai,
            work_permit.tgl_selesai,
            work_permit.nama_pekerjaan,
            work_permit.lokasi_kerja,
            plant.nama_plant,
            izin_lembur.no_lembur,
            progress_pengerjaan.status_pengerjaan
        ')
            ->join('work_permit',         'work_permit.id = document_center.work_permit_id',              'left')
            ->join('plant',               'plant.id = work_permit.plant_id',                              'left')
            ->join('izin_lembur',         'izin_lembur.id = document_center.izin_lembur_id',              'left')
            ->join('progress_pengerjaan', 'progress_pengerjaan.id = document_center.progress_pengerjaan_id', 'left')
            ->orderBy('work_permit.created_at', 'DESC');


        if (! $isAdmin) {
            $builder->where('work_permit.plant_id', $myPlantId);
        }

        $documentCenters = $builder->get()->getResultObject();

        // Render view HTML → string untuk di-load ke Dompdf
        $html = view('document_center/export_pdf', [
            'documentCenters' => $documentCenters,
            'isAdmin'         => $isAdmin,
        ]);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false); // base64 image, tidak perlu remote

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait'); // landscape agar kolom tidak sempit
        $dompdf->render();
        $dompdf->stream('document_center_' . date('Ymd_His') . '.pdf', [
            'Attachment' => true,
        ]);

        if (function_exists('write_log')) {
            write_log(
                module: 'document_center',
                action: 'export',
                description: 'Export data document center ke PDF'
            );
        }
    }

    // preview excel
    public function preview(int $id)
    {
        $excel = new WorkPermitWorkbook();
        return $excel->download($id);
    }
}
