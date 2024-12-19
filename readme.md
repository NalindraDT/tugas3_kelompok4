
### Nama: Nalindra Driyawan Thahai
### NPM: 21090069
### Kelas: TI-2C

<HR>

## config/Database.php

<div align="justify">
File database.php memiliki fungsi yang sama seperti koneksi.php yang biasanya digunakan untuk menyambungkan tabel/system dengan database. Selain fungsi di atas, file database tidak diperbolehkan memiliki fungsi lain

<br>
isi file:

- Pembuatan Class
```php
class Database {
    private $host = '160.19.166.42';
    private $db_name = '2C_klp4';
    private $username = '2C_klp4';
    private $password = 'sh4C@0Ya(.ti*Rob';
    private $conn;
```
Potongan coding diatas berfungsi untuk pembuatan class Database serta atribut nya

- Pembuatan Method

```php

public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
```
Dalam potongan coding diatas berisi pembuatan method/fungsi connect yang digunakan untuk menghubungkan table dengan database yang tertuju. PDO disini berfungsi untuk menggantikan mysqli karena kita menggunakan MVC

<hr>

## models/Loans.php

Dalam folder model biasanya berisi file yang digunakan untuk mengelola data. Di kasus ini folder models berisi file dengan nama loans.php, file ini berisi berbagai method yang bersangkut paut dengan pengelolaan database seperti insert,select dll

<br>
isi file:

- Pembuatan Class
```php
class loans {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

```
    Potongan coding diatas berfungsi untuk membuat instance dari class Database dan menghubungkan dengan connect

- Pembuatan berbagai Method

```php
    public function getAllLoans() {
        $query = $this->db->query("SELECT loans.id_peminjaman, loans.tgl_pinjam, loans.tgl_kembali, 
                                users.nama_user, books.judul FROM  loans INNER JOIN users ON loans.id_user = users.id_user
                                INNER JOIN books ON loans.id_buku = books.id_buku");
        return $query->fetchAll(PDO::FETCH_ASSOC);
```
Berfungsi untuk melakukan pengambilan data menggunakan inner join dari 2 table berbeda yaitu table users dan books. Hal ini bisa dilakukan karena adanya foreign key yang terdapat pada table loan yang merupakan primary key di table lain.

```php
public function getAllUsers() {
        $query = $this->db->query("SELECT * FROM users");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllBooks() {
        $query = $this->db->query("SELECT * FROM books");
        return $query->fetchAll(PDO::FETCH_ASSOC);
```
Berfungsi untuk memanggil semua data uang berada di table books dan users

```php
    public function find($id_peminjaman) {
        $query = $this->db->prepare("SELECT * FROM loans WHERE id_peminjaman = :id_peminjaman");
        $query->bindParam(':id_peminjaman', $id_peminjaman, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
```
Berfungsi untuk mencari data table sesuai dengan id nya

```php
public function add($tgl_pinjam, $tgl_kembali, $id_user, $id_buku) {
        $query = $this->db->prepare("INSERT INTO loans (tgl_pinjam,tgl_kembali,id_user,id_buku) VALUES (:tgl_pinjam, :tgl_kembali, :id_user, :id_buku)");
        $query->bindParam(':tgl_pinjam', $tgl_pinjam);
        $query->bindParam(':tgl_kembali', $tgl_kembali);
        $query->bindParam(':id_user', $id_user);
        $query->bindParam(':id_buku', $id_buku);
        return $query->execute();
    }
```
Berfungsi untuk menambahkan data ke dalam table di database

```php
public function update($id_peminjaman, $data) {
        $query = "UPDATE loans SET tgl_pinjam = :tgl_pinjam, tgl_kembali = :tgl_kembali, id_user = :id_user, id_buku = :id_buku WHERE id_peminjaman = :id_peminjaman";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tgl_pinjam', $data['tgl_pinjam']);
        $stmt->bindParam(':tgl_kembali', $data['tgl_kembali']);
        $stmt->bindParam(':id_user', $data['id_user']);
        $stmt->bindParam(':id_buku', $data['id_buku']);
        $stmt->bindParam(':id_peminjaman', $id_peminjaman);
        return $stmt->execute();
    }
```
Berfungsi untuk mengubah data dalam table di database

```php
    public function delete($id_peminjaman) {
        $query = "DELETE FROM loans WHERE id_peminjaman = :id_peminjaman";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_peminjaman', $id_peminjaman);
        return $stmt->execute();
    }
```
Berfungsi untuk menghapus data dalam table di database

<hr>

## controllers/LoansControlles

Berfungsi untuk mengelola logika pengguna, biasanya digunakan untuk pengelolaan table dalam sistem

- Beberapa method :

```php
    public function dashboard() {
        require_once '../app/views/dashboard.php';
    }
```
Berfungsi untuk menampilkan halaman dashboard sesuai route yang ditentukan

```php
public function index() {
        $loan = $this->loansModel->getAllLoans();
        require_once '../app/views/loans/index.php';
    }


    public function create() {
        $users = $this->loansModel->getAllUsers();
        $users1 = $this->loansModel->getAllBooks();
        require_once '../app/views/loans/create.php';
    }
        public function edit($id_peminjaman) {
        $loans1 = $this->loansModel->find($id_peminjaman);
        $users = $this->loansModel->getAllUsers();
        $books = $this->loansModel->getAllBooks();
        require_once __DIR__ . '/../views/loans/edit.php';
    }
```
Ketiga method diatas memiliki fungsi yang sama yaitu untuk memanggil data sesuai kebutuhan misalkan dalam create() terdapa get all users dan books karena dalam from di create() terdapat dropdown yang dipanggil dari table users dan books.

```php
public function store() {
        $id_user = $_POST['id_user'];
        $tgl_kembali = $_POST['tgl_kembali'];
        $tgl_pinjam = $_POST['tgl_pinjam'];
        $id_buku = $_POST['id_buku'];
        $tgl_kembali = $_POST['tgl_kembali'];
        $this->loansModel->add( $tgl_pinjam, $tgl_kembali, $id_user, $id_buku);
        header('Location: /loans/index');
    }
```
Berfungsi untuk menambahkan data ke dalam table loans sesuai dengan data yang diinputkan

```php
public function update($id_peminjaman, $data) {
        $updated = $this->loansModel->update($id_peminjaman, $data);
        if ($updated) {
            header("Location: /loans/index"); // Redirect to user list
        } else {
            echo "Failed to update loans.";
        }
    }
```
Berfungsi untuk mengubah data sesuai dengan isi yang di masukan 

```php
public function delete($id_peminjaman) {
        $deleted = $this->loansModel->delete($id_peminjaman);
        if ($deleted) {
            header("Location: /loans/index"); // Redirect to user list
        } else {
            echo "Failed to delete user.";
        }
    }
```
berfungsi untuk menghapus data dalam table

<hr>

## views/loans.php

Folde views berisi file file yang berkaitan dengan tampilan UI sistem. Mulai dari dashboard, table, form dan lain sebagainya.

### isi code:

```php

<select 
            name="id_user" 
            id="id_user" 
            class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <option value="">-- Pilih Peminjam --</option>
            <?php foreach ($users as $user): ?>
            <option value="<?php echo $user['id_user']; ?>">
            <?php echo $user['nama_user']; ?></option>
            <?php endforeach; ?>
        </select>

```
```php
<select 
            name="id_buku" 
            id="id_judul" 
            class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <option value="">-- Pilih buku --</option>
            <?php foreach ($users1 as $user1): ?>
            <option value="<?php echo $user1['id_buku']; ?>">
            <?php echo $user1['judul']; ?></option>
            <?php endforeach; ?>
        </select>
```

Kedua potongan coding diatas memiliki kesamaan yang sama yaitu fungsinya untuk membuat dropdown yang berisi data dari table lain

```php
        <select 
            name="id_user" 
            id="id_user" 
            class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <option value="">-- Pilih Peminjam --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user['id_user']; ?>" 
                    <?php echo ($user['id_user'] == $loans1['id_user']) ? 'selected' : ''; ?>>
                    <?php echo $user['nama_user']; ?>
                </option>
            <?php endforeach; ?>
        </select>
```
```php
 <select 
            name="id_buku" 
            id="id_judul" 
            class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <option value="">-- Pilih Judul --</option>
            <?php foreach ($books as $book): ?>
                <option value="<?php echo $book['id_buku']; ?>" 
                    <?php echo ($book['id_buku'] == $loans1['id_buku']) ? 'selected' : ''; ?>>
                    <?php echo $book['judul']; ?>
                </option>
            <?php endforeach; ?>
        </select>
```
Membuat dropdown edit agar saat mengedit pilihan di dropdown maka pilihan yang sebelumnya di inputkan menjadi first choice


## routes.php

Berisi rute rute yang dituju agar sistem memiliki jalur yang jelas

```php
require_once 'app/controllers/PublishersController.php';
require_once 'app/controllers/LoansController.php';

require_once 'app/controllers/UserController.php';
require_once 'app/controllers/Books.php';

$controller = new BooksController();
$UserController = new UserController();
$LoansController = new LoansController();
$PublishersController = new PublishersController();
$url = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($url == '/loans/dashboard' || $url == '/') {
    $LoansController->dashboard();
} elseif ($url == '/loans/index' && $requestMethod == 'GET') {
    $LoansController->index();
} elseif ($url == '/loans/create' && $requestMethod == 'GET') {
    $LoansController->create();
} elseif ($url == '/loans/store' && $requestMethod == 'POST') {
    $LoansController->store();
} elseif (preg_match('/\/loans\/edit\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $loansId = $matches[1];
    $LoansController->edit($loansId);
} elseif (preg_match('/\/loans\/update\/(\d+)/', $url, $matches) && $requestMethod == 'POST') {
    $loansId = $matches[1];
    $LoansController->update($loansId, $_POST);
} elseif (preg_match('/\/loans\/delete\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $loansId = $matches[1];
    $LoansController->delete($loansId);
}elseif ($url == '/publishers/dashboard' || $url == '/') {
    $PublishersController->dashboard();
} elseif ($url == '/publishers/index' && $requestMethod == 'GET') {
    $PublishersController->index();
} elseif ($url == '/publishers/create' && $requestMethod == 'GET') {
    $PublishersController->create();
} elseif ($url == '/publishers/store' && $requestMethod == 'POST') {
    $PublishersController->store();
} elseif (preg_match('/\/publishers\/edit\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $publishersId = $matches[1];
    $PublishersController->edit($publishersId);
} elseif (preg_match('/\/publishers\/update\/(\d+)/', $url, $matches) && $requestMethod == 'POST') {
    $publishersId = $matches[1];
    $PublishersController->update($publishersId, $_POST);
} elseif (preg_match('/\/publishers\/delete\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $publishersId = $matches[1];
    $PublishersController->delete($publishersId);
} elseif ($url == '/user/dashboard' || $url == '/') {
    $UserController->dashboard();
} elseif ($url == '/user/index' && $requestMethod == 'GET') {
    $UserController->index();
} elseif ($url == '/user/create' && $requestMethod == 'GET') {
    $UserController->create();
} elseif ($url == '/user/store' && $requestMethod == 'POST') {
    $UserController->store();
} elseif (preg_match('/\/user\/edit\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $id_user = $matches[1];
    $UserController->edit($id_user);
} elseif (preg_match('/\/user\/update\/(\d+)/', $url, $matches) && $requestMethod == 'POST') {
    $id_user = $matches[1];
    $UserController->update($id_user, $_POST);
} elseif (preg_match('/\/user\/delete\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $id_user = $matches[1];
    $UserController->deleteUser($id_user);
} elseif ($url == '/books/dashboard' || $url == '/') {
    $controller->dashboard();
} elseif ($url == '/books/index' && $requestMethod == 'GET') {
    $controller->index();
} elseif ($url == '/books/create' && $requestMethod == 'GET') {
    $controller->create();
} elseif ($url == '/books/store' && $requestMethod == 'POST') {
    $controller->store();
} elseif (preg_match('/\/books\/edit\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $id_buku = $matches[1];
    $controller->edit($id_buku);
} elseif (preg_match('/\/books\/update\/(\d+)/', $url, $matches) && $requestMethod == 'POST') {
    $id_buku = $matches[1];
    $controller->update($id_buku, $_POST);
} elseif (preg_match('/\/books\/delete\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $id_buku = $matches[1];
    $controller->delete($id_buku);
} else {
    http_response_code(404);
    echo "404 Not Found";
}
```
ini adalah contoh kode PHP yang menggunakan metode routing untuk menangani permintaan HTTP.
</div>

Hasil Hosting:
https://nalegaming.infinityfreeapp.com/

