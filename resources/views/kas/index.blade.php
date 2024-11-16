@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Tambah Iuran Kas</h1>

    <!-- Notifikasi berhasil -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-200 rounded-md">
            {{ session('success') }}
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
    
            <!-- Div pembungkus untuk menengahkan tombol -->
            <div class="mt-6 flex justify-center">
                <button type="submit" class="button-custom">
                    Simpan
                </button>
            </div>
        </form>
    </div>
     
    <!-- Tabel Kas Masuk -->
    <div class="bg-white shadow rounded-lg p-6">
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
