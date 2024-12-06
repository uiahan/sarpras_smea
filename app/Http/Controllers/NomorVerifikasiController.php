<?php

namespace App\Http\Controllers;

use App\Exports\NomorVerifikasi;
use App\Models\Jurusan;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NomorVerifikasiController extends Controller
{
    public function nomorVerifikasi(Request $request)
    {
        $query = Pengajuan::query();
        $user = Auth::user();
        $jurusan = Jurusan::all();

        $role = $user->role;

        $rolesWithAccessToAllJurusan = ['admin'];

        // Filter data berdasarkan jurusan jika bukan role dengan akses penuh
        if (!in_array($role, $rolesWithAccessToAllJurusan)) {
            $query->where('jurusan', $role);
        }

        // Filter untuk admin berdasarkan role (jurusan)
        if ($role == 'admin' && $request->filled('role')) {
            $query->where('jurusan', $request->input('role'));
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

        // Pastikan nomor_permintaan dan jenis_barang sudah terisi
        $query->whereNotNull('nomor_permintaan')->whereNotNull('jenis_barang');

        // Urutkan berdasarkan tanggal
        $query->orderBy('created_at', 'desc');

        // Ambil data
        $pengajuan = $query->get();

        // Gabungkan data dengan nomor_permintaan yang sama
        $pengajuanGrouped = $pengajuan->groupBy('nomor_permintaan')->map(function ($group) {
            $first = $group->first(); // Ambil data pertama dari grup
            // Tambahkan data gabungan ke properti dinamis
            $first->setAttribute('gabungan_jenis_barang', $group->pluck('jenis_barang')->unique()->implode(', '));
            $first->setAttribute('gabungan_status', $group->pluck('status')->unique()->implode(', '));
            return $first;
        });

        // Hitung jumlah total data sesuai filter
        $notaPermintaanCount = $pengajuanGrouped->count();

        // Simpan filter yang digunakan
        $filters = $request->only(['tanggal_awal', 'tanggal_akhir', 'status', 'role']);

        return view('pages.nota_permintaan.nota_permintaan', [
            'user' => $user,
            'jurusan' => $jurusan,
            'pengajuan' => $pengajuanGrouped->values(), // Konversi ke koleksi tanpa kunci
            'notaPermintaanCount' => $notaPermintaanCount,
            'filters' => $filters,
        ]);
    }

    public function detailNomorVerifikasi($nomor_permintaan)
{
    // Decode parameter
    $nomor_permintaan = urldecode($nomor_permintaan);

    $user = Auth::user();
    $pengajuan = Pengajuan::where('nomor_permintaan', $nomor_permintaan)->get();

    if ($pengajuan->isEmpty()) {
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    return view('pages.nota_permintaan.detail', compact('pengajuan', 'nomor_permintaan', 'user'));
}


    public function downloadExcel($nomor_permintaan)
    {
        $pengajuan = Pengajuan::where('nomor_permintaan', $nomor_permintaan)->get();

        if ($pengajuan->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        return Excel::download(new NomorVerifikasi($pengajuan), 'detail_nomor_permintaan_' . $nomor_permintaan . '.xlsx');
    }

    public function verifikasi($nomor_permintaan)
    {
        $user = Auth::user();
        $pengajuan = Pengajuan::where('nomor_permintaan', $nomor_permintaan)->get();

        // Pastikan data ditemukan
        if ($pengajuan->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        return view('pages.nota_permintaan.verifikasi', compact('pengajuan', 'nomor_permintaan', 'user'));
    }

    public function postVerifikasi(Request $request, $nomor_permintaan)
    {
        $validated = $request->validate([
            'nomor_verifikasi' => 'required|string|max:255',
        ]);

        // Update nomor_verifikasi pada semua data dengan nomor_permintaan yang sama
        Pengajuan::where('nomor_permintaan', $nomor_permintaan)
            ->update(['nomor_verifikasi' => $validated['nomor_verifikasi']]);

        return redirect()->route('nomorVerifikasi')
            ->with('notif', 'Nomor Verifikasi berhasil dimasukan.');
    }
}
