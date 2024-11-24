<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidasiController extends Controller
{
    public function validasi(Request $request)
    {
        $query = Pengajuan::query();
        $jurusan = Jurusan::all();
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

        // Filter berdasarkan tanggal (opsional)
        if ($request->filled('tanggal_awal') || $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->filled('tanggal_awal')
                ? Carbon::parse($request->input('tanggal_awal'))->startOfDay()
                : Carbon::create(1970, 1, 1, 0, 0, 0); // Waktu paling awal
            $tanggal_akhir = $request->filled('tanggal_akhir')
                ? Carbon::parse($request->input('tanggal_akhir'))->endOfDay()
                : Carbon::create(9999, 12, 31, 23, 59, 59); // Waktu paling akhir

            $query->whereBetween('tanggal_ajuan', [$tanggal_awal, $tanggal_akhir]);
        }

        // Filter berdasarkan status (opsional)
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter berdasarkan jurusan (opsional)
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

        return view('pages.validasi.validasi', compact('pengajuan', 'pengajuanCount', 'user', 'filters', 'jurusan'));
    }

    public function konfirmasi($id)
    {
        $user = Auth::user();
        $pengajuan = Pengajuan::findOrFail($id);
        return view('pages.validasi.konfirmasi', compact('user', 'pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diajukan,Diterima,Diperbaiki,Dibelikan,Di Sarpras,Dijurusan',
            'catatan' => 'nullable|string',
            'harga_beli' => 'nullable',
            'tanggal_realisasi' => 'nullable|date',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
            'harga_beli' => $request->harga_beli,
            'tanggal_realisasi' => $request->tanggal_realisasi,
        ]);

        return redirect()->route('validasi')->with('notif', 'Data pengajuan berhasil divalidasi.');
    }
}
