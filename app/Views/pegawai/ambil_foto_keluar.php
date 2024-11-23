<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"
    integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<input type="text" name="tanggal_keluar" id="tanggal_keluar" value="<?= $tanggal_keluar ?>">
<input type="text" name="jam_keluar" id="jam_keluar" value="<?= $jam_keluar ?>">
<div id="my_camera"></div>
<div style="display: none;" id="my_result"></div>
<button class="btn btn-danger mt-2" id="ambil-foto-keluar"> KELUAR! </button>

<script>
Webcam.set({
    width: 320,
    height: 240,
    dest_width: 320,
    dest_height: 240,
    image_format: 'jpeg',
    jpeg_quality: 90,
    force_flash: false
});

Webcam.attach('#my_camera');

document.getElementById('ambil-foto-keluar').addEventListener('click', function() {

    let tanggal_keluar = document.getElementById('tanggal_keluar').value;
    let jam_keluar = document.getElementById('jam_keluar').value;

    Webcam.snap(function(data_uri) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            document.getElementById('my_result').innerHTML = '<img src="' + data_uri + '"  />';
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                window.location.href = '<?= base_url('pegawai/home') ?>';
            }
        };
        xhttp.open("POST", "<?= base_url('pegawai/presensi_keluar_aksi/' . $id_presensi) ?>", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(
            'foto_keluar=' + encodeURIComponent(data_uri) +
            '&tanggal_keluar=' + tanggal_keluar +
            '&jam_keluar=' + jam_keluar
        );
    })
});
</script>

<?= $this->endSection() ?>