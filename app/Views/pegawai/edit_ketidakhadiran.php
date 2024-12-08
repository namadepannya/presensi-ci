<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>

<div class="card col-md-6">
    <div class="card-body">
        <form method="POST" action="<?= base_url('pegawai/ketidakhadiran/update/' . $ketidakhadiran['id']) ?>"
            enctype="multipart/form-data">

            <!-- Security -->
            <?= csrf_field() ?>

            <input type="hidden" name="existing_file" value="<?= $ketidakhadiran['file'] ?>">

            <div class="input-style-1">
                <label>Keterangan</label>
                <select name="keterangan"
                    class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : '' ?>">
                    <option value="">---Pilih Keterangan---</option>
                    <option value="Ijin" <?= ($ketidakhadiran['keterangan'] == 'Ijin') ? 'selected' : '' ?>>Ijin
                    </option>
                    <option value="Sakit" <?= ($ketidakhadiran['keterangan'] == 'Sakit') ? 'selected' : '' ?>>Sakit
                    </option>
                    <option value="Malas" <?= ($ketidakhadiran['keterangan'] == 'Malas') ? 'selected' : '' ?>>Malas
                    </option>
                    <option value="GaMood+Capek"
                        <?= ($ketidakhadiran['keterangan'] == 'GaMood+Capek') ? 'selected' : '' ?>>GaMood+Capek</option>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('keterangan') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Tanggal Ketidakhadiran</label>
                <input type="date" class="form-control <?= ($validation->hasError('tanggal')) ? 'is-invalid' : '' ?>"
                    name="tanggal" value="<?= old('tanggal', $ketidakhadiran['tanggal']) ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('tanggal') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Deskripsi</label>
                <textarea name="deskripsi"
                    class="form-control <?= ($validation->hasError('deskripsi')) ? 'is-invalid' : '' ?>" cols="30"
                    rows="5" placeholder="Deskripsi"><?= old('deskripsi', $ketidakhadiran['deskripsi']) ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('deskripsi') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>File Lama</label><br>
                <?php if ($ketidakhadiran['file']): ?>
                <a href="<?= base_url('uploads/' . $ketidakhadiran['file']) ?>"
                    target="_blank"><?= $ketidakhadiran['file'] ?></a>
                <?php else: ?>
                <p>Tidak ada file</p>
                <?php endif; ?>
            </div>

            <div class="input-style-1">
                <label>File Baru (Opsional)</label>
                <input type="file" class="form-control <?= ($validation->hasError('file')) ? 'is-invalid' : '' ?>"
                    name="file" value="<?= set_value('file') ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('file') ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>