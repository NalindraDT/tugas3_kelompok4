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
![alt text](</Pictures/Screenshot 2024-12-18 224918.png>)

## Output dashboard
![alt text](</Pictures/Screenshot 2024-12-19 132709-1.png>)

### Deskripsi table books
Tabel ini digunakan untuk menyimpan data buku dalam sebuah sistem basis data MySQL. Berikut adalah penjelasan mengenai kolom-kolom dalam tabel ini.
### Detail
- id_buku : int primary key auto increment
- judul : varchar(50)
- pengarang : varchar(50)
- tahun : year
- genre : varchar (50)
- id_penerbit : int foreign key

## Script Program ControllerBooks
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

## Script Program Models Books
```plaintext
<?php
// app/models/Books.php
require_once '../config/database.php';

class Books {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllBooks() {
        $query = $this->db->query("SELECT books.id_buku,books.judul,books.pengarang,books.tahun,books.genre,publishers.nama_penerbit FROM books JOIN publishers ON books.id_penerbit = publishers.id_penerbit");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllPublishers() {
        $query = $this->db->query("SELECT * FROM publishers ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id_buku) {
        $query = $this->db->prepare("SELECT * FROM books WHERE id_buku = :id_buku");
        $query->bindParam(':id_buku', $id_buku, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function add($judul, $pengarang, $tahun, $genre, $id_penerbit) {
        $query = $this->db->prepare("INSERT INTO books (judul, pengarang, tahun, genre, id_penerbit) VALUES (:judul, :pengarang, :tahun, :genre, :id_penerbit)");
        $query->bindParam(':judul', $judul);
        $query->bindParam(':pengarang', $pengarang);
        $query->bindParam(':tahun', $tahun);
        $query->bindParam(':genre', $genre);
        $query->bindParam(':id_penerbit', $id_penerbit);
        return $query->execute();
    }

    // Update books data by ID
    
    public function update($id_buku, $data) {
        $query = "UPDATE books SET judul = :judul, pengarang = :pengarang, tahun = :tahun, genre = :genre, id_penerbit = :id_penerbit
        WHERE id_buku = :id_buku";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':judul', $data['judul']);
        $stmt->bindParam(':pengarang', $data['pengarang']);
        $stmt->bindParam(':tahun', $data['tahun']);
        $stmt->bindParam(':genre', $data['genre']);
        $stmt->bindParam(':id_penerbit', $data['id_penerbit']);
        $stmt->bindParam(':id_buku', $id_buku);
        return $stmt->execute();
    }

    // Delete books by ID
    public function delete($id_buku) {
        $query = "DELETE FROM books WHERE id_buku = :id_buku";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_buku', $id_buku);
        return $stmt->execute();
    }
}
```

### Deskripsi
Books.php adalah kelas model dalam aplikasi PHP yang berfungsi untuk menangani operasi CRUD (Create, Read, Update, Delete) 
pada data buku dalam database. Kelas ini juga berhubungan dengan tabel penerbit melalui relasi sederhana. File ini merupakan bagian dari arsitektur MVC (Model-View-Controller) untuk pengelolaan data buku.
### Fungsi Utama
- getAllBooks() : Fungsi ini mengambil semua data buku dari tabel books dengan informasi penerbit melalui operasi JOIN.
- getAllPublishers() : Mengambil semua data penerbit dari tabel publishers. Fungsi ini berguna untuk menampilkan daftar penerbit saat input data buku.
- find($id_buku) : Fungsi untuk mendapatkan detail satu buku berdasarkan id_buku. Menggunakan query prepared statement untuk keamanan.
- add($judul, $pengarang, $tahun, $genre, $id_penerbit) : Menambahkan data buku baru ke dalam tabel books.
- update($id_buku, $data) : Memperbarui data buku berdasarkan id_buku.

## Script Program View Books index
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<style>
    html, body {
        height: 100%;
        margin: 0;
        overflow: hidden;
    }
</style>
<body class="min-h-screen bg-gray-400">
<!-- Judul -->
<h2 class="pt-8 text-center text-xl font-['Roboto'] font-bold">DAFTAR BUKU</h2>
<div class="container mx-auto px-4 flex flex-col min-h-screen">
    <div class="flex-1 flex flex-col items-center">
        <!-- tombol dan search bar -->
        <div class="mt-24 w-3/4">
            <div class="flex justify-end gap-2 items-center">
                <a href="/books/create" class="px-5 py-3 bg-blue-500 text-white font-semibold text-sm rounded-lg hover:bg-blue-600 transition duration-300"><i class="fa fa-plus mr-2"></i>Add</a>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari data..." class="w-48 pl-10 px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>
        <div id="no-data-row" class="mt-8 text-center bg-white p-4 rounded-lg shadow-md hidden w-3/4">
            <p class="text-gray-600 text-lg">Data Tidak tersedia</p>
        </div>
        <table id="books" class="mt-2 table-auto w-3/4 rounded-lg shadow-lg overflow-hidden text-sm text-left">
            <thead>
                <tr class="bg-gray-300 justify-center">
                    <th class="px-4 py-2 text-center">ID Buku</th>
                    <th class="px-4 py-2 text-center">Judul</th>
                    <th class="px-4 py-2 text-center">Pengarang</th>
                    <th class="px-4 py-2 text-center">Tahun</th>
                    <th class="px-4 py-2 text-center">Genre</th>
                    <th class="px-4 py-2 text-center">Penerbit</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr class="odd:bg-gray-100 even:bg-gray-200 hover:bg-gray-300 border-b border-gray-300">
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($book['id_buku']) ?></td>
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($book['judul']) ?></td>
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($book['pengarang']) ?></td>
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($book['tahun']) ?></td>
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($book['genre']) ?></td>
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($book['nama_penerbit']) ?></td>
                        <td class="px-4 py-2 text-center">
                            <a href="/books/edit/<?php echo $book['id_buku']; ?>" class="inline-block px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"><i class="fa fa-pen mr-2"></i>Edit</a>
                            <a href="/books/delete/<?php echo $book['id_buku']; ?>" id="delete" class="inline-block px-4 py-2 bg-red-500 text-white font-semibold text-sm rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"><i class="fa fa-trash mr-2"></i>Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr id="no-data-row" class="hidden">
                    <td colspan="5" class="text-center p-4 bg-white text-gray-600">
                        Tidak ada data yang ditemukan
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="mt-2 flex justify-between w-3/4">
            <a href="./dashboard" class="w-20 h-9 bg-gray-500 text-white text-sm font-medium rounded-md hover:bg-gray-600 transition duration-300 text-center flex items-center justify-center"><i class="fa fa-arrow-left mr-2"></i>Back</a>
            <div id="pagination" class="flex gap-2"></div>
        </div>
        <div class="fixed bottom-0 w-full h-12 bg-gray-300 rounded-md p-2 shadow-md">
            <div class="flex justify-center items-center h-full">
                <footer class="text-xs text-center">
                    <p>© 2024 PWEB2<br><a href="mailto:Kel4@example.com" class="text-blue-600 hover:underline flex items-center gap-1"> kel4@example.com</a></p>
                </footer>
            </div>
        </div>
    </div>
</div>
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-6 w-96">
        <h2 class="text-xl font-bold mb-4 text-center">Konfirmasi Hapus</h2>
        <div id="modalDetails" class="mb-4 text-sm"></div>
        <div class="flex justify-between">
            <button id="cancel" type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Tidak</button>
            <button id="confirm" type="button" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Ya</button>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('books');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = tbody.getElementsByTagName('tr');
    const modal = document.getElementById('confirmModal');
    const modalDetails = document.getElementById('modalDetails');
    const confirmBtn = document.getElementById('confirm');
    const cancelBtn = document.getElementById('cancel');
    const noDataRow = document.getElementById('no-data-row');

    document.querySelectorAll('#delete').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const deleteUrl = this.getAttribute('href');
            
            // Set pesan konfirmasi
            modalDetails.innerHTML = 'Apakah Anda yakin ingin menghapus data ini?';
            
            // Tampilkan modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Handle konfirmasi
            confirmBtn.onclick = function() {
                window.location.href = deleteUrl;
            };
            
            // Handle pembatalan
            cancelBtn.onclick = function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };
        });
    });

    // Set items per page
    const itemsPerPage = 5;
    const totalPages = Math.ceil(rows.length / itemsPerPage);
    let currentPage = 1;

    // Get pagination container
    const paginationContainer = document.getElementById('pagination');
    setupInitialPagination();

    function setupInitialPagination() {
        const totalPages = Math.ceil((rows.length - 1) / itemsPerPage); // Subtract 1 to exclude no-data row
        paginationContainer.innerHTML = '';

        // Hanya buat pagination jika total page lebih dari 1
    if (totalPages > 1) {
        for(let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.innerText = i;
            button.className = `px-3 py-1 rounded ${currentPage === i ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
            
            button.addEventListener('click', function() {
                currentPage = i;
                showPage(i);
                updatePaginationStyles();
            });
            
            paginationContainer.appendChild(button);
        }
    }

        showPage(1);
    }

    function showPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        // Hide all rows
        for(let i = 0; i < rows.length; i++) {
            rows[i].style.display = 'none';
        }

        // Show rows for current page
        for(let i = start; i < end && i < rows.length; i++) {
            rows[i].style.display = '';
        }
    }

    function updatePaginationStyles() {
        const buttons = paginationContainer.getElementsByTagName('button');
        for(let i = 0; i < buttons.length; i++) {
            if(i + 1 === currentPage) {
                buttons[i].className = 'px-3 py-1 rounded bg-blue-500 text-white';
            } else {
                buttons[i].className = 'px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300';
            }
        }
    }

    // Show first page initially
    showPage(1);

    // Add search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleRowsCount = 0;

        // Filter rows
        for(let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
                visibleRowsCount++;
            } else {
                row.style.display = 'none';
            }
        }

        // Show/hide table and no data message
        if (searchTerm && visibleRowsCount === 0) {
            table.style.display = 'none';
            noDataRow.classList.remove('hidden');
            document.getElementById('pagination').innerHTML = ''; // Clear pagination
        } else {
            table.style.display = 'table';
            noDataRow.classList.add('hidden');
            
            // Update pagination for visible rows
            const visibleRows = [...rows].filter(row => row.style.display !== 'none');
            updatePagination(visibleRows);
        }
    });

    function recreatePagination(visibleRows) {
        const totalPages = Math.ceil(visibleRows.length / itemsPerPage);
        paginationContainer.innerHTML = '';

        // Hanya buat pagination jika total page lebih dari 1
        if (totalPages > 1) {
            for(let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.innerText = i;
                button.className = `px-3 py-1 rounded ${currentPage === 1 ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
                
                button.addEventListener('click', function() {
                    currentPage = i;
                    showFilteredPage(i, visibleRows);
                    updatePaginationStyles();
                });
                
                paginationContainer.appendChild(button);
            }
        }

        // Show first page of filtered results
        if (visibleRows.length > 0) {
            showFilteredPage(1, visibleRows);
        }
    }

    function showFilteredPage(page, visibleRows) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        // Hide all rows first
        visibleRows.forEach(row => row.style.display = 'none');

        // Show rows for current page
        for(let i = start; i < end && i < visibleRows.length; i++) {
            visibleRows[i].style.display = '';
        }
    }

    function updateButtonStyles(container, currentPage) {
        const buttons = container.getElementsByTagName('button');
        for(let i = 0; i < buttons.length; i++) {
            if(i + 1 === currentPage) {
                buttons[i].className = 'px-3 py-1 rounded bg-blue-500 text-white';
            } else {
                buttons[i].className = 'px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300';
            }
        }
    }
});
</script>
</body>
</html>
``` 
### Output Books Index
![alt text](</Pictures/Screenshot 2024-12-19 133429.png>)
### Deskripsi
Proyek ini adalah aplikasi web sederhana yang menampilkan daftar buku menggunakan HTML, CSS (Tailwind CSS), JavaScript, dan PHP. 
Proyek ini mendukung fitur CRUD (Create, Read, Update, Delete) serta fitur pencarian, paginasi, dan konfirmasi hapus data.
### Fungsi Utama
- Menampilkan Data Buku <br>
Menampilkan data buku dalam bentuk tabel dengan informasi seperti ID Buku, Judul, Pengarang, Tahun, Genre, dan Penerbit.
- Tambah Data Buku <br>
Tombol untuk menambahkan buku baru yang mengarahkan ke halaman form tambah data.
- Edit Data Buku <br>
Mengubah data buku yang telah ada melalui tombol Edit. <br>
- Hapus Data Buku dengan Konfirmasi <br>
Menghapus data buku dengan menampilkan modal konfirmasi sebelum data benar-benar dihapus. <br>
- Pencarian Data<br>
Fitur pencarian untuk memfilter data buku berdasarkan teks yang dimasukkan.

## Script Program Views Books create
```
<!-- app/views/user/create.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Books</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <form action="/books/store" method="post">
    <div class="flex flex-col items-center justify-center w-full h-screen">
        <!-- Judul -->
        <h1 class="text-center text-2xl font-['Roboto'] font-semiold">TAMBAH DATA BUKU</h1>
        <!-- Formulir -->
        <div class="flex mt-12 items-center justify-center w-full">
            <img src="../../../../pictures/add.png" class="w-96 mr-20 mb-20 hidden md:block">
            <div class="flex flex-col gap-6 w-full max-w-md">
                <!-- Judul -->
                <label class="relative flex items-center w-full">
                    <i class="fa-solid fa-book absolute left-3 text-black"></i>
                    <input required type="text" name="judul" id="judul" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                    <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Judul</span>
                </label>
                <!-- Pengarang -->
                <label class="relative flex items-center w-full">
                    <i class="fa-solid fa-user-pen  absolute left-3 text-black"></i>
                    <input required type="pengarang"  name="pengarang" id="pengarang" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                    <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Pengarang</span>
                </label>
                <!-- Tahun -->
                <label class="relative flex items-center w-full">
                    <i class="fa-solid fa-calendar-days absolute left-3 text-black"></i>
                    <input required type="tahun" name="tahun" id="tahun" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                    <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Tahun</span>
                </label>
                <!-- Genre -->
                <label class="relative flex items-center w-full">
                    <i class="fa-solid fa-scroll absolute left-3 text-black"></i>
                    <input required type="text" name="genre" id="genre"  class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                    <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Genre</span>
                </label>
                 <!-- Penerbit -->
                 <label class="relative flex items-center w-full">
                <i class="fas fa-user absolute left-3 text-black"></i>
        <select 
            name="id_penerbit"
            id="id_penerbit"
            class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <option value="">-- Pilih Penerbit --</option>
            <?php foreach ($books as $book): ?>
            <option value="<?php echo $book['id_penerbit']; ?>">
            <?php echo $book['nama_penerbit']; ?></option>
            <?php endforeach; ?>
        </select>
        <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Pengguna</span>
    </label>
                <div class="flex gap-4 mt-2 ml-28">
                    <!-- Tombol Back (Link) -->
                    <a href="index" class="w-20 h-9 bg-gray-400 text-white text-sm font-medium rounded-md hover:bg-gray-500 transition duration-300 text-center flex items-center justify-center shadow-lg">Back</a>
                    <!-- Tombol Add -->
                    <button class="w-20 h-9 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 transition duration-300 shadow-lg">Add</button>
                </div>
            </div>
        </div>
        <div class="fixed bottom-0 w-full h-12 bg-gray-300 rounded-md p-2 shadow-md">
        <div class="flex justify-center items-center h-full">
        <footer class="text-xs text-center">
            <p>© 2024 PWEB2<br><a href="mailto:Kel4@example.com" class="text-blue-600 hover:underline flex items-center gap-1"> kel4@example.com</a></p>
        </footer>
    </div>
    </div>
</body>
</html>
```
### Output Tambah data buku
![alt text](/Pictures/image.png)       
### Deskripsi 
Form "Tambah Buku" adalah antarmuka pengguna yang dibuat untuk menambahkan entri buku baru ke dalam sistem. Form ini dibangun menggunakan HTML dan didesain dengan Tailwind CSS. Form ini menyediakan antarmuka yang responsif dan ramah pengguna, memungkinkan pengguna untuk memasukkan detail buku dan mengirimkan data ke endpoint server yang ditentukan.
### Fungsi Utama
- Mengumpulkan informasi buku <br>
Form ini memungkinkan pengguna memasukkan informasi penting mengenai buku
- Validasi data <br>
Setiap field dalam form memiliki validasi wajib untuk memastikan data yang dimasukkan lengkap dan valid sebelum dikirim ke server.
- Pengiriman data ke server <br>
Setelah data diisi dan divalidasi, form mengirimkan permintaan POST ke endpoint /books/store, di mana data diproses untuk ditambahkan ke database.
## Script Program edit
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<form action="/books/update/<?php echo $books['id_buku']; ?>" method="POST">
<div class="flex flex-col items-center justify-center w-full h-screen">
    <!-- Judul -->
    <h1 class="text-center text-2xl font-['Roboto'] font-semiold">EDIT DATA BUKU</h1>
    <!-- Formulir -->
    <div class="flex mt-12 items-center justify-center w-full">
        <img src="../../../../pictures/add.png" class="w-96 mr-20 mb-20 hidden md:block">
        <div class="flex flex-col gap-6 w-full max-w-md">
            <!-- Judul -->
            <label class="relative flex items-center w-full">
                <i class="fa-solid fa-book absolute left-3 text-black"></i>
                <input required type="text" name="judul" id="judul" value="<?php echo $books['judul']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Judul</span>
            </label>
            <!-- Pengarang -->
            <label class="relative flex items-center w-full">
                <i class="fa-solid fa-user-pen fas absolute left-3 text-black"></i>
                <input required type="pengarang"  name="pengarang" id="pengarang" value="<?php echo $books['pengarang']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Pengarang</span>
            </label>
            <!-- Tahun -->
            <label class="relative flex items-center w-full">
                <i class="fa-solid fa-calendar-days absolute left-3 text-black"></i>
                <input required type="tahun" name="tahun" id="tahun" value="<?php echo $books['tahun']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Tahun</span>
            </label>
            <!-- Genre -->
            <label class="relative flex items-center w-full">
                <i class="fa-solid fa-scroll absolute left-3 text-black"></i>
                <input required type="text" name="genre" id="genre" value="<?php echo $books['genre']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Genre</span>
            </label>
            <!-- Penerbit -->
            </label>
                 <!-- Penerbit -->
                 <label class="relative flex items-center w-full">
                <i class="fas fa-user absolute left-3 text-black"></i>
        <select 
            name="id_penerbit" 
            id="id_penerbit" 
            class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <option value="">-- Pilih Penerbit --</option>
            <?php foreach ($publishers as $publisher): ?>
                <option value="<?php echo $publisher['id_penerbit']; ?>" 
                    <?php echo ($publisher['id_penerbit'] == $books['id_penerbit']) ? 'selected' : ''; ?>>
                    <?php echo $publisher['nama_penerbit']; ?>
        </option>
            <?php endforeach; ?>
        </select>
        <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Penerbit</span>
    </label>
            <div class="flex gap-4 mt-2 ml-28">
                <!-- Tombol Back (Link) -->
                <a href="../index" class="w-20 h-9 bg-gray-400 text-white text-sm font-medium rounded-md hover:bg-gray-500 transition duration-300 text-center flex items-center justify-center">Back</a>
                <!-- Tombol Add -->
                <button type="submit" class="w-20 h-9 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 transition duration-300">Save</button>
            </div>
        </div>
        <div class="fixed bottom-0 w-full h-12 bg-gray-300 rounded-md p-2 shadow-md">
            <div class="flex justify-center items-center h-full">
                <footer class="text-xs text-center">
                    <p>© 2024 PWEB2<br><a href="mailto:Kel4@example.com" class="text-blue-600 hover:underline flex items-center gap-1"> kel4@example.com</a></p>
                </footer>
            </div>
        </div>
    </div>
</div>
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-6 w-96">
        <h2 class="text-xl font-bold mb-4 text-center">Konfirmasi Penyimpanan</h2>
        <div id="modalDetails" class="mb-4 text-sm"></div>
        <div class="flex justify-between">
            <button id="cancel" type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Batal</button>
            <button id="confirm" type="button" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
        </div>
    </div>
</div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('books');
    const modal = document.getElementById('confirmModal');
    const modalDetails = document.getElementById('modalDetails');
    const confirmBtn = document.getElementById('confirm');
    const cancelBtn = document.getElementById('cancel');

    form.addEventListener('submit', function(event) {
        // Prevent default form submission
        event.preventDefault();
        modalDetails.innerHTML = 'Apakah Anda yakin ingin menyimpan semua perubahan?';

        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        // Confirm button
        confirmBtn.onclick = function() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            form.submit();
        };
        // Cancel button
        cancelBtn.onclick = function() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };
    });
});
</script>
</body>
</html>
```
### Output Edit buku
![alt text](</Pictures/Screenshot 2024-12-19 133730.png>)
### Deskripsi
Form "Edit Buku" adalah antarmuka pengguna untuk memperbarui entri buku yang sudah ada dalam sistem. Form ini dirancang untuk memberikan pengalaman pengguna yang intuitif dengan validasi dan interaktivitas yang memadai.
### Fungsi Utama
- Mengedit data buku
- Konfirmasi penyimpanan