<?php
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
