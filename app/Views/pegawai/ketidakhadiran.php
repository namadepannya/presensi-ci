<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>

<a href="<?= base_url('pegawai/ketidakhadiran/create') ?>" class="btn btn-primary">
    <i class="lni lni-circle-plus"></i> Ajukan
</a>

<table class="table table-striped" id="datatables">
    <thead>
        <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
        <tr>
            <th>No</th>
            <th>Keterangan</th>
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>File</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <?php if($ketidakhadiran) : ?>
    <tbody>
        <?php $no = 1; 
        foreach($ketidakhadiran as $ketidakhadiran) : ?>
        <tr>
            <td> <?= $no++ ?> </td>
            <td> <?= $ketidakhadiran['keterangan'] ?> </td>
            <td> <?= $ketidakhadiran['tanggal'] ?> </td>
            <td> <?= $ketidakhadiran['deskripsi'] ?> </td>

            <!-- Menampilkan file yang diupload -->
            <td>
                <?php if ($ketidakhadiran['file']): ?>
                <?php
            // Mendapatkan ekstensi file
            $ext = pathinfo($ketidakhadiran['file'], PATHINFO_EXTENSION);
            // Menampilkan file jika gambar
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo '<a href="' . base_url('uploads/' . $ketidakhadiran['file']) . '" target="_blank">
                <img src="' . base_url('uploads/' . $ketidakhadiran['file']) . '" alt="File" width="70">
              </a>';
            } elseif ($ext == 'pdf') {
                // Jika file adalah PDF, tampilkan ikon PDF atau link untuk membuka
                echo '<a href="' . base_url('uploads/' . $ketidakhadiran['file']) . '" target="_blank">
         <img src="' . base_url('assets/images/pdf-icon.png') . '" alt="PDF" width="70">
     </a>';
            } else {
                // Jika file lain, tampilkan nama file
                echo '<span>File: ' . $ketidakhadiran['file'] . '</span>';
            }
        ?>
                <?php else: ?>
                <span>No file uploaded</span>
                <?php endif; ?>
            </td>

            <!-- Menampilkan status PENDING -->
            <td>
                <?php if ($ketidakhadiran['status'] == 'PENDING'): ?>
                <span class="badge badge-pending">PENDING</span>
                <?php endif; ?>
            </td>

            <td>
                <a href="<?= base_url('pegawai/ketidakhadiran/edit/' . $ketidakhadiran['id']) ?>"
                    class="badge bg-primary">Edit</a>
                <a href="<?= base_url('pegawai/ketidakhadiran/delete/' . $ketidakhadiran['id']) ?>"
                    class="badge bg-danger tombol-hapus"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <?php else : ?>
    <tbody>
        <tr>
            <td colspan="7">Data tidak ditemukan</td>
        </tr>
    </tbody>
    <?php endif ; ?>

</table>

<?= $this->endSection() ?>