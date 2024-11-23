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
        $role = auth()->user()->role;

        $rolesWithAccessToAllJurusan = [
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

    public function uploadPengambilan()
    {
        $user = Auth::user();
        return view('pages.pengambilan.upload', compact('user'));
    }

    public function ubahStatus(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        $pengajuan->status = 'Dijurusan';
        $pengajuan->save();

        return redirect()->back()->with('notif', 'Status berhasil diubah menjadi Dijurusan');
    }
}
