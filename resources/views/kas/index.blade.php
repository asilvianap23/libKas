@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-blue-600 mb-2 border-b-4">Tambah Iuran Kas</h1>
        <p class="text-lg text-gray-700 mt-2"><span class="text-lg text-gray-500 ml-2">(Halaman ini digunakan untuk menambahkan data kas masuk dan melihat daftar kas masuk.)</span></p>
    </div>

    <!-- Menampilkan Pesan Sukses -->
    @if (session('success'))
        <div class="bg-blue-200 text-blue-800 p-4 rounded-lg shadow-md mb-6 transition-transform duration-300 ease-in-out transform hover:scale-105">
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Menampilkan Pesan Error -->
    @if ($errors->any())
        <div class="bg-red-200 text-red-800 p-4 rounded-lg shadow-md mb-6 transition-transform duration-300 ease-in-out transform hover:scale-105">
            <ul class="list-disc ml-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Tambah Kas -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <form action="{{ route('kas.masuk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" id="amount" name="amount" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500"></textarea>
                </div>
            </div>
            <div class="mt-6">
                <label for="photo" class="block text-sm font-medium text-gray-700">Bukti Transfer (Image)</label>
                <input type="file" id="photo" name="photo" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500">
            </div>
            <div class="mt-6 flex justify-center">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md shadow hover:bg-blue-600 focus:ring focus:ring-blue-300">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Kas Masuk -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Kas Masuk</h2>
        <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md">
            <thead class="bg-blue-100 text-blue-800">
                <tr>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Jumlah</th>
                    <th class="px-4 py-2 text-left">Deskripsi</th>
                    <th class="px-4 py-2 text-left">Bukti Transfer</th>
                    <th class="px-4 py-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($kasMasuk as $kas)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $kas->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2">{{ number_format($kas->amount, 2) }}</td>
                    <td class="px-4 py-2">{{ $kas->description }}</td>
                    <td class="px-4 py-2">
                        @if($kas->photo)
                            <a href="{{ Storage::url($kas->photo) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Bukti</a>
                        @else
                            <span class="text-gray-500">Belum ada bukti</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if($kas->is_verified)
                            <span class="px-3 py-1 rounded-full text-sm bg-green-200 text-green-800">Diverifikasi</span>
                        @elseif($kas->rejected_at)
                            <span class="px-3 py-1 rounded-full text-sm bg-red-200 text-red-800">Ditolak</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-sm bg-yellow-200 text-yellow-800">Menunggu</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="mt-4">
            {{ $kasMasuk->links() }}
        </div>
    </div>
</div>
@endsection
