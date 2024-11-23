<?php

namespace App\Http\Controllers;

use App\Models\Format;
use App\Models\Upload;
use App\Models\Uploadpengambilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        // Validasi input file
        $request->validate([
            'upload_pengajuan_file' => 'required|max:10240', // maksimal 10MB
        ]);

        $user = Auth::user(); // Ambil data user yang sedang login

        // Hapus data lama yang memiliki user_id yang sama
        $existingUploads = Upload::where('user_id', $user->id)->get();
        foreach ($existingUploads as $upload) {
            // Hapus file lama dari folder public/upload jika ada
            if (file_exists(public_path($upload->upload_pengajuan_file))) {
                unlink(public_path($upload->upload_pengajuan_file));
            }
            $upload->delete(); // Hapus data dari database
        }

        // Ambil file dari request
        $ajuanFile = $request->file('upload_pengajuan_file');

        // Tentukan nama file dan lokasi penyimpanan
        $ajuanFileName = time() . '-ajuan-' . $ajuanFile->getClientOriginalName();

        // Simpan file ke folder public/upload
        $ajuanFile->move(public_path('upload'), $ajuanFileName);

        // Simpan path file ke database
        Upload::create([
            'upload_pengajuan_file' => 'upload/' . $ajuanFileName,
            'user_id' => $user->id,
        ]);

        return redirect()->route('pengajuan')->with('notif', 'File pengajuan berhasil diupload.');
    }


    public function uploadFilePengambilan(Request $request)
    {
        // Validasi input file
        $request->validate([
            'upload_pengambilan_file' => 'required|max:10240', // maksimal 10MB
        ]);

        $user = Auth::user(); // Ambil data user yang sedang login

        // Hapus data lama yang memiliki user_id yang sama
        $existingUploads = Uploadpengambilan::where('user_id', $user->id)->get();
        foreach ($existingUploads as $upload) {
            // Hapus file lama dari folder public/upload jika ada
            if (file_exists(public_path($upload->upload_pengambilan_file))) {
                unlink(public_path($upload->upload_pengambilan_file));
            }
            $upload->delete(); // Hapus data dari database
        }

        // Ambil file dari request
        $ajuanFile = $request->file('upload_pengambilan_file');

        // Tentukan nama file dan lokasi penyimpanan
        $ajuanFileName = time() . '-pengambilan-' . $ajuanFile->getClientOriginalName();

        // Simpan file ke folder public/upload
        $ajuanFile->move(public_path('upload'), $ajuanFileName);

        // Simpan path file ke database
        Uploadpengambilan::create([
            'upload_pengambilan_file' => 'upload/' . $ajuanFileName,
            'user_id' => $user->id,
        ]);

        return redirect()->route('pengambilan')->with('notif', 'File pengambilan berhasil diupload.');
    }


    public function downloadPengajuan(Request $request)
    {
        $user = Auth::user(); // Ambil data user yang sedang login

        // Cari file berdasarkan user_id
        $format = Upload::where('user_id', $user->id)->latest()->first();

        if (!$format || !$format->upload_pengajuan_file) {
            return redirect()->back()->with('error', 'File pengajuan tidak ditemukan.');
        }

        $filePath = public_path($format->upload_pengajuan_file);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath);
    }

    public function downloadPengambilan(Request $request)
    {
        $user = Auth::user(); // Ambil data user yang sedang login

        // Cari file berdasarkan user_id
        $format = Uploadpengambilan::where('user_id', $user->id)->latest()->first();

        if (!$format || !$format->upload_pengambilan_file) {
            return redirect()->back()->with('error', 'File pengambilan tidak ditemukan.');
        }

        $filePath = public_path($format->upload_pengambilan_file);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath);
    }
}
