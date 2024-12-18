<?php
// app/controllers/UserController.php
require_once '../app/models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function dashboard() {
        $users = $this->userModel->getAllUsers();
        require_once '../app/views/dashboard.php';

    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        require_once '../app/views/user/index.php';

    }

    public function create() {
        require_once '../app/views/user/create.php';
    }

    public function store() {
        $nama_user = $_POST['nama_user'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $no_anggota = $_POST['no_anggota'];
        $this->userModel->addUser($nama_user, $email, $password, $no_anggota);
        header('Location: /user/index');
    }
    // Show the edit form with the user data
    public function edit($id_user) {
        $id_user = $this->userModel->findUser($id_user);
        require_once __DIR__ . '/../views/user/edit.php';
    }

    // Process the update request
    public function update($id_user, $data) {
        $updated = $this->userModel->updateUser($id_user, $data);
        if ($updated) {
            header("Location: /user/index"); // Redirect to user list
        } else {
            echo "Failed to update user.";
        }
    }

    // Process delete request
    public function deleteUser($id_user) {
        $deleted = $this->userModel->deleteUser($id_user);
        if ($deleted) {
            header("Location: /user/index"); // Redirect to user list
        } else {
            echo "Failed to delete user.";
        }
    }
}
