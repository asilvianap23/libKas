@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Kas Keluar</h1>

    <!-- Form untuk input Kas Keluar -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <form action="{{ route('kas.keluar.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" id="amount" name="amount" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-center">
                <button type="submit" class="button-custom">
                    Simpan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
