<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data</title>
</head>
<body>
    <div class="">
        
    </div>
</body>
</html>
<!-- app/views/user/index.php -->
<h2>Daftar Pengguna</h2>
<a href="/user/create">Tambah Pengguna Baru</a>
<ul>
    <?php foreach ($users as $user): ?>
        <div>
            <p><?= htmlspecialchars($user['nama_user']) ?> - <?= htmlspecialchars($user['email']) ?>
            <a href="/user/edit/<?php echo $user['id_user']; ?>">Edit</a> |
            <a href="/user/delete/<?php echo $user['id_user']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </p>
        </div>
    <?php endforeach; ?>
</ul>
