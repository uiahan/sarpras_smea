<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\Uploadpengambilan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokumenController extends Controller
{
    public function dokumen()
    {
        $user = Auth::user();

        $userr = User::where('role', '!=', 'admin')
            ->with(['uploads', 'uploadPengambilans'])
            ->get();

        $pengajuanCount = Upload::count();
        $pengambilanCount = Uploadpengambilan::count();
        return view('pages.dokumen.dokumen', compact('userr', 'user', 'pengajuanCount', 'pengambilanCount'));
    }

    public function lihatPengajuan($userId)
    {
        // Cari file yang di-upload oleh user
        $upload = Upload::where('user_id', $userId)->latest()->first(); // Ambil yang terbaru

        if (!$upload || !$upload->upload_pengajuan_file) {
            return redirect()->back()->with('error', 'File pengajuan tidak ditemukan.');
        }

        $filePath = public_path($upload->upload_pengajuan_file);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath);
    }

    public function lihatPengambilan($userId)
    {
        // Cari file yang di-upload oleh user
        $upload = Uploadpengambilan::where('user_id', $userId)->latest()->first(); // Ambil yang terbaru

        if (!$upload || !$upload->upload_pengambilan_file) {
            return redirect()->back()->with('error', 'File pengambilan tidak ditemukan.');
        }

        $filePath = public_path($upload->upload_pengambilan_file);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath);
    }
}
