# Sistem Perijinan Menonton Video (Laravel)

Aplikasi berbasis web yang dibangun dengan Laravel untuk mengelola hak akses menonton video. Sistem ini memiliki dua level pengguna (Admin dan Customer) dengan fitur pembatasan waktu menonton (misalnya: akses hanya berlaku selama 2 jam setelah disetujui).

## Fitur Utama
- **Admin**: CRUD data customer, CRUD data video, dan menyetujui request menonton video dengan batas waktu tertentu.
- **Customer**: Melihat katalog video, meminta akses menonton, dan menonton video selama masa tenggang waktu yang diberikan belum habis.

## Prasyarat (Prerequisites)
Pastikan sistem Anda sudah terinstal:
- PHP >= 8.1
- Composer
- XAMPP / Laragon / Web Server lainnya
- MySQL / MariaDB

---

## Langkah Instalasi

1. **Clone Repositori**
```bash
   git clone <url-repo-anda>
   cd <nama-folder-repo>
```

2. **Install Dependencies**

```bash
   composer install

```


3. **Pengaturan Environment**
Duplikat file `.env.example` menjadi `.env`.
```bash
    cp .env.example .env

```


Buka file `.env` dan sesuaikan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=

```


4. **Generate Application Key**
```bash
php artisan key:generate

```


5. **Migrasi Database**
Jalankan perintah ini untuk membuat struktur tabel (users, video_categories, videos, video_requests) di database:
```bash
php artisan migrate

```



---

## Konfigurasi Storage Symlink (Penting!)


```bash
php artisan storage:link

```

*Catatan: Pastikan Anda menjalankan perintah ini setiap kali memindahkan aplikasi ke server/komputer baru.*

---

## Panduan Setting Upload Video Besar (php.ini)

Secara bawaan (default), PHP membatasi ukuran upload file hanya sebesar 2MB - 8MB. Agar Admin bisa mengunggah video berukuran besar (misal hingga 500MB), Anda **wajib** mengubah konfigurasi pada file `php.ini`.

### Langkah 1: Ubah Nilai Konfigurasi

Cari nilai berikut di dalam file `php.ini` Anda dan ubah angkanya:

```ini
upload_max_filesize = 500M
post_max_size = 512M
memory_limit = 512M
max_execution_time = 300

```

*(Catatan: Nilai `post_max_size` harus sama atau sedikit lebih besar dari `upload_max_filesize`).*

### Langkah 2: Temukan Lokasi File `php.ini` & Restart Server

Lokasi file `php.ini` dan cara me-restart server berbeda-beda tergantung Sistem Operasi yang Anda gunakan:

#### 🍎 Pengguna Mac (macOS)

* **Jika menggunakan XAMPP:**
* Lokasi file: `/Applications/XAMPP/xamppfiles/etc/php.ini`
* Cara Restart: Buka aplikasi `manager-osx` (XAMPP Control Panel), masuk ke tab **Manage Servers**, pilih **Apache Web Server**, lalu klik **Restart**.


* **Jika menggunakan PHP bawaan / Homebrew (via `php artisan serve`):**
* Ketik `php --ini` di terminal untuk melihat lokasi file `php.ini` yang aktif (biasanya di `/opt/homebrew/etc/php/8.x/php.ini`).
* Cara Restart: Matikan server artisan (tekan `Ctrl + C` di terminal), lalu ketik ulang `php artisan serve`.



#### 🪟 Pengguna Windows

* **Jika menggunakan XAMPP:**
* Lokasi file: `C:\xampp\php\php.ini`
* Cara Restart: Buka XAMPP Control Panel, klik tombol **Stop** pada modul Apache, lalu klik **Start** kembali.


* **Jika menggunakan Laragon:**
* Klik Kanan pada Laragon -> PHP -> Quick Settings -> ubah `upload_max_filesize` dan `post_max_size`.
* Cara Restart: Klik tombol **Stop** lalu **Start All** di Laragon.



#### 🐧 Pengguna Linux (Ubuntu/Debian)

* **Jika menggunakan Apache (LAMP Stack):**
* Lokasi file biasanya ada di: `/etc/php/8.x/apache2/php.ini`
* Cara Restart: `sudo systemctl restart apache2`


* **Jika menggunakan Nginx:**
* Lokasi file biasanya ada di: `/etc/php/8.x/fpm/php.ini`
* Cara Restart: `sudo systemctl restart nginx` dan `sudo systemctl restart php8.x-fpm`


* **Jika menggunakan XAMPP Linux:**
* Lokasi file: `/opt/lampp/etc/php.ini`
* Cara Restart: `sudo /opt/lampp/lampp restart`



---

## Menjalankan Aplikasi

Setelah semua langkah di atas selesai, jalankan *development server* Laravel:

```bash
php artisan serve

```

Buka browser dan akses aplikasi melalui: **http://localhost:8000**

