<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidasiController extends Controller
{
    public function validasi(Request $request)
    {
        $query = Pengajuan::query();
        $user = Auth::user();
        $role = $user->role;
    
        $rolesWithAccessToAllJurusan = [
            'waka kurikulum',
            'waka sarpras',
            'waka hubin',
            'waka kesiswaan',
            'waka evbank',
            'admin'
        ];
    
        // Filter berdasarkan role
        if (!in_array($role, $rolesWithAccessToAllJurusan)) {
            $query->where('jurusan', $role);
        }
    
        // Filter berdasarkan tanggal
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $tanggal_awal = Carbon::parse($request->input('tanggal_awal'))->startOfDay();
            $tanggal_akhir = Carbon::parse($request->input('tanggal_akhir'))->endOfDay();
    
            $query->whereBetween('tanggal_ajuan', [$tanggal_awal, $tanggal_akhir]);
        }
    
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
    
        // Filter berdasarkan jurusan
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->input('jurusan'));
        }
    
        // Urutkan data
        $query->orderBy('tanggal_ajuan', 'desc');
    
        // Ambil data dan jumlah
        $pengajuan = $query->get();
        $pengajuanCount = $query->count();
    
        // Kirim semua input filter ke view
        $filters = $request->only(['tanggal_awal', 'tanggal_akhir', 'status', 'jurusan']);
    
        return view('pages.validasi.validasi', compact('pengajuan', 'pengajuanCount', 'user', 'filters'));
    }
    

    public function konfirmasi($id)
    {
        $user = Auth::user();
        $pengajuan = Pengajuan::findOrFail($id);
        return view('pages.validasi.konfirmasi', compact('user','pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diajukan,Diterima,Diperbaiki,Dibelikan,Di Sarpras,Dijurusan',
            'catatan' => 'nullable|string',
            'tanggal_realisasi' => 'nullable|date',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
            'tanggal_realisasi' => $request->tanggal_realisasi,
        ]);

        return redirect()->route('validasi')->with('notif', 'Data pengajuan berhasil divalidasi.');
    }
}
