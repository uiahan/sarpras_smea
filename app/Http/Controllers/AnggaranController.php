<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggaranController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $jurusan = Jurusan::all();
    
        // Ambil parameter role dari request untuk filter
        $roleFilter = $request->input('role');
    
        // Jika role yang login bukan admin, hanya tampilkan data sesuai role pengguna
        if ($user->role != 'admin') {
            $roleFilter = $user->role;  // Menggunakan role pengguna yang sedang login
        }
    
        // Query untuk mendapatkan data user dengan filter role (exclude admin)
        $userr = User::query()
            ->where('role', '!=', 'admin') // Exclude admin
            ->when($roleFilter, function ($query) use ($roleFilter) {
                return $query->where('role', $roleFilter);
            })
            ->withSum('pengajuan', 'total_harga') // Menambahkan total_pengajuan per user
            ->get();
    
        // Hitung total user (dengan filter jika ada)
        $userCount = User::query()
            ->where('role', '!=', 'admin') // Exclude admin
            ->when($roleFilter, function ($query) use ($roleFilter) {
                return $query->where('role', $roleFilter);
            })
            ->count();
    
        // Hitung total anggaran berdasarkan filter yang diterapkan
        $totalAnggaran = $userr->sum('anggaran'); // Menjumlahkan anggaran semua user sesuai filter
    
        // Hitung total harga semua pengajuan (dengan filter jika ada)
        $totalPengajuan = Pengajuan::query()
            ->when($roleFilter, function ($query) use ($roleFilter) {
                return $query->whereHas('user', function ($q) use ($roleFilter) {
                    return $q->where('role', $roleFilter);
                });
            })
            ->sum('total_harga'); // Menjumlahkan total_harga dari semua pengajuan
    
        // Hitung sisa anggaran secara keseluruhan
        $sisaAnggaran = $totalAnggaran - $totalPengajuan;
    
        // Hitung sisa anggaran untuk setiap user
        $userr = $userr->map(function ($user) {
            $totalPengajuanUser = $user->pengajuan_sum_total_harga ?? 0; // Menambahkan total_pengajuan user
            $user->sisa_anggaran = $user->anggaran - $totalPengajuanUser; // Menghitung sisa anggaran per user
            return $user;
        });
    
        // Kirim data ke view
        return view('pages.dashboard.dashboard', compact('userr', 'user', 'userCount', 'totalAnggaran', 'totalPengajuan', 'sisaAnggaran', 'jurusan'));
    }
    
    
    



    public function tambahAnggaran($id)
    {
        $user = Auth::user();
        $userr = User::findOrFail($id);
        return view('pages.dashboard.tambahanggaran', compact('user', 'userr'));
    }

    public function postTambahAnggaran(Request $request, $id)
    {
        $request->validate([
            'anggaran' => 'required|numeric|min:0',
        ]);

        try {
            // Cari data user berdasarkan ID
            $user = User::findOrFail($id);

            // Update jumlah anggaran
            $user->anggaran = $request->input('anggaran');
            $user->save();

            return redirect()->route('dashboard')->with('notif', 'Anggaran berhasil diperbarui!');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}
