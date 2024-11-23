<?php

namespace App\Http\Controllers;

use App\Models\Format;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormatController extends Controller
{
    public function setting()
    {
        $user = Auth::user();
        return view('pages.format.setting', compact('user'));
    }

    public function uploadFormat(Request $request)
    {
        // Validasi input file
        $request->validate([
            'format_pengajuan_file' => 'required|max:10240', // maksimal 10MB
            'format_pengambilan_file' => 'required|max:10240', // maksimal 10MB
        ]);

        // Hapus semua data lama dari tabel formats
        Format::truncate();

        // Ambil file dari request
        $ajuanFile = $request->file('format_pengajuan_file');
        $pengambilanFile = $request->file('format_pengambilan_file');

        // Tentukan nama file dan lokasi penyimpanan
        $ajuanFileName = time() . '-ajuan-' . $ajuanFile->getClientOriginalName();
        $pengambilanFileName = time() . '-pengambilan-' . $pengambilanFile->getClientOriginalName();

        // Simpan file ke folder public/document
        $ajuanFile->move(public_path('document'), $ajuanFileName);
        $pengambilanFile->move(public_path('document'), $pengambilanFileName);

        $user = Auth::user();
        // Simpan path file ke database
        Format::create([
            'format_pengajuan_file' => 'document/' . $ajuanFileName,
            'format_pengambilan_file' => 'document/' . $pengambilanFileName,
            'user_id' => $user->id,
        ]);

        return redirect()->back()->with('notif', 'Format file berhasil diupload.');
    }

    public function downloadPengajuan()
    {
        // Cari data format file di database
      

        // Cari file berdasarkan user_id
        $format = Format::where('user_id', 1)->latest()->first();

        if (!$format || !$format->format_pengajuan_file) {
            return redirect()->back()->with('error', 'File pengajuan tidak ditemukan.');
        }

        $filePath = public_path($format->format_pengajuan_file);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath);
    }

    // Fungsi untuk download format pengambilan
    public function downloadPengambilan()
    {
        // Cari data format file di database
      

        // Cari file berdasarkan user_id
        $format = Format::where('user_id', 1)->latest()->first();

        if (!$format || !$format->format_pengambilan_file) {
            return redirect()->back()->with('error', 'File pengambilan tidak ditemukan.');
        }

        $filePath = public_path($format->format_pengambilan_file);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath);
    }
}
