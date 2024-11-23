<?php

namespace App\Http\Controllers;

use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DanaController extends Controller
{
    public function dana()
    {
        $user = Auth::user();
        $dana = SumberDana::all();
        $danaCount = SumberDana::count();
        return view('pages.dana.dana', compact('dana', 'user', 'danaCount'));
    }

    public function tambahDana()
    {
        $user = Auth::user();
        return view('pages.dana.tambah', compact('user'));
    }

    public function editDana($id)
    {
        $user = Auth::user();
        $dana = SumberDana::findOrFail($id);
        return view('pages.dana.edit', compact('user', 'dana'));
    }

    public function postTambahDana(Request $request)
    {
        $validated = $request->validate([
            'sumber_dana' => 'required|string',
        ]);

        SumberDana::create([
            'user_id' => auth()->id(),
            'sumber_dana' => $validated['sumber_dana'],
        ]);

        return redirect()->route('dana')->with('notif', 'Sumber Dana baru berhasil ditambahkan.');
    }

    public function postEditDana(Request $request, $id)
    {
        $validated = $request->validate([
            'sumber_dana' => 'required|string',
        ]);

        $dana = SumberDana::findOrFail($id);
        $dana->update([
            'sumber_dana' => $validated['sumber_dana'],
        ]);

        return redirect()->route('dana')->with('notif', 'Sumber Dana berhasil diubah.');
    }

    public function postHapusDana($id)
    {
        $dana = SumberDana::findOrFail($id);
        $dana->delete();

        return redirect()->route('dana')->with('notif', 'Sumber Dana berhasil dihapus.');
    }
}
