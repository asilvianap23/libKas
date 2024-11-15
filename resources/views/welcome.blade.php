<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang di Sistem Kas Forum Perpustakaan</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Background image */
        .bg-custom {
            background-image: url('{{ asset('images/perpus.jpg') }}'); /* Ganti dengan nama foto Anda di folder public/image */
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-custom min-h-screen flex items-center justify-center">

    <div class="text-center p-8 bg-white bg-opacity-60 rounded-lg shadow-xl max-w-lg w-full">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-6">Selamat Datang di Sistem Kas Forum Perpustakaan</h1>
        <p class="text-xl text-gray-700 mb-8">Silahkan pilih registrasi atau login untuk melanjutkan.</p>

        <div class="flex justify-center space-x-6">
            <!-- Tombol Registrasi Transparan -->
            <a href="{{ route('register') }}" class="px-6 py-3 text-blue-600 border-2 border-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition duration-300 transform hover:scale-105 shadow-lg">Registrasi</a>

            <!-- Tombol Login Transparan -->
            <a href="{{ route('login') }}" class="px-6 py-3 text-green-600 border-2 border-green-600 rounded-full hover:bg-green-600 hover:text-white transition duration-300 transform hover:scale-105 shadow-lg">Login</a>
        </div>
    </div>

</body>
</html>
