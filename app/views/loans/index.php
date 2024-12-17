<h2>Daftar Pinjaman</h2>
<a href="/loans/create">Tambah Pinjaman Baru</a>
<ul>
    <?php foreach ($loan as $loans): ?>
        <div>
            <p>
                <?= htmlspecialchars($loans['nama_user']) ?> - 
                <?= htmlspecialchars($loans['tgl_pinjam']) ?> - 
                <?= htmlspecialchars($loans['tgl_kembali']) ?> - 
                <?= htmlspecialchars($loans['judul']) ?>
                <a href="/loans/edit/<?php echo $loans['id_peminjaman']; ?>">Edit</a> |
                <a href="/loans/delete/<?php echo $loans['id_peminjaman']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </p>
        </div>
    <?php endforeach; ?>
</ul>
