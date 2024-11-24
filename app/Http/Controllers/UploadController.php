<?php

namespace App\Http\Controllers;

use App\Models\Format;
use App\Models\Upload;
use App\Models\Uploadpengambilan;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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
        $validated = $request->validate([
            'upload_pengambilan_file' => 'required',  // validasi file
            'pengajuan_id' => 'required',  // validasi pengajuan_id
        ]);

        // Ambil file yang diupload
        $file = $validated['upload_pengambilan_file'];

        // Tentukan path di public/upload menggunakan public_path
        $uploadPath = public_path('upload');  // Menentukan folder tujuan di dalam public
        $fileName = $file->getClientOriginalName(); // Ambil nama asli file
        $file->move($uploadPath, $fileName); // Pindahkan file ke folder yang ditentukan

        // Simpan data ke tabel 'uploadpengambilans'
        $uploadPengambilan = UploadPengambilan::create([
            'upload_pengambilan_file' => 'upload/' . $fileName,  // Menyimpan path relatif
            'pengajuan_id' => $validated['pengajuan_id'],
        ]);

        // Redirect ke route tertentu (misalnya, ke halaman yang menampilkan daftar pengambilan)
        return redirect()->route('pengambilan')->with('notif', 'File pengambilan berhasil di upload.');
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

    public function downloadPengambilan(Request $request, $id)
    {
        $uploadPengambilan = UploadPengambilan::find($id); // Gunakan find() agar tidak muncul 404

        if (!$uploadPengambilan) {
            // Jika data tidak ditemukan, beri notifikasi bahwa data tidak ada
            return redirect()->back()->with('error', 'Data tidak ditemukan atau file belum diupload oleh user.');
        }

        // Cek apakah file ada di folder public
        $filePath = public_path($uploadPengambilan->upload_pengambilan_file);
        
        if (empty($uploadPengambilan->upload_pengambilan_file) || !file_exists($filePath)) {
            // Jika file belum ada atau kosong, beri errorikasi bahwa file belum diupload
            return redirect()->back()->with('error', 'File belum diupload oleh user.');
        }

        // Jika file ditemukan, lakukan download
        return Response::download($filePath);
    }
}
