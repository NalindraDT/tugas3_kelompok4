<?php
// app/controllers/UserController.php
require_once '../app/models/Loans.php';

class LoansController {
    private $loansModel;

    public function __construct() {
        $this->loansModel = new loans();
    }
    
    public function index() {
        $loan = $this->loansModel->getAllLoans();
        require_once '../app/views/loans/index.php';
    }
    public function dashboard() {
        require_once '../app/views/loans/dashboard.php';
    }


    public function create() {
        $users = $this->loansModel->getAllUsers();
        $users1 = $this->loansModel->getAllBooks();
        require_once '../app/views/loans/create.php';
    }

    public function store() {
        $id_user = $_POST['id_user'];
        $tgl_kembali = $_POST['tgl_kembali'];
        $tgl_pinjam = $_POST['tgl_pinjam'];
        $id_buku = $_POST['id_buku'];
        $tgl_kembali = $_POST['tgl_kembali'];
        $this->loansModel->add( $tgl_pinjam, $tgl_kembali, $id_user, $id_buku);
        header('Location: /loans/index');
    }
    // Show the edit form with the user data
    public function edit($id_peminjaman) {
        $loans1 = $this->loansModel->find($id_peminjaman); // Assume find() gets user by id_peminjaman
        $users = $this->loansModel->getAllUsers();
        $books = $this->loansModel->getAllBooks();
        require_once __DIR__ . '/../views/loans/edit.php';
    }

    // Process the update request
    public function update($id_peminjaman, $data) {
        $updated = $this->loansModel->update($id_peminjaman, $data);
        if ($updated) {
            header("Location: /loans/index"); // Redirect to user list
        } else {
            echo "Failed to update loans.";
        }
    }

    // Process delete request
    public function delete($id_peminjaman) {
        $deleted = $this->loansModel->delete($id_peminjaman);
        if ($deleted) {
            header("Location: /loans/index"); // Redirect to user list
        } else {
            echo "Failed to delete user.";
        }
    }
}
