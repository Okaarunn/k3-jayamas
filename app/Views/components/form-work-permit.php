<form action="<?= base_url('work-permit-request/store') ?>" method="post" id="workPermitForm">
    <?= csrf_field() ?>

    <div class="tab-content">

        <!-- TAB 1 -->
        <div class="tab-pane fade show active" id="tab-vendor">

            <div class="row">

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Tipe Pengaju</label>
                    <select name="tipe_pengaju" class="form-control-k3" required>
                        <option value="">Pilih</option>
                        <option value="vendor">Vendor</option>
                        <option value="internal">Internal</option>
                    </select>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Nama Pengaju</label>
                    <input type="text" name="nama_pengaju" class="form-control-k3" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Alamat Vendor</label>
                    <input type="text" name="alamat_vendor" class="form-control-k3">
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">No Telp</label>
                    <input type="text" name="notelp_vendor" class="form-control-k3">
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Lokasi Kerja</label>
                    <input type="text" name="lokasi_kerja" class="form-control-k3" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control-k3" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control-k3" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-k3">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control-k3" required>
                </div>

                <div class="col-md-12 mb-4">
                    <label class="form-label-k3">Pekerjaan</label>
                    <select name="pekerjaan_id" class="form-control-k3" required>
                        <option value="">Pilih Pekerjaan</option>
                        <?php foreach ($pekerjaans as $p) : ?>
                            <option value="<?= $p['id'] ?>"><?= $p['nama_pekerjaan'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

        </div>

        <!-- TAB 2 CHECKLIST -->
        <div class="tab-pane fade" id="tab-checklist">

            <?php
            function radio($name)
            {
                return "
<div class='form-check-inline-group'>
<label><input type='radio' name='$name' value='1' required> Ya</label>
<label><input type='radio' name='$name' value='0' required> Tidak</label>
</div>";
            }
            ?>

            <div class="mb-3">
                <label>Pemeriksaan Bahaya</label>
                <?= radio('pemeriksaan_bahaya') ?>
            </div>

            <div class="mb-3">
                <label>Penyediaan APD</label>
                <?= radio('penyediaan_apd') ?>
            </div>

            <div class="mb-3">
                <label>Alat Pernapasan</label>
                <?= radio('alat_pernapasan') ?>
            </div>

            <div class="mb-3">
                <label>Pemeriksaan Kelayakan</label>
                <?= radio('pemeriksaan_kelayakan') ?>
            </div>

            <div class="mb-3">
                <label>Tanda Peringatan</label>
                <?= radio('tanda_peringatan') ?>
            </div>

            <div class="mb-3">
                <label>Perlengkapan K3</label>
                <?= radio('perlengkapan_k3') ?>
            </div>

        </div>

        <!-- TAB 3 JSA (tetap) -->
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

        <!-- TAB 4 LEMBUR -->
        <div class="tab-pane fade" id="tab-lembur">

            <div class="row">

                <div class="col-md-6">
                    <label>Tanggal Lembur</label>
                    <input type="date" name="tanggal_lembur" class="form-control-k3">
                </div>

                <div class="col-md-6">
                    <label>Jam Mulai</label>
                    <input type="time" name="jam_mulai_lembur" class="form-control-k3">
                </div>

                <div class="col-md-6">
                    <label>Jam Selesai</label>
                    <input type="time" name="jam_selesai_lembur" class="form-control-k3">
                </div>

                <div class="col-md-12">
                    <label>Alasan</label>
                    <textarea name="alasan_lembur" class="form-control-k3"></textarea>
                </div>

            </div>

        </div>

    </div>

    <!-- GLOBAL TAB NAVIGATION -->
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
                <!-- Rendered dynamically by JavaScript -->
            </div>
        </div>
    </div>

</form>