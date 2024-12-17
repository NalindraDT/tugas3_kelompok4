<h2>Daftar Buku</h2>
<a href="/books/create">Tambah Buku Baru</a>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID Buku</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Tahun</th>
            <th>Genre</th>
            <th>Nama Penerbit</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?= htmlspecialchars($book['id_buku']) ?></td>
                <td><?= htmlspecialchars($book['judul']) ?></td>
                <td><?= htmlspecialchars($book['pengarang']) ?></td>
                <td><?= htmlspecialchars($book['tahun']) ?></td>
                <td><?= htmlspecialchars($book['genre']) ?></td>
                <td><?= htmlspecialchars($book['nama_penerbit']) ?></td>
                <td>
                    <a href="/books/edit/<?php echo $book['id_buku']; ?>">Edit</a> |
                    <a href="/books/delete/<?php echo $book['id_buku']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>