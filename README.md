# Bayu Project Absensi

Ini adalah aplikasi absensi berbasis web menggunakan CodeIgniter 4 untuk mencatat kehadiran karyawan dan manajemen data absensi.

## Apa itu CodeIgniter?

CodeIgniter adalah framework PHP yang ringan, cepat, fleksibel, dan aman. Proyek ini dibangun dengan menggunakan CodeIgniter 4 sebagai kerangka kerja backend.

## Instalasi dan Pembaruan

1. Clone repositori ini:
    ```bash
    git clone https://github.com/username/repo-name.git
    ```

2. Install dependensi dengan Composer:
    ```bash
    composer install
    ```

3. Copy file `.env.example` ke `.env` dan sesuaikan konfigurasi database serta URL dasar aplikasi Anda.

4. Untuk memperbarui framework, jalankan:
    ```bash
    composer update
    ```

## Setup

- Sesuaikan file `.env` untuk konfigurasi aplikasi Anda, seperti pengaturan **baseURL**, **database**, dll.
- Jika Anda menggunakan database, pastikan untuk menjalankan migrasi:
    ```bash
    php spark migrate
    ```

## Pengaturan dan Persyaratan Server

- PHP versi 8.1 atau lebih tinggi
- Pastikan untuk mengaktifkan ekstensi berikut:
    - [intl](http://php.net/manual/en/intl.requirements.php)
    - [mbstring](http://php.net/manual/en/mbstring.installation.php)

## Catatan Penting

- Pastikan untuk menyesuaikan konfigurasi server Anda agar mengarah ke folder *public* pada proyek ini.
- Jangan lupa untuk mengaktifkan ekstensi PHP yang diperlukan seperti `mbstring` dan `intl`.

