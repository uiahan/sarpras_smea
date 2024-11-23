<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function user()
    {
        $user = Auth::user();
        $userr = User::where('role', '!=', 'admin')->get();
        $userCount = User::where('role', '!=', 'admin')->count();
        return view('pages.user.user', compact('userr', 'user', 'userCount'));
    }

    public function tambahUser()
    {
        $user = Auth::user();
        return view('pages.user.tambah', compact('user'));
    }

    public function editUser($id)
    {
        $user = Auth::user();
        $userr = User::findOrFail($id);
        return view('pages.user.edit', compact('user', 'userr'));
    }

    public function resetpw($id)
    {
        $user = Auth::user();
        $userr = User::findOrFail($id);
        return view('pages.user.resetpw', compact('user', 'userr'));
    }

    public function postTambahUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|in:Akutansi Keuangan Lembaga,Bisnis Daring Pemasaran,Otomatisasi Tata Kelola Perkantoran,Teknik Jaringan Komputer,Rekayasa Perangkat Lunak,waka kurikulum,waka sarpras,waka hubin,waka kesiswaan,waka evbank,admin',
            'foto' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('img'), $fotoName);
            $fotoPath = 'img/' . $fotoName;
        }

        User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'foto' => $fotoPath,
        ]);

        return redirect()->route('user')->with('notif', 'User baru berhasil ditambahkan!');
    }

    public function postHapusUser($id)
    {
        $userr = User::findOrFail($id);
        $userr->delete();

        return redirect()->back()->with('notif', 'User berhasil dihapus.');
    }

    public function postEditUser(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role' => 'required|string|max:255',
            'foto' => 'nullable',
        ]);

        $userr = User::findOrFail($id);

        $fotoPath = $userr->foto;
        if ($request->hasFile('foto')) {
            if (Storage::exists($fotoPath)) {
                Storage::delete($fotoPath);
            }

            $foto = $request->file('foto');
            $fotoName = time() . '-' . $foto->getClientOriginalName();
            $fotoPath = 'img/' . $fotoName;

            $foto->move(public_path('img'), $fotoName);
        }

        $userr->update([
            'name' => $request->name,
            'foto' => $fotoPath,
            'username' => $request->username,
            'role' => $request->role,
        ]);

        return redirect()->route('user')->with('notif', 'User berhasil di ubah.');
    }

    public function postResetPassword(Request $request, $id)
    {

        $user = Auth::user();
        $userr = User::findOrFail($id);

        if ($user->role !== 'admin') {
            $request->validate([
                'old_password' => 'required|string',
            ]);

            if (!Hash::check($request->old_password, $userr->password)) {
                return redirect()->back()->withErrors(['old_password' => 'Password lama yang Anda masukkan salah.']);
            }
        }

        $validated = $request->validate([
            'new_password' => 'required|string|min:8',
        ]);

        $userr->password = bcrypt($request->new_password);
        $userr->save();

        return redirect()->route('user')->with('notif', 'Password berhasil di reset.');
    }
}
