# Lingkungan Pengembangan Laravel dengan Docker

Ini adalah lingkungan pengembangan lokal yang terisolasi menggunakan Docker untuk proyek Laravel. Setup ini mencakup semua yang Anda butuhkan untuk menjalankan, mengembangkan, dan membagikan aplikasi Anda dengan mudah.

## ✨ Fitur Utama

- **Terisolasi**: Semua layanan (PHP, Nginx, MySQL) berjalan di dalam kontainer Docker, tidak mengganggu sistem lokal Anda.
- **PHP 8.4**: Menggunakan versi PHP terbaru.
- **Nginx**: Sebagai web server yang cepat dan efisien.
- **MySQL 8**: Server database yang andal.
- **Vite**: Server pengembangan frontend dengan *Hot Module Replacement* (HMR).
- **Ngrok**: Terintegrasi untuk membuat URL publik secara instan dan membagikan pekerjaan Anda.
- **Makefile**: Semua perintah kompleks disederhanakan menjadi perintah `make` yang mudah diingat dan sepenuhnya otomatis.

## 📋 Prasyarat

Sebelum memulai, pastikan Anda telah menginstall perangkat lunak berikut di komputer Anda:

1.  **Docker & Docker Compose**: [Panduan Instalasi Docker](https://docs.docker.com/get-docker/)
2.  **Git**: Diperlukan untuk mengkloning repositori dan menyediakan Git Bash di Windows. [Unduh Git](https://git-scm.com/download/win).
3.  **jq**: Alat command-line untuk mem-parsing JSON. Dibutuhkan oleh `Makefile`.
    ```bash
    # Untuk Ubuntu/Debian
    sudo apt-get update && sudo apt-get install jq
    
    # Untuk macOS (via Homebrew)
    brew install jq
    
    # Untuk Windows (via Winget di PowerShell)
    winget install jqlang.jq
    ```

### 🖥️ Catatan untuk Pengguna Windows

`Makefile` ini menggunakan perintah `sed` yang tidak tersedia secara default di Windows Command Prompt atau PowerShell.

**Solusi**: Jalankan semua perintah `make` dari terminal **Git Bash** yang sudah termasuk saat Anda menginstall Git untuk Windows. Git Bash menyediakan lingkungan mirip Linux yang dibutuhkan agar semua perintah berjalan dengan benar.

## 🚀 Langkah-langkah Instalasi

1.  **Clone Repositori**
    ```bash
    git clone [URL_REPOSITORI_ANDA]
    cd [NAMA_DIREKTORI_PROYEK]
    ```

2.  **Siapkan File `.env`**
    Salin file contoh dan tambahkan token Ngrok Anda.
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan tambahkan `NGROK_AUTHTOKEN` Anda. Anda bisa mendapatkannya dari [Dasbor Ngrok](https://dashboard.ngrok.com/get-started/your-authtoken).
    ```env
    # ... (variabel lain)
    
    NGROK_AUTHTOKEN=TOKEN_ANDA_DARI_NGROK
    ```

3.  **Bangun Image Docker**
    Perintah ini akan membuat semua image kustom dan mengunduh yang diperlukan.
    ```bash
    make build
    ```

4.  **Install Dependensi Composer**
    ```bash
    make composer cmd="install"
    ```

5.  **Generate Kunci Aplikasi Laravel**
    ```bash
    make artisan cmd="key:generate"
    ```

6.  **Jalankan Migrasi Database**
    ```bash
    make artisan cmd="migrate"
    ```

Instalasi selesai! Anda siap untuk mengembangkan.

## 💻 Penggunaan Sehari-hari

### Menjalankan Lingkungan

Untuk memulai semua layanan, memperbarui `.env` secara otomatis, dan mendapatkan URL publik:
```bash
make run
```
Setelah beberapa saat, terminal akan menampilkan URL publik dari Ngrok.

### Menghentikan Lingkungan

Untuk menghentikan semua layanan:
```bash
make stop
```

### Mengakses Aplikasi

- **URL Publik**: Gunakan URL yang ditampilkan setelah menjalankan `make run`.
- **Dashboard Ngrok**: [http://localhost:4040](http://localhost:4040)
- **Aplikasi Lokal (jika diperlukan)**: [http://localhost:8080](http://localhost:8080)

## 📖 Daftar Perintah `make`

Berikut adalah daftar lengkap perintah yang tersedia untuk memudahkan pengembangan.

| Perintah | Parameter | Deskripsi |
| :--- | :--- | :--- |
| `make run` | - | Menjalankan semua kontainer, mengupdate `.env`, dan menampilkan URL Ngrok. |
| `make stop` | - | Menghentikan semua kontainer. |
| `make restart` | - | Menghentikan lalu menjalankan kembali semua kontainer. |
| `make build` | - | Membangun ulang image (setelah mengubah `Dockerfile`) dan menjalankan kontainer. |
| `make reset` | - | **PERHATIAN:** Menghentikan kontainer dan **menghapus semua volume data** (database akan hilang). |
| `make artisan` | `cmd="..."` | Menjalankan perintah `php artisan`. Contoh: `make artisan cmd="make:model Post"` |
| `make composer`| `cmd="..."` | Menjalankan perintah Composer. Contoh: `make composer cmd="require spatie/laravel-permission"` |
| `make npm` | `cmd="..."` | Menjalankan perintah NPM di dalam kontainer Vite. Contoh: `make npm cmd="install"` |
| `make logs` | `s=...` | Melihat log dari sebuah layanan. Default: `app`. Contoh: `make logs s=vite` |
| `make shell` | - | Masuk ke terminal kontainer `app` sebagai user `www-data`. |
| `make shell-root`| - | Masuk ke terminal kontainer `app` sebagai user `root` (untuk instalasi paket). |
| `make help` | - | Menampilkan daftar semua perintah yang tersedia. |

## 📁 Struktur Direktori Docker

- `docker/nginx/default.conf`: Konfigurasi Nginx untuk melayani aplikasi dan Vite.
- `docker/php/Dockerfile`: Instruksi untuk membangun image PHP 8.4 dengan ekstensi yang dibutuhkan.
- `docker/vite/Dockerfile`: Instruksi untuk membangun image Node.js dengan `curl` dan `jq`.
- `docker/vite/entrypoint.sh`: Script otomatisasi untuk mengambil URL Ngrok dan menjalankan Vite.
