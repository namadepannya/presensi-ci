<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"
    integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<input type="text" name="id_pegawai" id="id_pegawai" value="<?= $id_pegawai ?>">
<input type="text" name="tanggal_masuk" id="tanggal_masuk" value="<?= $tanggal_masuk ?>">
<input type="text" name="jam_masuk" id="jam_masuk" value="<?= $jam_masuk ?>">
<div id="my_camera"></div>
<div style="display: none;" id="my_result"></div>
<button class="btn btn-primary mt-2" id="ambil-foto"> Masuk </button>

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

document.getElementById('ambil-foto').addEventListener('click', function() {
    let id = document.getElementById('id_pegawai').value;
    let tanggal_masuk = document.getElementById('tanggal_masuk').value;
    let jam_masuk = document.getElementById('jam_masuk').value;
    // console.log(tanggal_masuk);

    Webcam.snap(function(data_uri) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            document.getElementById('my_result').innerHTML = '<img src="' + data_uri + '"  />';
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                window.location.href = '<?= base_url('pegawai/home') ?>';
            }
        };
        xhttp.open("POST", "<?= base_url('pegawai/presensi_masuk_aksi') ?>", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(
            'foto_masuk=' + encodeURIComponent(data_uri) +
            '&id_pegawai=' + id +
            '&tanggal_masuk=' + tanggal_masuk +
            '&jam_masuk=' + jam_masuk
        );
    })
});
</script>

<?= $this->endSection() ?>