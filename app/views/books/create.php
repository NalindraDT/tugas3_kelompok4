
<!-- app/views/books/create.php -->
<h2>Tambah Buku Baru</h2>
<form action="/books/store" method="POST">
    <label for="judul">Judul:</label>
    <input type="judu;" name="judul" id="judul" required> <br>
    <label for="pengarang">Pengarang:</label>
    <input type="pengarang" name="pengarang" id="pengarang" required> <br>
    <label for="tahun">Tahun:</label>
    <input type="tahun" name="tahun" id="tahun" required> <br>
    <label for="genre">Genre:</label>
    <input type="genre" name="genre" id="genre" required> <br>
    
    <!-- <label for="id_penerbit">ID Penerbit:</label>
    <input type="id_penerbit" name="id_penerbit" id="id_penerbit" required> <br> -->
    <select name="id_penerbit" id="id_penerbit" required>
        <option value="">-- Pilih Penerbit --</option>
        <?php foreach ($books as $book): ?>
            <option value="<?php echo $book['id_penerbit']; ?>">
                <?php echo $book['nama_penerbit']; ?>
            </option>
        <?php endforeach;?>
        </select>
    <button type="submit">Simpan</button>
</form>
