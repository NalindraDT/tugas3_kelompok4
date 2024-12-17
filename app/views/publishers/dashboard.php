<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    body::before {
        content: '';
        position: fixed; /* Tetap di latar belakang */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(#00000080,#00000080), url(../project-mvc/pictures/room-interior-design.jpg);
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        z-index: -1;
    }
</style>
<body class="flex justify-center items-center mt-5 bg-gray-200">
    <!-- Content -->
    <div class="flex flex-col z-1 w-full items-center gap-5">  
    <!-- Selamat Datang -->
    <div class="w-11/12 bg-gray-300 rounded-md p-3 shadow-md">
        <h2 class="text-center text-black font-semibold text-2xl">WELCOME</h2>
    </div>

    <div class="flex justify-center items-center min-h-[72vh] space-x-20">
        <!-- Col 1 -->
        <div class="w-72 h-96 bg-gray-300 rounded-md p-3 shadow-md shadow-md hover:shadow-lg hover:scale-105 transition duration-300">
            <div class="flex justify-center">
                <img class="w-32" src="../project-mvc/pictures/rb_4707.png">
            </div>
            <p class="text-gray-600 text-sm mt-2">Manajemen Anggota Perpustakaan:  kelola data anggota seperti nama, email, password, dan nomor anggota</p>
            <h3 class="text-center text-black mt-12 font-semibold text-2xl">User</h3>
            <button class="w-24 h-8 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 mt-12">See Details</button>
        </div>

    <!-- Col 2 -->
        <div class="w-72 h-96 bg-gray-300 rounded-md p-3 shadow-md shadow-md hover:shadow-lg hover:scale-105 transition duration-300">
            <div class="flex justify-center">
                <img class="w-32" src="../project-mvc/pictures/rb_2149334866.png">
            </div>
            <p class="text-gray-600 text-sm mt-2">Kelola Data Buku Perpustakaan: Tambah, ubah, hapus, dan kelola data buku seperti judul, penulis,tahun terbit, dan genre.</p>
            <h3 class="text-center text-black mt-12 font-semibold text-2xl">Books</h3>
            <button class="w-24 h-8 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 mt-12">See Details</button>
        </div>

    <!-- Col 3 -->
        <div class="w-72 h-96 bg-gray-300 rounded-md p-3 shadow-md shadow-md hover:shadow-lg hover:scale-105 transition duration-300">
            <div class="flex justify-center">
                <img class="w-32" src="../project-mvc/pictures/rb_646.png">
            </div>
            <p class="text-gray-600 text-sm mt-2">Kelola Data Buku Perpustakaan: Tambah, ubah, hapus, dan kelola data buku seperti judul, penulis,tahun terbit, dan genre.</p>
            <h3 class="text-center text-black mt-12 font-semibold text-2xl">Publisher</h3>
            <button class="w-24 h-8 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 mt-12"><a href="/publishers/index" class="text-white">See Details</a></button>
        </div>

        <!-- Col 4 -->
        <div class="w-72 h-96 bg-gray-300 rounded-md p-3 shadow-md shadow-md hover:shadow-lg hover:scale-105 transition duration-300">
            <div class="flex justify-center">
                <img class="w-28" src="../project-mvc/pictures/rb_82392.png">
            </div>
            <p class="text-gray-600 text-sm mt-2">Kelola Data Buku Perpustakaan: Tambah, ubah, hapus, dan kelola data buku seperti judul, penulis,tahun terbit, dan genre.</p>
            <h3 class="text-center text-black mt-10 font-semibold text-2xl">Loans</h3>
            <button class="w-24 h-8 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 mt-12">See Details</button>
        </div>

    </div>
    <div class="fixed bottom-0 w-full h-12 bg-gray-300 rounded-md p-2 shadow-md">
        <div class="flex justify-center items-center h-full">
        <footer class="text-xs text-center">
            <p>© 2024 PWEB2<br><a href="mailto:Kel4@example.com" class="text-blue-600 hover:underline flex items-center gap-1"> kel4@example.com</a></p>
        </footer>
    </div>
</div>
</body>
</html>