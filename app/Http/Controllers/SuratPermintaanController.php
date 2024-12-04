<?php

namespace App\Http\Controllers;

use App\Exports\ExportSuratPermintaan;
use App\Models\Jurusan;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SuratPermintaanController extends Controller
{
    public function suratPermintaan(Request $request)
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
        $query->whereNotNull('nomor_verifikasi');

        // Urutkan berdasarkan tanggal
        $query->orderBy('created_at', 'desc');

        // Ambil data
        $pengajuan = $query->get();

        // Gabungkan data dengan nomor_permintaan yang sama
        $pengajuanGrouped = $pengajuan->groupBy('nomor_verifikasi')->map(function ($group) {
            $first = $group->first(); // Ambil data pertama dari grup
            // Tambahkan data gabungan ke properti dinamis
            $first->setAttribute('gabungan_jenis_barang', $group->pluck('jenis_barang')->unique()->implode(', '));
            $first->setAttribute('gabungan_status', $group->pluck('status')->unique()->implode(', '));
            return $first;
        });

        // Hitung jumlah total data sesuai filter
        $suratPermintaanCount = $pengajuanGrouped->count();

        // Simpan filter yang digunakan
        $filters = $request->only(['tanggal_awal', 'tanggal_akhir', 'status', 'role']);

        return view('pages.surat_permintaan.surat_permintaan', [
            'user' => $user,
            'jurusan' => $jurusan,
            'pengajuan' => $pengajuanGrouped->values(), // Konversi ke koleksi tanpa kunci
            'suratPermintaanCount' => $suratPermintaanCount,
            'filters' => $filters,
        ]);
    }

    public function detailSuratPermintaan($nomor_verifikasi)
    {
        $user = Auth::user();
        $pengajuan = Pengajuan::where('nomor_verifikasi', $nomor_verifikasi)->get();

        if ($pengajuan->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        session(['nomor_verifikasi' => $nomor_verifikasi]);

        return view('pages.surat_permintaan.detail.detail', compact('pengajuan', 'nomor_verifikasi', 'user'));
    }

    public function editDetailSuratPermintaan($id)
    {
        $user = Auth::user();
        $pengajuan = Pengajuan::findOrFail($id);

        $nomor_verifikasi = session('nomor_verifikasi');

        return view('pages.surat_permintaan.detail.edit', compact('user', 'pengajuan', 'nomor_verifikasi'));
    }

    public function postEditDetailSuratPermintaan(Request $request, $id)
    {
        $request->validate([
            'jumlah_yg_diacc' => 'required'
        ]);

        // Ambil nomor verifikasi dari session
        $nomor_verifikasi = session('nomor_verifikasi');

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->jumlah_yg_diacc = $request->jumlah_yg_diacc; // Update jumlah_yg_diacc
        $pengajuan->save();

        return redirect()->route('detailSuratPermintaan', $nomor_verifikasi)->with('notif', 'Jumlah yang di acc berhasil dimasukan');
    }

    public function downloadSuratPermintaan($nomor_verifikasi)
    {
        // Ambil data berdasarkan nomor verifikasi
        $pengajuan = Pengajuan::where('nomor_verifikasi', $nomor_verifikasi)->get();

        // Validasi jika data kosong
        if ($pengajuan->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan untuk nomor verifikasi tersebut.');
        }

        // Download file Excel
        return Excel::download(new ExportSuratPermintaan($pengajuan), 'surat_permintaan.xlsx');
    }
}
