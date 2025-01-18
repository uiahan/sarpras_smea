<?php

namespace App\Http\Controllers;

use App\Models\DetailKodeBarang;
use App\Models\JenisBarang;
use App\Models\Jurusan;
use App\Models\KodeBarang;
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
        $kodeBarang = KodeBarang::all();
        $detailKodeBarang = DetailKodeBarang::all();
        $jenisBarang = JenisBarang::all();
        $pengajuan = Pengajuan::findOrFail($id);
        return view('pages.validasi.konfirmasi', compact('user', 'pengajuan', 'kodeBarang', 'jenisBarang', 'detailKodeBarang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diajukan,Diterima,Diperbaiki,Dibelikan,Di Sarpras,Dijurusan',
            'catatan' => 'nullable|string',
            'harga_beli' => 'nullable',
            'satuan_barang' => 'nullable',
            'kode_barang' => 'nullable',
            'nusp' => 'nullable',
            'nama_barang' => 'nullable',
            'jenis_barang' => 'nullable',
            'nomor_permintaan' => 'nullable',
            'tanggal_realisasi' => 'nullable|date',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
            'harga_beli' => $request->harga_beli,
            'satuan_barang' => $request->satuan_barang,
            'kode_barang' => $request->kode_barang,
            'nusp' => $request->nusp,
            'nama_barang' => $request->nama_barang,
            'jenis_barang' => $request->jenis_barang,
            'nomor_permintaan' => $request->nomor_permintaan,
            'tanggal_realisasi' => $request->tanggal_realisasi,
        ]);

        return redirect()->route('validasi')->with('notif', 'Data pengajuan berhasil divalidasi.');
    }

    public function getNusp($kode_barang_id)
    {
        $nuspList = DetailKodeBarang::where('kode_barang_id', $kode_barang_id)->get();
        // dd($nuspList);
        return response()->json($nuspList);
    }

    public function getNamaBarang($nusp)
{
    // Fetch the data where nusp matches
    $barang = DetailKodeBarang::where('nusp', $nusp)->first();

    if ($barang) {
        // Return the nama_barang and kode_barang_id as JSON response
        return response()->json([
            'nama_barang' => $barang->nama_barang,
            'kode_barang_id' => $barang->kode_barang_id
        ]);
    } else {
        return response()->json([], 404); // No matching nusp
    }
}

}
