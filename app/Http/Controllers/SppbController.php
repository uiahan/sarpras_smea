<?php

namespace App\Http\Controllers;

use App\Exports\ExportSPPB;
use App\Models\Jurusan;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SppbController extends Controller
{
    public function sppb(Request $request)
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
        $sppbCount = $pengajuanGrouped->count();

        // Simpan filter yang digunakan
        $filters = $request->only(['tanggal_awal', 'tanggal_akhir', 'status', 'role']);

        return view('pages.sppb.sppb', [
            'user' => $user,
            'jurusan' => $jurusan,
            'pengajuan' => $pengajuanGrouped->values(), // Konversi ke koleksi tanpa kunci
            'sppbCount' => $sppbCount,
            'filters' => $filters,
        ]);
    }

    public function detailSppb($nomor_verifikasi)
    {
        $user = Auth::user();
        $pengajuan = Pengajuan::where('nomor_verifikasi', $nomor_verifikasi)->get();

        if ($pengajuan->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Ambil elemen pertama dari koleksi
        $selectedPengajuan = $pengajuan->firstWhere('tahun');

        if (!$selectedPengajuan) {
            return redirect()->back()->with('error', 'Data untuk tahun yang diminta tidak ditemukan.');
        }

        session(['nomor_verifikasi' => $nomor_verifikasi]);

        return view('pages.sppb.detail', compact('selectedPengajuan', 'nomor_verifikasi', 'user', 'pengajuan'));
    }

    public function downloadSPPB($nomor_verifikasi)
    {
        // Ambil data berdasarkan nomor verifikasi
        $pengajuan = Pengajuan::where('nomor_verifikasi', $nomor_verifikasi)->get();

        // Validasi jika data kosong
        if ($pengajuan->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan untuk nomor verifikasi tersebut.');
        }

        // Download file Excel
        return Excel::download(new ExportSPPB($pengajuan), 'surat_perintah_penyaluran_barang.xlsx');
    }

    public function bast(Request $request)
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
        $sppbCount = $pengajuanGrouped->count();

        // Simpan filter yang digunakan
        $filters = $request->only(['tanggal_awal', 'tanggal_akhir', 'status', 'role']);

        return view('pages.bast.bast', [
            'user' => $user,
            'jurusan' => $jurusan,
            'pengajuan' => $pengajuanGrouped->values(), // Konversi ke koleksi tanpa kunci
            'sppbCount' => $sppbCount,
            'filters' => $filters,
        ]);
    }

    public function detailBast($nomor_verifikasi)
    {
        $user = Auth::user();
        $pengajuan = Pengajuan::where('nomor_verifikasi', $nomor_verifikasi)->get();

        if ($pengajuan->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Ambil elemen pertama dari koleksi
        $selectedPengajuan = $pengajuan->firstWhere('tahun');

        if (!$selectedPengajuan) {
            return redirect()->back()->with('error', 'Data untuk tahun yang diminta tidak ditemukan.');
        }

        session(['nomor_verifikasi' => $nomor_verifikasi]);

        return view('pages.bast.detail', compact('selectedPengajuan', 'nomor_verifikasi', 'user', 'pengajuan'));
    }

    public function downloadBast($nomor_verifikasi)
    {
        // Ambil data berdasarkan nomor verifikasi
        $pengajuan = Pengajuan::where('nomor_verifikasi', $nomor_verifikasi)->get();

        // Validasi jika data kosong
        if ($pengajuan->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan untuk nomor verifikasi tersebut.');
        }

        // Download file Excel
        return Excel::download(new ExportSPPB($pengajuan), 'berita_acara_serah_terima.xlsx');
    }

    public function pengeluaran(Request $request)
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

        // Pastikan nomor_verifikasi sudah terisi
        $query->whereNotNull('nomor_verifikasi');

        // Urutkan berdasarkan tanggal
        $query->orderBy('created_at', 'desc');

        // Ambil semua data yang sudah ada nomor_verifikasi
        $pengajuan = $query->get();

        // Hitung jumlah total data sesuai filter
        $sppbCount = $pengajuan->count();

        // Simpan filter yang digunakan
        $filters = $request->only(['tanggal_awal', 'tanggal_akhir', 'status', 'role']);

        return view('pages.pengeluaran.pengeluaran', [
            'user' => $user,
            'jurusan' => $jurusan,
            'pengajuan' => $pengajuan, // Menampilkan semua data yang memiliki nomor_verifikasi
            'sppbCount' => $sppbCount,
            'filters' => $filters,
        ]);
    }
}
