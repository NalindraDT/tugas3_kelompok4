<!-- app/views/books/edit.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Books</title>
</head>
<body>
    <h2>Edit Books</h2>
    <form action="/books/update/<?php echo $books['id_buku']; ?>" method="POST">
        <label for="judul">Judul:</label>
        <input type="text" id="judul" name="judul" value="<?php echo $books['judul']; ?>" required>
        <br>
        <label for="pengarang">Pengarang:</label>
        <input type="text" id="pengarang" name="pengarang" value="<?php echo $books['pengarang']; ?>" required>
        <br>
        <label for="tahun">Tahun:</label>
        <input type="year" id="tahun" name="tahun" value="<?php echo $books['tahun']; ?>" required>
        <br>
        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" value="<?php echo $books['genre']; ?>" required>
        <br>
        <label for="id_penerbit">Nama penerbit :</label>
        <select name="id_penerbit" id="id_penerbit" required>
            <option value="">-- Pilih Judul --</option>
            <?php foreach ($publishers as $publisher): ?>
                <option value="<?php echo $publisher['id_penerbit']; ?>" 
                    <?php echo ($publisher['id_penerbit'] == $books['id_penerbit']) ? 'selected' : ''; ?>>
                    <?php echo $publisher['nama_penerbit']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <!-- <label for="id_penerbit">ID Penerbit:</label>
        <input type="text" id="id_penerbit" name="id_penerbit" value="<?php echo $books['id_penerbit']; ?>" required>
        <br> -->
        <button type="submit">Update</button>
    </form>
    <a href="/books/index">Back to List</a>
</body>
</html>