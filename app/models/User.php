<?php
require_once '../config/database.php';

class User {
    private $db;

    public function __construct(){
        $this->db = (new Database())->connect();
    }

    public function getAllUsers(){
        $query = $this->db->query("SELECT * FROM users");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findUser($id_user) {
        $query = $this->db->prepare("SELECT * FROM users WHERE id_user = :id_user");
        $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($nama_user, $email, $password, $no_anggota){
        $query = $this->db->prepare("INSERT INTO users (nama_user, email, password, no_anggota) values (:nama_user, :email, :password, :no_anggota)");
        $query->bindParam(':nama_user', $nama_user);
        $query->bindParam(':email', $email);
        $query->bindParam(':password', $password);
        $query->bindParam(':no_anggota', $no_anggota);
        return $query->execute();
    }

    public function updateUser($id_user, $data){
        $query = "UPDATE users SET nama_user = :nama_user, email = :email, password = :password, no_anggota = :no_anggota WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama_user', $data['nama_user']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':no_anggota', $data['no_anggota']);
        $stmt->bindParam(':id_user', $id_user);
        return $stmt->execute();
    }

    public function deleteUser($id_user){
        $query = "DELETE from users WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        return $stmt->execute();
    }
}
