<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DetailController extends Controller
{
    public function detail(Pengajuan $pengajuan)
    {
        $user = Auth::user();
        $detail = Detail::where('pengajuan_id', $pengajuan->id)->get();
        session(['pengajuan_id' => $pengajuan->id]);
        return view('pages.pengajuan.detail.detail', compact('detail', 'pengajuan', 'user'));
    }

    public function tambahDetail()
    {
        $user = Auth::user();
        $pengajuan_id = session('pengajuan_id');
        return view('pages.pengajuan.detail.tambah', compact('pengajuan_id', 'user'));
    }

    public function editDetail($id)
    {
        $user = Auth::user();
        $detail = Detail::findOrFail($id);
        $pengajuan_id = session('pengajuan_id');
        return view('pages.pengajuan.detail.edit', compact('pengajuan_id', 'detail', 'user'));
    }

    public function postTambahDetail(Request $request)
    {
        $request->validate([
            'gambar' => 'nullable|image', // Memastikan gambar jika ada valid
            'nama' => 'required|string',
            'keterangan' => 'required|string',
            'pengajuan_id' => 'required|exists:pengajuans,id',
        ]);

        // Cek jika ada file gambar yang di-upload
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = time() . '-' . $gambar->getClientOriginalName();
            $gambar->move(public_path('img'), $gambarName);
            $gambarPath = 'img/' . $gambarName; // Menyimpan path gambar
        } else {
            $gambarPath = null; // Jika tidak ada gambar, set null
        }

        // Menyimpan detail dengan gambar atau null jika tidak ada
        Detail::create([
            'user_id' => auth()->id(),
            'pengajuan_id' => $request->pengajuan_id,
            'gambar' => $gambarPath, // Menyimpan path atau null
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('detail', $request->pengajuan_id)->with('notif', 'Detail berhasil ditambahkan!');
    }


    public function postEditDetail(Request $request, $id)
{
    $request->validate([
        'gambar' => 'nullable',
        'nama' => 'required|string|max:255',
        'keterangan' => 'required|string|max:500',
        'pengajuan_id' => 'required|exists:pengajuans,id',
    ]);

    $detail = Detail::find($id);
    if (!$detail) {
        return response()->json(['error' => 'Detail tidak ditemukan!'], 404);
    }

    $gambarPath = $detail->gambar;
    if ($request->hasFile('gambar')) {
        // Check if gambarPath is not null before trying to delete it
        if ($gambarPath && Storage::exists($gambarPath)) {
            Storage::delete($gambarPath);
        }

        $gambar = $request->file('gambar');
        $gambarName = time() . '-' . $gambar->getClientOriginalName();
        $gambarPath = 'img/' . $gambarName;

        $gambar->move(public_path('img'), $gambarName);
    }

    // Update data detail
    $detail->update([
        'pengajuan_id' => $request->pengajuan_id,
        'gambar' => $gambarPath,
        'nama' => $request->nama,
        'keterangan' => $request->keterangan,
    ]);

    return redirect()->route('detail', $request->pengajuan_id)->with('notif', 'Detail barang berhasil diperbarui!');
}


    public function postHapusDetail($id)
    {
        $detail = Detail::find($id);

        if (!$detail) {
            return response()->json(['error' => 'Detail tidak ditemukan!'], 404);
        }

        if (Storage::exists($detail->gambar)) {
            Storage::delete($detail->gambar);
        }

        $detail->delete();

        return redirect()->back()->with('notif', 'Detail berhasil dihapus.');
    }
}
