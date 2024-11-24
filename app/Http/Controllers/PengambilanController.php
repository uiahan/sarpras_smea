<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Uploadpengambilan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengambilanController extends Controller
{
    public function pengambilan(Request $request)
    {
        $user = Auth::user();
        $query = Pengajuan::query();
        $role = $user->role;

        $rolesWithAccessToAllJurusan = [
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

        // Filter berdasarkan status yang diizinkan
        $query->whereIn('status', ['Di Sarpras', 'Dijurusan']);

        // Urutkan data
        $query->orderBy('tanggal_ajuan', 'desc');

        // Ambil data dan jumlah
        $pengajuan = $query->get();
        $pengajuanCount = $query->count();

        // Kirim semua input filter ke view
        $filters = $request->only(['tanggal_awal', 'tanggal_akhir']);

        return view('pages.pengambilan.pengambilan', compact('pengajuanCount', 'pengajuan', 'user', 'filters'));
    }

    public function uploadPengambilan($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $user = Auth::user();
        return view('pages.pengambilan.upload', compact('user', 'pengajuan'));
    }

    public function ubahStatus(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        $pengajuan->status = 'Dijurusan';
        $pengajuan->save();

        return redirect()->back()->with('notif', 'Status berhasil diubah menjadi Dijurusan');
    }
}
