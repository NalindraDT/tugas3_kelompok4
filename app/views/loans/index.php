
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<style>
    html, body {
        height: 100%;
        margin: 0;
        overflow: hidden;
    }
</style>
<body class="min-h-screen bg-gray-400">
<!-- Judul -->
<h2 class="pt-8 text-center text-xl font-['Roboto'] font-bold">DAFTAR PENGGUNA</h2>
<div class="container mx-auto px-4 flex flex-col min-h-screen">
    <div class="flex-1 flex flex-col items-center">
        <!-- tombol dan search bar -->
        <div class="mt-24 w-3/4">
            <div class="flex justify-end gap-2 items-center">
                <a href="/loans/create" class="px-5 py-3 bg-blue-500 text-white font-semibold text-sm rounded-lg hover:bg-blue-600 transition duration-300"><i class="fa fa-plus mr-2"></i>Add</a>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari data..." class="w-48 pl-10 px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>
        <div id="no-data-row" class="mt-8 text-center bg-white p-4 rounded-lg shadow-md hidden w-3/4">
            <p class="text-gray-600 text-lg">Data Tidak tersedia</p>
        </div>
        <table id="loans" class="mt-2 table-auto w-3/4 rounded-lg shadow-lg overflow-hidden text-sm text-left">
            <thead>
                <tr class="bg-gray-300 justify-center">
                    <th class="px-4 py-2 text-center">Nama</th>
                    <th class="px-4 py-2 text-center">Judul</th>
                    <th class="px-4 py-2 text-center">Tanggal Pinjam</th>
                    <th class="px-4 py-2 text-center">Tanggal Kembali</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loan as $loans): ?>
                    <tr class="odd:bg-gray-100 even:bg-gray-200 hover:bg-gray-300 border-b border-gray-300">
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($loans['nama_user'])?></td>
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($loans['judul'])?></td>
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($loans['tgl_pinjam'])?></td>
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($loans['tgl_kembali'])?></td>
                        <td class="px-4 py-2 text-center">
                            <a href="/loans/edit/<?php echo $loans['id_peminjaman']; ?>" class="inline-block px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"><i class="fa fa-pen mr-2"></i>Edit</a>
                            <a href="/loans/delete/<?php echo $loans['id_peminjaman']; ?>" id="delete" class="inline-block px-4 py-2 bg-red-500 text-white font-semibold text-sm rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"><i class="fa fa-trash mr-2"></i>Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr id="no-data-row" class="hidden">
                    <td colspan="5" class="text-center p-4 bg-white text-gray-600">
                        Tidak ada data yang ditemukan
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="mt-2 flex justify-between w-3/4">
            <a href="./dashboard" class="w-20 h-9 bg-gray-500 text-white text-sm font-medium rounded-md hover:bg-gray-600 transition duration-300 text-center flex items-center justify-center"><i class="fa fa-arrow-left mr-2"></i>Back</a>
            <div id="pagination" class="flex gap-2"></div>
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
        <h2 class="text-xl font-bold mb-4 text-center">Konfirmasi Hapus</h2>
        <div id="modalDetails" class="mb-4 text-sm"></div>
        <div class="flex justify-between">
            <button id="cancel" type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Tidak</button>
            <button id="confirm" type="button" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Ya</button>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('loans');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = tbody.getElementsByTagName('tr');
    const modal = document.getElementById('confirmModal');
    const modalDetails = document.getElementById('modalDetails');
    const confirmBtn = document.getElementById('confirm');
    const cancelBtn = document.getElementById('cancel');
    const noDataRow = document.getElementById('no-data-row');

    document.querySelectorAll('#delete').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const deleteUrl = this.getAttribute('href');
            
            // Set pesan konfirmasi
            modalDetails.innerHTML = 'Apakah Anda yakin ingin menghapus data ini?';
            
            // Tampilkan modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Handle konfirmasi
            confirmBtn.onclick = function() {
                window.location.href = deleteUrl;
            };
            
            // Handle pembatalan
            cancelBtn.onclick = function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };
        });
    });

    // Set items per page
    const itemsPerPage = 5;
    const totalPages = Math.ceil(rows.length / itemsPerPage);
    let currentPage = 1;

    // Get pagination container
    const paginationContainer = document.getElementById('pagination');
    setupInitialPagination();

    function setupInitialPagination() {
        const totalPages = Math.ceil((rows.length - 1) / itemsPerPage); // Subtract 1 to exclude no-data row
        paginationContainer.innerHTML = '';

        // Hanya buat pagination jika total page lebih dari 1
    if (totalPages > 1) {
        for(let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.innerText = i;
            button.className = `px-3 py-1 rounded ${currentPage === i ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
            
            button.addEventListener('click', function() {
                currentPage = i;
                showPage(i);
                updatePaginationStyles();
            });
            
            paginationContainer.appendChild(button);
        }
    }

        showPage(1);
    }

    function showPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        // Hide all rows
        for(let i = 0; i < rows.length; i++) {
            rows[i].style.display = 'none';
        }

        // Show rows for current page
        for(let i = start; i < end && i < rows.length; i++) {
            rows[i].style.display = '';
        }
    }

    function updatePaginationStyles() {
        const buttons = paginationContainer.getElementsByTagName('button');
        for(let i = 0; i < buttons.length; i++) {
            if(i + 1 === currentPage) {
                buttons[i].className = 'px-3 py-1 rounded bg-blue-500 text-white';
            } else {
                buttons[i].className = 'px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300';
            }
        }
    }

    // Show first page initially
    showPage(1);

    // Add search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleRowsCount = 0;

        // Filter rows
        for(let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
                visibleRowsCount++;
            } else {
                row.style.display = 'none';
            }
        }

        // Show/hide table and no data message
        if (searchTerm && visibleRowsCount === 0) {
            table.style.display = 'none';
            noDataRow.classList.remove('hidden');
            document.getElementById('pagination').innerHTML = ''; // Clear pagination
        } else {
            table.style.display = 'table';
            noDataRow.classList.add('hidden');
            
            // Update pagination for visible rows
            const visibleRows = [...rows].filter(row => row.style.display !== 'none');
            updatePagination(visibleRows);
        }
    });

    function recreatePagination(visibleRows) {
        const totalPages = Math.ceil(visibleRows.length / itemsPerPage);
        paginationContainer.innerHTML = '';

        // Hanya buat pagination jika total page lebih dari 1
        if (totalPages > 1) {
            for(let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.innerText = i;
                button.className = `px-3 py-1 rounded ${currentPage === 1 ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
                
                button.addEventListener('click', function() {
                    currentPage = i;
                    showFilteredPage(i, visibleRows);
                    updatePaginationStyles();
                });
                
                paginationContainer.appendChild(button);
            }
        }

        // Show first page of filtered results
        if (visibleRows.length > 0) {
            showFilteredPage(1, visibleRows);
        }
    }

    function showFilteredPage(page, visibleRows) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        // Hide all rows first
        visibleRows.forEach(row => row.style.display = 'none');

        // Show rows for current page
        for(let i = start; i < end && i < visibleRows.length; i++) {
            visibleRows[i].style.display = '';
        }
    }

    function updateButtonStyles(container, currentPage) {
        const buttons = container.getElementsByTagName('button');
        for(let i = 0; i < buttons.length; i++) {
            if(i + 1 === currentPage) {
                buttons[i].className = 'px-3 py-1 rounded bg-blue-500 text-white';
            } else {
                buttons[i].className = 'px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300';
            }
        }
    }
});
</script>
</body>
</html>