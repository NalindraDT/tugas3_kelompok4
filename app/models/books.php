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
