@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Kas Keluar</h1>

    <!-- Menampilkan Pesan Sukses -->
    @if (session('success'))
        <div class="bg-green-600 text-white p-4 rounded-lg shadow-md mb-6">
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
        <div class="bg-red-600 text-white p-4 rounded-lg shadow-md mb-6">
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

    <!-- Form untuk input Kas Keluar -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
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
                <button type="button" id="add-file" class="mt-2 text-blue-500 hover:underline">Tambah File</button>
                <p class="mt-2 text-sm text-gray-500">File yang diperbolehkan: gambar, PDF, Word (doc, docx), Excel (xls, xlsx)</p>
            </div>
        
            <div class="mt-6 flex justify-center">
                <button type="submit" class="button-custom">
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
        newInput.classList.add('mt-1', 'block', 'w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-md', 'shadow-sm', 'focus:ring-blue-500', 'focus:border-blue-500');
        document.getElementById('file-inputs').appendChild(newInput);
    });
</script>
@endsection
