@extends('layout.master')
@section('title', 'Pengambilan')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-6">
                        <h3 class="fw-bold text-secondary">Pengambilan</h3>
                    </div>
                    <div class="col-6">
                        <p class="text-muted text-end text-secondary">Pengambilan &gt; Home</p>
                    </div>
                </div>
            </div>

            <div class="card card-nasabah count-card border-0 mt-4 shadow" style="background-color: #d9261c">
                <div class="row px-3 py-4">
                    <div class="col-7 text-white">
                        <h5>Total Pengambilan:</h5>
                        <h1 class="px-3">{{ $pengajuanCount }}</h1>
                    </div>
                    <div class="col-5 d-flex align-items-center" style="height: 100%;">
                        <i class='fa-solid fa-book nav_icon text-white' style="font-size: 5rem"></i>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4 p-4 shadow">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="me-auto text-secondary">Tabel Pengajuan</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end d-none d-xl-block">
                        <div>
                            <a href="{{ route('download.pengambilan') }}" class="btn rounded-4 text-white btn-kuning" style="background-color: #edbb05">
                                <i class="fa-solid fa-download"></i> Download format pengambilan
                            </a>
                            <div class="btn-group">
                                <button type="button" class="btn ms-2 rounded-4 text-white btn-kuning dropdown-toggle"
                                        style="background-color: #edbb05" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-upload"></i> Pengambilan
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('uploadPengambilan') }}">
                                            <i class="fa-solid fa-upload"></i> Upload
                                        </a>
                                    </li>
                                    <li class="mt-1">
                                        <a class="dropdown-item" href="{{ route('downloadPengambilan') }}">
                                            <i class="fa-solid fa-eye"></i> Lihat
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('pengajuan.downloadPDF') }}" class="btn ms-2 rounded-4 text-white btn-kuning" style="background-color: #edbb05">
                                <i class="fa-solid fa-file-pdf"></i> Download PDF
                            </a>     
                        </div>
                    </div>
                    <div class="col-md-12 d-block d-xl-none">
                        <div>
                            <a href="{{ route('download.pengambilan') }}" class="btn mt-3 w-100 rounded-4 text-white btn-kuning" style="background-color: #edbb05">
                                <i class="fa-solid fa-download"></i> Download format pengambilan
                            </a>
                            <div class="btn-group w-100">
                                <button type="button" class="btn mt-3 rounded-4 text-white btn-kuning dropdown-toggle"
                                        style="background-color: #edbb05" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-upload"></i> Pengambilan
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('uploadPengambilan') }}">
                                            <i class="fa-solid fa-upload"></i> Upload
                                        </a>
                                    </li>
                                    <li class="mt-1">
                                        <a class="dropdown-item" href="{{ route('downloadPengambilan') }}">
                                            <i class="fa-solid fa-eye"></i> Lihat
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('pengajuan.downloadPDF') }}" class="btn w-100 mt-3 rounded-4 text-white btn-kuning" style="background-color: #edbb05">
                                <i class="fa-solid fa-file-pdf"></i> Download PDF
                            </a>     
                        </div>
                    </div>
                </div>
                <hr>
                <form action="{{ route('pengambilan') }}">
                    <div class="row">
                        <div class="col-xl-5 col-12">
                            <label for="tanggal_awal">Tanggal awal</label>
                            <input type="date" required name="tanggal_awal" class="form-control border-0" value="{{ $filters['tanggal_awal'] ?? '' }}"
                                style="background-color: #ededed">
                        </div>
                        <div class="col-xl-5 col-12">
                            <label for="tanggal_akhir">Tanggal akhir</label>
                            <input type="date" required name="tanggal_akhir" class="form-control border-0" value="{{ $filters['tanggal_akhir'] ?? '' }}"
                                style="background-color: #ededed">
                        </div>
                        <div class="col-xl-2 col-12 d-flex align-items-end mt-xl-0 mt-4">
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
                                <th scope="col">Barang</th>
                                <th scope="col">Program kegiatan</th>
                                <th scope="col">Jurusan</th>
                                <th scope="col">Tanggal ajuan</th>
                                <th scope="col">Tanggal realisasi</th>
                                <th scope="col">Harga satuan</th>
                                <th scope="col">Tahun</th>
                                <th scope="col">Banyak</th>
                                <th scope="col">Total harga</th>
                                <th scope="col">Harga beli</th>
                                <th scope="col">Sumber dana</th>
                                <th scope="col">Keterangan</th>
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
                                    <td style="vertical-align: middle;">{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td style="vertical-align: middle;">{{ $item->tahun }}</td>
                                    <td style="vertical-align: middle;">{{ $item->banyak }}</td>
                                    <td style="vertical-align: middle;">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    <td style="vertical-align: middle;">
                                        @if ($item->harga_beli)
                                        {{ number_format($item->harga_beli, 0, ',', '.') }}
                                        @else
                                            <span class="text-danger">Belum Dimasukan</span>
                                        @endif
                                    </td>       
                                    <td style="vertical-align: middle;">{{ $item->sumber_dana }}</td>
                                    <td style="vertical-align: middle;">{{ $item->keterangan }}</td>
                                    <td style="vertical-align: middle;">{{ $item->status }}</td>
                                    <td style="vertical-align: middle;">
                                        <div class="d-flex">
                                            <a href="{{ route('detail', $item->id) }}" class="btn btn-primary"
                                                style="padding: 12px 15px;">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            @if ($item->status !== 'Dijurusan')
                                                <form id="ubahStatusForm-{{ $item->id }}"
                                                    action="{{ route('ubahStatus', $item->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                                <a href="#"
                                                    onclick="event.preventDefault(); confirmStatusChange({{ $item->id }});"
                                                    class="btn btn-success ms-1" style="padding: 12px 15px;">
                                                    <i class="fa-solid fa-check"></i>
                                                </a>
                                            @endif
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

        function confirmStatusChange(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Status akan diubah menjadi 'Dijurusan'!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Ubah!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form jika dikonfirmasi
                    document.getElementById(`ubahStatusForm-${id}`).submit();
                }
            });
        }
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
