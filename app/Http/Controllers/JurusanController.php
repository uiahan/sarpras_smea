<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurusanController extends Controller
{
    public function jurusan()
    {
        $user = Auth::user();
        $jurusan = Jurusan::all();
        $jurusanCount = Jurusan::count();
        return view('pages.jurusan.jurusan', compact('jurusan', 'user', 'jurusanCount'));
    }

    public function tambahJurusan()
    {
        $user = Auth::user();
        return view('pages.jurusan.tambah', compact('user'));
    }

    public function editJurusan($id)
    {
        $user = Auth::user();
        $jurusan = Jurusan::findOrFail($id);
        return view('pages.jurusan.edit', compact('user', 'jurusan'));
    }

    public function postTambahJurusan(Request $request)
    {
        $validated = $request->validate([
            'jurusan' => 'required|string',
        ]);

        Jurusan::create([
            'user_id' => auth()->id(),
            'jurusan' => $validated['jurusan'],
        ]);

        return redirect()->route('jurusan')->with('notif', 'Jurusan baru berhasil ditambahkan.');
    }

    public function postEditJurusan(Request $request, $id)
    {
        $validated = $request->validate([
            'jurusan' => 'required|string',
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update([
            'jurusan' => $validated['jurusan'],
        ]);

        return redirect()->route('jurusan')->with('notif', 'Nama Jurusan berhasil diubah.');
    }

    public function postHapusJurusan($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('jurusan')->with('notif', 'Jurusan berhasil dihapus.');
    }
}
