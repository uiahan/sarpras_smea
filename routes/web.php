<?php

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
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidasiController;
use App\Models\Format;
use App\Models\SumberDana;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/postLogin', [AuthController::class, 'postLogin'])->name('postLogin');

Route::middleware('auth')->group(function () {
    //pengajuan
    Route::get('/pengajuan', [PengajuanController::class, 'pengajuan'])->name('pengajuan');
    Route::get('/tambahPengajuan', [PengajuanController::class, 'tambahPengajuan'])->name('tambahPengajuan');
    Route::get('/uploadPengajuan', [PengajuanController::class, 'uploadPengajuan'])->name('uploadPengajuan');
    Route::get('/editPengajuan/{id}', [PengajuanController::class, 'editPengajuan'])->name('editPengajuan');
    Route::post('/postEditPengajuan/{id}', [PengajuanController::class, 'postEditPengajuan'])->name('postEditPengajuan');
    Route::get('/postHapusPengajuan/{id}', [PengajuanController::class, 'postHapusPengajuan'])->name('postHapusPengajuan');
    Route::post('/postTambahPengajuan', [PengajuanController::class, 'postTambahPengajuan'])->name('postTambahPengajuan');

    //detail
    Route::get('/detail/{pengajuan}', [DetailController::class, 'detail'])->name('detail');
    Route::get('/tambahDetail', [DetailController::class, 'tambahDetail'])->name('tambahDetail');
    Route::get('/editDetail/{id}', [DetailController::class, 'editDetail'])->name('editDetail');
    Route::post('/postEditDetail/{id}', [DetailController::class, 'postEditDetail'])->name('postEditDetail');
    Route::post('/postTambahDetail', [DetailController::class, 'postTambahDetail'])->name('postTambahDetail');
    Route::get('/postHapusDetail/{id}', [DetailController::class, 'postHapusDetail'])->name('postHapusDetail');

    //pengambilan
    Route::get('/pengambilan', [PengambilanController::class, 'pengambilan'])->name('pengambilan');
    Route::get('/uploadPengambilan', [PengambilanController::class, 'uploadPengambilan'])->name('uploadPengambilan');
    Route::post('/ubahStatus/{id}', [PengambilanController::class, 'ubahStatus'])->name('ubahStatus');

    //validasi
    Route::get('/validasi', [ValidasiController::class, 'validasi'])->name('validasi');
    Route::get('/konfirmasi/{id}', [ValidasiController::class, 'konfirmasi'])->name('konfirmasi');
    Route::post('/update/{id}', [ValidasiController::class, 'update'])->name('update');

    //jurusan
    Route::get('/jurusan', [JurusanController::class, 'jurusan'])->name('jurusan');
    Route::get('/tambahJurusan', [JurusanController::class, 'tambahJurusan'])->name('tambahJurusan');
    Route::get('/editJurusan/{id}', [JurusanController::class, 'editJurusan'])->name('editJurusan');
    Route::post('/postTambahJurusan', [JurusanController::class, 'postTambahJurusan'])->name('postTambahJurusan');
    Route::post('/postEditJurusan/{id}', [JurusanController::class, 'postEditJurusan'])->name('postEditJurusan');
    Route::get('/postHapusJurusan/{id}', [JurusanController::class, 'postHapusJurusan'])->name('postHapusJurusan');

    //sumber dana
    Route::get('/dana', [DanaController::class, 'dana'])->name('dana');
    Route::get('/tambahDana', [DanaController::class, 'tambahDana'])->name('tambahDana');
    Route::get('/editDana/{id}', [DanaController::class, 'editDana'])->name('editDana');
    Route::post('/postTambahDana', [DanaController::class, 'postTambahDana'])->name('postTambahDana');
    Route::post('/postEditDana/{id}', [DanaController::class, 'postEditDana'])->name('postEditDana');
    Route::get('/postHapusDana/{id}', [DanaController::class, 'postHapusDana'])->name('postHapusDana');

    //user
    Route::get('/user', [UserController::class, 'user'])->name('user');
    Route::get('/tambahUser', [UserController::class, 'tambahUser'])->name('tambahUser');
    Route::get('/editUser/{id}', [UserController::class, 'editUser'])->name('editUser');
    Route::get('/resetpw/{id}', [UserController::class, 'resetpw'])->name('resetpw');
    Route::post('/postTambahUser', [UserController::class, 'postTambahUser'])->name('postTambahUser');
    Route::get('/postHapusUser/{id}', [UserController::class, 'postHapusUser'])->name('postHapusUser');
    Route::post('/postEditUser/{id}', [UserController::class, 'postEditUser'])->name('postEditUser');
    Route::post('/postResetPassword/{id}', [UserController::class, 'postResetPassword'])->name('postResetPassword');

    //format
    Route::get('/setting', [FormatController::class, 'setting'])->name('setting');
    Route::post('/uploadFormat', [FormatController::class, 'uploadFormat'])->name('uploadFormat');

    //upload
    Route::post('/uploadFile', [UploadController::class, 'uploadFile'])->name('uploadFile');
    Route::post('/uploadFilePengambilan', [UploadController::class, 'uploadFilePengambilan'])->name('uploadFilePengambilan');
    Route::get('/downloadPengajuan', [UploadController::class, 'downloadPengajuan'])->name('downloadPengajuan');
    Route::get('/downloadPengambilan', [UploadController::class, 'downloadPengambilan'])->name('downloadPengambilan');

    //dokumen
    Route::get('/dokumen', [DokumenController::class, 'dokumen'])->name('dokumen');
    Route::get('/lihatPengajuan/{userId}', [DokumenController::class, 'lihatPengajuan'])->name('lihatPengajuan');
    Route::get('/lihatPengambilan/{userId}', [DokumenController::class, 'lihatPengambilan'])->name('lihatPengambilan');

    //anggaran
    Route::get('/dashboard', [AnggaranController::class, 'dashboard'])->name('dashboard');
    Route::get('/tambahAnggaran/{id}', [AnggaranController::class, 'tambahAnggaran'])->name('tambahAnggaran');
    Route::post('/postTambahAnggaran/{id}', [AnggaranController::class, 'postTambahAnggaran'])->name('postTambahAnggaran');

    //pdf
    Route::get('/pengajuan/download-pdf', [PengajuanController::class, 'downloadPDF'])->name('pengajuan.downloadPDF');

    //download format
    Route::get('/download/format-pengajuan', [FormatController::class, 'downloadPengajuan'])->name('download.pengajuan');
    Route::get('/download/format-pengambilan', [FormatController::class, 'downloadPengambilan'])->name('download.pengambilan');
});
