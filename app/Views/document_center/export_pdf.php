<?php

/**
 * View: app/Views/document_center/export_pdf.php
 * Digunakan oleh Dompdf — gunakan inline style, hindari CSS modern
 */

/**
 * Convert gambar lokal ke base64 data URI agar tampil di Dompdf
 */
function imgToBase64DC(string $path): string
{
    if (empty($path) || ! file_exists($path)) {
        return '';
    }
    $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $mime = match ($ext) {
        'png'  => 'png',
        'gif'  => 'gif',
        'webp' => 'webp',
        default => 'jpeg',
    };
    return 'data:image/' . $mime . ';base64,' . base64_encode(file_get_contents($path));
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #1a1a1a;
            padding: 14px;
        }

        /* ── Kop laporan ── */
        .report-title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .report-sub {
            text-align: center;
            font-size: 8px;
            color: #555;
            margin-bottom: 10px;
        }

        .divider {
            border: none;
            border-top: 2px solid #2E7D32;
            margin-bottom: 10px;
        }

        /* ── Tabel ── */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 4px 5px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }

        th {
            background-color: #2E7D32;
            color: #ffffff;
            font-weight: bold;
            font-size: 8.5px;
        }

        td {
            font-size: 8px;
        }

        tr:nth-child(even) td {
            background-color: #f5f5f5;
        }

        /* ── Lebar kolom ── */
        .col-no {
            width: 3%;
        }

        .col-nowp {
            width: 11%;
        }

        .col-lembur {
            width: 9%;
        }

        .col-pengaju {
            width: 13%;
        }

        .col-tgl {
            width: 9%;
        }

        .col-pekerjaan {
            width: 16%;
            text-align: left;
        }

        .col-lokasi {
            width: 10%;
        }

        .col-status {
            width: 10%;
        }

        .col-plant {
            width: 9%;
        }

        /* ── Badge status ── */
        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 7.5px;
            font-weight: bold;
        }

        .badge-selesai {
            background-color: #c8e6c9;
            color: #1b5e20;
        }

        .badge-proses {
            background-color: #fff9c4;
            color: #f57f17;
        }

        .badge-belum {
            background-color: #ffcdd2;
            color: #b71c1c;
        }

        .badge-default {
            background-color: #e0e0e0;
            color: #424242;
        }

        /* ── Footer halaman ── */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 7.5px;
            color: #888;
            text-align: right;
            padding: 4px 14px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>

<body>

    <div class="report-title">Document Center K3</div>
    <div class="report-sub">Dicetak pada: <?= date('d/m/Y H:i') ?></div>
    <hr class="divider">

    <table>
        <thead>
            <tr>
                <th class="col-no">#</th>
                <th class="col-nowp">NO WP/JSA</th>
                <th class="col-lembur">No Lembur</th>
                <th class="col-pengaju">Identitas Pengaju</th>
                <th class="col-tgl">Tgl Mulai</th>
                <th class="col-tgl">Tgl Selesai</th>
                <th class="col-pekerjaan">Pekerjaan</th>
                <th class="col-lokasi">Lokasi</th>
                <th class="col-status">Status</th>
                <?php if ($isAdmin) : ?>
                    <th class="col-plant">Plant</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($documentCenters as $row) :

                // Tentukan badge class berdasarkan status
                $status   = strtolower($row->status_pengerjaan ?? '');
                $badgeClass = 'badge-default';
                if (str_contains($status, 'selesai'))        $badgeClass = 'badge-selesai';
                elseif (str_contains($status, 'proses') || str_contains($status, 'progress')) $badgeClass = 'badge-proses';
                elseif (str_contains($status, 'belum'))      $badgeClass = 'badge-belum';
            ?>
                <tr>
                    <td class="col-no"><?= $no++ ?></td>
                    <td class="col-nowp"><?= esc($row->no_wp       ?? '-') ?></td>
                    <td class="col-lembur"><?= esc($row->no_lembur   ?? '-') ?></td>
                    <td class="col-pengaju"><?= esc($row->nama_pengaju ?? '-') ?></td>
                    <td class="col-tgl"><?= esc($row->tgl_mulai    ?? '-') ?></td>
                    <td class="col-tgl"><?= esc($row->tgl_selesai  ?? '-') ?></td>
                    <td class="col-pekerjaan"><?= esc($row->nama_pekerjaan ?? '-') ?></td>
                    <td class="col-lokasi"><?= esc($row->lokasi_kerja ?? '-') ?></td>
                    <td class="col-status">
                        <span class="badge <?= $badgeClass ?>">
                            <?= esc($row->status_pengerjaan ?? '-') ?>
                        </span>
                    </td>
                    <?php if ($isAdmin) : ?>
                        <td class="col-plant"><?= esc($row->nama_plant ?? '-') ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Document Center K3 &mdash; <?= date('d/m/Y H:i') ?>
    </div>

</body>

</html>