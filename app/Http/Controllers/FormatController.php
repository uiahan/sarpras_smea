<?php

namespace App\Http\Controllers;

use App\Models\Format;
use App\Models\FormatPengajuan;
use App\Models\FormatPengambilan;
use App\Models\FormatUploadPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormatController extends Controller
{
    public function setting()
    {
        $user = Auth::user();
        $pengajuan = FormatPengajuan::first();
        $pengambilan = FormatPengambilan::all();
        $excel = FormatUploadPengajuan::first();
        return view('pages.format.setting', compact('user', 'pengambilan', 'pengajuan', 'excel'));
    }

    public function uploadFormatPengajuan(Request $request)
{
    // Validasi input file
    $request->validate([
        'format_pengajuan_file' => 'required', // Maksimal 10MB
    ]);

    $user = Auth::user(); // Ambil data user yang sedang login

    // Hapus data lama yang memiliki user_id yang sama
    $existingUploads = FormatPengajuan::where('user_id', $user->id)->get();
    foreach ($existingUploads as $upload) {
        // Hapus file lama dari folder public/document jika ada
        $filePath = public_path($upload->format_pengajuan_file);
        if (is_file($filePath)) { // Pastikan path adalah file
            unlink($filePath);
        }
        $upload->delete(); // Hapus data dari database
    }

    // Ambil file dari request
    $ajuanFile = $request->file('format_pengajuan_file');

    // Tentukan nama file dan lokasi penyimpanan
    $ajuanFileName = time() . '-ajuan-' . $ajuanFile->getClientOriginalName();

    // Simpan file ke folder public/document
    $ajuanFile->move(public_path('document'), $ajuanFileName);

    // Simpan path file ke database
    FormatPengajuan::create([
        'format_pengajuan_file' => 'document/' . $ajuanFileName,
        'user_id' => $user->id,
    ]);

    return redirect()->route('setting')->with('notif', 'Format pengajuan berhasil diupload.');
}

public function uploadFormatUploadPengajuan(Request $request)
{
    // Validasi input file
    $request->validate([
        'format_upload_pengajuan_file' => 'required', // Maksimal 10MB
    ]);

    $user = Auth::user(); // Ambil data user yang sedang login

    // Hapus data lama yang memiliki user_id yang sama
    $existingUploads = FormatUploadPengajuan::where('user_id', $user->id)->get();
    foreach ($existingUploads as $upload) {
        // Hapus file lama dari folder public/document jika ada
        $filePath = public_path($upload->format_upload_pengajuan_file);
        if (is_file($filePath)) { // Pastikan path adalah file
            unlink($filePath);
        }
        $upload->delete(); // Hapus data dari database
    }

    // Ambil file dari request
    $ajuanFile = $request->file('format_upload_pengajuan_file');

    // Tentukan nama file dan lokasi penyimpanan
    $ajuanFileName = time() . '-format_upload_pengajuan-' . $ajuanFile->getClientOriginalName();

    // Simpan file ke folder public/document
    $ajuanFile->move(public_path('document'), $ajuanFileName);

    // Simpan path file ke database
    FormatUploadPengajuan::create([
        'format_upload_pengajuan_file' => 'document/' . $ajuanFileName,
        'user_id' => $user->id,
    ]);

    return redirect()->route('setting')->with('notif', 'Format upload excel pengajuan berhasil diupload.');
}


public function uploadFormatPengambilan(Request $request)
{
    // Validasi input file
    $request->validate([
        'format_pengambilan_file' => 'required', // Maksimal 10MB
    ]);

    $user = Auth::user(); // Ambil data user yang sedang login

    // Hapus data lama yang memiliki user_id yang sama
    $existingUploads = FormatPengambilan::where('user_id', $user->id)->get();
    foreach ($existingUploads as $upload) {
        // Hapus file lama dari folder public/document jika ada
        $filePath = public_path($upload->format_pengambilan_file);
        if (is_file($filePath)) { // Pastikan path adalah file
            unlink($filePath);
        }
        $upload->delete(); // Hapus data dari database
    }

    // Ambil file dari request
    $ajuanFile = $request->file('format_pengambilan_file');

    // Tentukan nama file dan lokasi penyimpanan
    $ajuanFileName = time() . '-pengambilan-' . $ajuanFile->getClientOriginalName();

    // Simpan file ke folder public/document
    $ajuanFile->move(public_path('document'), $ajuanFileName);

    // Simpan path file ke database
    FormatPengambilan::create([
        'format_pengambilan_file' => 'document/' . $ajuanFileName,
        'user_id' => $user->id,
    ]);

    return redirect()->route('setting')->with('notif', 'Format pengajuan berhasil diupload.');
}

    public function downloadFormatPengajuan(Request $request)
    {
        // Ganti '1' dengan user_id dari user yang sedang login jika diperlukan
        $format = FormatPengajuan::where('user_id', 1)->first();
    
        // Periksa apakah format ditemukan
        if (!$format || !$format->format_pengajuan_file) {
            return redirect()->back()->with('error', 'File pengajuan tidak ditemukan.');
        }
    
        // Tentukan path file
        $filePath = public_path($format->format_pengajuan_file);
    
        // Periksa apakah file ada
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    
        // Download file
        return response()->download($filePath);
    }
    public function downloadFormatUploadPengajuan(Request $request)
    {
        // Ganti '1' dengan user_id dari user yang sedang login jika diperlukan
        $format = FormatUploadPengajuan::where('user_id', 1)->first();
    
        // Periksa apakah format ditemukan
        if (!$format || !$format->format_upload_pengajuan_file) {
            return redirect()->back()->with('error', 'File pengajuan tidak ditemukan.');
        }
    
        // Tentukan path file
        $filePath = public_path($format->format_upload_pengajuan_file);
    
        // Periksa apakah file ada
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    
        // Download file
        return response()->download($filePath);
    }
    

    public function downloadFormatPengambilan(Request $request)
    {
        // Ganti '1' dengan user_id dari user yang sedang login jika diperlukan
        $format = FormatPengambilan::where('user_id', 1)->first();
    
        // Periksa apakah format ditemukan
        if (!$format || !$format->format_pengambilan_file) {
            return redirect()->back()->with('error', 'File pengambilan tidak ditemukan.');
        }
    
        // Tentukan path file
        $filePath = public_path($format->format_pengambilan_file);
    
        // Periksa apakah file ada
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    
        // Download file
        return response()->download($filePath);
    }
}
