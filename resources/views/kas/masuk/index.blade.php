@extends('layouts.app')

@section('content')
<!-- Header Section -->
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-blue-600 mb-2 border-b-4">Verifikasi Kas Masuk</h1>
        <p class="text-lg text-gray-700 mt-2"><span class="text-lg text-gray-500 ml-2">(Detail dan Verifikasi)</span></p>
    </div>
</div>

<!-- Body Section dengan Kotak -->
<div class="container mx-auto px-4 py-6">
    <div class="bg-white border border-gray-300 shadow-lg rounded-lg p-6">
        <!-- Filter dan Pencarian -->
        <div class="flex flex-wrap items-center justify-between mb-4">
            <form method="GET" action="{{ route('kas.masuk.index') }}" class="flex items-center gap-4 w-full">
                <!-- Limit - Ditempatkan di kiri -->
                <div class="flex-shrink-0">
                    <select name="limit" class="border rounded px-4 py-2" onchange="this.form.submit()">
                        <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('limit') == 15 ? 'selected' : '' }}>15</option>
                        <option value="30" {{ request('limit') == 30 ? 'selected' : '' }}>30</option>
                        <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
        
                <!-- Elemen di kanan -->
                <div class="ml-auto flex items-center gap-4">
                    <!-- Filter Status -->
                    <select name="status" class="border rounded px-4 py-2" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Sudah Diverifikasi</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
        
                    <!-- Search -->
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari deskripsi..." 
                        class="border rounded px-4 py-2" 
                        value="{{ request('search') }}"
                    />      
        
                    <button type="submit" class="button-custom">Filter</button>
                </div>
            </form>        
        </div>
        
        <!-- Tabel Kas Masuk -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b">Tanggal</th>
                        <th class="px-6 py-3 border-b">Jumlah</th>
                        <th class="px-6 py-3 border-b">Deskripsi</th>
                        <th class="px-6 py-3 border-b">Kas Masuk Dari</th>
                        <th class="px-6 py-3 border-b">Instansi</th>
                        <th class="px-6 py-3 border-b">Bukti Transfer</th>
                        <th class="px-6 py-3 border-b">Status</th>
                        <th class="px-6 py-3 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kas as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 border-b">{{ $item->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 border-b">{{ number_format($item->amount, 2) }}</td>
                        <td class="px-6 py-4 border-b">{{ $item->description }}</td>
                        <td class="px-6 py-4 border-b">{{ $item->user->name }}</td>
                        <td class="px-6 py-4 border-b">{{ $item->user->instansi }}</td>
                        <td class="px-6 py-4 border-b">
                            @if($item->photo)
                                <a href="{{ Storage::url($item->photo) }}" class="link-view" target="_blank">Lihat Bukti</a>
                            @else
                                <span class="text-gray-500">tidak ada bukti</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 border-b">
                            @if($item->is_verified)
                                <span class="status-verified">Sudah Diverifikasi</span>
                            @elseif($item->rejected_at)
                                <span class="status-rejected">Ditolak pada {{ $item->rejected_at->format('Y-m-d') }}</span>
                            @else
                                <span class="status-pending">Menunggu Verifikasi</span>
                            @endif
                        </td>                    
                        <td class="px-6 py-4 border-b">
                            <div class="flex-buttons">
                                @if(!$item->is_verified && !$item->rejected_at)
                                <form action="{{ route('kas.masuk.verify', $item->id) }}" method="POST" onsubmit="return confirmAction(event)">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="verify" class="button-custom">
                                        Verifikasi
                                    </button>
                                </form>
                                <form action="{{ route('kas.masuk.reject', $item->id) }}" method="POST" onsubmit="return confirmAction(event)">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="reject" class="button-custom">
                                        Tolak
                                    </button>
                                </form>
                                
                                @else
                                    <span class="text-green-500 font-medium">Sudah Diproses</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    
        <!-- Pagination -->
        <div class="mt-4">
            {{ $kas->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<script>
    function confirmAction(event) {
        return confirm('Apakah Anda yakin ingin melanjutkan tindakan ini?');
    }
</script>

@endsection
