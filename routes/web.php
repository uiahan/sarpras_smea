<?php

use App\Exports\DetailKodeBarangExport;
use App\Exports\KartuPersediaanExport;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DanaController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormatController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PengambilanController;
use App\Http\Controllers\SppbController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidasiController;
use App\Http\Middleware\AdminMiddleware;
use App\Imports\DetailKodeBarangImport;
use App\Models\Format;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use App\Exports\PengajuanExport;
use App\Http\Controllers\DetailKodeBarangController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\KartuPersediaanController;
use App\Http\Controllers\KodeBarangController;
use App\Http\Controllers\NomorVerifikasiController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\SuratPermintaanController;
use App\Models\DetailKodeBarang;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/postLogin', [AuthController::class, 'postLogin'])->name('postLogin');

Route::middleware('auth')->group(function () {
    // Semua pengguna yang login bisa akses
    // Pengajuan
    Route::get('/pengajuan', [PengajuanController::class, 'pengajuan'])->name('pengajuan');
    Route::get('/tambahPengajuan', [PengajuanController::class, 'tambahPengajuan'])->name('tambahPengajuan');
    Route::get('/uploadPengajuan', [PengajuanController::class, 'uploadPengajuan'])->name('uploadPengajuan');
    Route::get('/editPengajuan/{id}', [PengajuanController::class, 'editPengajuan'])->name('editPengajuan');
    Route::post('/postEditPengajuan/{id}', [PengajuanController::class, 'postEditPengajuan'])->name('postEditPengajuan');
    Route::get('/postHapusPengajuan/{id}', [PengajuanController::class, 'postHapusPengajuan'])->name('postHapusPengajuan');
    Route::post('/postTambahPengajuan', [PengajuanController::class, 'postTambahPengajuan'])->name('postTambahPengajuan');
    Route::get('/uploadExcel', [PengajuanController::class, 'uploadExcel'])->name('uploadExcel');
    Route::post('/postUploadExcel', [PengajuanController::class, 'postUploadExcel'])->name('postUploadExcel');

    // Detail
    Route::get('/detail/{pengajuan}', [DetailController::class, 'detail'])->name('detail');
    Route::get('/tambahDetail', [DetailController::class, 'tambahDetail'])->name('tambahDetail');
    Route::get('/editDetail/{id}', [DetailController::class, 'editDetail'])->name('editDetail');
    Route::post('/postEditDetail/{id}', [DetailController::class, 'postEditDetail'])->name('postEditDetail');
    Route::post('/postTambahDetail', [DetailController::class, 'postTambahDetail'])->name('postTambahDetail');
    Route::get('/postHapusDetail/{id}', [DetailController::class, 'postHapusDetail'])->name('postHapusDetail');

    // Pengambilan
    Route::get('/pengambilan', [PengambilanController::class, 'pengambilan'])->name('pengambilan');
    Route::get('/uploadPengambilan/{id}', [PengambilanController::class, 'uploadPengambilan'])->name('uploadPengambilan');
    Route::post('/ubahStatus/{id}', [PengambilanController::class, 'ubahStatus'])->name('ubahStatus');

    // Upload
    Route::post('/uploadFile', [UploadController::class, 'uploadFile'])->name('uploadFile');
    Route::post('/uploadFilePengambilan', [UploadController::class, 'uploadFilePengambilan'])->name('uploadFilePengambilan');
    Route::get('/downloadPengajuan', [UploadController::class, 'downloadPengajuan'])->name('downloadPengajuan');
    Route::get('/downloadPengambilan/{id}', [UploadController::class, 'downloadPengambilan'])->name('downloadPengambilan');

    // PDF
    Route::get('/pengajuan/download-pdf', [PengajuanController::class, 'downloadPDF'])->name('pengajuan.downloadPDF');

    // Download Format
    Route::get('/download/format-pengajuan', [FormatController::class, 'downloadPengajuan'])->name('download.pengajuan');
    Route::get('/download/format-pengambilan', [FormatController::class, 'downloadPengambilan'])->name('download.pengambilan');

    // Dashboard
    Route::get('/dashboard', [AnggaranController::class, 'dashboard'])->name('dashboard');

    //format
    Route::get('/downloadFormatUploadPengajuan', [FormatController::class, 'downloadFormatUploadPengajuan'])->name('downloadFormatUploadPengajuan');
    Route::get('/downloadFormatPengajuan', [FormatController::class, 'downloadFormatPengajuan'])->name('downloadFormatPengajuan');
    Route::get('/downloadFormatPengambilan', [FormatController::class, 'downloadFormatPengambilan'])->name('downloadFormatPengambilan');

    //export excel
    Route::get('/pengajuan/export', function () {
        return Excel::download(new PengajuanExport, 'pengajuan.xlsx');
    })->name('downloadExcelPengajuan');
    Route::get('/download-excel', [PengambilanController::class, 'exportPengambilan'])->name('downloadExcelPengambilan');
    Route::get('/downloadPengambilanExcel', [PengambilanController::class, 'exportPengambilan'])->name('downloadPengambilanExcel');
    Route::get('/download-excel-kartu-persediaan', function (Request $request) {
        $filters = $request->all(); // Ambil filter dari URL
        return Excel::download(new KartuPersediaanExport($filters), 'kartu_persediaan.xlsx');
    })->name('download.excelpp');


    // Group khusus untuk admin
    Route::middleware(AdminMiddleware::class)->group(function () {
        // Validasi
        Route::get('/admin/validasi', [ValidasiController::class, 'validasi'])->name('validasi');
        Route::get('/admin/konfirmasi/{id}', [ValidasiController::class, 'konfirmasi'])->name('konfirmasi');
        Route::post('/admin/update/{id}', [ValidasiController::class, 'update'])->name('update');
        Route::get('/get-nusp/{kode_barang}', [ValidasiController::class, 'getNusp'])->name('getNusp');
        Route::get('/get-nama-barang/{nusp}', function ($nusp) {
            $detailKodeBarang = DetailKodeBarang::where('nusp', $nusp)->first();
            return response()->json($detailKodeBarang);
        })->name('getNamaBarang');


        //kode barang
        Route::get('/admin/kodeBarang', [KodeBarangController::class, 'kodeBarang'])->name('kodeBarang');
        Route::get('/admin/tambahKodeBarang', [KodeBarangController::class, 'tambahKodeBarang'])->name('tambahKodeBarang');
        Route::get('/admin/uploadKodeBarangExcel', [KodeBarangController::class, 'uploadKodeBarangExcel'])->name('uploadKodeBarangExcel');
        Route::post('/admin/postUploadKodeBarangExcel', [KodeBarangController::class, 'postUploadKodeBarangExcel'])->name('postUploadKodeBarangExcel');
        Route::post('/admin/postTambahKodeBarang', [KodeBarangController::class, 'postTambahKodeBarang'])->name('postTambahKodeBarang');
        Route::get('/admin/editKodeBarang/{id}', [KodeBarangController::class, 'editKodeBarang'])->name('editKodeBarang');
        Route::get('/admin/postHapusKodeBarang/{id}', [KodeBarangController::class, 'postHapusKodeBarang'])->name('postHapusKodeBarang');
        Route::post('/admin/postEditKodeBarang/{id}', [KodeBarangController::class, 'postEditKodeBarang'])->name('postEditKodeBarang');
        Route::get('/download-kode-barang', [KodeBarangController::class, 'downloadExcel'])->name('downloadExcelKodeBarang');

        //detail kode barang
        Route::get('/admin/detailKodeBarang/{kodeBarang}', [DetailKodeBarangController::class, 'detailKodeBarang'])->name('detailKodeBarang');
        Route::get('/admin/tambahDetailKodeBarang', [DetailKodeBarangController::class, 'tambahDetailKodeBarang'])->name('tambahDetailKodeBarang');
        Route::get('/admin/editDetailKodeBarang/{id}', [DetailKodeBarangController::class, 'editDetailKodeBarang'])->name('editDetailKodeBarang');
        Route::post('/admin/postTambahDetailKodeBarang', [DetailKodeBarangController::class, 'postTambahDetailKodeBarang'])->name('postTambahDetailKodeBarang');
        Route::get('/admin/postHapusDetailBarang/{id}', [DetailKodeBarangController::class, 'postHapusDetailKodeBarang'])->name('postHapusDetailBarang');
        Route::post('/admin/postEditDetailBarang/{id}', [DetailKodeBarangController::class, 'postEditDetailKodeBarang'])->name('postEditDetailBarang');
        Route::get('/admin/uploadDetailKodeBarangExcel', [DetailKodeBarangController::class, 'uploadDetailKodeBarangExcel'])->name('uploadDetailKodeBarangExcelShow');
        Route::get('/download-excel-kode-barang/{kode_barang_id}', function ($kode_barang_id) {
            return Excel::download(new DetailKodeBarangExport($kode_barang_id), 'detail_kode_barang.xlsx');
        })->name('downloadExcelDetailKodeBarang');
        Route::post('/upload-excel-kode-barang/{kode_barang_id}', function (Request $request, $kode_barang_id) {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);

            Excel::import(new DetailKodeBarangImport($kode_barang_id), $request->file('file'));

            return redirect()->route('detailKodeBarang', $request->kode_barang_id)->with('notif', 'Detail kode barang berhasil diupload!');
        })->name('uploadDetailKodeBarangExcel');

        // Jurusan
        Route::get('/admin/jurusan', [JurusanController::class, 'jurusan'])->name('jurusan');
        Route::get('/admin/tambahJurusan', [JurusanController::class, 'tambahJurusan'])->name('tambahJurusan');
        Route::get('/admin/editJurusan/{id}', [JurusanController::class, 'editJurusan'])->name('editJurusan');
        Route::post('/admin/postTambahJurusan', [JurusanController::class, 'postTambahJurusan'])->name('postTambahJurusan');
        Route::post('/admin/postEditJurusan/{id}', [JurusanController::class, 'postEditJurusan'])->name('postEditJurusan');
        Route::get('/admin/postHapusJurusan/{id}', [JurusanController::class, 'postHapusJurusan'])->name('postHapusJurusan');

        // Sumber Dana
        Route::get('/admin/dana', [DanaController::class, 'dana'])->name('dana');
        Route::get('/admin/tambahDana', [DanaController::class, 'tambahDana'])->name('tambahDana');
        Route::get('/admin/editDana/{id}', [DanaController::class, 'editDana'])->name('editDana');
        Route::post('/admin/postTambahDana', [DanaController::class, 'postTambahDana'])->name('postTambahDana');
        Route::post('/admin/postEditDana/{id}', [DanaController::class, 'postEditDana'])->name('postEditDana');
        Route::get('/admin/postHapusDana/{id}', [DanaController::class, 'postHapusDana'])->name('postHapusDana');

        // User
        Route::get('/admin/user', [UserController::class, 'user'])->name('user');
        Route::get('/admin/tambahUser', [UserController::class, 'tambahUser'])->name('tambahUser');
        Route::get('/admin/editUser/{id}', [UserController::class, 'editUser'])->name('editUser');
        Route::get('/adminresetpw/{id}', [UserController::class, 'resetpw'])->name('resetpw');
        Route::post('/admin/postTambahUser', [UserController::class, 'postTambahUser'])->name('postTambahUser');
        Route::get('/admin/postHapusUser/{id}', [UserController::class, 'postHapusUser'])->name('postHapusUser');
        Route::post('/admin/postEditUser/{id}', [UserController::class, 'postEditUser'])->name('postEditUser');
        Route::post('/admin/postResetPassword/{id}', [UserController::class, 'postResetPassword'])->name('postResetPassword');

        // Format
        Route::get('/admin/setting', [FormatController::class, 'setting'])->name('setting');
        Route::post('/admin/uploadFormatPengajuan', [FormatController::class, 'uploadFormatPengajuan'])->name('uploadFormatPengajuan');
        Route::post('/admin/uploadFormatPengambilan', [FormatController::class, 'uploadFormatPengambilan'])->name('uploadFormatPengambilan');
        Route::post('/admin/uploadFormatUploadPengajuan', [FormatController::class, 'uploadFormatUploadPengajuan'])->name('uploadFormatUploadPengajuan');

        // Dokumen
        Route::get('/admin/dokumen', [DokumenController::class, 'dokumen'])->name('dokumen');
        Route::get('/admin/lihatPengajuan/{userId}', [DokumenController::class, 'lihatPengajuan'])->name('lihatPengajuan');
        Route::get('/admin/lihatPengambilan/{userId}', [DokumenController::class, 'lihatPengambilan'])->name('lihatPengambilan');

        // Anggaran
        Route::get('/admin/tambahAnggaran/{id}', [AnggaranController::class, 'tambahAnggaran'])->name('tambahAnggaran');
        Route::post('admin/postTambahAnggaran/{id}', [AnggaranController::class, 'postTambahAnggaran'])->name('postTambahAnggaran');

        //nota permintaan
        Route::get('/admin/nomorVerifikasi', [NomorVerifikasiController::class, 'nomorVerifikasi'])->name('nomorVerifikasi');
        Route::get('/admin/detailNomorVerifikasi/{nomor_permintaan}', [NomorVerifikasiController::class, 'detailNomorVerifikasi'])->name('detailNomorVerifikasi');
        Route::get('/pengajuan/download/{nomor_permintaan}', [NomorVerifikasiController::class, 'downloadExcel'])->name('downloadNomorVerifikasiExcel');
        Route::get('/verifikasi/{nomor_permintaan}', [NomorVerifikasiController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/postVerifikasi/{nomor_permintaan}', [NomorVerifikasiController::class, 'postVerifikasi'])->name('postVerifikasi');

        //surat permintaan
        Route::get('/admin/suratPermintaan', [SuratPermintaanController::class, 'suratPermintaan'])->name('suratPermintaan');        
        Route::get('/admin/detailSuratPermintaan/{nomor_verifikasi}', [SuratPermintaanController::class, 'detailSuratPermintaan'])->name('detailSuratPermintaan');        
        Route::get('/admin/editDetailSuratPermintaan/{id}', [SuratPermintaanController::class, 'editDetailSuratPermintaan'])->name('editDetailSuratPermintaan');        
        Route::post('/admin/postEditDetailSuratPermintaan/{id}', [SuratPermintaanController::class, 'postEditDetailSuratPermintaan'])->name('postEditDetailSuratPermintaan');  
        Route::get('/download-surat-permintaan/{nomor_verifikasi}', [SuratPermintaanController::class, 'downloadSuratPermintaan'])->name('downloadSuratPermintaan');      

        //jenis barang
        Route::get('/admin/jenisBarang', [JenisBarangController::class, 'jenisBarang'])->name('jenisBarang');
        Route::get('/admin/tambahJenisBarang', [JenisBarangController::class, 'tambahJenisBarang'])->name('tambahJenisBarang');
        Route::get('/admin/editJenisBarang/{id}', [JenisBarangController::class, 'editJenisBarang'])->name('editJenisBarang');
        Route::get('/admin/postHapusJenisBarang/{id}', [JenisBarangController::class, 'postHapusJenisBarang'])->name('postHapusJenisBarang');
        Route::post('/admin/postEditJenisBarang/{id}', [JenisBarangController::class, 'postEditJenisBarang'])->name('postEditJenisBarang');
        Route::post('/admin/postTambahJenisBarang', [JenisBarangController::class, 'postTambahJenisBarang'])->name('postTambahJenisBarang');

        //sppb
        Route::get('/admin/sppb', [SppbController::class, 'sppb'])->name('sppb');
        Route::get('/admin/bast', [SppbController::class, 'bast'])->name('bast');
        Route::get('/admin/pengeluaran', [SppbController::class, 'pengeluaran'])->name('pengeluaran');
        Route::get('/admin/detailSppb/{nomor_verifikasi}', [SppbController::class, 'detailSppb'])->name('detailSppb');
        Route::get('/admin/detailBast/{nomor_verifikasi}', [SppbController::class, 'detailBast'])->name('detailBast');
        Route::get('/admin/downloadSPPB/{nomor_verifikasi}', [SppbController::class, 'downloadSPPB'])->name('downloadSPPB');
        Route::get('/admin/downloadBast/{nomor_verifikasi}', [SppbController::class, 'downloadBast'])->name('downloadBast');
        Route::get('/download-excel', [PengeluaranController::class, 'downloadExcel'])->name('download.excelp');

        //kartu persediaan
        Route::get('/admin/kartuPersediaan', [KartuPersediaanController::class, 'kartuPersediaan'])->name('kartuPersediaan');
    });
});
