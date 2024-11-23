<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<div class="card col-md-6">
    <div class="card-body">
        <form method="POST" action="<?= base_url('admin/data_pegawai/update/'.$pegawai['id']) ?>"
            enctype="multipart/form-data">

            <div class="input-style-1">
                <label>Nama Pegawai</label>
                <input type="text" class=" form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>"
                    name="nama" placeholder="Nama Pegawai" value="<?= $pegawai['nama'] ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('nama') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin"
                    class=" form-control <?= ($validation->hasError('jenis_kelamin')) ? 'is-invalid' : '' ?>">
                    <option value="">---Pilih Jenis Kelamin---</option>
                    <option <?php if($pegawai['jenis_kelamin'] == 'Laki-laki') {
                        echo 'selected';
                    } ?> value="Laki-laki">Laki-laki</option>
                    <option <?php if($pegawai['jenis_kelamin'] == 'Perempuan') {
                        echo 'selected';
                    } ?> value="Perempuan">Perempuan</option>
                    <option <?php if($pegawai['jenis_kelamin'] == 'Cowok') {
                        echo 'selected';
                    } ?> value="Cowok">Cowok</option>
                    <option <?php if($pegawai['jenis_kelamin'] == 'Cewek') {
                        echo 'selected';
                    } ?> value="Cewek">Cewek</option>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('jenis_kelamin') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Alamat</label>
                <textarea name="alamat"
                    class=" form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" cols="30"
                    rows="5" placeholder="Alamat Anda"> <?= $pegawai['alamat'] ?> </textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('alamat') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>No Telepon</label>
                <input type="text"
                    class=" form-control <?= ($validation->hasError('no_telepon')) ? 'is-invalid' : '' ?>"
                    name="no_telepon" placeholder="No Telepon" value="<?= $pegawai['no_telepon'] ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('no_telepon') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Jabatan</label>
                <select name="jabatan"
                    class=" form-control <?= ($validation->hasError('jabatan')) ? 'is-invalid' : '' ?>">
                    <option value="<?= $pegawai['jabatan'] ?>"><?= $pegawai['jabatan'] ?></option>
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
                    <option value="<?= $pegawai['lokasi_presensi'] ?>"><?= $pegawai['lokasi_presensi'] ?></option>
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
                <input type="hidden" value="<?= $pegawai['foto'] ?>" name="foto_lama">
                <input type="file" class=" form-control <?= ($validation->hasError('foto')) ? 'is-invalid' : '' ?>"
                    name="foto" />
                <div class="invalid-feedback">
                    <?= $validation->getError('foto') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Username</label>
                <input type="text" class=" form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>"
                    name="username" placeholder="Username" value="<?= $pegawai['username'] ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('username') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Password</label>
                <input type="hidden" value="<?= $pegawai['password'] ?>" name="password_lama">
                <input type="password"
                    class=" form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" name="password"
                    placeholder="Password" />
                <div class="invalid-feedback">
                    <?= $validation->getError('password') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Konfirmasi Password</label>
                <input type="password"
                    class=" form-control <?= ($validation->hasError('konfirmasi_password')) ? 'is-invalid' : '' ?>"
                    name="konfirmasi_password" placeholder="Konfirmasi Password" />
                <div class="invalid-feedback">
                    <?= $validation->getError('konfirmasi_password') ?>
                </div>
            </div>

            <div class="input-style-1">
                <label>Role</label>
                <select name="role" class=" form-control <?= ($validation->hasError('role')) ? 'is-invalid' : '' ?>">
                    <option value="">---Pilih Role---</option>
                    < <option <?php if($pegawai['role'] == 'Admin') {
                        echo 'selected';
                    } ?> value="Admin">Admin</option>
                        <option <?php if($pegawai['role'] == 'Pegawai') {
                        echo 'selected';
                    } ?> value="Pegawai">Pegawai</option>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('role') ?>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Update</button>

        </form>
    </div>
</div>

<?= $this->endSection() ?>