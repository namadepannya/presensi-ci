<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>

<form class="row g-3">
    <div class="col-auto">
        <input type="date" class="form-control" name="filter_tanggal">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-3">Tampilkan</button>
    </div>
</form>
<table class="table table-striped table-bordered">
    <tr>
        <th>No</th>
        <th>Nama Pegawai</th>
        <th>Tanggal Masuk</th>
        <th>Jam Masuk</th>
        <th>Jam Keluar</th>
        <th>Total Jam Kerja</th>
        <th>Total Keterlambatan</th>
    </tr>

    <?php if($rekap_presensi) : ?>
    <?php $no =1;
    foreach($rekap_presensi as $rekap) : ?>
    <?php 
    //menghitung jumlah jam kerja
        $timestamp_jam_masuk = strtotime($rekap['tanggal_masuk'].$rekap['jam_masuk']);
        $timestamp_jam_keluar = strtotime($rekap['tanggal_keluar'].$rekap['jam_keluar']);
        $selisih = $timestamp_jam_keluar - $timestamp_jam_masuk;
        $jam = floor($selisih / 3600);
        $selisih -= $jam * 3600;
        $menit = floor($selisih / 60);
    //menghitung total keterlambatan
        $jam_masuk_real = strtotime($rekap['jam_masuk']);
        $jam_masuk_kantor = strtotime($rekap['jam_masuk_kantor']);
        $selisih_terlambat =$jam_masuk_real - $jam_masuk_kantor;
        $jam_terlambat = floor($selisih_terlambat / 3600);
        $selisih_terlambat -= $jam_terlambat * 3600;
        $menit_terlambat = floor($selisih_terlambat / 60);
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $rekap['nama'] ?></td>
        <td><?= date('d F Y', strtotime($rekap['tanggal_masuk'])) ?></td>
        <td><?= $rekap['jam_masuk'] ?></td>
        <td><?= $rekap['jam_keluar'] ?></td>
        <td>
            <?php if($rekap['jam_keluar'] == '00:00:00') : ?>
            0 jam 0 Menit
            <?php else : ?>
            <?= $jam . ' Jam ' . $menit . ' Menit '?>
            <?php endif; ?>
        </td>
        <td>
            <?php if($jam_terlambat < 0 || $menit_terlambat < 0 ) : ?>
            <span class="btn btn-success">ON TIME</span>
            <?php else : ?>
            <?= $jam_terlambat . ' Jam ' . $menit_terlambat . ' Menit '?>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php else : ?>
    <tr>
        <td class="center" colspan="7" style="text-align: center; vertical-align: middle;">DATA EWEUHHAN</td>
    </tr>
    <?php endif ; ?>
</table>

<?= $this->endSection() ?>