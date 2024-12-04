<?php

namespace App\Http\Controllers;

use App\Models\KodeBarang;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KartuPersediaanController extends Controller
{
    public function kartuPersediaan(Request $request)
    {
        $user = Auth::user();
        $kodeBarang = KodeBarang::all();
    
        // Get filters from the request
        $filters = $request->all();
        $pengajuan = Pengajuan::query();
    
        // Hanya ambil data yang memiliki nomor_verifikasi
        $pengajuan = $pengajuan->whereNotNull('nomor_verifikasi');
    
        // Apply filters jika tanggal tersedia
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir') && $request->tanggal_awal && $request->tanggal_akhir) {
            $pengajuan = $pengajuan->whereBetween('tanggal_realisasi', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
    
        // Filter berdasarkan kode_barang jika tersedia
        if ($request->has('kode_barang') && $request->kode_barang) {
            $pengajuan = $pengajuan->where('kode_barang', $request->kode_barang);
        }
    
        // Filter berdasarkan nama_barang jika tersedia
        if ($request->has('nama_barang') && $request->nama_barang) {
            $pengajuan = $pengajuan->where('nama_barang', 'like', '%' . $request->nama_barang . '%');
        }
    
        // Get the filtered data
        $pengajuan = $pengajuan->get();
    
        return view('pages.kartu_persediaan.kartu_persediaan', compact('user', 'pengajuan', 'kodeBarang', 'filters'));
    }
    

    
}
