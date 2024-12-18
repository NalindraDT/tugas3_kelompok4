<!-- app/views/publishers/edit.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penerbit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <form action="/publishers/update/<?php echo $publishers['id_penerbit']; ?>" method="POST">
    <div class="flex flex-col items-center justify-center w-full h-screen">
    <!-- Judul -->
    <h1 class="text-center text-2xl font-['Roboto'] font-semiold">EDIT DATA PENERBIT</h1>
    <!-- Formulir -->
    <div class="flex mt-12 items-center justify-center w-full">
        <img src="../../../../pictures/add.png" class="w-96 mr-20 mb-20 hidden md:block">
        <div class="flex flex-col gap-6 w-full max-w-md">
        <!-- Nama -->
        <label class="relative flex items-center w-full">
            <i class="fas fa-user absolute left-3 text-black"></i>
            <input required type="text" name="nama_penerbit" id="nama_penerbit" value="<?php echo $publishers['nama_penerbit']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Nama Penerbit</span>
        </label>
        <!-- Alamat -->
        <label class="relative flex items-center w-full">
            <i class="fa-solid fa-location-dot absolute left-3 text-black"></i>
            <input required type="alamat"  name="alamat" id="alamat" value="<?php echo $publishers['alamat']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Alamat</span>
        </label>
        <!-- Kontak -->
        <label class="relative flex items-center w-full">
            <i class="fa-solid fa-phone absolute left-3 text-black"></i>
            <input required type="kontak" name="kontak" id="kontak" value="<?php echo $publishers['kontak']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Kontak</span>
        </label>
        <div class="flex gap-4 mt-2 ml-28">
            <!-- Tombol Back (Link) -->
            <a href="../index" class="w-20 h-9 bg-gray-400 text-white text-sm font-medium rounded-md hover:bg-gray-500 transition duration-300 text-center flex items-center justify-center">Back</a>
            <!-- Tombol Add -->
            <button type="submit" class="w-20 h-9 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 transition duration-300">Save</button>
            </div>
        </div>
        <div class="fixed bottom-0 w-full h-12 bg-gray-300 rounded-md p-2 shadow-md">
            <div class="flex justify-center items-center h-full">
                <footer class="text-xs text-center">
                    <p>© 2024 PWEB2<br><a href="mailto:Kel4@example.com" class="text-blue-600 hover:underline flex items-center gap-1"> kel4@example.com</a></p>
                </footer>
            </div>
        </div>
    </div>
</div>
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-6 w-96">
        <h2 class="text-xl font-bold mb-4 text-center">Konfirmasi Penyimpanan</h2>
        <div id="modalDetails" class="mb-4 text-sm"></div>
        <div class="flex justify-between">
            <button id="cancel" type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Batal</button>
            <button id="confirm" type="button" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
        </div>
    </div>
</div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('publishers');
    const modal = document.getElementById('confirmModal');
    const modalDetails = document.getElementById('modalDetails');
    const confirmBtn = document.getElementById('confirm');
    const cancelBtn = document.getElementById('cancel');

    form.addEventListener('submit', function(event) {
        // Prevent default form submission
        event.preventDefault();
        modalDetails.innerHTML = 'Apakah Anda yakin ingin menyimpan semua perubahan?';

        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        // Confirm button
        confirmBtn.onclick = function() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            form.submit();
        };
        // Cancel button
        cancelBtn.onclick = function() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };
    });
});
</script>
        <!-- <tr>
            <td colspan="2" style="text-align: center;">
                <button type="submit">Update</button>
            </td>
        </tr>
    </table>
    </form>
    <a href="/publishers/index">Back to List</a> -->
</body>
</html>