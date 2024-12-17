<!-- app/views/publishers/index.php -->
<h2>Daftar Penerbit</h2>
<a href="/publishers/create">Tambah Penerbit Baru</a>
<table border="2" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>ID Penerbit</th>
            <th>Nama Penerbit</th>
            <th>Alamat</th>
            <th>Kontak</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($publishers as $publisher): ?>
        <tr>
            <td><?= htmlspecialchars($publisher['id_penerbit']) ?></td>
            <td><?= htmlspecialchars($publisher['nama_penerbit']) ?></td>
            <td><?= htmlspecialchars($publisher['alamat']) ?></td>
            <td><?= htmlspecialchars($publisher['kontak']) ?></td>
            <td>
            <a href="/publishers/edit/<?php echo $publisher['id_penerbit']; ?>">Edit</a> |
            <a href="/publishers/delete/<?php echo $publisher['id_penerbit']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    </table>