@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dashboard Kas') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard Kas</h1>

                    <!-- Total Kas - Tampil di paling atas -->
                    <div class="mt-6 bg-white p-6 shadow-2xl rounded-lg text-center">
                        <h2 class="text-2xl font-semibold text-gray-800">Total Kas</h2>
                        <p class="text-3xl text-blue-600 mt-2">Rp {{ number_format($totalKas, 2) }}</p>
                    </div>

                    <!-- Ringkasan Kas Masuk dan Kas Keluar - Ditampilkan Bersebelahan -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kas Masuk -->
                        <div class="bg-white p-6 shadow-2xl rounded-lg">
                            <h2 class="text-lg font-semibold text-gray-800">Kas Masuk</h2>
                            <p class="text-blue-600 text-xl mt-2">Hari Ini: Rp {{ number_format($transaksiHariIni, 2) }}</p>
                            <p class="text-blue-600 text-xl mt-2">Bulan Ini: Rp {{ number_format($transaksiBulanIni, 2) }}</p>
                        </div>

                        <!-- Kas Keluar -->
                        <div class="bg-white p-6 shadow-2xl rounded-lg">
                            <h2 class="text-lg font-semibold text-gray-800">Kas Keluar</h2>
                            <p class="text-red-600 text-xl mt-2">Hari Ini: Rp {{ number_format($kasKeluarHariIni, 2) }}</p>
                            <p class="text-red-600 text-xl mt-2">Bulan Ini: Rp {{ number_format($kasKeluarBulanIni, 2) }}</p>
                        </div>
                    </div>

                    <!-- Tabel data transaksi -->
                    <div class="mt-8 bg-white p-6 shadow-2xl rounded-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Transaksi Kas Terbaru</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse border border-gray-200 shadow-lg rounded-lg">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Tanggal</th>
                                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Keterangan</th>
                                        <th class="py-3 px-6 text-right text-sm font-semibold text-gray-700 border-b border-gray-200">Jumlah</th>
                                        <th class="py-3 px-6 text-center text-sm font-semibold text-gray-700 border-b border-gray-200">Tipe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Kas Masuk -->
                                    @foreach($kasMasuk as $item)
                                        <tr class="hover:bg-blue-50">
                                            <td class="py-3 px-6 text-sm text-gray-800 border-b border-gray-200">
                                                {{ $item->created_at->format('Y-m-d') }}
                                            </td>
                                            <td class="py-3 px-6 text-sm text-gray-800 border-b border-gray-200">
                                                {{ $item->description }}
                                            </td>
                                            <td class="py-3 px-6 text-sm text-green-600 border-b border-gray-200 text-right">
                                                Rp {{ number_format($item->amount, 2) }}
                                            </td>
                                            <td class="py-3 px-6 text-sm text-green-600 border-b border-gray-200 text-center">
                                                Kas Masuk
                                            </td>
                                        </tr>
                                    @endforeach
                    
                                    <!-- Kas Keluar -->
                                    @foreach($kasKeluar as $item)
                                        <tr class="hover:bg-red-50">
                                            <td class="py-3 px-6 text-sm text-gray-800 border-b border-gray-200">
                                                {{ $item->created_at->format('Y-m-d') }}
                                            </td>
                                            <td class="py-3 px-6 text-sm text-gray-800 border-b border-gray-200">
                                                {{ $item->description }}
                                            </td>
                                            <td class="py-3 px-6 text-sm text-red-600 border-b border-gray-200 text-right">
                                                Rp {{ number_format($item->amount, 2) }}
                                            </td>
                                            <td class="py-3 px-6 text-sm text-red-600 border-b border-gray-200 text-center">
                                                Kas Keluar
                                            </td>
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
