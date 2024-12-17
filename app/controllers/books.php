<?php
// app/controllers/BooksController.php
require_once '../app/models/Books.php';

class BooksController {
    private $booksModel;

    public function __construct() {
        $this->booksModel = new Books();
    }

    public function dashboard() {
        $books = $this->booksModel->getAllBooks();
        require_once '../app/views/books/dashboard.php';

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
