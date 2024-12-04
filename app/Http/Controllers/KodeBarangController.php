<?php

namespace App\Http\Controllers;

use App\Models\KodeBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\KodeBarangExport;
use App\Imports\KodeBarangImport;
use Maatwebsite\Excel\Facades\Excel;

class KodeBarangController extends Controller
{
    public function kodeBarang() {
        $user = Auth::user();
        $kodeBarang = KodeBarang::all();
        $kodeBarangCount = KodeBarang::count();
        return view('pages.kode_barang.kode_barang', compact('user', 'kodeBarang', 'kodeBarangCount'));
    }

    public function tambahKodeBarang() {
        $user = Auth::user();
        $kodeBarang = KodeBarang::all();
        $kodeBarangCount = KodeBarang::count();
        return view('pages.kode_barang.tambah', compact('user', 'kodeBarang', 'kodeBarangCount'));
    }

    public function editKodeBarang($id) {
        $user = Auth::user();
        $kodeBarang = KodeBarang::findOrFail($id);
        $kodeBarangCount = KodeBarang::count();
        return view('pages.kode_barang.edit', compact('user', 'kodeBarang', 'kodeBarangCount'));
    }

    public function uploadKodeBarangExcel() {
        $user = Auth::user();
        $kodeBarangCount = KodeBarang::count();
        return view('pages.kode_barang.upload', compact('user', 'kodeBarangCount'));
    }

    public function postUploadKodeBarangExcel(Request $request)
    {
        // Validasi file yang di-upload
        $request->validate([
            'excelFile' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        // Proses import
        try {
            Excel::import(new KodeBarangImport, $request->file('excelFile'));
            return redirect()->route('kodeBarang')->with('notif', 'Data berhasil diupload!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengupload file.');
        }
    }

    public function postTambahKodeBarang(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string',
        ]);

        KodeBarang::create([
            'kode_barang' => $validated['kode_barang'],
        ]);

        return redirect()->route('kodeBarang')->with('notif', 'Kode Barang baru berhasil ditambahkan.');
    }

    public function postEditKodeBarang(Request $request, $id)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string',
        ]);

        $jurusan = KodeBarang::findOrFail($id);
        $jurusan->update([
            'kode_barang' => $validated['kode_barang'],
        ]);

        return redirect()->route('kodeBarang')->with('notif', 'Kode Barang berhasil diubah.');
    }

    public function postHapusKodeBarang($id)
    {
        $jurusan = KodeBarang::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('kodeBarang')->with('notif', 'Kode Barang berhasil dihapus.');
    }

    public function downloadExcel()
    {
        // Men-download file Excel
        return Excel::download(new KodeBarangExport, 'kode_barang.xlsx');
    }


}
