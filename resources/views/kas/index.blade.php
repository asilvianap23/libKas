@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Tambah Iuran Kas</h1>

    <!-- Menampilkan Pesan Sukses -->
    @if (session('success'))
        <div class="bg-green-600 text-white p-4 rounded-lg shadow-md mb-6 transform scale-95 opacity-50 transition-all duration-500 ease-in-out hover:scale-100 hover:opacity-100">
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Menampilkan Pesan Error -->
    @if ($errors->any())
        <div class="bg-red-600 text-white p-4 rounded-lg shadow-md mb-6 transform scale-95 opacity-50 transition-all duration-500 ease-in-out hover:scale-100 hover:opacity-100">
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <ul class="list-disc ml-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif


    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form action="{{ route('kas.masuk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
    
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" id="amount" name="amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>
    
            <div class="mt-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>
    
            <div class="mt-4">
                <label for="photo" class="block text-sm font-medium text-gray-700">Bukti Transfer</label>
                <input type="file" id="photo" name="photo" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2">
            </div>
    
            <div class="mt-6 flex justify-center">
                <button type="submit" class="button-custom">
                    Simpan
                </button>
            </div>
        </form>
    </div>
     
    <!-- Tabel Kas Masuk yang belum diverifikasi -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Kas Masuk</h2>
        <table class="table-custom">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b text-left">Tanggal</th>
                    <th class="px-4 py-2 border-b text-left">Jumlah</th>
                    <th class="px-4 py-2 border-b text-left">Deskripsi</th>
                    <th class="px-4 py-2 border-b text-left">Bukti Transfer</th>
                    <th class="px-4 py-2 border-b text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kasMasuk as $kas)
                <tr>
                    <td class="px-4 py-2 border-b">{{ $kas->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2 border-b">{{ number_format($kas->amount, 2) }}</td>
                    <td class="px-4 py-2 border-b">{{ $kas->description }}</td>
                    <td class="px-4 py-2 border-b">
                        @if($kas->photo)
                            <a href="{{ Storage::url($kas->photo) }}" target="_blank" class="link-view">Lihat Bukti</a>
                        @else
                            <span>Belum ada bukti</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border-b">
                        @if($kas->is_verified)
                            <span class="status-verified">Sudah Diverifikasi</span>
                        @elseif($kas->rejected_at)
                            <span class="status-rejected">Ditolak pada {{ $kas->rejected_at->format('Y-m-d') }}</span>
                        @else
                            <span class="status-pending">Menunggu Verifikasi</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $kasMasuk->links() }}
        </div>
    </div>
</div>
@endsection
