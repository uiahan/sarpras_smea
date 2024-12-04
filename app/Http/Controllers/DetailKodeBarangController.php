<?php

namespace App\Http\Controllers;

use App\Models\DetailKodeBarang;
use App\Models\KodeBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailKodeBarangController extends Controller
{
    public function detailKodeBarang(KodeBarang $kodeBarang)
    {
        $user = Auth::user();
        $detailKodeBarang = DetailKodeBarang::where('kode_barang_id', $kodeBarang->id)->get();
        session(['kode_barang_id' => $kodeBarang->id]);
        return view('pages.kode_barang.detail.detail', compact('detailKodeBarang', 'kodeBarang', 'user'));
    }

    public function uploadDetailKodeBarangExcel()
    {
        $user = Auth::user();
        $kode_barang_id = session('kode_barang_id');
        return view('pages.kode_barang.detail.upload', compact('user', 'kode_barang_id'));
    }

    public function tambahDetailKodeBarang()
    {
        $user = Auth::user();
        $kode_barang_id = session('kode_barang_id');
        return view('pages.kode_barang.detail.tambah', compact('kode_barang_id', 'user'));
    }

    public function editDetailKodeBarang($id)
    {
        $detailKodeBarang = DetailKodeBarang::findOrFail($id);
        $user = Auth::user();
        $kode_barang_id = session('kode_barang_id');
        return view('pages.kode_barang.detail.edit', compact('kode_barang_id', 'user', 'detailKodeBarang'));
    }

    public function postTambahDetailKodeBarang(Request $request)
    {
        $request->validate([ // Memastikan gambar jika ada valid
            'nusp' => 'required|string',
            'nama_barang' => 'required|string',
            'kode_barang_id' => 'required|exists:kode_barangs,id',
        ]);

        DetailKodeBarang::create([
            'nusp' => $request->nusp,
            'nama_barang' => $request->nama_barang, // Menyimpan path atau null
            'kode_barang_id' => $request->kode_barang_id,
        ]);

        return redirect()->route('detailKodeBarang', $request->kode_barang_id)->with('notif', 'Detail kode barang berhasil ditambahkan!');
    }

    public function postHapusDetailKodeBarang($id)
    {
        $detail = DetailKodeBarang::find($id);

        if (!$detail) {
            return response()->json(['error' => 'Detail tidak ditemukan!'], 404);
        }

        $detail->delete();

        return redirect()->back()->with('notif', 'Detail kode barang berhasil dihapus.');
    }

    public function postEditDetailKodeBarang(Request $request, $id)
    {
        $validated = $request->validate([
            'nusp' => 'required|string',
            'nama_barang' => 'required|string',
        ]);

        $jurusan = DetailKodeBarang::findOrFail($id);
        $jurusan->update([
            'nusp' => $validated['nusp'],
            'nama_barang' => $validated['nama_barang'],
        ]);

        return redirect()->route('detailKodeBarang', $request->kode_barang_id)->with('notif', 'Detail Kode Barang berhasil diubah.');
    }

    public function getNusp($kode_barang_id)
{
    $nuspList = DetailKodeBarang::where('kode_barang_id', $kode_barang_id)->get();
    return response()->json($nuspList);
}
}
