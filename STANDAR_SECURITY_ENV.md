# Standar Keamanan Konfigurasi Database & Environment Variable (Multi-Project cPanel & XAMPP)

Dokumen ini menjadi panduan standar (*Standard Operating Procedure*) untuk mengamankan kredensial database dan *environment variable* pada proyek PHP / CodeIgniter di lingkungan **Shared Hosting (cPanel)** maupun **Development Lokal (XAMPP)**.

---

## 1. Mengapa Tidak Menggunakan File `.env` Teks Biasa di `public_html`?

Pada *shared hosting* atau cPanel, meletakkan file `.env` berformat teks biasa di dalam folder `public_html` memiliki sejumlah celah keamanan:

1. **Risiko Terekspos Jika `.htaccess` Terhapus/Berubah**:
   - File `.env` adalah teks biasa (*plain text*). Jika aturan pemblokiran di `.htaccess` tidak sengaja terhapus, tertimpa, atau *mod_rewrite/authz* gagal dimuat, siapa pun dapat mengunduh isi password database cukup dengan membuka `https://domain.com/.env` di browser.
2. **Memberikan Petunjuk (*Clue*) di `.htaccess`**:
   - Menambahkan blok `<FilesMatch "^\.env">` di dalam `.htaccess` justru memberi tahu pihak yang memiliki akses baca ke `.htaccess` bahwa aplikasi menyimpan kredensial penting di file `.env`.
3. **Terlihat oleh Pengguna File Manager / FTP**:
   - Jika kredensial ditaruh langsung di `application/config/database.php` atau di dalam folder `public_html`, siapa pun yang memiliki akses ke folder proyek di `public_html` dapat langsung melihat username dan password database.

---

## 2. Solusi Standar: Berlapis & Terpusat di Luar `public_html`

Standar keamanan ini menerapkan **3 lapis proteksi sekaligus**:

1. **Lokasi di Luar `public_html` (`/home/username/.env_config/`)**:
   - Browser/pengunjung web hanya bisa mengakses file di dalam `public_html`. File yang berada di `/home/username/.env_config/` **100% mustahil diakses melalui URL HTTP/HTTPS** dalam kondisi apa pun, namun tetap bisa dibaca oleh script PHP (`include`/`require`) di level sistem operasi server.
2. **Format File `.php` dengan Guard `defined('BASEPATH')`**:
   - File konfigurasi disimpan sebagai script PHP (bukan teks biasa) dan diawali dengan `defined('BASEPATH') or exit('No direct script access allowed');`.
   - *Worst-case scenario*: Meskipun seseorang salah meletakkan file ini di dalam `public_html` **dan** menghapus `.htaccess`, saat diakses via browser PHP hanya akan mengeksekusi `exit()` dan menampilkan halaman kosong tanpa membocorkan kredensial.
3. **Mendukung Multi-Project & Multi-Database**:
   - Satu akun cPanel yang menampung banyak aplikasi/subdomain cukup memiliki satu folder `.env_config/` di luar `public_html` yang berisi file konfigurasi terpisah untuk setiap project.

---

## 3. Struktur Direktori Standar

### A. Di Server Production (cPanel)
```text
/home/username/                            <-- Root cPanel (DI LUAR public_html - Aman dari Web)
├── .env_config/                           <-- Folder terpusat untuk semua kredensial DB
│   ├── iaa-investment.php                 <-- Kredensial DB Project 1
│   ├── project-kedua.php                  <-- Kredensial DB Project 2
│   └── project-ketiga.php                 <-- Kredensial DB Project 3
│
└── public_html/                           <-- Folder Web Publik
    ├── iaa-investment/                    <-- Folder Aplikasi Project 1
    ├── project-kedua/                     <-- Folder Aplikasi Project 2
    └── project-ketiga/                    <-- Folder Aplikasi Project 3
```

### B. Di Komputer Lokal (XAMPP)
Untuk *development* lokal, developer dapat memilih salah satu:
- Menyimpan di `C:\xampp\.env_config\<nama-project>.php` (meniru struktur cPanel), **atau**
- Menyimpan di dalam root proyek masing-masing sebagai `.env.php` (otomatis diabaikan oleh Git melalui `.gitignore`).

---

## 4. Standar Kode Implementasi

### Langkah 1: Buat File Kredensial (`/home/username/.env_config/<project_key>.php` atau `.env.php`)

Simpan template contoh di repositori sebagai `.env.php.example`:

```php
<?php
defined('BASEPATH') or exit('No direct script access allowed');

return array(
    'DB_DSN'    => '',
    'DB_HOST'   => 'localhost',
    'DB_USER'   => 'isi_username_db',
    'DB_PASS'   => 'isi_password_db',
    'DB_NAME'   => 'isi_nama_database',
    'DB_DRIVER' => 'mysqli',
);
```

> **Catatan untuk CodeIgniter 4 atau PHP Native**:
> Jika digunakan pada CodeIgniter 4, ganti baris `defined('BASEPATH')` menjadi:
> `defined('FCPATH') or exit('No direct script access allowed');`

---

### Langkah 2: Gunakan Loader di `application/config/database.php`

Ubah bagian konfigurasi koneksi di `application/config/database.php` menjadi seperti berikut (cukup ubah nilai `$project_key` sesuai nama project):

```php
$active_group = 'default';
$query_builder = TRUE;

// Ubah sesuai identitas unik masing-masing project
$project_key = 'iaa-investment';

$possible_env_paths = array(
    // 1. Jika project berada di dalam subfolder public_html/<project> -> naik 2 level ke /home/username/.env_config/
    dirname(FCPATH, 2) . DIRECTORY_SEPARATOR . '.env_config' . DIRECTORY_SEPARATOR . $project_key . '.php',

    // 2. Jika project berada langsung di root public_html -> naik 1 level ke /home/username/.env_config/
    dirname(FCPATH, 1) . DIRECTORY_SEPARATOR . '.env_config' . DIRECTORY_SEPARATOR . $project_key . '.php',

    // 3. Fallback menggunakan variabel HOME di cPanel (/home/username/.env_config/...)
    ( ! empty($_SERVER['HOME']) ? rtrim($_SERVER['HOME'], '/\\') . DIRECTORY_SEPARATOR . '.env_config' . DIRECTORY_SEPARATOR . $project_key . '.php' : ''),

    // 4. Fallback di dalam folder project sendiri (untuk development lokal XAMPP)
    FCPATH . '.env.php',
);

$env_db = array();
foreach ($possible_env_paths as $env_path)
{
    if ($env_path !== '' && is_file($env_path) && is_readable($env_path))
    {
        $loaded_env = include $env_path;
        if (is_array($loaded_env))
        {
            $env_db = $loaded_env;
            break;
        }
    }
}

$db['default'] = array(
    'dsn'          => isset($env_db['DB_DSN']) ? $env_db['DB_DSN'] : '',
    'hostname'     => isset($env_db['DB_HOST']) ? $env_db['DB_HOST'] : 'localhost',
    'username'     => isset($env_db['DB_USER']) ? $env_db['DB_USER'] : '',
    'password'     => isset($env_db['DB_PASS']) ? $env_db['DB_PASS'] : '',
    'database'     => isset($env_db['DB_NAME']) ? $env_db['DB_NAME'] : '',
    'dbdriver'     => isset($env_db['DB_DRIVER']) ? $env_db['DB_DRIVER'] : 'mysqli',
    'dbprefix'     => '',
    'pconnect'     => FALSE,
    'db_debug'     => (ENVIRONMENT !== 'production'),
    'cache_on'     => FALSE,
    'cachedir'     => '',
    'char_set'     => 'utf8',
    'dbcollat'     => 'utf8_general_ci',
    'swap_pre'     => '',
    'encrypt'      => FALSE,
    'compress'     => FALSE,
    'stricton'     => FALSE,
    'failover'     => array(),
    'save_queries' => TRUE
);
```

---

### Langkah 3: Standar `.gitignore`

Pastikan file `.gitignore` pada setiap repositori proyek memiliki aturan berikut agar file kredensial asli tidak pernah ter-*commit* ke Git:

```gitignore
# Sensitive Credentials & Environment Configs
.env
.env.*
.env.php
.env_config/
!.env.php.example
```

---

## 5. Checklist Deployment Project Baru ke cPanel

1. [ ] Pastikan di `application/config/database.php`, variabel `$project_key` sudah diisi sesuai nama project (misal: `'project-kedua'`).
2. [ ] Buka **cPanel File Manager**, klik tombol **Settings** di pojok kanan atas, dan pastikan **Show Hidden Files (dotfiles)** dicentang ketika Anda ingin mengelola folder `.env_config`.
3. [ ] Masuk ke direktori paling atas (`/home/username/`, di luar `public_html`), lalu buat folder `.env_config` (jika belum ada) dengan *permission* `0700` atau `0750`.
4. [ ] Buat file `/home/username/.env_config/<project_key>.php` dengan *permission* `0600` atau `0640`, lalu isi kredensial database cPanel untuk project tersebut.
5. [ ] Pastikan tidak ada file `.env.php` di dalam folder `public_html` pada server production agar pembacaan sepenuhnya mengambil dari `/home/username/.env_config/<project_key>.php`.

