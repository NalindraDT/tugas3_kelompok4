<!-- app/views/publishers/edit.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Penerbit</title>
</head>
<body>
    <h2>Edit Penerbit</h2>
    <form action="/publishers/update/<?php echo $publishers['id_penerbit']; ?>" method="POST">
    <table>
        <tr>    
            <td><label for="nama_penerbit">Nama Penerbit:</label></td>
            <td><input type="text" id="nama_penerbit" name="nama_penerbit" value="<?php echo $publishers['nama_penerbit']; ?>" required></td>
        </tr>
        <tr>
            <td><label for="alamat">Alamat:</label></td>
            <td><input type="text" id="alamat" name="alamat" value="<?php echo $publishers['alamat']; ?>" required></td>
        </tr>
        <tr>
            <td><label for="kontak">Kontak:</label></td>
            <td><input type="number" id="kontak" name="kontak" value="<?php echo $publishers['kontak']; ?>" required></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <button type="submit">Update</button>
            </td>
        </tr>
    </table>
    </form>
    <a href="/publishers/index">Back to List</a>
</body>
</html>