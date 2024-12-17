<!-- app/views/user/create.php -->
<h2>Tambah Pengguna Baru</h2>
<form action="/loans/store" method="POST">
    <label for="peminjam">Nama Peminjam:</label>
    <select name="id_user" id="peminjam" required>
        <option value="">-- Pilih Peminjam --</option>
        <?php foreach ($users as $user): ?>
            <option value="<?php echo $user['id_user']; ?>">
                <?php echo $user['nama_user']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label for="judul">Judul Buku:</label>
    <select name="id_buku" id="judul" required>
        <option value="">-- Pilih judul --</option>
        <?php foreach ($users1 as $user1): ?>
            <option value="<?php echo $user1['id_buku']; ?>">
                <?php echo $user1['judul']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label for="tgl_pinjam">Tanggal pinjam:</label>
    <input type="date" name="tgl_pinjam" id="tgl_pinjam" required>
    <label for="tgl_kembali">Tanggal Kembali:</label>
    <input type="date" name="tgl_kembali" id="tgl_kembali" required>
    <button type="submit">Simpan</button>
</form>
