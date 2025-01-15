@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-2xl text-blue-800 dark:text-blue-300 leading-tight text-center">
        {{ __('Dashboard Kas') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-gray-800 dark:to-gray-900 shadow-2xl rounded-xl overflow-hidden">
                <div class="p-10">
                    <h1 class="text-5xl font-extrabold text-blue-900 dark:text-blue-200 text-center mb-8">
                        Dashboard Kas
                    </h1>

                    <!-- Total Kas -->
                    <div class="bg-gradient-to-r from-green-200 via-green-300 to-green-400 p-8 shadow-lg rounded-lg text-center transform hover:scale-105 transition-transform duration-300 mb-8">
                        <h2 class="text-3xl font-semibold text-gray-800">
                            <i class="fas fa-wallet text-green-800 mr-2"></i> Total Kas
                        </h2>
                        <p class="text-6xl font-extrabold text-green-900 mt-4">Rp {{ $totalKas }}</p>
                    </div>

                    <!-- Ringkasan Kas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Kas Masuk -->
                        <div class="bg-white dark:bg-gray-800 p-8 shadow-md rounded-lg transform hover:scale-105 hover:shadow-xl transition-transform duration-300">
                            <h2 class="text-lg font-semibold text-gray-800">
                                <i class="fas fa-arrow-down text-green-600 mr-2"></i> Kas Masuk
                            </h2>
                            <p class="text-green-700 text-4xl font-bold mt-4">Hari Ini: Rp {{ $transaksiHariIni }}</p>
                            <p class="text-green-700 text-4xl font-bold mt-2">Bulan Ini: Rp {{ $transaksiBulanIni }}</p>
                        </div>

                        <!-- Kas Keluar -->
                        <div class="bg-white dark:bg-gray-800 p-8 shadow-md rounded-lg transform hover:scale-105 hover:shadow-xl transition-transform duration-300">
                            <h2 class="text-lg font-semibold text-gray-800">
                                <i class="fas fa-arrow-up text-red-600 mr-2"></i> Kas Keluar
                            </h2>
                            <p class="text-red-700 text-4xl font-bold mt-4">Hari Ini: Rp {{ $kasKeluarHariIni }}</p>
                            <p class="text-red-700 text-4xl font-bold mt-2">Bulan Ini: Rp {{ $kasKeluarBulanIni }}</p>
                        </div>
                    </div>

                    <!-- Tabel Transaksi -->
                    <div class="bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 p-8 shadow-lg rounded-xl">
                        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6">
                            <i class="fas fa-list-alt text-gray-700 dark:text-gray-300 mr-2"></i> Transaksi Kas Terbaru
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-gray-800 border-collapse rounded-lg">
                                <thead class="bg-gradient-to-br from-blue-300 to-blue-500 text-white">
                                    <tr>
                                        <th class="py-4 px-6 text-left text-lg font-semibold">Tanggal</th>
                                        <th class="py-4 px-6 text-left text-lg font-semibold">Keterangan</th>
                                        <th class="py-4 px-6 text-left text-lg font-semibold">Jumlah</th>
                                        <th class="py-4 px-6 text-left text-lg font-semibold">Tipe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kasMasuk as $item)
                                        <tr class="hover:bg-blue-50 dark:hover:bg-gray-700">
                                            <td class="py-4 px-6 text-sm">{{ $item->created_at->format('Y-m-d') }}</td>
                                            <td class="py-4 px-6 text-sm">{{ $item->description }}</td>
                                            <td class="py-4 px-6 text-sm text-green-700">Rp {{ number_format($item->amount, 2) }}</td>
                                            <td class="py-4 px-6 text-sm text-green-700">Kas Masuk</td>
                                        </tr>
                                    @endforeach
                                    @foreach($kasKeluar as $item)
                                        <tr class="hover:bg-blue-50 dark:hover:bg-gray-700">
                                            <td class="py-4 px-6 text-sm">{{ $item->created_at->format('Y-m-d') }}</td>
                                            <td class="py-4 px-6 text-sm">{{ $item->description }}</td>
                                            <td class="py-4 px-6 text-sm text-red-700">Rp {{ number_format($item->amount, 2) }}</td>
                                            <td class="py-4 px-6 text-sm text-red-700">Kas Keluar</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
