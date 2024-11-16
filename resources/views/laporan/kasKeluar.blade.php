@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-semibold text-gray-900 mb-6">Laporan Kas Keluar</h1>

    <!-- Filter Tanggal dan Pencarian -->
    <form method="GET" action="{{ route('laporan.kasKeluar') }}" class="mb-8 bg-white p-6 shadow-md rounded-lg">
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
        </div>
        <button type="submit" class="mt-4 w-full sm:w-auto px-6 py-2 text-black font-semibold rounded-md shadow-md hover:bg-blue-700 transition duration-200">
            Filter
        </button>
    </form>

    <!-- Filter Limit -->
    <form method="GET" action="{{ route('laporan.kasKeluar') }}">
        <div class="flex items-center space-x-4">
            <label for="limit" class="text-sm font-medium text-gray-700">Limit</label>
            <select name="limit" id="limit" class="mt-2 px-4 py-2 border border-gray-300 rounded-md w-24 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" onchange="this.form.submit()">
                <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ request('limit') == 15 ? 'selected' : '' }}>15</option>
                <option value="30" {{ request('limit') == 30 ? 'selected' : '' }}>30</option>
                <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
            </select>
        </div>
    </form>

    <!-- Tabel Kas Keluar -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg mt-4">
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
                @forelse($kasKeluar as $kas)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900 border-b">{{ $kas->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-b">{{ number_format($kas->amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-b">{{ $kas->description }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-b">{{ $kas->user->name ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 border-b">Tidak ada data kas keluar</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $kasKeluar->links() }}
    </div>
</div>
@endsection
