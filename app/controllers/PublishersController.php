<?php
// app/controllers/PublishersController.php
require_once '../app/models/Publishers.php';

class PublishersController {
    private $publishersModel;

    public function __construct() {
        $this->publishersModel = new Publishers();
    }

    public function dashboard() {
        $publishers = $this->publishersModel->getAllPublishers();
        require_once '../app/views/publishers/dashboard.php';

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
