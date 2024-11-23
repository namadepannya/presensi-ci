<?=$this->extend('pegawai/layout.php')?>

<?=$this->section('content')?>

<style>
.parent-clock {
    display: grid;
    grid-template-columns: auto auto auto auto auto;
    font-size: 25px;
    font-weight: bold;
    justify-content: center;
}

#map {
    height: 500px;
    width: 700px;
    margin: auto;
}
</style>

<div class="row mb-3">
    <div class="col-md-2"></div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">Presensi Masuk</div>
            <?php if ($cek_presensi < 1): ?>
            <!-- Kondisi sebelum presensi -->
            <div class="card-body text-center">
                <div class="fw-bold"> <?=date('d F Y')?> </div>
                <div class="parent-clock">
                    <div id="jam-masuk"></div>
                    <div>:</div>
                    <div id="menit-masuk"></div>
                    <div>:</div>
                    <div id="detik-masuk"></div>
                </div>
                <form method="POST" action="<?=base_url('pegawai/presensi_masuk')?> ">
                    <!-- Lokasi kantor -->
                    <input type="hidden" name="latitude_kantor" value="<?=$lokasi_presensi['latitude']?>">
                    <input type="hidden" name="longitude_kantor" value="<?=$lokasi_presensi['longitude']?>">
                    <input type="hidden" name="radius" value="<?=$lokasi_presensi['radius']?>">
                    <!-- Lokasi pegawai -->
                    <input type="text" name="latitude_pegawai" id="latitude_pegawai">
                    <input type="text" name="longitude_pegawai" id="longitude_pegawai">
                    <!-- Date and Time -->
                    <input type="hidden" name="tanggal_masuk" value="<?=date('Y-m-d')?>">
                    <input type="hidden" id="jam_masuk" name="jam_masuk" value="<?=date('H:i:s')?>">
                    <input type="hidden" name="id_pegawai" value="<?=session()->get('id_pegawai')?>">
                    <button class="btn btn-primary mt-3">Masuk</button>
                </form>
            </div>
            <?php else: ?>
            <!-- Kondisi setelah presensi masuk -->
            <div class="card-body text-center">
                <svg fill="#1C2033" width="52" height="52" version="1.1" id="lni_lni-cloud-check"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                    <g>
                        <path d="M39.1,26.9l-8.8,8.3l-2.5-2.5c-0.9-0.9-2.3-0.9-3.2,0c-0.9,0.9-0.9,2.3,0,3.2l3.6,3.6c0.5,0.5,1.2,0.8,2,0.8
                        c0.6,0,1.3-0.2,1.8-0.6l10-9.4c0.9-0.9,0.9-2.3,0.1-3.2C41.4,26,40,26,39.1,26.9z" />
                        <path
                            d="M57.3,23.6c-2.7-2.9-6.4-4.8-10.3-5.5c-2.2-3.4-5.4-5.9-9.1-7.2c-1.7-0.7-3.7-1-5.8-1c-9.4,0-17.2,7.2-17.8,16.4
                        C7.2,27.1,1.8,33,1.8,40.1c0,7.7,6.3,13.9,14.1,14h27.8c10.2,0,18.6-8.1,18.6-18.1C62.3,31.4,60.5,27,57.3,23.6z" />
                    </g>
                </svg>
                <h5>Anjeun Tos Absen!</h5>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Presensi Keluar -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">Presensi Keluar</div>

            <?php if ($cek_presensi < 1) : ?>
            <!-- Kondisi jika belum presensi -->
            <div class="card-body text-center">
                <h5>Harap melakukan presensi masuk terlebih dahulu.</h5>
            </div>
            <?php elseif ($cek_presensi_keluar < 1) : ?>
            <!-- Kondisi jika sudah presensi masuk tapi belum presensi keluar -->
            <div class="card-body text-center">
                <div class="fw-bold"> <?= date('d F Y') ?> </div>
                <div class="parent-clock">
                    <div id="jam-keluar"></div>
                    <div>:</div>
                    <div id="menit-keluar"></div>
                    <div>:</div>
                    <div id="detik-keluar"></div>
                </div>
                <form method="POST" action="<?= base_url('pegawai/presensi_keluar/' . $ambil_presensi_masuk['id']) ?>">
                    <!-- Lokasi kantor -->
                    <input type="text" name="latitude_kantor" value="<?= $lokasi_presensi['latitude'] ?>" hidden>
                    <input type="text" name="longitude_kantor" value="<?= $lokasi_presensi['longitude'] ?>" hidden>
                    <input type="hidden" name="radius" value="<?= $lokasi_presensi['radius'] ?>">
                    <!-- Lokasi pegawai -->
                    <input type="text" name="latitude_pegawai" id="latitude_pegawai">
                    <input type="text" name="longitude_pegawai" id="longitude_pegawai">
                    <!-- Date and Time -->
                    <input type="hidden" name="tanggal_keluar" value="<?= date('Y-m-d') ?>">
                    <input type="hidden" id="jam_keluar" name="jam_keluar" value="<?= date('H:i:s') ?>">
                    <button class="btn btn-danger mt-3">Keluar</button>
                </form>
            </div>
            <?php else : ?>
            <!-- Kondisi jika sudah presensi keluar -->
            <div class="card-body text-center">
                <svg fill="#1C2033" width="52" height="52" version="1.1" id="lni_lni-cloud-check"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                    <g>
                        <path d="M39.1,26.9l-8.8,8.3l-2.5-2.5c-0.9-0.9-2.3-0.9-3.2,0c-0.9,0.9-0.9,2.3,0,3.2l3.6,3.6c0.5,0.5,1.2,0.8,2,0.8
                    c0.6,0,1.3-0.2,1.8-0.6l10-9.4c0.9-0.9,0.9-2.3,0.1-3.2C41.4,26,40,26,39.1,26.9z" />
                        <path
                            d="M57.3,23.6c-2.7-2.9-6.4-4.8-10.3-5.5c-2.2-3.4-5.4-5.9-9.1-7.2c-1.7-0.7-3.7-1-5.8-1c-9.4,0-17.2,7.2-17.8,16.4
                    C7.2,27.1,1.8,33,1.8,40.1c0,7.7,6.3,13.9,14.1,14h27.8c10.2,0,18.6-8.1,18.6-18.1C62.3,31.4,60.5,27,57.3,23.6z" />
                    </g>
                </svg>
                <h5>Anjeun Tos Absen Uih!</h5>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>

<div id="map"></div>



<script>
window.setInterval("waktuMasuk()", 1000);

function waktuMasuk() {
    const waktu = new Date();
    document.getElementById("jam-masuk").innerHTML = formatWaktu(waktu.getHours());
    document.getElementById("menit-masuk").innerHTML = formatWaktu(waktu.getMinutes());
    document.getElementById("detik-masuk").innerHTML = formatWaktu(waktu.getSeconds());
}

window.setInterval("waktuKeluar()", 1000);

function waktuKeluar() {
    const waktu = new Date();
    document.getElementById("jam-keluar").innerHTML = formatWaktu(waktu.getHours());
    document.getElementById("menit-keluar").innerHTML = formatWaktu(waktu.getMinutes());
    document.getElementById("detik-keluar").innerHTML = formatWaktu(waktu.getSeconds());
}

function formatWaktu(waktu) {
    if (waktu < 10) {
        return '0' + waktu;
    } else {
        return waktu;
    }
}

getLocation();

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Browser Anda Tidak Mendukung Geolocation!");
    }
}

function showPosition(position) {

    var latitude_pegawai = position.coords.latitude;
    var longitude_pegawai = position.coords.longitude;
    document.getElementById("latitude_pegawai").value = latitude_pegawai;
    document.getElementById("longitude_pegawai").value = longitude_pegawai;

    initMap(latitude_pegawai, longitude_pegawai);
}

function initMap(latitude_pegawai, longitude_pegawai) {
    var map = L.map('map').setView([<?= $lokasi_presensi['latitude'] ?>, <?= $lokasi_presensi['longitude'] ?>], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Marker untuk posisi pegawai
    var marker = L.marker([latitude_pegawai, longitude_pegawai]).addTo(map);

    // Circle untuk lokasi presensi
    var circle = L.circle([<?= $lokasi_presensi['latitude'] ?>, <?= $lokasi_presensi['longitude'] ?>], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 100
    }).addTo(map);

    marker.bindPopup("<b>Aing Didieu</b><br>OTW").openPopup();
    circle.bindPopup("Lokasi Presensi Anda");
}
</script>

<?=$this->endSection()?>