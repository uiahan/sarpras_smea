@extends('layout.master')
@section('title', 'Validasi')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-6">
                        <h3 class="fw-bold text-secondary">Validasi</h3>
                    </div>
                    <div class="col-6">
                        <p class="text-muted text-end text-secondary">Validasi &gt; Home</p>
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
                    <div class="col-md-4">
                        <h4 class="me-auto text-secondary">Tabel Validasi Pengajuan</h4>
                    </div>
                </div>
                <hr>
                <form action="{{ route('validasi') }}" method="GET">
                    <div class="row">
                        <div class="col-xl-6 col-12 mb-3">
                            <label for="tanggal_awal">Tanggal awal</label>
                            <input type="date" name="tanggal_awal" class="form-control border-0"
                                value="{{ $filters['tanggal_awal'] ?? '' }}" style="background-color: #ededed">
                        </div>
                        <div class="col-xl-6 col-12 mb-3">
                            <label for="tanggal_akhir">Tanggal akhir</label>
                            <input type="date" name="tanggal_akhir" class="form-control border-0"
                                value="{{ $filters['tanggal_akhir'] ?? '' }}" style="background-color: #ededed">
                        </div>
                        <div class="col-xl-4 col-12 mt-xl-0">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control border-0"
                                style="background-color: #ededed">
                                <option value="" disabled {{ request('status') == '' ? 'selected' : '' }}>Pilih Status
                                </option>
                                <option value="Diajukan" {{ request('status') == 'Diajukan' ? 'selected' : '' }}>Diajukan
                                </option>
                                <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima
                                </option>
                                <option value="Diperbaiki" {{ request('status') == 'Diperbaiki' ? 'selected' : '' }}>
                                    Diperbaiki</option>
                                <option value="Dibelikan" {{ request('status') == 'Dibelikan' ? 'selected' : '' }}>Dibelikan
                                </option>
                                <option value="Di Sarpras" {{ request('status') == 'Di Sarpras' ? 'selected' : '' }}>Di
                                    Sarpras</option>
                                <option value="Dijurusan" {{ request('status') == 'Dijurusan' ? 'selected' : '' }}>Dijurusan
                                </option>
                                <option value="Rusak" {{ request('status') == 'Rusak' ? 'selected' : '' }}>Rusak
                                </option>
                            </select>
                        </div>
                        <div class="col-xl-4 col-12 mt-xl-0 mt-3">
                            <label for="jurusan">Jurusan</label>
                            <select name="jurusan" id="jurusan" class="form-control border-0"
                                style="background-color: #ededed">
                                <option value="" disabled {{ old('jurusan') ? '' : 'selected' }}>Pilih Jurusan</option>
                                @foreach ($jurusan as $item)
                                    <option value="{{ $item->jurusan }}" {{ old('jurusan') == $item->id ? 'selected' : '' }}>
                                        {{ $item->jurusan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-4 col-12 d-flex align-items-end mt-xl-0 mt-3">
                            <button type="submit" class="text-white btn-merah btn w-100 btn-tambah-nasabah"
                                style="background-color: #d9261c">
                                <i class="fa-solid fa-filter me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive pb-2">
                    <table class="table" id="example">
                        <thead style="background-color: #f2f2f2">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama barang</th>
                                <th scope="col">Spesifikasi nama barang</th>
                                <th scope="col">Satuan barang</th>
                                <th scope="col">Kode barang</th>
                                <th scope="col">NUSP</th>
                                <th scope="col">Keperluan</th>
                                <th scope="col">Jenis barang</th>
                                <th scope="col">Nomor permintaan</th>
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
                                <th scope="col">catatan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #f2f2f2">
                            @foreach ($pengajuan as $item)
                                <tr>
                                
                                    <td style="vertical-align: middle;" scope="row">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: middle;">
                                        @if ($item->nama_barang)
                                            {{ $item->nama_barang }}
                                        @else
                                            <span class="text-danger">Belum Dimasukan</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle;">{{ $item->barang }}</td>
                                    <td style="vertical-align: middle;">
                                        @if ($item->satuan_barang)
                                            {{ $item->satuan_barang }}
                                        @else
                                            <span class="text-danger">Belum Dimasukan</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle;">
                                        @if ($item->kode_barang)
                                            {{ $item->kode_barang }}
                                        @else
                                            <span class="text-danger">Belum Dimasukan</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle;">
                                        @if ($item->nusp)
                                            {{ $item->nusp }}
                                        @else
                                            <span class="text-danger">Belum Dimasukan</span>
                                        @endif
                                    </td>
                                    
                                    <td style="vertical-align: middle;">
                                        @if ($item->keperluan)
                                            {{ $item->keperluan }}
                                        @else
                                            <span class="text-danger">Belum Dimasukan</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle;">
                                        @if ($item->jenis_barang)
                                            {{ $item->jenis_barang }}
                                        @else
                                            <span class="text-danger">Belum Dimasukan</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle;">
                                        @if ($item->nomor_permintaan)
                                            {{ $item->nomor_permintaan }}
                                        @else
                                            <span class="text-danger">Belum Dimasukan</span>
                                        @endif
                                    </td>
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
                                    <td style="vertical-align: middle;">@if ($item->catatan)
                                        {{ ($item->catatan) }}
                                    @else
                                        <span class="text-danger">Tidak Ada Catatan</span>
                                    @endif</td>
                                    <td style="vertical-align: middle;">{{ $item->status }}</td>
                                    <td style="vertical-align: middle;">
                                        <div class="d-flex">
                                            <a href="{{ route('detail', $item->id) }}" class="btn btn-primary"
                                                style="padding: 12px 15px;">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <a href="{{ route('konfirmasi', $item->id) }}" class="btn btn-success ms-1"
                                                style="padding: 12px 15px;">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="{{ route('downloadPengambilan', $item->id) }}" class="btn ms-1 btn-warning text-white"
                                                style="padding: 12px 15px;">
                                                <i class="fa-solid fa-download"></i>
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

    .btn-warning {
        -webkit-box-shadow: 0px 0px 5px 0px #ffc108;
        -moz-box-shadow: 0px 0px 5px 0px #ffc108;
        box-shadow: 0px 0px 5px 0px #ffc108;
        Copy Text
    }
</style>
