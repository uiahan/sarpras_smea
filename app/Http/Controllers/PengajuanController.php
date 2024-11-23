<?php

namespace App\Http\Controllers;

use App\Models\Format;
use App\Models\Jurusan;
use App\Models\Pengajuan;
use App\Models\SumberDana;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function pengajuan(Request $request)
    {
        $query = Pengajuan::query();
        $user = Auth::user();
        $format = Format::all();
        $role = $user->role;

        $rolesWithAccessToAllJurusan = [
            'admin'
        ];

        // Filter data berdasarkan jurusan jika bukan role dengan akses penuh
        if (!in_array($role, $rolesWithAccessToAllJurusan)) {
            $query->where('jurusan', $role);
        }

        // Filter berdasarkan role untuk admin
        if ($role == 'admin' && $request->filled('role')) {
            $query->where('jurusan', $request->input('role'));
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

        // Urutkan berdasarkan tanggal
        $query->orderBy('tanggal_ajuan', 'desc');

        // Ambil data dan jumlah
        $pengajuan = $query->get();
        $pengajuanCount = $query->count();

        // Simpan filter yang digunakan
        $filters = $request->only(['tanggal_awal', 'tanggal_akhir', 'status', 'role']);

        return view('pages.pengajuan.pengajuan', compact('pengajuan', 'pengajuanCount', 'user', 'filters', 'format'));
    }

    public function tambahPengajuan()
    {
        $user = Auth::user();
        $sumberDana = SumberDana::all();
        $jurusan = Jurusan::all();
        return view('pages.pengajuan.tambah', compact('user', 'sumberDana', 'jurusan'));
    }

    public function uploadPengajuan()
    {
        $user = Auth::user();
        $sumberDana = SumberDana::all();
        $jurusan = Jurusan::all();
        return view('pages.pengajuan.upload', compact('user', 'sumberDana', 'jurusan'));
    }

    public function editPengajuan($id)
    {
        $user = Auth::user();
        $sumberDana = SumberDana::all();
        $pengajuan = Pengajuan::findOrFail($id);
        $jurusan = Jurusan::all();
        return view('pages.pengajuan.edit', compact('user', 'sumberDana', 'pengajuan', 'jurusan'));
    }

    public function postTambahPengajuan(Request $request)
    {
        $validated = $request->validate([
            'jurusan' => 'required|string',
            'barang' => 'required|string',
            'program_kegiatan' => 'required|string',
            'tahun' => 'required',
            'tanggal_ajuan' => 'required|date',
            'tanggal_realisasi' => 'nullable',
            'harga_satuan' => 'required|numeric|min:0',
            'banyak' => 'required|numeric|min:1',
            'harga_beli' => 'nullable|numeric|min:0',
            'sumber_dana' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:Diajukan,Diterima,Diperbaiki,Dibelikan,Di Sarpras,Dijurusan',
        ]);

        $validated['total_harga'] = $validated['harga_satuan'] * $validated['banyak'];
        Pengajuan::create([
            'user_id' => auth()->id(),
            'jurusan' => $validated['jurusan'],
            'barang' => $validated['barang'],
            'program_kegiatan' => $validated['program_kegiatan'],
            'tahun' => $validated['tahun'],
            'tanggal_ajuan' => $validated['tanggal_ajuan'],
            'tanggal_realisasi' => $validated['tanggal_realisasi'] ?? null,
            'harga_satuan' => $validated['harga_satuan'],
            'banyak' => $validated['banyak'],
            'harga_beli' => $validated['harga_beli'],
            'total_harga' => $validated['total_harga'],
            'sumber_dana' => $validated['sumber_dana'],
            'keterangan' => $validated['keterangan'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('pengajuan')->with('notif', 'Pengajuan berhasil ditambahkan.');
    }

    public function postEditPengajuan(Request $request, $id)
    {
        $validated = $request->validate([
            'jurusan' => 'required|string',
            'barang' => 'required|string',
            'program_kegiatan' => 'required|string',
            'tahun' => 'required',
            'tanggal_ajuan' => 'required|date',
            'tanggal_realisasi' => 'nullable|date',
            'harga_satuan' => 'required|numeric|min:0',
            'banyak' => 'required|numeric|min:1',
            'harga_beli' => 'nullable|numeric|min:0',
            'sumber_dana' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:Diajukan,Diterima,Diperbaiki,Dibelikan,Di Sarpras,Dijurusan',
        ]);

        $validated['total_harga'] = $validated['harga_satuan'] * $validated['banyak'];
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update([
            'jurusan' => $validated['jurusan'],
            'barang' => $validated['barang'],
            'program_kegiatan' => $validated['program_kegiatan'],
            'tahun' => $validated['tahun'],
            'tanggal_ajuan' => $validated['tanggal_ajuan'],
            'tanggal_realisasi' => $validated['tanggal_realisasi'] ?? null,
            'harga_satuan' => $validated['harga_satuan'],
            'banyak' => $validated['banyak'],
            'harga_beli' => $validated['harga_beli'],
            'total_harga' => $validated['total_harga'],
            'sumber_dana' => $validated['sumber_dana'],
            'keterangan' => $validated['keterangan'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('pengajuan')->with('notif', 'Pengajuan berhasil diubah.');
    }

    public function postHapusPengajuan($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->delete();

        return redirect()->route('pengajuan')->with('notif', 'Pengajuan berhasil dihapus.');
    }

    public function downloadPDF()
    {
        $pengajuan = Pengajuan::all();

        $data = [
            'judul' => 'Tabel Pengajuan',
            'pengajuan' => $pengajuan
        ];

        $pdf = Pdf::loadView('pdf.pengajuan', $data)->setPaper('A4', 'landscape');
        return $pdf->download('tabel_pengajuan.pdf');
    }
}
