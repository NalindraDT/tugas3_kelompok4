
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <form action="/loans/store" method="post"
     class="flex flex-col items-center justify-center w-full h-screen">
        <!-- Judul -->
        <h1 class="text-center text-2xl font-['Roboto'] font-semiold">TAMBAH DATA PEMINJAMAN</h1>
        <!-- Formulir -->
        <div class="flex mt-12 items-center justify-center w-full">
            <img src="../../../../pictures/add.png" class="w-96 mr-20 mb-20 hidden md:block">
            <div class="flex flex-col gap-6 w-full max-w-md">
    <label class="relative flex items-center w-full">
        <i class="fas fa-user absolute left-3 text-black"></i>
        <select 
            name="id_user" 
            id="id_user" 
            class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <option value="">-- Pilih Peminjam --</option>
            <?php foreach ($users as $user): ?>
            <option value="<?php echo $user['id_user']; ?>">
            <?php echo $user['nama_user']; ?></option>
            <?php endforeach; ?>
        </select>
        <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Pengguna</span>
    </label>
                <!-- Nama -->
    <label class="relative flex items-center w-full">
        <i class="fas fa-book absolute left-3 text-black"></i>
        <select 
            name="id_buku" 
            id="id_judul" 
            class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
            <option value="">-- Pilih buku --</option>
            <?php foreach ($users1 as $user1): ?>
            <option value="<?php echo $user1['id_buku']; ?>">
            <?php echo $user1['judul']; ?></option>
            <?php endforeach; ?>
        </select>
        <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Buku</span>
    </label>
    <label class="relative flex items-center w-full">
        <input required type="date" name="tgl_pinjam" id="tgl_pinjam" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
        <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Tanggal Pinjam</span>
    </label>
    <!-- NPM -->
    <label class="relative flex items-center w-full">
        <input required type="date" name="tgl_kembali" id="tgl_kembali" class="w-72 pr-3 pl-8 py-2 h-12 text-sm outline-none border-2 border-black rounded-lg hover:border-gray-600 duration-200 peer focus:border-indigo-600 bg-inherit shadow-lg">
        <span class="absolute left-6 top-3 px-1 text-m tracking-wide peer-focus:text-indigo-600 pointer-events-none duration-200 peer-focus:text-sm peer-focus:-translate-y-5 bg-white ml-2 peer-valid:text-sm peer-valid:-translate-y-5">Tanggal Kembali</span>
    </label>
                <div class="flex gap-4 mt-2 ml-28">
    <!-- Tombol Back (Link) -->
    <a href="index" class="w-20 h-9 bg-gray-400 text-white text-sm font-medium rounded-md hover:bg-gray-500 transition duration-300 text-center flex items-center justify-center shadow-lg">Back</a>
    <!-- Tombol Add -->
    <button class="w-20 h-9 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 transition duration-300 shadow-lg">Add</button>
                </div>
            </div>
        </div>
        <div class="fixed bottom-0 w-full h-12 bg-gray-300 rounded-md p-2 shadow-md">
        <div class="flex justify-center items-center h-full">
        <footer class="text-xs text-center">
            <p>© 2024 PWEB2<br><a href="mailto:Kel4@example.com" class="text-blue-600 hover:underline flex items-center gap-1"> kel4@example.com</a></p>
        </footer>
    </div>
    </div>
            </form>
</body>
</html>



