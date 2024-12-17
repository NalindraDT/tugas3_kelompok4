<!-- app/views/publishers/create.php -->
<h2>Tambah Data Penerbit</h2>
<form action="/publishers/store" method="POST">
<table>
    <tr>
        <td><label for="nama_penerbit">Nama Penerbit</label></td>
        <td><input type="text" name="nama_penerbit" id="nama_penerbit" required></td>
    </tr>
    <tr>
        <td><label for="alamat">Alamat</label></td>
        <td><input type="text" name="alamat" id="alamat" required></td>
    </tr>
    <tr>
        <td><label for="kontak">Kontak</label></td>
        <td><input type="number" name="kontak" id="kontak" required></td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: center;">
            <button type="submit">Simpan</button>
        </td>
    </tr>
</table>
</form>