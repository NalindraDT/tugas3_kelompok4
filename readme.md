# Tugas 3 Pemrogaman Web 2

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
Berfungsi untuk men


</div>