# Praktikum Pemgrograman Web 2 - Sistem Pengelolaan Perpustakaan Digital

## Informasi Umum
Proyek ini merupakan bagian dari Tugas UAS Mata Kuliah Praktikum Pemrograman WEB 2 yang dilakukan oleh kelompok 4 kelas TI-2C Politeknik Negeri Cilacap <br>

## Deskripsi Proyek
Proyek ini merupakan Sistem Pengelolaan Perpustakaan Digital berbasis web yang dirancang menggunakan arsitektur Model-View-Controller (MVC) dengan menerapkan konsep Pemrograman Berorientasi Objek (OOP). Aplikasi ini bertujuan untuk mempermudah pengelolaan koleksi buku, pengguna, serta aktivitas peminjaman dan pengembalian dalam perpustakaan secara digital.

## Tujuan
Tujuan dari praktikum ini adalah untuk memberikan pemahaman yang lebih baik tentang arsitektur MVC dalam pengembangan aplikasi web dan untuk meningkatkan kemampuan mahasiswa dalam menerapkan konsep OOP serta melakukan operasi CRUD (Create, Read, Update, Delete) pada data.

## 1. Membuat Tabel Publishers dalam Database '2C_klp4' <br>
![Screenshot 2024-12-18 212352](https://github.com/user-attachments/assets/f31659e8-72cd-4ece-a724-94439b02cf31)
 <br>
Tabel ini digunakan untuk mencatat informasi tentang penerbit buku. Data dalam tabel ini memuat nama penerbit, informasi kontak, dan alamat, sehingga perpustakaan dapat dengan mudah melacak sumber buku yang diterbitkan. Informasi penerbit sering kali digunakan untuk keperluan pencatatan administrasi atau saat ingin menambah koleksi baru. Hubungan antara tabel penerbit dengan tabel buku memastikan setiap koleksi buku memiliki data penerbit yang valid, memudahkan dalam pengelolaan dan pelaporan koleksi. 
<br>

## 2. 
Script di bawah digunakan untuk mengelola data dalam tabel `publishers` pada database. Kelas ini terhubung ke database melalui konfigurasi di file eksternal dan menyediakan metode CRUD (Create, Read, Update, Delete). Metode `getAllPublishers` mengambil semua data penerbit, sedangkan `find` mencari data berdasarkan ID tertentu. Metode `add` digunakan untuk menambahkan data penerbit baru, sementara `update` memperbarui data penerbit berdasarkan ID, dan `delete` menghapus data penerbit berdasarkan ID. Seluruh operasi menggunakan PDO (PHP Data Objects) dengan parameter yang di-bind untuk menjaga keamanan dari SQL injection.
``` <?php
// app/models/Publishers.php
require_once '../config/database.php';

class Publishers {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllPublishers() {
        $query = $this->db->query("SELECT * FROM publishers");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id_penerbit) {
        $query = $this->db->prepare("SELECT * FROM publishers WHERE id_penerbit = :id_penerbit");
        $query->bindParam(':id_penerbit', $id_penerbit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function add($id_penerbit, $nama_penerbit, $alamat, $kontak) {
        $query = $this->db->prepare("INSERT INTO publishers (id_penerbit, nama_penerbit, alamat, kontak) VALUES (:id_penerbit, :nama_penerbit, :alamat, :kontak)");
        $query->bindParam(':id_penerbit', $id_penerbit);
        $query->bindParam(':nama_penerbit', $nama_penerbit);
        $query->bindParam(':alamat', $alamat);
        $query->bindParam(':kontak', $kontak);
        return $query->execute();
    }

    // Update publishers data by ID
    public function update($id_penerbit, $data) {
        $query = "UPDATE publishers SET id_penerbit = :id_penerbit, nama_penerbit = :nama_penerbit, alamat = :alamat, kontak = :kontak WHERE id_penerbit = :id_penerbit";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_penerbit', $data['id_penerbit']);
        $stmt->bindParam(':nama_penerbit', $data['nama_penerbit']);
        $stmt->bindParam(':alamat', $data['alamat']);
        $stmt->bindParam(':kontak', $data['kontak']);
        $stmt->bindParam(':id_penerbit', $id_penerbit);
        return $stmt->execute();
    }

    // Delete publishers by ID
    public function delete($id_penerbit) {
        $query = "DELETE FROM publishers WHERE id_penerbit = :id_penerbit";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_penerbit', $id_penerbit);
        return $stmt->execute();
    }
}
```

## 3.
Script di bawah ini adalah kelas `PublishersController` yang merupakan bagian dari pola arsitektur MVC (Model-View-Controller), bertugas menangani logika aplikasi terkait pengelolaan data penerbit. Controller ini menggunakan model `Publishers` untuk berinteraksi dengan database dan menyediakan berbagai metode seperti `dashboard` dan `index` untuk menampilkan data penerbit, `create` untuk memuat formulir penambahan data, `store` untuk menyimpan data baru, serta `edit` dan `update` untuk mengedit data yang sudah ada. Selain itu, terdapat metode `delete` untuk menghapus data penerbit berdasarkan ID. Controller ini juga mengarahkan pengguna ke halaman yang sesuai setelah setiap operasi, memisahkan logika bisnis dari tampilan (View) dengan memuat file tampilan yang relevan.
``` <?php
// app/controllers/PublishersController.php
require_once '../app/models/Publishers.php';

class PublishersController {
    private $publishersModel;

    public function __construct() {
        $this->publishersModel = new Publishers();
    }

    public function dashboard() {
        $publishers = $this->publishersModel->getAllPublishers();
        require_once '../app/views/dashboard.php';

    }
    public function index() {
        $publishers = $this->publishersModel->getAllPublishers();
        require_once '../app/views/publishers/index.php';

    }

    public function create() {
        require_once '../app/views/publishers/create.php';
    }

    public function store() {
        $id_penerbit = $_POST['id_penerbit'];
        $nama_penerbit = $_POST['nama_penerbit'];
        $alamat = $_POST['alamat'];
        $kontak = $_POST['kontak'];
        $this->publishersModel->add($id_penerbit, $nama_penerbit, $alamat, $kontak);
        header('Location: /publishers/index');
    }
    // Show the edit form with the publishers data
    public function edit($id_penerbit) {
        $publishers = $this->publishersModel->find($id_penerbit); // Assume find() gets publishers by ID
        require_once __DIR__ . '/../views/publishers/edit.php';
    }

    // Process the update request
    public function update($id_penerbit, $data) {
        $updated = $this->publishersModel->update($id_penerbit, $data);
        if ($updated) {
            header("Location: /publishers/index"); // Redirect to user list
        } else {
            echo "Failed to update publishers.";
        }
    }

    // Process delete request
    public function delete($id_penerbit) {
        $deleted = $this->publishersModel->delete($id_penerbit);
        if ($deleted) {
            header("Location: /publishers/index"); // Redirect to user list
        } else {
            echo "Failed to delete publishers.";
        }
    }
}
```

## 4. Views - Create
Script di bawah ini adalah sebuah halaman formulir HTML untuk menambahkan data penerbit menggunakan framework CSS Tailwind dan ikon Font Awesome. Formulir ini terdiri dari tiga input utama: nama penerbit, alamat, dan kontak, yang masing-masing memiliki ikon, placeholder dinamis, dan validasi wajib diisi (atribut `required`). Tampilan formulir dirancang responsif dengan tata letak modern menggunakan komponen seperti bayangan, animasi hover, dan border dinamis. Selain itu, terdapat tombol "Back" untuk kembali ke halaman sebelumnya dan tombol "Add" untuk mengirim data ke server melalui metode POST ke endpoint `/publishers/store`. Halaman ini juga dilengkapi dengan footer sederhana yang mencantumkan informasi hak cipta dan kontak email kelompok pengembang. Gambar dekoratif hanya ditampilkan pada layar besar untuk mempercantik tampilan.
```<!-- app/views/publishers/create.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAMBAH DATA PENERBIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <form action="/publishers/store" method="post">
    <div class="flex flex-col items-center justify-center w-full h-screen">
        <!-- Judul -->
        <h1 class="text-center text-2xl font-['Roboto'] font-semiold">TAMBAH DATA PENERBIT</h1>
        <!-- Formulir -->
        <div class="flex mt-12 items-center justify-center w-full">
            <img src="../../../../pictures/add.png" class="w-96 mr-20 mb-20 hidden md:block">
            <div class="flex flex-col gap-6 w-full max-w-md">
                <!-- Nama -->
                <label class="relative flex items-center w-full">
                    <i class="fas fa-user absolute left-3 text-black"></i>
                    <input required type="text" name="nama_penerbit" id="nama_penerbit" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                    <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Nama Penerbit</span>
                </label>
                <!-- Alamat -->
                <label class="relative flex items-center w-full">
                    <i class="fa-solid fa-location-dot absolute left-3 text-black"></i>
                    <input required type="alamat"  name="alamat" id="alamat" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                    <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Alamat</span>
                </label>
                <!-- Kontak -->
                <label class="relative flex items-center w-full">
                    <i class="fa-solid fa-phone absolute left-3 text-black"></i>
                    <input required type="kontak" name="kontak" id="kontak" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                    <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Kontak</span>
                </label>
                <!-- NPM -->
                <!-- <label class="relative flex items-center w-full">
                    <i class="fas fa-graduation-cap absolute left-3 text-black"></i>
                    <input required type="text" pattern="\d*" name="no_anggota" id="no_anggota"  class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg" oninput="this.value=this.value.replace(/\D/g,'')">
                    <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">NPM</span>
                </label> -->
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
### Views - Edit
Script ini adalah halaman HTML yang digunakan untuk mengedit data penerbit dalam sistem berbasis web. Formulir utama menampilkan input seperti nama penerbit, alamat, dan kontak yang diisi dengan data penerbit yang ada, ditarik dari PHP menggunakan variabel `$publishers`. Saat pengguna mencoba mengirimkan formulir, modal konfirmasi muncul menggunakan JavaScript untuk meminta konfirmasi sebelum menyimpan perubahan. Tombol-tombol seperti "Back" dan "Save" memberikan navigasi dan pengolahan data. Desainnya responsif dengan ikon dan tampilan modern untuk pengalaman pengguna yang lebih baik, sementara modal memastikan tindakan pengguna divalidasi sebelum data diperbarui ke basis data.
```<!-- app/views/publishers/edit.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penerbit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <form action="/publishers/update/<?php echo $publishers['id_penerbit']; ?>" method="POST">
    <div class="flex flex-col items-center justify-center w-full h-screen">
    <!-- Judul -->
    <h1 class="text-center text-2xl font-['Roboto'] font-semiold">EDIT DATA PENERBIT</h1>
    <!-- Formulir -->
    <div class="flex mt-12 items-center justify-center w-full">
        <img src="../../../../pictures/add.png" class="w-96 mr-20 mb-20 hidden md:block">
        <div class="flex flex-col gap-6 w-full max-w-md">
        <!-- Nama -->
        <label class="relative flex items-center w-full">
            <i class="fas fa-user absolute left-3 text-black"></i>
            <input required type="text" name="nama_penerbit" id="nama_penerbit" value="<?php echo $publishers['nama_penerbit']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Nama Penerbit</span>
        </label>
        <!-- Alamat -->
        <label class="relative flex items-center w-full">
            <i class="fa-solid fa-location-dot absolute left-3 text-black"></i>
            <input required type="alamat"  name="alamat" id="alamat" value="<?php echo $publishers['alamat']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Alamat</span>
        </label>
        <!-- Kontak -->
        <label class="relative flex items-center w-full">
            <i class="fa-solid fa-phone absolute left-3 text-black"></i>
            <input required type="kontak" name="kontak" id="kontak" value="<?php echo $publishers['kontak']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Kontak</span>
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
    const form = document.getElementById('publishers');
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
        <!-- <tr>
            <td colspan="2" style="text-align: center;">
                <button type="submit">Update</button>
            </td>
        </tr>
    </table>
    </form>
    <a href="/publishers/index">Back to List</a> -->
</body>
</html>
```
### Views - Index
Halaman ini menampilkan tabel data penerbit dengan fitur pencarian, paginasi, serta tombol aksi seperti edit dan hapus. Fungsi pencarian memungkinkan pengguna mencari data tertentu, sedangkan fitur paginasi membatasi jumlah data yang ditampilkan per halaman. Ada modal konfirmasi yang muncul saat pengguna mencoba menghapus data untuk memastikan tindakan tersebut. Script ini juga menggunakan elemen visual responsif, ikon FontAwesome, dan elemen aksesibilitas untuk meningkatkan pengalaman pengguna di berbagai perangkat.
```<!-- app/views/publishers/index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penerbit</title>
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
<h2 class="pt-8 text-center text-xl font-['Roboto'] font-bold">DAFTAR PENERBIT</h2>
<div class="container mx-auto px-4 flex flex-col min-h-screen">
    <div class="flex-1 flex flex-col items-center">
        <!-- tombol dan search bar -->
        <div class="mt-24 w-3/4">
            <div class="flex justify-end gap-2 items-center">
                <a href="/publishers/create" class="px-5 py-3 bg-blue-500 text-white font-semibold text-sm rounded-lg hover:bg-blue-600 transition duration-300"><i class="fa fa-plus mr-2"></i>Add</a>
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
        <table id="publishers" class="mt-2 table-auto w-3/4 rounded-lg shadow-lg overflow-hidden text-sm text-left">
            <thead>
                <tr class="bg-gray-300 justify-center">
                <th class="px-4 py-2 text-center">ID Penerbit</th>
                <th class="px-4 py-2 text-center">Nama Penerbit</th>
                <th class="px-4 py-2 text-center">Alamat</th>
                <th class="px-4 py-2 text-center">Kontak</th>
                <th class="px-4 py-2 text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($publishers as $publisher): ?>
        <tr class="odd:bg-gray-100 even:bg-gray-200 hover:bg-gray-300 border-b border-gray-300">
            <td class="px-4 py-2 text-center"><?= htmlspecialchars($publisher['id_penerbit']) ?></td>
            <td class="px-4 py-2 text-center"><?= htmlspecialchars($publisher['nama_penerbit']) ?></td>
            <td class="px-4 py-2 text-center"><?= htmlspecialchars($publisher['alamat']) ?></td>
            <td class="px-4 py-2 text-center"><?= htmlspecialchars($publisher['kontak']) ?></td>
            <td class="px-4 py-2 text-center">
                <a href="/publishers/edit/<?php echo $publisher['id_penerbit']; ?>" class="inline-block px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"><i class="fa fa-pen mr-2"></i>Edit</a> |
                <a href="/publishers/delete/<?php echo $publisher['id_penerbit']; ?>" id="delete" class="inline-block px-4 py-2 bg-red-500 text-white font-semibold text-sm rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"><i class="fa fa-trash mr-2"></i>Delete</a>
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
    const table = document.getElementById('publishers');
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



