@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-blue-600 mb-2 border-b-4">Kas Keluar</h1>
        <p class="text-lg text-gray-700 mt-2"><span class="text-lg text-gray-500 ml-2">(Catat pengeluaran dengan rapi dan efisien)</span></p>
    </div>

    <!-- Menampilkan Pesan Sukses -->
    @if (session('success'))
        <div class="bg-green-50 text-green-700 border border-green-200 p-4 rounded-lg shadow-md mb-6">
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Menampilkan Pesan Error -->
    @if ($errors->any())
        <div class="bg-red-50 text-red-700 border border-red-200 p-4 rounded-lg shadow-md mb-6">
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

    <!-- Form untuk input Kas Keluar -->
    <div class="bg-white p-8 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Form Pengeluaran</h2>
        <form action="{{ route('kas.keluar.store') }}" method="POST" enctype="multipart/form-data">
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
        
            <!-- Input File untuk Bukti -->
            <div class="mt-6">
                <label for="files" class="block text-sm font-medium text-gray-700">Unggah Bukti</label>
                <div id="file-inputs">
                    <input type="file" name="files[]" accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button type="button" id="add-file" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">+ Tambah File</button>
                <p class="mt-2 text-sm text-gray-500">File yang diperbolehkan: gambar, PDF, Word (doc, docx), Excel (xls, xlsx)</p>
            </div>
        
            <div class="mt-8 flex justify-center">
                <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-md shadow hover:bg-blue-600 focus:ring focus:ring-blue-300">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('add-file').addEventListener('click', function() {
        const newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.name = 'files[]';
        newInput.accept = 'image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        newInput.classList.add('mt-2', 'block', 'w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-md', 'shadow-sm', 'focus:ring-blue-500', 'focus:border-blue-500');
        document.getElementById('file-inputs').appendChild(newInput);
    });
</script>
@endsection
