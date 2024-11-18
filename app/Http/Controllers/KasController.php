<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasController extends Controller
{
    // Menampilkan halaman kas (masuk dan keluar)
    public function index()
    {
        // Mendapatkan data kas masuk dan kas keluar dengan pagination
        $kasMasuk = Kas::where('type', 'masuk')->paginate(10); // Menambahkan paginate
        $kasKeluar = Kas::where('type', 'keluar')->paginate(10); // Menambahkan paginate
        $kas = Kas::paginate(10); // Data utama yang juga dipaginasi
    
        return view('kas.index', compact('kasMasuk', 'kasKeluar', 'kas'));
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
            return redirect()->route('kas.index')->with('success', 'Kas masuk berhasil disimpan dan menunggu verifikasi');
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
           // Mendapatkan total kas masuk yang sudah diverifikasi
            $totalKasMasuk = Kas::where('type', 'masuk')
            ->where('is_verified', 1)
            ->sum('amount');

        // Mendapatkan total kas keluar yang sudah disimpan
        $totalKasKeluar = Kas::where('type', 'keluar')->sum('amount');

        // Validasi apakah kas cukup
        if ($totalKasMasuk - $totalKasKeluar < $request->amount) {
        return back()->withErrors(['amount' => 'Jumlah pengeluaran melebihi saldo kas yang tersedia.']);
        }

        // Jika validasi lolos, lanjutkan menyimpan data pengeluaran
        Kas::create([
        'amount' => $request->amount,
        'description' => $request->description,
        'type' => 'keluar',
        'user_id' => Auth::id(), // Menambahkan user_id
        'is_verified' => 1, // Asumsi langsung diverifikasi
        ]);

        return redirect()->route('kas.keluar.index')->with('success', 'Kas keluar berhasil disimpan.');
    }
    
    public function showKasMasuk(Request $request)
    {
        // $kas = Kas::query()
        // ->where('is_verified', 0)
        // ->whereNull('rejected_at')// Menampilkan kas yang belum diverifikasi
        // ->paginate($request->limit ?: 10);
        // // Ambil nilai status dari query string
    // // Ambil nilai status dari query string
  // Ambil input 'type' atau default 'masuk'
        $type = $request->input('type', 'masuk');  // Default ke 'masuk' jika 'type' tidak ada

        $query = Kas::query();

        // Filter berdasarkan status jika status dipilih
        $status = $request->input('status');

        if ($status === 'verified') {
            $query->where('is_verified', 1); // Sudah Diverifikasi
        } elseif ($status === 'pending') {
            $query->where('is_verified', 0)->whereNull('rejected_at'); // Menunggu Verifikasi
        } elseif ($status === 'rejected') {
            $query->whereNotNull('rejected_at'); // Ditolak
        }

        // Filter berdasarkan type, apakah 'masuk' atau 'keluar'
        $query->where('type', $type); // Menyaring berdasarkan 'type'

        // Ambil data dengan pagination
        $kas = $query->latest()->paginate(10);

        return view('kas.masuk.index', compact('kas'));
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
    public function laporanKasMasuk(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $search = $request->search;
        $limit = $request->limit ?? 10; // Default limit 10 jika tidak ada
        
        $kasMasuk = Kas::where('type', 'masuk')
            ->where('is_verified', true) // Menambahkan filter untuk yang sudah diverifikasi
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
            ->paginate($limit); // Gunakan paginate untuk membatasi jumlah data per halaman
        
        return view('laporan.kasMasuk', compact('kasMasuk', 'startDate', 'endDate', 'search', 'limit'));
    }
    
    
    public function laporanKasKeluar(Request $request)
    {
        // Mendapatkan inputan dari request
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $search = $request->search;
        $limit = $request->limit ?? 10; // Jika tidak ada limit, default ke 10
    
        // Query untuk mengambil data kas keluar
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
            // Menambahkan pagination dengan limit
            ->orderBy('created_at', 'desc') // Menambahkan pengurutan berdasarkan tanggal
            ->paginate($limit);
    
        // Mengirim data ke view
        return view('laporan.kasKeluar', compact('kasKeluar', 'startDate', 'endDate', 'search', 'limit'));
    }       
}