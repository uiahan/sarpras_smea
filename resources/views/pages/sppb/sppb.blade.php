@extends('layout.master')
@section('title', 'SPPB')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-6">
                        <h3 class="fw-bold text-secondary">Surat Perintah Penyaluran Barang</h3>
                    </div>
                    <div class="col-6">
                        <p class="text-muted text-xl-end text-secondary">SPPB &gt; Home</p>
                    </div>
                </div>
            </div>

            <div class="card card-nasabah count-card border-0 mt-4 shadow" style="background-color: #d9261c">
                <div class="row px-3 py-4">
                    <div class="col-7 text-white">
                        <h5>Total SPPB:</h5>
                        <h1 class="px-3">{{ $sppbCount }}</h1>
                    </div>
                    <div class="col-5 d-flex align-items-center" style="height: 100%;">
                        <i class='fa-solid fa-file-alt nav_icon text-white' style="font-size: 5rem"></i>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4 p-4 shadow">
                <div class="row">
                    <div class="col-md-3">
                        <h4 class="me-auto text-secondary">Tabel SPPB</h4>
                    </div>
                </div>
                <hr>
                <form action="{{ route('sppb') }}" method="GET">
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
                    <table class="table" id="example">
                        <thead style="background-color: #f2f2f2">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nomor verifikasi</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #f2f2f2">
                            @foreach ($pengajuan as $item)
                            <tr>
                                <td style="vertical-align: middle;" scope="row">{{ $loop->iteration }}</td>
                                <td style="vertical-align: middle;">
                                    @if ($item->nomor_verifikasi)
                                        {{ $item->nomor_verifikasi }}
                                    @else
                                        <span class="text-danger">Belum Dimasukan</span>
                                    @endif
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="d-flex">
                                        <a href="{{ route('detailSppb', $item->nomor_verifikasi) }}" class="btn ms-1 btn-primary"
                                            style="padding: 12px 15px;">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        <a href="{{ route('downloadSPPB', $item->nomor_verifikasi) }}"
                                            class="btn text-white ms-1 btn-merah"
                                            style="padding: 12px 15px; background-color:#d9261c;">
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
</style>