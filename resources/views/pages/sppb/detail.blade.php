@extends('layout.master')
@section('title', 'Detail SPPB')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-6">
                        <h3 class="fw-bold text-secondary">Detail Surat Perintah Penyaluran Barang</h3>
                    </div>
                    <div class="col-6">
                        <p class="text-muted text-xl-end text-secondary">SPPB &gt; Detail</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4 p-4 shadow">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="me-auto text-secondary">Nomor Verifikasi: {{ $nomor_verifikasi }}</h4>
                        <h6 class="me-auto text-secondary">Periode: {{ $selectedPengajuan->tahun }}</h6>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end d-none d-xl-block">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('sppb') }}" class="btn ms-2 rounded-4 text-white btn-kuning"
                                style="background-color: #edbb05">
                                Kembali <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 d-block d-xl-none">
                        <div>
                            <a href="{{ route('sppb') }}" class="btn mt-3 w-100 rounded-4 text-white btn-kuning"
                                style="background-color: #edbb05">
                                Kembali <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="table-responsive pb-2">
                    <table class="table table-bordered" id="example">
                        <thead style="background-color: #f2f2f2">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">No</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">Kode Barang</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">Nama Barang</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">Spesifikasi Nama Barang</th>
                                <th colspan="2" style="vertical-align: middle; text-align:center;"  >Pengajuan Permintaan</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">Keterangan Nama Barang</th>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <th>Satuan Barang</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #f2f2f2">
                            @foreach ($pengajuan as $item)
                                <tr>
                                    <td style="vertical-align: middle;" scope="row">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: middle;">{{ $item->kode_barang }}</td>
                                    <td style="vertical-align: middle;">{{ $item->nama_barang }}</td>
                                    <td style="vertical-align: middle;">{{ $item->barang }}</td>
                                    <td style="vertical-align: middle;">{{ $item->jumlah_yg_diacc }}</td>
                                    <td style="vertical-align: middle;">{{ $item->satuan_barang }}</td>
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
