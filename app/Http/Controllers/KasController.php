<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use Illuminate\Http\Request;

class KasController extends Controller
{
    // Menampilkan halaman kas (masuk dan keluar)
    public function index()
    {
        $kasMasuk = Kas::where('type', 'masuk')->get();
        $kasKeluar = Kas::where('type', 'keluar')->get();

        return view('kas.index', compact('kasMasuk', 'kasKeluar'));
    }

    // Menyimpan transaksi kas
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|in:masuk,keluar',
            'description' => 'nullable|string|max:255',
        ]);

        // Menyimpan transaksi kas (masuk atau keluar)
        Kas::create([
            'amount' => $request->input('amount'),
            'type' => $request->input('type'),
            'description' => $request->input('description'),
            'user_id' => auth()->id(), // Menyertakan user_id
        ]);

        return redirect()->route('kas.masuk.index')->with('success', 'Transaksi kas berhasil disimpan');
    }

    // Menampilkan halaman Kas Keluar
    public function showKasKeluar()
    {
        $kasKeluar = Kas::where('type', 'keluar')->get();

        return view('kas.keluar.index', compact('kasKeluar'));
    }

    // Menyimpan transaksi Kas Keluar
    public function storeKasKeluar(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'nullable|string|max:255',
        ]);

        // Menyimpan transaksi Kas Keluar
        Kas::create([
            'amount' => $request->input('amount'),
            'type' => 'keluar',
            'description' => $request->input('description'),
            'user_id' => auth()->id(), // Menyertakan user_id (misalnya pengguna yang sedang login)
        ]);

        return redirect()->route('kas.keluar.index')->with('success', 'Transaksi Kas Keluar berhasil disimpan');
    }

    // Menampilkan halaman Kas Masuk
    public function showKasMasuk()
    {
        $kasMasuk = Kas::where('type', 'masuk')->get();
        $kas = Kas::with('user')->get(); 

        return view('kas.masuk.index', compact('kasMasuk', 'kas'));
    }

    // Menyimpan transaksi Kas Masuk
    public function storeKasMasuk(Request $request)
    {
        // Validasi input
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan kas masuk dengan status belum diverifikasi
        $kas = new Kas();
        $kas->amount = $request->amount;
        $kas->description = $request->description;
        if ($request->hasFile('photo')) {
            $kas->photo = $request->file('photo')->store('bukti_transfer');
        }
        $kas->user_id = auth()->id(); // User yang menambahkan kas
        $kas->is_verified = false; // Kas belum diverifikasi
        $kas->save();
        session()->flash('success', 'Data berhasil disimpan!');
        return redirect()->route('kas.masuk.index')->with('success', 'Kas masuk berhasil disimpan dan menunggu verifikasi');
    }

    // Verifikasi Kas Masuk
    public function verifyKasMasuk($id)
    {
        // Temukan kas yang belum diverifikasi
        $kas = Kas::findOrFail($id);

        // Tandai kas tersebut sebagai sudah diverifikasi
        $kas->is_verified = true;
        $kas->save();

        return redirect()->route('kas.masuk.index')->with('success', 'Kas masuk berhasil diverifikasi');
    }

    // Menolak Kas Masuk
    public function rejectKasMasuk($id)
    {
        $kas = Kas::findOrFail($id);

        // Menandai kas sebagai ditolak
        $kas->is_verified = false;
        $kas->rejected_at = now();  // Menandakan waktu penolakan
        $kas->save();

        return redirect()->route('kas.masuk.index')->with('success', 'Kas berhasil ditolak.');
    }

    // Menangani proses verifikasi atau penolakan Kas Masuk
    public function processVerificationKasMasuk(Request $request, $id)
    {
        $kas = Kas::findOrFail($id);
    
        // Validasi input apakah aksi yang dipilih adalah verifikasi atau penolakan
        $request->validate([
            'action' => 'required|in:verify,reject',
        ]);
    
        if ($request->action == 'verify') {
            // Jika verifikasi, set status menjadi terverifikasi dan catat waktu verifikasi
            $kas->is_verified = true;
            $kas->verified_at = now();  // Waktu verifikasi
            $kas->rejected_at = null;   // Pastikan rejected_at kosong jika diverifikasi
        } elseif ($request->action == 'reject') {
            // Jika ditolak, set status menjadi tidak terverifikasi dan catat waktu penolakan
            $kas->is_verified = false;
            $kas->rejected_at = now();  // Waktu penolakan
        }
    
        // Simpan perubahan status
        $kas->save();
    
        // Redirect ke halaman utama dengan pesan sukses atau gagal
        return redirect()->route('kas.index')->with('status', $request->action == 'verify' ? 'Kas berhasil diverifikasi.' : 'Kas ditolak.');
    }
    // Fungsi untuk menampilkan laporan kas masuk
    public function laporanKasMasuk(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $search = $request->search;
    
        // Query untuk kas masuk dan pencarian berdasarkan deskripsi dan nama pengguna
        $kasMasuk = Kas::where('type', 'masuk')
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('created_at', '<=', $endDate);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('description', 'like', '%' . $search . '%')
                          ->orWhereHas('user', function ($query) use ($search) {
                              $query->where('name', 'like', '%' . $search . '%');
                          });
                });
            })
            ->get();
    
        return view('laporan.kasMasuk', compact('kasMasuk', 'startDate', 'endDate', 'search'));
    }
    public function laporanKasKeluar(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $search = $request->search;

        $kasKeluar = Kas::where('type', 'keluar')
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('created_at', '<=', $endDate);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('description', 'like', "%$search%");
            })
            ->get();

        return view('laporan.kasKeluar', compact('kasKeluar', 'startDate', 'endDate', 'search'));
    }    

}
