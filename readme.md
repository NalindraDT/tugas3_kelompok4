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
### <?php
// app/controllers/BooksController.php
require_once '../app/models/Books.php';

class BooksController {
    private $booksModel;

    public function __construct() {
        $this->booksModel = new Books();
    }

    public function dashboard() {
        $books = $this->booksModel->getAllBooks();
        require_once '../app/views/dashboard.php';

    }
    public function index() {
        $books = $this->booksModel->getAllBooks();
        require_once '../app/views/books/index.php';

    }

    public function create() {
        $books = $this->booksModel->getAllPublishers();
        require_once '../app/views/books/create.php';
    }

    public function store() {
        $judul = $_POST['judul'];
        $pengarang = $_POST['pengarang'];
        $tahun = $_POST['tahun'];
        $genre = $_POST['genre'];
        $id_penerbit = $_POST['id_penerbit'];
        $this->booksModel->add($judul, $pengarang, $tahun, $genre, $id_penerbit);
        header('Location: /books/index');
    }
    // Menampilkan form edit dengan data buku
    public function edit($id_buku) {
        $books = $this->booksModel->find($id_buku); // Asumsikan find() mendapatkan buku berdasarkan ID
        $publishers = $this->booksModel->getAllPublishers();
        require_once __DIR__ . '/../views/books/edit.php';
    }

    // Memproses permintaan update
    public function update($id_buku, $data) {
        $updated = $this->booksModel->update($id_buku, $data);
        if ($updated) {
            header("Location: /books/index"); // Redirect ke list buku
        } else {
            echo "Failed to update book.";
        }
    }

    // Process permintaan delete 
    public function delete($id_buku) {
        $deleted = $this->booksModel->delete($id_buku);
        if ($deleted) {
            header("Location: /books/index"); // Redirect ke list buku
        } else {
            echo "Failed to delete book.";
        }
    }
}

BooksController adalah sebuah kelas yang mengatur logika kontroler untuk fitur manajemen data buku dalam sebuah sistem berbasis PHP. 
File ini berada dalam direktori app/controllers/ dan berfungsi sebagai perantara antara model (logika database) dan view (tampilan antarmuka pengguna).

### Fungsi Utama
- dashboard() : Menampilkan halaman dashboard yang memuat semua data buku.
- index() : Menampilkan halaman utama daftar buku.
- create() : Menampilkan form untuk menambahkan data buku baru.
- store() : Memproses data buku baru yang dikirim dari form tambah dan menyimpannya ke database.
- edit ($id_buku) : Menampilkan form edit dengan data buku yang diambil berdasarkan ID buku.
- update ($id_buku, $data) : Memproses pembaruan data buku berdasarkan input dari form edit.
- delete ($id_buku) : Menghapus data buku berdasarkan ID buku.

BooksController menyediakan semua fitur CRUD (Create, Read, Update, Delete) untuk pengelolaan data buku. 
Controller ini bekerja bersama model Books untuk berinteraksi dengan database dan view untuk menampilkan data ke pengguna.
File ini mengikuti arsitektur MVC (Model-View-Controller) untuk menjaga pemisahan logika aplikasi, data, dan tampilan.


