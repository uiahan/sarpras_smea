@extends('layout.master')
@section('title', 'Pengeluaran')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-6">
                        <h3 class="fw-bold text-secondary">Pengeluaran</h3>
                    </div>
                    <div class="col-6">
                        <p class="text-muted text-xl-end text-secondary">Pengeluaran &gt; Home</p>
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
                            <a href="{{ route('download.excelp') }}" class="btn rounded-4 text-white btn-kuning" style="background-color: #edbb05">
                                <i class="fa-solid fa-download"></i> Download Excel
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 d-block d-xl-none">
                        <div>
                            <a href="{{ route('download.excelp') }}" class="btn mt-3 w-100 rounded-4 text-white btn-kuning"
                                style="background-color: #edbb05">
                                <i class="fa-solid fa-download"></i> Download Excel
                            </a>

                        </div>
                    </div>
                </div>
                <hr>
                <form action="{{ route('pengeluaran') }}" method="GET">
                    <div class="row">
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

                        <div class="col-xl-6 col-12 mt-xl-3">
                            <label for="role">Jurusan</label>
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
                        <div class="col-xl-6 col-12 d-flex align-items-end mt-xl-0 mt-4">
                            <button type="submit" class="text-white btn-merah btn w-100 btn-tambah-nasabah"
                                style="background-color: #d9261c">
                                <i class="fa-solid fa-filter me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive pb-2">
                    <table class="table table-bordered" id="example">
                        <thead style="background-color: #f2f2f2">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">NO</th>
                                <th colspan="2" style="vertical-align: middle; text-align:center;">BAST</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">Kode Barang</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">Nama Barang</th>
                                <th colspan="2" style="vertical-align: middle; text-align:center;">Spesifikasi Barang
                                </th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">Jumlah</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">Satuan Barang</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">Harga Satuan Barang
                                </th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">Total Harga</th>
                                <th colspan="2" style="vertical-align: middle; text-align:center;">SPPB</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">Penerima</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">Keterangan</th>
                            </tr>
                            <tr>
                                <th style="vertical-align: middle; text-align:center;">Tanggal Realisasi</th>
                                <th style="vertical-align: middle; text-align:center;">Nomor Verif</th>
                                <th style="vertical-align: middle; text-align:center;">NUSP</th>
                                <th style="vertical-align: middle; text-align:center;">Spesifikasi Nama Barang</th>
                                <th style="vertical-align: middle; text-align:center;">Tanggal Realisasi</th>
                                <th style="vertical-align: middle; text-align:center;">Nomor Permintaan</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #f2f2f2">
                            @foreach ($pengajuan as $item)
                                <tr>
                                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: middle;">{{ $item->tanggal_realisasi }}</td>
                                    <td style="vertical-align: middle;">{{ $item->nomor_verifikasi }}</td>
                                    <td style="vertical-align: middle;">{{ $item->kode_barang }}</td>
                                    <td style="vertical-align: middle;">{{ $item->nama_barang }}</td>
                                    <td style="vertical-align: middle;">{{ $item->nusp }}</td>
                                    <td style="vertical-align: middle;">{{ $item->barang }}</td>
                                    <td style="vertical-align: middle;">{{ $item->banyak }}</td>
                                    <td style="vertical-align: middle;">{{ $item->satuan_barang }}</td>
                                    <td class="td-harga">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td style="vertical-align: middle;">{{ $item->total_harga }}</td>
                                    <td style="vertical-align: middle;">{{ $item->tanggal_realisasi }}</td>
                                    <td style="vertical-align: middle;">{{ $item->nomor_permintaan }}</td>
                                    <td style="vertical-align: middle;">{{ $item->jurusan }}</td>
                                    <td style="vertical-align: middle;">{{ $item->keterangan }}</td>
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

    .td-harga {
        max-width: 150px;
        /* Batas lebar kolom */
        white-space: nowrap;
        /* Mencegah teks membungkus ke bawah */
        overflow: hidden;
        /* Sembunyikan bagian teks yang melampaui batas */
        text-overflow: ellipsis;
        /* Tampilkan '...' jika teks terpotong */
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
