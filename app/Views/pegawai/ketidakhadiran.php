<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>

<a href="<?= base_url('pegawai/ketidakhadiran/create') ?>" class="btn btn-primary">
    <i class="lni lni-circle-plus"></i> Ajukan
</a>

<table class="table table-striped" id="datatables">
    <thead>
        <!-- Pindahkan link ke bagian head atau di luar table -->
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
        foreach($ketidakhadiran as $item) : ?>
        <tr>
            <td> <?= $no++ ?> </td>
            <td> <?= $item['keterangan'] ?> </td>
            <td> <?= $item['tanggal'] ?> </td>
            <td> <?= $item['deskripsi'] ?> </td>

            <!-- Menampilkan file -->
            <td>
                <?php if ($item['file']): ?>
                <?php
                $ext = pathinfo($item['file'], PATHINFO_EXTENSION);
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo '<a href="' . base_url('uploads/' . $item['file']) . '" target="_blank">
                    <img src="' . base_url('uploads/' . $item['file']) . '" alt="File" width="70">
                  </a>';
                } elseif ($ext == 'pdf') {
                    echo '<a href="' . base_url('uploads/' . $item['file']) . '" target="_blank">
             <img src="' . base_url('assets/images/pdf-icon.png') . '" alt="PDF" width="70">
         </a>';
                } else {
                    echo '<span>File: ' . $item['file'] . '</span>';
                }
                ?>
                <?php else: ?>
                <span>No file uploaded</span>
                <?php endif; ?>
            </td>

            <!-- Status -->
            <td>
                <?php if (isset($item['status'])): ?>
                <?php if (strtolower($item['status']) === 'approved'): ?>
                <span class="badge bg-success">Approved</span>
                <?php elseif (strtolower($item['status']) === 'pending'): ?>
                <span class="badge bg-warning">Pending</span>
                <?php else: ?>
                <span class="badge bg-danger">Rejected</span>
                <?php endif; ?>
                <?php else: ?>
                <span class="badge bg-secondary">Status not available</span>
                <?php endif; ?>
            </td>

            <!-- Aksi -->
            <td>
                <?php if (isset($item['status']) && $item['status'] == 'PENDING'): ?>
                <a href="<?= base_url('pegawai/ketidakhadiran/edit/' . $item['id']) ?>"
                    class="badge bg-primary">Edit</a>
                <a href="<?= base_url('pegawai/ketidakhadiran/delete/' . $item['id']) ?>"
                    class="badge bg-danger tombol-hapus"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                <?php else: ?>
                <!-- Jika status APPROVED, tidak menampilkan tombol -->
                <span class="text-muted">---</span>
                <?php endif; ?>
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