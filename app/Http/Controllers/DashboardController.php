<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil total kas masuk yang terverifikasi
        $totalKasMasuk = Kas::where('type', 'masuk')
            ->where('is_verified', true) // Hanya kas masuk yang terverifikasi
            ->sum('amount'); // Total kas masuk yang terverifikasi
    
        // Ambil total kas keluar
        $totalKasKeluar = Kas::where('type', 'keluar')
            ->sum('amount'); // Total kas keluar
    
        // Mengambil transaksi hari ini (kas masuk yang terverifikasi)
        $transaksiHariIni = Kas::whereDate('created_at', today())
            ->where('is_verified', true)
            ->where('type', 'masuk') // Hanya kas masuk yang terverifikasi
            ->sum('amount');
    
        // Mengambil transaksi bulan ini (kas masuk yang terverifikasi)
        $transaksiBulanIni = Kas::whereMonth('created_at', now()->month)
            ->where('is_verified', true)
            ->where('type', 'masuk') // Hanya kas masuk yang terverifikasi
            ->sum('amount');
    
        // Mengambil transaksi kas masuk terbaru yang terverifikasi
        $kasMasuk = Kas::where('type', 'masuk')
            ->where('is_verified', true) // Hanya kas masuk yang terverifikasi
            ->latest()
            ->limit(5)
            ->get(); // Ambil 5 transaksi kas masuk terakhir yang terverifikasi

        // Mengambil 5 transaksi kas keluar yang terverifikasi
        $kasKeluar = Kas::where('type', 'keluar')
            ->where('is_verified', true) // Hanya kas keluar yang terverifikasi
            ->latest() // Mengurutkan berdasarkan tanggal terbaru
            ->limit(5) // Ambil 5 transaksi terakhir
            ->get();

        // Mengambil kas keluar hari ini
        $kasKeluarHariIni = Kas::whereDate('created_at', today())  // Hanya kas keluar hari ini
            ->where('type', 'keluar')
            ->sum('amount');

        // Mengambil kas keluar bulan ini
        $kasKeluarBulanIni = Kas::whereMonth('created_at', now()->month)  // Hanya kas keluar bulan ini
            ->where('type', 'keluar')
            ->sum('amount');

        // Menghitung total kas bersih (kas masuk - kas keluar)
        $totalKas = $totalKasMasuk - $totalKasKeluar;

        // Mengirim data ke view
        return view('dashboard', [
            'totalKas' => number_format($totalKas, 2), // Format uang
            'transaksiHariIni' => number_format($transaksiHariIni, 2), 
            'transaksiBulanIni' => number_format($transaksiBulanIni, 2),
            'kasMasuk' => $kasMasuk, // Mengirim data kas masuk ke view
            'kasKeluar' => $kasKeluar,
            'kasKeluarHariIni' => number_format($kasKeluarHariIni, 2),  // Kas keluar hari ini dengan format
            'kasKeluarBulanIni' => number_format($kasKeluarBulanIni, 2),  // Kas keluar bulan ini dengan format
        ]);
    }
}
