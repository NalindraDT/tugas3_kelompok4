# Praktikum Pemgrograman Web 2 - Sistem Pengelolaan Perpustakaan Digital

## Informasi Umum
Proyek ini merupakan bagian dari Tugas UAS Mata Kuliah Praktikum Pemrograman WEB 2 yang dilakukan oleh kelompok 4 kelas TI-2C Politeknik Negeri Cilacap yang dilakukan oleh kelompok 4 dengan Sitem yang bernama Perpustakaan Pengelolaan Perpustakaan Digital

## Deskripsi Proyek
Proyek ini merupakan Sistem Pengelolaan Perpustakaan Digital berbasis web yang dirancang menggunakan arsitektur Model-View-Controller (MVC) dengan menerapkan konsep Pemrograman Berorientasi Objek (OOP). Aplikasi ini bertujuan untuk mempermudah pengelolaan koleksi buku, pengguna, serta aktivitas peminjaman dan pengembalian dalam perpustakaan secara digital.

## Tujuan
Tujuan dari praktikum ini adalah untuk memberikan pemahaman yang lebih baik tentang arsitektur MVC dalam pengembangan aplikasi web dan untuk meningkatkan kemampuan mahasiswa dalam menerapkan konsep OOP serta melakukan operasi CRUD (Create, Read, Update, Delete) pada data. 

## Tech Stack
- **Bahasa Pemrograman:** PHP
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript
- **Version Control:** Git (GitLab)
- **Web Server:** Apache (dengan .htaccess untuk pengaturan URL)

## Struktur Proyek
```plaintext
mvc-sample/
├── app/
│   ├── controllers/
│   │   └── books.php         # Controller untuk mengelola logika buku
│   ├── models/
│   │   └── books.php                   # Model untuk mengelola data buku
│   └── views/
│       └── books/
│           ├── index.php              # View untuk menampilkan daftar dan manajemen buku
│           ├── edit.php               # Edit untuk menampilkan halaman edit pengguna            
│           └── create.php             # View untuk menampilkan form pembuatan buku baru
├── config/
│   └── database.php                   # Konfigurasi database
├── public/
│   ├── .htaccess                      # Pengaturan URL rewrite
│   └── index.php                      # Entry point aplikasi
├── .htaccess                          # Pengaturan URL rewrite
└── routes.php                         # Mendefinisikan rute untuk aplikasi
```

## Database 2C_klp4 Table Books
### Deskripsi table books
Tabel ini digunakan untuk menyimpan data buku dalam sebuah sistem basis data MySQL. Berikut adalah penjelasan mengenai kolom-kolom dalam tabel ini.
### Detail
- id_buku : int primary key auto increment
- judul : varchar(50)
- pengarang : varchar(50)
- tahun : year
- genre : varchar (50)
- id_penerbit : int foreign key

# Script Program
### 
