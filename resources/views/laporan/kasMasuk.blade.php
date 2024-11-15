@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-semibold text-gray-900 mb-6">Laporan Kas</h1>

    <!-- Filter Tanggal dan Pencarian -->
    <form method="GET" action="{{ route('laporan.kasMasuk') }}" class="mb-8 bg-white p-6 shadow-md rounded-lg">
        <div class="flex space-x-6">
            <!-- Filter Tanggal Mulai dan Selesai -->
            <div class="w-1/3">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="mt-2 px-4 py-2 border border-gray-300 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            </div>
            <div class="w-1/3">
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="mt-2 px-4 py-2 border border-gray-300 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            </div>
            <!-- Filter Pencarian -->
            <div class="w-1/3">
                <label for="search" class="block text-sm font-medium text-gray-700">Cari</label>
                <input type="text" name="search" id="search" value="{{ $search }}" placeholder="Cari deskripsi" class="mt-2 px-4 py-2 border border-gray-300 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            </div>
            <button type="submit" class="button-custom">
                Filter
            </button>
        </div>
    </form>

    <!-- Tabel Kas Masuk dan Kas Keluar -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="px-6 py-3 text-left text-sm font-medium">Tanggal</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Jumlah</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Pengguna</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kasMasuk as $kas)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900 border-b">{{ $kas->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-b">{{ number_format($kas->amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-b">{{ $kas->description }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-b">{{ $kas->user->name ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 border-b">Tidak ada data kas masuk</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
