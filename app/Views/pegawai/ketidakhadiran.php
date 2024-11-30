<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>

<a href="<?= base_url('pegawai/ketidakhadiran/create') ?>" class="btn btn-primary"> <i class="lni lni-circle-plus"></i>
    Ajukan</a>
<table class="table table-striped" id="datatables">
    <thead>
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
        <?php $no =1; 
    foreach($ketidakhadiran as $ketidakhadiran) : ?>

        <tr>
            <td> <?= $no++ ?> </td>
            <td> <?= $ketidakhadiran['keterangan'] ?> </td>
            <td> <?= $ketidakhadiran['tanggal'] ?> </td>
            <td> <?= $ketidakhadiran['deskripsi'] ?> </td>
            <td> <?= $ketidakhadiran['status'] ?> </td>
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

    <?php endif ; ?>

    <tbody>
        <tr>
            <td colspan="7">Datana ge can ayaan</td>
        </tr>
    </tbody>
</table>


<?= $this->endSection() ?>