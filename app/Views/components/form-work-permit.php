<?php

/**
 * @var array $plants
 * @var array $kategoriPekerjaans
 */

?>

<form action="<?= base_url('work-permit-request/store') ?>" method="post" id="workPermitForm"
    data-csrf-name="<?= csrf_token() ?>"
    data-csrf-value="<?= csrf_hash() ?>"
    data-pekerjaan-store-url="<?= base_url('/kategori-pekerjaan/store') ?>">
    <?= csrf_field() ?>

    <div class="tab-content">

        <!-- tab identitas vendor/internal -->
        <div class="tab-pane fade show active" id="tab-vendor">

            <div class="row">

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Tipe Pengaju</label>
                    <select name="tipe_pengaju" id="tipe_pengaju" class="form-control-k3" required>
                        <option disabled selected>Pilih</option>
                        <option value="vendor">Vendor</option>
                        <option value="internal">Departemen Internal</option>
                    </select>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Pilih Plant</label>
                    <select name="plant_id" class="form-control-k3" required>
                        <option disabled selected>Pilih</option>
                        <?php foreach ($plants as $plant) : ?>
                            <option value="<?= $plant['id'] ?>"><?= $plant['nama_plant'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Identitas Pengaju</label>
                    <input type="text" name="nama_pengaju" id="nama_pengaju" class="form-control-k3" placeholder="Contoh: PT. Maju Jaya" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Alamat Email Pengaju</label>
                    <input type="email" name="email_pengaju" id="email_pengaju" class="form-control-k3" placeholder="Contoh: majujaya@gmail.com" required>
                </div>

                <div class="col-md-6 mb-4" id="wrap_alamat_vendor">
                    <label class="form-label-k3">Alamat Vendor</label>
                    <input type="text" name="alamat_vendor" id="alamat_vendor" class="form-control-k3" placeholder="Contoh: Jl. Raya Industri No. 12, Surabaya">
                </div>

                <div class="col-md-6 mb-4" id="wrap_notelp_vendor">
                    <label class="form-label-k3">No Telepon Vendor</label>
                    <input type="text" name="notelp_vendor" id="notelp_vendor" class="form-control-k3" placeholder="Contoh: 0812-3456-7890">
                </div>

                <div class="col-md-6 mb-4" id="wrap_nama_pekerja_vendor">
                    <label class="form-label-k3">Nama Pekerja Vendor</label>
                    <input type="text" name="nama_pekerja_vendor" id="nama_pekerja_vendor" class="form-control-k3" placeholder="Contoh: Ahmad Fauzi">
                </div>

                <div class="col-md-6 mb-4" id="wrap_jabatan_pekerja_vendor">
                    <label class="form-label-k3">Jabatan Pekerja Vendor</label>
                    <input type="text" name="jabatan_pekerja_vendor" id="jabatan_pekerja_vendor" class="form-control-k3" placeholder="Contoh: Teknisi Listrik">
                </div>

                <div class="col-md-6 mb-4" id="wrap_no_ktp_pic_vendor">
                    <label class="form-label-k3">No KTP PIC Vendor</label>
                    <input type="text" name="no_ktp_pic_vendor" id="no_ktp_pic_vendor" class="form-control-k3" placeholder="Contoh: 3578012345678901" maxlength="16">
                </div>

                <div class="col-md-6 mb-4" id="wrap_departemen" style="display:none">
                    <label class="form-label-k3">Departemen</label>
                    <input type="text" name="departemen" id="departemen" class="form-control-k3" placeholder="Contoh: Dept. Maintenance">
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Kategori Pekerjaan</label>

                    <div style="display:flex; gap:10px; align-items:center;">
                        <select name="kategori_pekerjaan_id" class="form-control-k3" required style="flex:1;">
                            <option value="" disabled selected>Pilih jenis pekerjaan...</option>

                            <?php foreach ($kategoriPekerjaans as $kategoriPekerjaan) : ?>
                                <option value="<?= $kategoriPekerjaan['id'] ?>">
                                    <?= $kategoriPekerjaan['nama_kategori_pekerjaan'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button type="button"
                            class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#modalPekerjaan"
                            style="white-space:nowrap;">
                            + Tambah
                        </button>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Nama Pekerjaan</label>
                    <input type="text" name="nama_pekerjaan" id="nama_pekerjaan" class="form-control-k3" placeholder="Contoh: Memasang kabel listrik" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Lokasi Kerja</label>
                    <input type="text" name="lokasi_kerja" id="lokasi_kerja" class="form-control-k3" placeholder="Contoh: Area Produksi Lantai 2" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Tanggal Pelaksanaan</label>
                    <input type="date" name="tgl_mulai" class="form-control-k3" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control-k3" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control-k3" required>
                </div>



            </div>

        </div>

        <!-- tab checklist -->
        <div class="tab-pane fade" id="tab-checklist">

            <?php
            function radio(string $name)
            {
                return "<div class='form-check-inline-group'>
                    <label><input type='radio' name='$name' value='1' required> Ya</label>
                    <label><input type='radio' name='$name' value='0' required> Tidak</label>
                    </div>";
            }
            ?>
            <!-- checklist -->
            <div class="row">
                <!-- persiapan keselamatan -->
                <div class="col-md-6">
                    <h6 class="checklist-section-title">Persiapan Keselamatan</h6>

                    <div class="checklist-item">
                        <label>Pemeriksaan bahaya di tempat kerja (analisa resiko / HIRA)</label>
                        <?= radio('pemeriksaan_bahaya') ?>
                    </div>

                    <div class="checklist-item">
                        <label>Penyediaan APD yang diperlukan (safety helmet, safety shoes, body harness, dll.)</label>
                        <?= radio('penyediaan_apd') ?>
                    </div>

                    <div class="checklist-item">
                        <label>Alat pernapasan buatan (Respirator, Masker Kain)</label>
                        <?= radio('alat_pernapasan') ?>
                    </div>

                    <div class="checklist-item">
                        <label>Pemeriksaan kelayakan peralatan yang digunakan (Tangga, Perancah, APD, dll.)</label>
                        <?= radio('pemeriksaan_kelayakan') ?>
                    </div>

                    <div class="checklist-item">
                        <label>Rambu / tanda peringatan untuk mencegah resiko orang yang di bawah area kerja</label>
                        <?= radio('tanda_peringatan') ?>
                    </div>

                    <div class="checklist-item">
                        <label>Perlengkapan P3K</label>
                        <?= radio('perlengkapan_k3') ?>
                    </div>

                    <div class="checklist-item">
                        <label>Penaikan dan penurunan peralatan kerja dengan alat bantu (Tali, Tool Box, dll.)</label>
                        <?= radio('penaikan_penurunan_peralatan') ?>
                    </div>
                </div>

                <!-- monitoring dan pengendalian -->
                <div class="col-md-6">
                    <h6 class="checklist-section-title">Monitoring & Pengendalian</h6>

                    <div class="checklist-item">
                        <label>Peralatan kerja terhubung dengan badan pekerja (tangan), untuk menghindari resiko peralatan terjatuh</label>
                        <?= radio('peralatan_terhubung_dengan_badan') ?>
                    </div>

                    <div class="checklist-item">
                        <label>Diperlukan pengecekan alat-alat yang dialiri listrik</label>
                        <?= radio('pengecekan_alat') ?>
                    </div>

                    <div class="checklist-item">
                        <label>Semua peralatan yang beresiko mengagetkan pekerja sudah dimatikan (Bel, Sirine, Cerobong Asap, dll.)</label>
                        <?= radio('peralatan_mengagetkan') ?>
                    </div>

                    <div class="checklist-item">
                        <label>Menginformasikan kepada pekerja di sekitar area pekerjaan, agar dapat mengurangi / menghentikan kegiatan yang dapat mengganggu jalannya pekerjaan</label>
                        <?= radio('konfirmasi_pekerja') ?>
                    </div>

                    <div class="checklist-item">
                        <label>Monitoring selama pekerjaan berlangsung</label>
                        <?= radio('monitoring_pekerjaan') ?>
                    </div>

                    <div class="checklist-item">
                        <label>Menjaga dan memonitor kebersihan dan kerapihan tempat kerja baik selama maupun sesudah bekerja</label>
                        <?= radio('monitoring_kebersihan') ?>
                    </div>

                    <div class="checklist-item">
                        <label>Diperlukan izin kerja Penanganan Bahan Kimia</label>
                        <?= radio('izin_bahan_kimia') ?>
                    </div>

                    <div class="checklist-item">
                        <label>Tersedia APAR di tempat kerja</label>
                        <?= radio('tersedia_apar') ?>
                    </div>
                </div>
            </div>

            <!-- text area -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <h6 class="checklist-section-title">Catatan Tambahan</h6>
                </div>

                <div class="col-md-6">
                    <label class="form-label-k3">APD Yang Digunakan</label>
                    <textarea name="penggunaan_apd" class="form-control-k3" rows="5" placeholder="Contoh: Sepatu safety, Helm, Sarung tangan, Rompi kerja, Kacamata safety" required></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label-k3">Pencegahan Tambahan</label>
                    <textarea name="pencegahan_tambahan" class="form-control-k3" rows="5" placeholder="Contoh: Membatasi akses area kerja, memasang warning sign, menyediakan first aid kit, emergency equipment"></textarea>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <h6 class="checklist-section-title">Detail Penanggung Jawab</h6>
                </div>

                <div class="col-md-6">
                    <label class="form-label-k3">Yang Mengawasi</label>
                    <input type="text" class="form-control-k3" placeholder="Agung Siswanto" name="pengawasan" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label-k3">Yang Melakukan Pekerjaan (Bagian)</label>
                    <textarea class="form-control-k3" rows="5" placeholder="Tulis nama anda dan (bagian) serta beri tanda pisah(koma). Contoh: Ari (Pasang Kaca), Deni (Pengecat), Rudi (Epoxy)" name="bagian_pekerjaan"></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label-k3">Mengetahui | AK3</label>
                    <input type="text" class="form-control-k3" placeholder="Agung Siswanto" name="mengetahui_ak3" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label-k3">Penanggung Jawab | Supervisor Kerja</label>
                    <input type="text" class="form-control-k3" placeholder="Agung Siswanto" name="penanggung_jawab_checklist" required>
                </div>
            </div>
        </div>

        <!-- tab 3 JSA -->
        <div class="tab-pane fade" id="tab-jsa">

            <div id="tahapPekerjaanContainer"></div>

            <button type="button" id="addTahapBtn" class="btn-add-tahap">Tambah Tahap</button>

            <div class="mt-4">
                <label class="form-label-k3">Ada lembur? <span class="req">*</span></label>

                <label style="margin-right: 20px;">
                    <input type="radio" name="ada_lembur" value="1" onchange="WP.handleLemburToggle(true)" required> Ya
                </label>

                <label>
                    <input type="radio" name="ada_lembur" value="0" onchange="WP.handleLemburToggle(false)" required> Tidak
                </label>
            </div>



        </div>

        <!-- tab 4 lembur -->
        <div class="tab-pane fade" id="tab-lembur">

            <div class="row">

                <div class="col-md-6 mt-2">
                    <label>Tanggal Lembur</label>
                    <input type="date" name="tanggal_lembur" class="form-control-k3">
                </div>

                <div class="col-md-6 mt-2">
                    <label>Hari</label>
                    <input name="hari" type="text" class="form-control-k3" placeholder="Contoh: Senin" />
                </div>

                <div class="col-md-6 mt-2">
                    <label>Jam Mulai Lembur</label>
                    <input type="time" name="jam_mulai_lembur" class="form-control-k3">
                </div>

                <div class="col-md-6 mt-2">
                    <label>Jam Selesai Lembur</label>
                    <input type="time" name="jam_selesai_lembur" class="form-control-k3">
                </div>

                <div class="col-md-12 mt-2">
                    <label>Uraian Pekerjaan</label>
                    <textarea name="uraian_pekerjaan" class="form-control-k3" placeholder="Contoh: Perbaikan instalasi listrik panel utama di area gudang"></textarea>
                </div>

                <div class="col-md-12 mt-2">
                    <label>Alasan Lembur</label>
                    <textarea name="alasan_lembur" class="form-control-k3" placeholder="Contoh: Pekerjaan tidak dapat diselesaikan pada jam kerja normal karena membutuhkan penghentian mesin produksi"></textarea>
                </div>

                <div class="col-md-6 mt-2">
                    <label>Peralatan Yang Digunakan</label>
                    <input name="peralatan_digunakan" type="text" class="form-control-k3" placeholder="Contoh: Tang, Obeng, Multimeter" />
                </div>

                <div class="col-md-6 mt-2">
                    <label>Potensi Bahaya Pekerjaan</label>
                    <input name="potensi_bahaya_lembur" type="text" class="form-control-k3" placeholder="Contoh: Sengatan listrik, terjatuh dari ketinggian" />
                </div>

                <div class="col-md-6 mt-2">
                    <label>APD yang Digunakan</label>
                    <input name="apd_digunakan" type="text" class="form-control-k3" placeholder="Contoh: Helm, Sarung Tangan Listrik, Sepatu Safety" />
                </div>

                <div class="col-md-6 mt-2">
                    <label>Nama Penanggung Jawab Vendor</label>
                    <input name="nama_penanggung_jawab_vendor" type="text" class="form-control-k3" placeholder="Contoh: Budi Santoso" />
                </div>

                <div class="col-md-6 mt-2">
                    <label>Jabatan Penanggung Jawab Vendor</label>
                    <input name="jabatan_penanggung_jawab_vendor" type="text" class="form-control-k3" placeholder="Contoh: Site Manager" />
                </div>

                <div class="col-md-6 mt-2">
                    <label>Nama Penanggung Jawab Perusahaan</label>
                    <input name="nama_penanggung_jawab_perusahaan" type="text" class="form-control-k3" placeholder="Contoh: Andi Wijaya" />
                </div>

                <div class="col-md-6 mt-2">
                    <label>Jabatan Penanggung Jawab Perusahaan</label>
                    <input name="jabatan_penanggung_jawab_perusahaan" type="text" class="form-control-k3" placeholder="Contoh: HSE Supervisor" />
                </div>

                <div class="col-md-6 mt-2">
                    <label>Dibuat Oleh</label>
                    <input name="dibuat_oleh" type="text" class="form-control-k3" placeholder="Contoh: Ahmad / HSE Project" />
                </div>

            </div>

        </div>
    </div>

    <!-- tab navigation -->
    <div class="tab-nav-bar" id="tabNavBar">
        <div class="tab-nav-info">
            <span class="step-indicator" id="stepIndicator">Langkah 1 dari 3</span>
        </div>

        <div class="tab-nav-actions">
            <button type="button" id="btnPrev" class="btn-nav btn-nav-prev">
                <i class="fas fa-arrow-left"></i>
                Sebelumnya
            </button>

            <div id="btnNextArea">
            </div>
        </div>
    </div>
</form>

<!-- modal add pekerjaan -->
<div class="modal fade" id="modalPekerjaan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('/kategori-pekerjaan/store') ?>" method="post">
                <?= csrf_field() ?>

                <input type="hidden" name="redirect_to" value="<?= current_url() ?>">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pekerjaan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <label>Kategori Pekerjaan Baru</label>
                    <input type="text" name="nama_kategori_pekerjaan_baru" class="form-control" required>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>