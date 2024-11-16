@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dashboard Kas') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard Kas</h1>

                    <!-- Total Kas - Tampil di paling atas -->
                    <div class="mt-6 bg-white p-6 shadow rounded-lg text-center">
                        <h2 class="text-2xl font-semibold text-gray-800">
                            <i class="fas fa-wallet text-blue-600 mr-2"></i> Total Kas
                        </h2>
                        <p class="text-3xl text-blue-600 mt-2">Rp {{ number_format($totalKas, 2) }}</p>
                    </div>

                    <!-- Ringkasan Kas Masuk dan Kas Keluar - Ditampilkan Bersebelahan -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kas Masuk -->
                        <div class="bg-white p-6 shadow rounded-lg">
                            <h2 class="text-lg font-semibold text-gray-800">
                                <i class="fas fa-arrow-incoming text-green-600 mr-2"></i> Kas Masuk
                            </h2>
                            <p class="text-blue-600 text-xl mt-2">Hari Ini: Rp {{ number_format($transaksiHariIni, 2) }}</p>
                            <p class="text-blue-600 text-xl mt-2">Bulan Ini: Rp {{ number_format($transaksiBulanIni, 2) }}</p>
                        </div>

                        <!-- Kas Keluar -->
                        <div class="bg-white p-6 shadow rounded-lg">
                            <h2 class="text-lg font-semibold text-gray-800">
                                <i class="fas fa-arrow-outgoing text-red-600 mr-2"></i> Kas Keluar
                            </h2>
                            <p class="text-red-600 text-xl mt-2">Hari Ini: Rp {{ number_format($kasKeluarHariIni, 2) }}</p>
                            <p class="text-red-600 text-xl mt-2">Bulan Ini: Rp {{ number_format($kasKeluarBulanIni, 2) }}</p>
                        </div>
                    </div>

                    <!-- Tabel data transaksi -->
                    <div class="mt-8 bg-white p-6 shadow rounded-lg">
                        <h2 class="text-xl font-semibold text-gray-800">
                            <i class="fas fa-list-alt text-gray-700 mr-2"></i> Transaksi Kas Terbaru
                        </h2>
                        <table class="min-w-full mt-4 border-collapse">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Tanggal</th>
                                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Keterangan</th>
                                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Jumlah</th>
                                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Tipe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Kas Masuk -->
                                @foreach($kasMasuk as $item)
                                    <tr>
                                        <td class="py-2 px-4 border-b text-sm">{{ $item->created_at->format('Y-m-d') }}</td>
                                        <td class="py-2 px-4 border-b text-sm">{{ $item->description }}</td>
                                        <td class="py-2 px-4 border-b text-sm text-green-600">
                                            Rp {{ number_format($item->amount, 2) }}
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm text-green-600">Kas Masuk</td>
                                    </tr>
                                @endforeach

                                <!-- Kas Keluar -->
                                @foreach($kasKeluar as $item)
                                    <tr>
                                        <td class="py-2 px-4 border-b text-sm">{{ $item->created_at->format('Y-m-d') }}</td>
                                        <td class="py-2 px-4 border-b text-sm">{{ $item->description }}</td>
                                        <td class="py-2 px-4 border-b text-sm text-red-600">
                                            Rp {{ number_format($item->amount, 2) }}
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm text-red-600">Kas Keluar</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
