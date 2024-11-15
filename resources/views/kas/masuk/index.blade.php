@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Kas Masuk</h1>
    <!-- Tabel Kas Masuk -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="table-custom">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b">Tanggal</th>
                    <th class="px-6 py-3 border-b">Jumlah</th>
                    <th class="px-6 py-3 border-b">Deskripsi</th>
                    <th class="px-6 py-3 border-b">Kas Masuk Dari</th>
                    <th class="px-6 py-3 border-b">Bukti Transfer</th>
                    <th class="px-6 py-3 border-b">Status</th>
                    <th class="px-6 py-3 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kas as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 border-b">{{ $item->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 border-b">{{ number_format($item->amount, 2) }}</td>
                    <td class="px-6 py-4 border-b">{{ $item->description }}</td>
                    <td class="px-6 py-4 border-b">{{ $item->user->name }}</td>
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
                                <form action="{{ route('kas.masuk.verify', $item->id) }}" method="POST" class="inline" onsubmit="return confirmAction()">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="verify" class="button-custom button-verify">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                
                                <form action="{{ route('kas.masuk.verify', $item->id) }}" method="POST" class="inline" onsubmit="return confirmAction()">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="reject" class="button-custom button-reject">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-green-500 font-medium">Sudah Diproses</span>
                            @endif
                        </div>
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>        
    </div>
</div>

<script>
    // Fungsi untuk konfirmasi aksi sebelum submit
    function confirmAction(event) {
        const action = event.target.name;
        if (action === 'verify') {
            return confirm('Apakah Anda yakin ingin memverifikasi kas ini?');
        } else if (action === 'reject') {
            return confirm('Apakah Anda yakin ingin menolak kas ini?');
        }
        return false;
    }

</script>
@endsection
