<?php


/**
 * 
 * @param string 
 * @return string      
 */
function imgToBase64(string $path): string
{
    if (empty($path) || !file_exists($path)) {
        return '';
    }
    $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $mime = match ($ext) {
        'png'         => 'png',
        'gif'         => 'gif',
        'webp'        => 'webp',
        default       => 'jpeg',
    };
    $encoded = base64_encode(file_get_contents($path));
    return 'data:image/' . $mime . ';base64,' . $encoded;
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
            padding: 12px;
        }

        h3 {
            font-size: 13px;
            margin-bottom: 8px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;

        }

        th,
        td {
            border: 1px solid #555;
            padding: 4px 5px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }

        th {
            background-color: #d0d0d0;
            font-weight: bold;
            font-size: 9px;
        }

        td {
            font-size: 8.5px;
        }


        .col-no {
            width: 3%;
        }

        .col-kode {
            width: 8%;
        }

        .col-petugas {
            width: 10%;
        }

        .col-tgl {
            width: 9%;
        }

        .col-ket {
            width: 18%;
            text-align: left;
        }

        .col-foto {
            width: 10%;
        }

        .col-dicatat {
            width: 10%;
        }

        .col-plant {
            width: 9%;
        }

        img.foto {
            width: 65px;
            height: 65px;
            display: block;
            margin: 0 auto;

        }

        .no-foto {
            color: #999;
            font-style: italic;
        }

        tr:nth-child(even) td {
            background-color: #f7f7f7;
        }
    </style>
</head>

<body>

    <h3>Data Patrol K3</h3>

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-kode">Kode</th>
                <th class="col-petugas">Petugas</th>
                <th class="col-tgl">Tgl Patrol</th>
                <th class="col-tgl">Tgl Selesai</th>
                <th class="col-ket">Keterangan</th>
                <th class="col-foto">Foto Sebelum</th>
                <th class="col-foto">Foto Sesudah</th>
                <th class="col-dicatat">Dicatat</th>
                <th class="col-plant">Plant</th>


            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $uploadDir = FCPATH . 'uploads/patrol/';

            foreach ($data as $row):

                $srcBefore = '';
                if (!empty($row->foto_before_filename)) {
                    $srcBefore = imgToBase64($uploadDir . $row->foto_before_filename);
                }

                $srcAfter = '';
                if (!empty($row->foto_after_filename)) {
                    $srcAfter = imgToBase64($uploadDir . $row->foto_after_filename);
                }
            ?>
                <tr>
                    <td class="col-no"><?= $no++ ?></td>
                    <td class="col-kode"><?= esc($row->kode) ?></td>
                    <td class="col-petugas"><?= esc($row->nama_petugas) ?></td>
                    <td class="col-tgl"><?= esc($row->tanggal_patrol) ?></td>
                    <td class="col-tgl"><?= esc($row->tanggal_penyelesaian ?? '-') ?></td>
                    <td class="col-ket"><?= esc($row->keterangan) ?></td>

                    <!-- image before -->
                    <td class="col-foto">
                        <?php if ($srcBefore): ?>
                            <img class="foto" src="<?= $srcBefore ?>" alt="Before">
                        <?php else: ?>
                            <span class="no-foto">-</span>
                        <?php endif; ?>
                    </td>

                    <!-- image after -->
                    <td class="col-foto">
                        <?php if ($srcAfter): ?>
                            <img class="foto" src="<?= $srcAfter ?>" alt="After">
                        <?php else: ?>
                            <span class="no-foto">-</span>
                        <?php endif; ?>
                    </td>

                    <td class="col-dicatat"><?= esc($row->created_by_username ?? '-') ?></td>
                    <td class="col-plant"><?= esc($row->nama_plant ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>