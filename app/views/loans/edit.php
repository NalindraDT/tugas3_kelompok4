<!-- app/views/user/edit.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>

    <h2>Edit Loans</h2>
    <form action="/loans/update/<?php echo $loans1['id_peminjaman']; ?>" method="POST">
    <label for="peminjam">Nama Peminjam:</label>
        <select name="id_user" id="peminjam" required>
            <option value="">-- Pilih Peminjam --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user['id_user']; ?>" 
                    <?php echo ($user['id_user'] == $loans1['id_user']) ? 'selected' : ''; ?>>
                    <?php echo $user['nama_user']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="judul">Judul Buku:</label>
        <select name="id_buku" id="judul" required>
            <option value="">-- Pilih Judul --</option>
            <?php foreach ($books as $book): ?>
                <option value="<?php echo $book['id_buku']; ?>" 
                    <?php echo ($book['id_buku'] == $loans1['id_buku']) ? 'selected' : ''; ?>>
                    <?php echo $book['judul']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    <br>
        <label for="tgl_pinjam">Tgl:</label>
        <input type="date" id="tgl_pinjam" name="tgl_pinjam" value="<?php echo $loans1['tgl_pinjam']; ?>" required>
        <br>
        <label for="tgl_kembali">Tgl:</label>
        <input type="date" id="tgl_kembali" name="tgl_kembali" value="<?php echo $loans1['tgl_kembali']; ?>" required>
        <br>
        <button type="submit">Update</button>
    </form>
    <a href="/loans/index">Back to List</a>
</body>
</html>