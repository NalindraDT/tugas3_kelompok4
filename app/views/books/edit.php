<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <form action="/books/update/<?php echo $books['id_buku']; ?>" method="POST">
        <div class="flex flex-col items-center justify-center w-full h-screen">
            <!-- Judul -->
            <h1 class="text-center text-2xl font-['Roboto'] font-semiold">EDIT DATA BUKU</h1>
            <!-- Formulir -->
            <div class="flex mt-12 items-center justify-center w-full">
                <img src="../../../../pictures/add.png" class="w-96 mr-20 mb-20 hidden md:block">
                <div class="flex flex-col gap-6 w-full max-w-md">
                    <!-- Judul -->
                    <label class="relative flex items-center w-full">
                        <i class="fa-solid fa-book absolute left-3 text-black"></i>
                        <input required type="text" name="judul" id="judul" value="<?php echo $books['judul']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                        <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Judul</span>
                    </label>
                    <!-- Pengarang -->
                    <label class="relative flex items-center w-full">
                        <i class="fa-solid fa-user-pen fas absolute left-3 text-black"></i>
                        <input required type="pengarang" name="pengarang" id="pengarang" value="<?php echo $books['pengarang']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                        <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Pengarang</span>
                    </label>
                    <!-- Tahun -->
                    <label class="relative flex items-center w-full">
                        <i class="fa-solid fa-calendar-days absolute left-3 text-black"></i>
                        <input required type="tahun" name="tahun" id="tahun" value="<?php echo $books['tahun']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                        <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Tahun</span>
                    </label>
                    <!-- Genre -->
                    <label class="relative flex items-center w-full">
                        <i class="fa-solid fa-scroll absolute left-3 text-black"></i>
                        <input required type="text" name="genre" id="genre" value="<?php echo $books['genre']; ?>" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                        <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Genre</span>
                    </label>
                    <!-- Penerbit -->
                    </label>
                    <!-- Penerbit -->
                    <label class="relative flex items-center w-full">
                        <i class="fas fa-user absolute left-3 text-black"></i>
                        <select
                            name="id_penerbit"
                            id="id_penerbit"
                            class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
                            <!-- Opsi default untuk memastikan pengguna memilih penerbit -->
                            <option value="">-- Pilih Penerbit --</option>

                            <!-- Variabel $publisher akan merepresentasikan setiap elemen dari $publishers -->
                            <?php foreach ($publishers as $publisher): ?>
                                <!-- Menampilkan setiap penerbit dari data $publishers -->
                                <option value="<?php echo $publisher['id_penerbit']; ?>"
                                    <?php echo ($publisher['id_penerbit'] == $books['id_penerbit']) ? 'selected' : ''; ?>>
                                    <?php echo $publisher['nama_penerbit']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Penerbit</span>
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
            const form = document.getElementById('books'); // Mengambil referensi elemen form dengan ID 'books'
            const modal = document.getElementById('confirmModal'); // Mengambil referensi elemen modal konfirmasi dengan ID 'confirmModal'
            const modalDetails = document.getElementById('modalDetails'); // Mengambil referensi elemen untuk menampilkan detail konfirmasi dalam modal
            const confirmBtn = document.getElementById('confirm');  // Mengambil referensi tombol konfirmasi di dalam modal
            const cancelBtn = document.getElementById('cancel'); // Mengambil referensi tombol batal di dalam modal

            // Fungsi ini akan dipanggil setiap kali pengguna mencoba mengirimkan form
            form.addEventListener('submit', function(event) {
                // Mencegah pengiriman form secara default
                event.preventDefault();
                // Menambahkan pesan konfirmasi ke dalam modal
                modalDetails.innerHTML = 'Apakah Anda yakin ingin menyimpan semua perubahan?';

                // Menampilkan modal dengan mengganti kelas 'hidden' dengan 'flex'
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
</body>

</html>