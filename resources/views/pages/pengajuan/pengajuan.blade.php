@extends('layout.master')
@section('title', 'Pengajuan')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-6">
                        <h3 class="fw-bold text-secondary">Pengajuan</h3>
                    </div>
                    <div class="col-6">
                        <p class="text-muted text-xl-end text-secondary">Pengajuan &gt; Home</p>
                    </div>
                </div>
            </div>

            <div class="card card-nasabah count-card border-0 mt-4 shadow" style="background-color: #d9261c">
                <div class="row px-3 py-4">
                    <div class="col-7 text-white">
                        <h5>Total Pengajuan:</h5>
                        <h1 class="px-3">{{ $pengajuanCount }}</h1>
                    </div>
                    <div class="col-5 d-flex align-items-center" style="height: 100%;">
                        <i class='fa-solid fa-book-bookmark nav_icon text-white' style="font-size: 5rem"></i>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4 p-4 shadow">
                <div class="row">
                    <div class="col-md-3">
                        <h4 class="me-auto text-secondary">Tabel Pengajuan</h4>
                    </div>
                    <div class="col-md-9 d-flex justify-content-end d-none d-xl-block">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('downloadFormatPengajuan') }}" class="btn rounded-4 text-white btn-kuning"
                                style="background-color: #edbb05">
                                <i class="fa-solid fa-download"></i> Download format ajuan
                            </a>
                            <div class="btn-group">
                                <button type="button" class="btn ms-2 rounded-4 text-white btn-kuning dropdown-toggle"
                                    style="background-color: #edbb05" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-upload"></i> Pengajuan
                                </button>
                                <ul class="dropdown-menu">
                                    @if ($user->role == 'admin')
                                        <li class="mt-1">
                                            <a class="dropdown-item" href="{{ route('dokumen') }}">
                                                <i class="fa-solid fa-eye"></i> Lihat
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <a class="dropdown-item" href="{{ route('uploadPengajuan') }}">
                                                <i class="fa-solid fa-upload"></i> Upload
                                            </a>
                                        </li>
                                        <li class="mt-1">
                                            <a class="dropdown-item" href="{{ route('downloadPengajuan') }}">
                                                <i class="fa-solid fa-eye"></i> Lihat
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <a href="{{ route('tambahPengajuan') }}" class="btn ms-2 rounded-4 text-white btn-kuning"
                                style="background-color: #edbb05">
                                <i class="fa-solid fa-code-pull-request"></i> Tambah pengajuan
                            </a>
                            <a href="{{ route('downloadExcelPengajuan') }}" class="btn ms-2 rounded-4 text-white btn-primary">
                                <i class="fa-solid fa-file-excel"></i> Download Excel
                            </a>
                            <a href="{{ route('uploadExcel') }}" class="btn btn-success ms-2 rounded-4 text-white">
                                <i class="fa-solid fa-file-excel"></i> Upload Excel
                            </a>
                        </div>
                    </div>

                    <div class="col-md-12 d-block d-xl-none">
                        <div>
                            <a href="{{ route('download.pengajuan') }}"
                                class="btn mt-3 w-100 rounded-4 text-white btn-kuning" style="background-color: #edbb05">
                                <i class="fa-solid fa-download"></i> Download format ajuan
                            </a>
                            <div class="btn-group w-100">
                                <button type="button" class="btn mt-3 rounded-4 text-white btn-kuning dropdown-toggle"
                                    style="background-color: #edbb05" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-upload"></i> Pengajuan
                                </button>
                                <ul class="dropdown-menu">
                                    @if ($user->role == 'admin')
                                        <li class="mt-1">
                                            <a class="dropdown-item" href="{{ route('dokumen') }}">
                                                <i class="fa-solid fa-eye"></i> Lihat
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <a class="dropdown-item" href="{{ route('uploadPengajuan') }}">
                                                <i class="fa-solid fa-upload"></i> Upload
                                            </a>
                                        </li>
                                        <li class="mt-1">
                                            <a class="dropdown-item" href="{{ route('downloadPengajuan') }}">
                                                <i class="fa-solid fa-eye"></i> Lihat
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <a href="{{ route('tambahPengajuan') }}" class="btn mt-3 w-100 rounded-4 text-white btn-kuning"
                                style="background-color: #edbb05">
                                <i class="fa-solid fa-code-pull-request"></i> Tambah pengajuan
                            </a>
                            <a href="{{ route('downloadExcelPengajuan') }}" class="btn mt-3 w-100 rounded-4 text-white btn-primary">
                                <i class="fa-solid fa-file-excel"></i> Download Excel
                            </a>
                            <a href="{{ route('uploadExcel') }}" class="btn btn-success mt-3 w-100 rounded-4 text-white">
                                <i class="fa-solid fa-file-excel"></i> Upload Excel
                            </a>
                        </div>
                    </div>

                </div>
                <hr>
                <form action="{{ route('pengajuan') }}" method="GET">
                    <div class="row">
                        @if ($user->role == 'admin')
                            <div class="col-xl-6 col-12">
                                <label for="tanggal_awal">Tanggal awal</label>
                                <input type="date" name="tanggal_awal" class="form-control border-0"
                                    value="{{ $filters['tanggal_awal'] ?? '' }}" style="background-color: #ededed">
                            </div>
                            <div class="col-xl-6 col-12">
                                <label for="tanggal_akhir">Tanggal akhir</label>
                                <input type="date" name="tanggal_akhir" class="form-control border-0"
                                    value="{{ $filters['tanggal_akhir'] ?? '' }}" style="background-color: #ededed">
                            </div>
                            <div class="col-xl-4 col-12 mt-xl-3 mt-0">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control border-0"
                                    style="background-color: #ededed">
                                    <option value="" disabled {{ request('status') == '' ? 'selected' : '' }}>
                                        Pilih Status
                                    </option>
                                    <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>
                                        Diterima
                                    </option>
                                    <option value="Diperbaiki" {{ request('status') == 'Diperbaiki' ? 'selected' : '' }}>
                                        Diperbaiki</option>
                                    <option value="Dibelikan" {{ request('status') == 'Dibelikan' ? 'selected' : '' }}>
                                        Dibelikan
                                    </option>
                                    <option value="Di Sarpras" {{ request('status') == 'Di Sarpras' ? 'selected' : '' }}>
                                        Di
                                        Sarpras</option>
                                    <option value="Dijurusan" {{ request('status') == 'Dijurusan' ? 'selected' : '' }}>
                                        Dijurusan
                                    </option>
                                </select>
                            </div>
                            <div class="col-xl-4 col-12 mt-xl-3">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control border-0"
                                    style="background-color: #ededed">
                                    <option value="" disabled {{ old('jurusan') ? '' : 'selected' }}>Pilih Jurusan
                                    </option>
                                    @foreach ($jurusan as $item)
                                        <option value="{{ $item->jurusan }}"
                                            {{ old('jurusan') == $item->id ? 'selected' : '' }}>
                                            {{ $item->jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-4 col-12 d-flex align-items-end mt-xl-0 mt-4">
                                <button type="submit" class="text-white btn-merah btn w-100 btn-tambah-nasabah"
                                    style="background-color: #d9261c">
                                    <i class="fa-solid fa-filter me-2"></i>Filter
                                </button>
                            </div>
                        @else
                            <div class="col-xl-3 col-12">
                                <label for="tanggal_awal">Tanggal awal</label>
                                <input type="date" name="tanggal_awal" class="form-control border-0"
                                    value="{{ $filters['tanggal_awal'] ?? '' }}" style="background-color: #ededed">
                            </div>
                            <div class="col-xl-3 col-12 mt-xl-0 mt-2">
                                <label for="tanggal_akhir">Tanggal akhir</label>
                                <input type="date" name="tanggal_akhir" class="form-control border-0"
                                    value="{{ $filters['tanggal_akhir'] ?? '' }}" style="background-color: #ededed">
                            </div>
                            <div class="col-xl-3 col-12 mt-xl-0 mt-2">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control border-0"
                                    style="background-color: #ededed">
                                    <option value="" disabled {{ request('status') == '' ? 'selected' : '' }}>
                                        Pilih Status
                                    </option>
                                    <option value="Diajukan" {{ request('status') == 'Diajukan' ? 'selected' : '' }}>
                                        Diajukan
                                    </option>
                                    <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>
                                        Diterima
                                    </option>
                                    <option value="Diperbaiki" {{ request('status') == 'Diperbaiki' ? 'selected' : '' }}>
                                        Diperbaiki</option>
                                    <option value="Dibelikan" {{ request('status') == 'Dibelikan' ? 'selected' : '' }}>
                                        Dibelikan
                                    </option>
                                    <option value="Di Sarpras" {{ request('status') == 'Di Sarpras' ? 'selected' : '' }}>
                                        Di
                                        Sarpras</option>
                                    <option value="Dijurusan" {{ request('status') == 'Dijurusan' ? 'selected' : '' }}>
                                        Dijurusan
                                    </option>
                                    <option value="Rusak" {{ request('rusak') == 'Rusak' ? 'selected' : '' }}>
                                        Rusak
                                    </option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-12 d-flex align-items-end mt-xl-0 mt-4">
                                <button type="submit" class="text-white btn-merah btn w-100 btn-tambah-nasabah"
                                    style="background-color: #d9261c">
                                    <i class="fa-solid fa-filter me-2"></i>Filter
                                </button>
                            </div>
                        @endif
                    </div>
                </form>
                <div class="table-responsive pb-2">
                    <table class="table" id="example">
                        <thead style="background-color: #f2f2f2">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Spesifikasi nama barang</th>
                                <th scope="col">Program kegiatan</th>
                                <th scope="col">Jurusan</th>
                                <th scope="col">Tanggal ajuan</th>
                                <th scope="col">Tanggal realisasi</th>
                                <th scope="col">Harga satuan</th>
                                <th scope="col">Tahun</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Total harga</th>
                                <th scope="col">Harga beli</th>
                                <th scope="col">Sumber dana</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Keperluan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #f2f2f2">
                            @foreach ($pengajuan as $item)
                                <tr>
                                    <td style="vertical-align: middle;" scope="row">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: middle;">{{ $item->barang }}</td>
                                    <td style="vertical-align: middle;">{{ $item->program_kegiatan }}</td>
                                    <td style="vertical-align: middle;">{{ $item->jurusan }}</td>
                                    <td style="vertical-align: middle;">{{ $item->tanggal_ajuan }}</td>
                                    <td style="vertical-align: middle;">
                                        @if ($item->tanggal_realisasi)
                                            {{ $item->tanggal_realisasi }}
                                        @else
                                            <span class="text-danger">Belum Ditentukan</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle;">
                                        {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td style="vertical-align: middle;">{{ $item->tahun }}</td>
                                    <td style="vertical-align: middle;">{{ $item->banyak }}</td>
                                    <td style="vertical-align: middle;">
                                        {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    <td style="vertical-align: middle;">
                                        @if ($item->harga_beli)
                                            {{ number_format($item->harga_beli, 0, ',', '.') }}
                                        @else
                                            <span class="text-danger">Belum Dimasukan</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle;">{{ $item->sumber_dana }}</td>
                                    <td style="vertical-align: middle;">{{ $item->keterangan }}</td>
                                    <td style="vertical-align: middle;">{{ $item->keperluan }}</td>
                                    <td style="vertical-align: middle;">{{ $item->status }}</td>
                                    <td style="vertical-align: middle;">
                                        <div class="d-flex">
                                            <a href="{{ route('detail', $item->id) }}" class="btn btn-primary"
                                                style="padding: 12px 15px;">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <a href="{{ route('editPengajuan', $item->id) }}"
                                                class="btn btn-success ms-1" style="padding: 12px 15px;">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="{{ route('postHapusPengajuan', $item->id) }}"
                                                class="btn text-white ms-1 btn-merah"
                                                style="padding: 12px 15px; background-color:#d9261c;"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.css">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>
    <script>
        new DataTable('#example');

        console.log("Session Notification: {{ session('notif') }}");
    </script>
@endsection
<style>
    .toast {
        opacity: 1.0 !important;
        background-color: #00983d !important;
        padding: 15px 20px;
        margin: 10px;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }

    .toast:hover {
        transform: scale(1.01);
    }

    .toast .toast-message {
        color: #ffffff;
    }

    @media (min-width: 768px) {
        .count-card {
            width: 50% !important;
        }
    }

    @media (min-width: 992px) {
        .count-card {
            width: 30% !important;
        }
    }

    .img-news {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    .content-shifted {
        margin-left: 250px;
        transition: margin-left 0.3s ease;
    }

    .sidebar {
        width: 250px;
    }

    .btn-primary {
        -webkit-box-shadow: 0px 0px 5px 0px rgba(13, 109, 252, 1);
        -moz-box-shadow: 0px 0px 5px 0px rgba(13, 109, 252, 1);
        box-shadow: 0px 0px 5px 0px rgba(13, 109, 252, 1);
    }

    .btn-merah {
        -webkit-box-shadow: 0px 0px 5px 0px #d9261c;
        -moz-box-shadow: 0px 0px 5px 0px #d9261c;
        box-shadow: 0px 0px 5px 0px #d9261c;
        Copy Text
    }

    .btn-success {
        -webkit-box-shadow: 0px 0px 5px 0px #00752f;
        -moz-box-shadow: 0px 0px 5px 0px #00752f;
        box-shadow: 0px 0px 5px 0px #00752f;
        Copy Text
    }

    .btn-kuning {
        -webkit-box-shadow: 0px 0px 5px 0px #edbb05;
        -moz-box-shadow: 0px 0px 5px 0px #edbb05;
        box-shadow: 0px 0px 5px 0px #edbb05;
        Copy Text
    }
</style>
