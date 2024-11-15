<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use Illuminate\Http\Request;

class KasMasukController extends Controller
{
    // Menampilkan halaman Kas Masuk
    public function index()
    {
        $kasMasuk = Kas::where('type', 'masuk')->get();
        $kas = Kas::with('user')->get(); 

        return view('kas.masuk.index', compact('kasMasuk', 'kas'));
    }

    // Menyimpan transaksi Kas Masuk
    public function store(Request $request)
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
    public function verify($id)
    {
        // Temukan kas yang belum diverifikasi
        $kas = Kas::findOrFail($id);

        // Tandai kas tersebut sebagai sudah diverifikasi
        $kas->is_verified = true;
        $kas->save();

        return redirect()->route('kas.masuk.index')->with('success', 'Kas masuk berhasil diverifikasi');
    }
    public function reject($id)
    {
        $kas = Kas::findOrFail($id);

        // Menandai kas sebagai ditolak
        $kas->is_verified = false;
        $kas->rejected_at = now();  // Menandakan waktu penolakan
        $kas->save();

        return redirect()->route('kas.masuk.index')->with('success', 'Kas berhasil ditolak.');
    }
    public function processVerification(Request $request, $id)
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
    public function process(Request $request, $id)
    {
        $kas = Kas::findOrFail($id);
        $action = $request->input('action');
    
        if ($action === 'verify') {
            // Verifikasi logika di sini
            $kas->is_verified = true;
            $kas->save();
            return redirect()->route('kas.index')->with('success', 'Kas berhasil diverifikasi');
        } elseif ($action === 'reject') {
            // Tolak logika di sini
            $kas->rejected_at = now();
            $kas->save();
            return redirect()->route('kas.index')->with('success', 'Kas berhasil ditolak');
        }
    
        return back()->with('error', 'Tindakan tidak valid');
    }
    
        

}
