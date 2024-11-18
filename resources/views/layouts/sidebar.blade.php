<div class="sidebar fixed top-0 left-0 w-64 h-full bg-white text-gray-800 shadow-xl transition-all duration-300 ease-in-out transform -translate-x-full lg:translate-x-0" id="sidebar">
    <div class="sidebar-header flex items-center justify-between p-4 border-b border-gray-300">
        <span class="menu-header text-2xl font-bold text-gray-800">Sistem Kas</span>
        <a href="javascript:void(0)" class="closebtn text-xl cursor-pointer" onclick="toggleSidebar()">×</a>
    </div>
    <div class="sidebar-menu mt-8 space-y-4">
        <!-- Menu Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-lg font-semibold text-gray-800 hover:bg-blue-600 rounded-lg transition duration-200 transform hover:scale-105" id="menu-dashboard">
            <i class="fas fa-tachometer-alt mr-4 text-lg"></i> Dashboard
        </a>

        <!-- Menu Kas -->
        <div class="space-y-2">
            <a href="javascript:void(0)" class="flex items-center px-6 py-3 text-lg font-semibold text-gray-800 hover:bg-blue-600 rounded-lg transition duration-200 transform hover:scale-105 group" onclick="toggleSubMenu('kas-menu')">
                <i class="fas fa-cash-register mr-4 text-lg"></i> Kas 
                <i class="fas fa-chevron-down ml-auto transform transition" id="kas-menu-icon"></i>
            </a>
            <div id="kas-menu" class="ml-6 space-y-2 pl-6 hidden">
                <a href="{{ route('kas.index') }}" class="flex items-center px-6 py-3 text-lg font-medium text-gray-700 hover:bg-blue-500 rounded-lg transition duration-200 transform hover:scale-105">
                    <i class="fas fa-plus-circle mr-4 text-md"></i> Tambah Iuran Kas
                </a>
                <a href="{{ route('kas.keluar.index') }}" class="flex items-center px-6 py-3 text-lg font-medium text-gray-700 hover:bg-blue-500 rounded-lg transition duration-200 transform hover:scale-105">
                    <i class="fas fa-minus-circle mr-4 text-md"></i> Catat Kas Keluar
                </a>
            </div>
        </div>
        <a href="{{ route('kas.masuk.index') }}" class="flex items-center px-6 py-3 text-lg font-medium text-gray-700 hover:bg-blue-500 rounded-lg transition duration-200 transform hover:scale-105">
            <i class="fas fa-wallet mr-4 text-md"></i> Verifikasi Kas Masuk
        </a>
        
        <!-- Menu Laporan -->
        <div class="space-y-2">
            <a href="javascript:void(0)" class="flex items-center px-6 py-3 text-lg font-semibold text-gray-800 hover:bg-blue-600 rounded-lg transition duration-200 transform hover:scale-105 group" onclick="toggleSubMenu('laporan-menu')">
                <i class="fas fa-chart-line mr-4 text-lg"></i> Laporan
                <i class="fas fa-chevron-down ml-auto transform transition" id="laporan-menu-icon"></i>
            </a>
            <div id="laporan-menu" class="ml-6 space-y-2 pl-6 hidden">
                <a href="{{ route('laporan.kasMasuk') }}" class="flex items-center px-6 py-3 text-lg font-medium text-gray-700 hover:bg-blue-500 rounded-lg transition duration-200 transform hover:scale-105">
                    <i class="fas fa-file-invoice-dollar mr-4 text-md"></i> Laporan Kas Masuk
                </a>
                <a href="{{ route('laporan.kasKeluar') }}" class="flex items-center px-6 py-3 text-lg font-medium text-gray-700 hover:bg-blue-500 rounded-lg transition duration-200 transform hover:scale-105">
                    <i class="fas fa-file-invoice mr-4 text-md"></i> Laporan Kas Keluar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Untuk sidebar responsive toggle -->
<script>
    function toggleSidebar() {
        var sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("-translate-x-full");
    }

    // Fungsi untuk menangani toggle submenu
    function toggleSubMenu(menuId) {
        var menu = document.getElementById(menuId);
        var icon = document.querySelector(`#${menuId}-icon`);
        
        // Toggle submenu visibility
        menu.classList.toggle('hidden');
        
        // Rotate icon jika sub-menu terbuka
        if (menu.classList.contains('hidden')) {
            icon.style.transform = 'rotate(0deg)';
        } else {
            icon.style.transform = 'rotate(180deg)';
        }
    }
    
    // Menambahkan event listener untuk menangani perubahan menu aktif
    document.querySelectorAll('.sidebar a').forEach(function(menuItem) {
        menuItem.addEventListener('click', function() {
            // Hapus kelas aktif dari semua menu
            document.querySelectorAll('.sidebar a').forEach(function(item) {
                item.classList.remove('bg-blue-600', 'text-white');
            });
            
            // Tambahkan kelas aktif pada menu yang dipilih
            menuItem.classList.add('bg-blue-600', 'text-white');
        });
    });
</script>

<!-- Tambahkan ikon dari Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
