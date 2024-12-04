<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisBarangController extends Controller
{
    public function jenisBarang()
    {
        $user = Auth::user();
        $jenisBarang = JenisBarang::all();
        $jenisBarangCount = JenisBarang::count();
        return view('pages.jenis_barang.jenis_barang', compact('jenisBarang', 'user', 'jenisBarangCount'));
    }

    public function tambahJenisBarang()
    {
        $user = Auth::user();
        $jenisBarang = JenisBarang::all();
        $jenisBarangCount = JenisBarang::count();
        return view('pages.jenis_barang.tambah', compact('jenisBarang', 'user', 'jenisBarangCount'));
    }

    public function editJenisBarang($id)
    {
        $user = Auth::user();
        $jenisBarang = JenisBarang::findOrFail($id);
        $jenisBarangCount = JenisBarang::count();
        return view('pages.jenis_barang.edit', compact('jenisBarang', 'user', 'jenisBarangCount'));
    }

    public function postTambahJenisBarang(Request $request)
    {
        $validated = $request->validate([
            'jenis_barang' => 'required|string',
        ]);

        JenisBarang::create([
            'jenis_barang' => $validated['jenis_barang'],
        ]);

        return redirect()->route('jenisBarang')->with('notif', 'Jenis barang baru berhasil ditambahkan.');
    }

    public function postEditJenisBarang(Request $request, $id)
    {
        $validated = $request->validate([
            'jenis_barang' => 'required|string',
        ]);

        $jurusan = JenisBarang::findOrFail($id);
        $jurusan->update([
            'jenis_barang' => $validated['jenis_barang'],
        ]);

        return redirect()->route('jenisBarang')->with('notif', 'Jenis barang berhasil diubah.');
    }

    public function postHapusJenisBarang($id)
    {
        $jurusan = JenisBarang::findOrFail($id);
        $jurusan->delete();

        return redirect()->back()->with('notif', 'Jenis barang berhasil dihapus.');
    }
}
