<?php

namespace Database\Seeders;

use App\Models\Detail;
use App\Models\Format;
use App\Models\FormatPengajuan;
use App\Models\FormatPengambilan;
use App\Models\FormatUploadPengajuan;
use App\Models\Jurusan;
use App\Models\Pengajuan;
use App\Models\SumberDana;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'role' => 'admin',
            'foto' => 'img/profile.jpg',
            'password' => bcrypt('admin')
        ]);

        User::create([
            'name' => 'akl',
            'username' => 'akl',
            'foto' => 'img/profile.jpg',
            'role' => 'Akutansi Keuangan Lembaga',
            'password' => bcrypt('akl')
        ]);

        User::create([
            'name' => 'bdp',
            'username' => 'bdp',
            'foto' => 'img/profile.jpg',
            'role' => 'Bisnis Daring Pemasaran',
            'password' => bcrypt('bdp')
        ]);

        User::create([
            'name' => 'otkp',
            'username' => 'otkp',
            'foto' => 'img/profile.jpg',
            'role' => 'Otomatisasi Tata Kelola Perkantoran',
            'password' => bcrypt('otkp')
        ]);

        User::create([
            'name' => 'tkj',
            'username' => 'tkj',
            'foto' => 'img/profile.jpg',
            'role' => 'Teknik Jaringan Komputer',
            'password' => bcrypt('tkj')
        ]);

        User::create([
            'name' => 'rpl',
            'username' => 'rpl',
            'foto' => 'img/profile.jpg',
            'role' => 'Rekayasa Perangkat Lunak',
            'password' => bcrypt('rpl')
        ]);

        User::create([
            'name' => 'waka kurikulum',
            'username' => 'waka kurikulum',
            'foto' => 'img/profile.jpg',
            'role' => 'waka kurikulum',
            'password' => bcrypt('waka kurikulum')
        ]);

        User::create([
            'name' => 'waka sarpras',
            'foto' => 'img/profile.jpg',
            'username' => 'waka sarpras',
            'role' => 'waka sarpras',
            'password' => bcrypt('waka sarpras')
        ]);

        User::create([
            'name' => 'waka hubin',
            'username' => 'waka hubin',
            'foto' => 'img/profile.jpg',
            'role' => 'waka hubin',
            'password' => bcrypt('waka hubin')
        ]);

        User::create([
            'name' => 'waka kesiswaan',
            'username' => 'waka kesiswaan',
            'foto' => 'img/profile.jpg',
            'role' => 'waka kesiswaan',
            'password' => bcrypt('waka kesiswaan')
        ]);

        User::create([
            'name' => 'waka evbank',
            'username' => 'waka evbank',
            'foto' => 'img/profile.jpg',
            'role' => 'waka evbank',
            'password' => bcrypt('waka evbank')
        ]);

        Jurusan::create([
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'user_id' => '1'
        ]);

        Jurusan::create([
            'jurusan' => 'Teknik Jaringan Komputer',
            'user_id' => '1'
        ]);

        Jurusan::create([
            'jurusan' => 'Otomatisasi Tata Kelola Perkantoran',
            'user_id' => '1'
        ]);

        Jurusan::create([
            'jurusan' => 'Bisnis Daring Pemasaran',
            'user_id' => '1'
        ]);

        Jurusan::create([
            'jurusan' => 'Akutansi Keuangan Lembaga',
            'user_id' => '1'
        ]);

        Jurusan::create([
            'jurusan' => 'waka kurikulum',
            'user_id' => '1'
        ]);

        Jurusan::create([
            'jurusan' => 'waka sarpras',
            'user_id' => '1'
        ]);

        Jurusan::create([
            'jurusan' => 'waka hubin',
            'user_id' => '1'
        ]);

        Jurusan::create([
            'jurusan' => 'waka kesiswaan',
            'user_id' => '1'
        ]);

        Jurusan::create([
            'jurusan' => 'waka evbank',
            'user_id' => '1'
        ]);

        SumberDana::create([
            'sumber_dana' => 'BOS',
            'user_id' => '1'
        ]);

        SumberDana::create([
            'sumber_dana' => 'BOPD',
            'user_id' => '1'
        ]);

        SumberDana::create([
            'sumber_dana' => 'Lainnya',
            'user_id' => '1'
        ]);

        Format::create([
            'format_pengajuan_file' => 'document/format_pengajuan.docx',
            'format_pengambilan_file' => 'document/format_pengambilan.docx',
            'user_id' => 1,
        ]);

        FormatPengajuan::create([
            'format_pengajuan_file' => 'document/format_pengajuan.docx',
            'user_id' => 1,
        ]);

        FormatPengambilan::create([
            'format_pengambilan_file' => 'document/format_pengambilan.docx',
            'user_id' => 1,
        ]);

        FormatUploadPengajuan::create([
            'format_upload_pengajuan_file' => 'document/format_upload_pengajuan.xlsx',
            'user_id' => 1,
        ]);
    }
}
