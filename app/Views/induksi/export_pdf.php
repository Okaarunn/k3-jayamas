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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

        .col-tanggal {
            width: 8%;
        }

        .col-peserta {
            width: 10%;
        }

        .col-keterangan {
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

    <h3>Data Induksi K3</h3>

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-tanggal">Tanggal Induksi</th>
                <th class="col-peserta">Jumlah Peserta</th>
                <th class="col-keterangan">Keterangan</th>
                <th class="col-foto">Dokumentasi</th>
                <th class="col-foto">Absensi</th>
                <th class="col-dicatat">Dicatat</th>
                <th class="col-plant">Plant</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;
            $uploadDir = FCPATH . 'uploads/induksi/';
            foreach ($induksi as $row) :

                $induksiDocumentation = '';
                if (!empty($row->dokumentasi) && isset($row->dokumentasi[0])) {
                    $induksiDocumentation = imgToBase64($uploadDir . $row->dokumentasi[0]->filename);
                }

                $induksiAbsensi = '';
                if (!empty($row->absensi) && isset($row->absensi[0])) {
                    $induksiAbsensi = imgToBase64($uploadDir . $row->absensi[0]->filename);
                }
            ?>

                <tr>
                    <td class="col-no">
                        <?= $no++ ?>
                    </td>

                    <td class="col-tanggal">
                        <?= esc($row->tanggal_induksi) ?>
                    </td>

                    <td class="col-peserta">
                        <?= esc($row->jumlah_peserta) ?>
                    </td>

                    <td class="col-keterangan">
                        <?= esc($row->keterangan) ?>
                    </td>

                    <!-- dokumentasi -->
                    <td class="col-foto">
                        <?php if ($induksiDocumentation): ?>
                            <img class="foto" src="<?= $induksiDocumentation ?>" alt="documentation">
                        <?php else: ?>
                            <span class="no-foto">-</span>
                        <?php endif; ?>
                    </td>

                    <!-- absensi -->
                    <td class="col-foto">
                        <?php if ($induksiAbsensi): ?>
                            <img class="foto" src="<?= $induksiAbsensi ?>" alt="absensi">
                        <?php else: ?>
                            <span class="no-foto">-</span>
                        <?php endif; ?>
                    </td>

                    <td class="col-dicatat">
                        <?= esc($row->created_by_username ?? '-') ?>
                    </td>


                    <td class="col-plant">
                        <?= esc($row->nama_plant ?? '-') ?>
                    </td>

                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

</body>

</html>