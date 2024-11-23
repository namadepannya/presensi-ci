<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<div class="card col-md-6">
    <div class="card-body">
        <form method="POST" action="<?= base_url('admin/data_pegawai/store') ?>" enctype="multipart/form-data">

            <!-- //security -->
            <?= csrf_field() ?>

            <div class="input-style-1">
                <label>Nama Pegawai</label>
                <input type="text" class=" form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>"
                    name="nama" placeholder="Nama Pegawai" value="<?= set_value('nama') ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('nama') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin"
                    class=" form-control <?= ($validation->hasError('jenis_kelamin')) ? 'is-invalid' : '' ?>">
                    <option value="">---Pilih Jenis Kelamin---</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                    <option value="Cowok">Cowok</option>
                    <option value="Cewek">Cewek</option>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('jenis_kelamin') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Alamat</label>
                <textarea name="alamat"
                    class=" form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" cols="30"
                    rows="5" placeholder="Alamat Anda" value="<?= set_value('alamat') ?>"></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('alamat') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>No Telepon</label>
                <input type="text"
                    class=" form-control <?= ($validation->hasError('no_telepon')) ? 'is-invalid' : '' ?>"
                    name="no_telepon" placeholder="No Telepon" value="<?= set_value('no_telepon') ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('no_telepon') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Jabatan</label>
                <select name="jabatan"
                    class=" form-control <?= ($validation->hasError('jabatan')) ? 'is-invalid' : '' ?>">
                    <option value="">---Pilih Jabatan---</option>
                    <?php foreach ($jabatan as $jab) : ?>
                    <option value="<?= $jab['jabatan'] ?>"><?= $jab['jabatan'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('jabatan') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Lokasi Presensi</label>
                <select name="lokasi_presensi"
                    class=" form-control <?= ($validation->hasError('lokasi_presensi')) ? 'is-invalid' : '' ?>">
                    <option value="">---Pilih Lokasi Presensi---</option>
                    <?php foreach ($lokasi_presensi as $lok) : ?>
                    <option value="<?= $lok['id'] ?>"><?= $lok['nama_lokasi'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('lokasi_presensi') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Foto</label>
                <input type="file" class=" form-control <?= ($validation->hasError('foto')) ? 'is-invalid' : '' ?>"
                    name="foto" />
                <div class="invalid-feedback">
                    <?= $validation->getError('foto') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Username</label>
                <input type="text" class=" form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>"
                    name="username" placeholder="Username" value="<?= set_value('username') ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('username') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Password</label>
                <input type="password"
                    class=" form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" name="password"
                    placeholder="Password" value="<?= set_value('password') ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('password') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Konfirmasi Password</label>
                <input type="password"
                    class=" form-control <?= ($validation->hasError('konfirmasi_password')) ? 'is-invalid' : '' ?>"
                    name="konfirmasi_password" placeholder="Konfirmasi Password"
                    value="<?= set_value('konfirmasi_password') ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('konfirmasi_password') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Role</label>
                <select name="role" class=" form-control <?= ($validation->hasError('role')) ? 'is-invalid' : '' ?>">
                    <option value="">---Pilih Role---</option>
                    <option value="Admin">Admin</option>
                    <option value="Pegawai">Pegawai</option>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('role') ?>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>

        </form>
    </div>
</div>

<?= $this->endSection() ?>