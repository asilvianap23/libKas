<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use Illuminate\Http\Request;

class KasKeluarController extends Controller
{
    // Menampilkan halaman Kas Keluar
    public function index()
    {
        $kasKeluar = Kas::where('type', 'keluar')->get();

        return view('kas.keluar.index', compact('kasKeluar'));
    }

    // Menyimpan transaksi Kas Keluar
    public function store(Request $request)
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

}
