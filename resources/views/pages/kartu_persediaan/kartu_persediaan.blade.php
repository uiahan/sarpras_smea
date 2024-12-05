@extends('layout.master')
@section('title', 'Kartu Persediaan')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-6">
                        <h3 class="fw-bold text-secondary">Kartu Persediaan</h3>
                    </div>
                    <div class="col-6">
                        <p class="text-muted text-xl-end text-secondary">Kartu Persediaan &gt; Home</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4 p-4 shadow">
                <div class="row">
                    <div class="col-md-3">
                        <h4 class="me-auto text-secondary">Tabel Kartu Persediaan</h4>
                    </div>
                    <div class="col-md-9 d-flex justify-content-end d-none d-xl-block">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('download.excelpp') }}" class="btn rounded-4 text-white btn-kuning" style="background-color: #edbb05">
                                <i class="fa-solid fa-download"></i> Download Excel
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 d-block d-xl-none">
                        <div>
                            <a href="{{ route('download.excelpp') }}" class="btn mt-3 w-100 rounded-4 text-white btn-kuning"
                                style="background-color: #edbb05">
                                <i class="fa-solid fa-download"></i> Download Excel
                            </a>

                        </div>
                    </div>
                </div>
                <hr>
                <form action="{{ route('kartuPersediaan') }}" method="GET">
                    <div class="row">
                        <div class="col-xl-6 col-12">
                            <label for="tanggal_awal">Tanggal awal</label>
                            <input type="date" name="tanggal_awal" class="form-control border-0"
                                value="{{ $filters['tanggal_awal'] ?? '' }}" value="{{ old('tanggal_awal', $filters['tanggal_awal'] ?? '') }}"  style="background-color: #ededed">
                        </div>
                        <div class="col-xl-6 col-12">
                            <label for="tanggal_akhir">Tanggal akhir</label>
                            <input type="date" name="tanggal_akhir" class="form-control border-0"
                                value="{{ $filters['tanggal_akhir'] ?? '' }}" value="{{ old('tanggal_awal', $filters['tanggal_awal'] ?? '') }}"  style="background-color: #ededed">
                        </div>

                        <div class="col-xl-3 col-12 mt-xl-3">
                            <label for="kode_barang" class="form-label">Kode Barang</label>
                            <select id="kode_barang" name="kode_barang" class="form-control border-0" style="background-color: #ededed">
                                <option value="" disabled selected>pilih Kode Barang</option>
                                @foreach ($kodeBarang as $item)
                                <option value="{{ $item->kode_barang }}" {{ old('kode_barang', $filters['kode_barang'] ?? '') == $item->kode_barang ? 'selected' : '' }}>
                                    {{ $item->kode_barang }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-3 col-12 mt-xl-3">
                            <div>
                                <label for="nusp" class="form-label">NUSP</label>
                                <select id="nusp" name="nusp" class="form-control border-0" style="background-color: #ededed">
                                    <option value="" disabled selected>( Pilih kode barang terlebih dahulu )</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-12 mt-xl-3">
                            <div>
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input value="{{ old('nama_barang', $filters['nama_barang'] ?? '') }}" type="text" id="nama_barang" value="" readonly name="nama_barang" class="form-control border-0"
                                    style="background-color: #ededed" min="0" placeholder="Nama barang otomatis muncul">
                            </div>
                        </div>
                        <div class="col-xl-3 col-12 d-flex align-items-end mt-xl-0 mt-4">
                            <button type="submit" class="text-white btn-merah btn w-100 btn-tambah-nasabah"
                                style="background-color: #d9261c">
                                <i class="fa-solid fa-filter me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive pb-2">
                    <table class="table table-bordered">
                        <thead style="background-color: #f2f2f2">
                            <!-- Table headers -->
                            <tr>
                                <th rowspan="2" style="vertical-align: middle; text-align: center;">Tanggal</th>
                                <th colspan="3" style="vertical-align: middle; text-align: center;">Masuk (persetujuan permintaan)</th>
                                <th colspan="3" style="vertical-align: middle; text-align: center;">Pengeluaran (persetujuan permintaan)</th>
                                <th colspan="3" style="vertical-align: middle; text-align: center;">Sisa/Saldo Barang Tersedia</th>
                            </tr>
                            <tr>
                                <th style="vertical-align: middle; text-align: center;">Jumlah</th>
                                <th style="vertical-align: middle; text-align: center;">Harga Satuan</th>
                                <th style="vertical-align: middle; text-align: center;">Total (Rp)</th>
                                <th style="vertical-align: middle; text-align: center;">Jumlah</th>
                                <th style="vertical-align: middle; text-align: center;">Harga Satuan</th>
                                <th style="vertical-align: middle; text-align: center;">Total (Rp)</th>
                                <th style="vertical-align: middle; text-align: center;">Sisa Jumlah</th>
                                <th style="vertical-align: middle; text-align: center;">Harga Satuan</th>
                                <th style="vertical-align: middle; text-align: center;">Sisa Total (Rp)</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #f2f2f2">
                            @forelse ($pengajuan as $item)
                                <tr>
                                    <td style="vertical-align: middle; text-align: center;">{{ $item->tanggal_realisasi }}</td>
                                    <td style="vertical-align: middle; text-align: center;">{{ $item->banyak }}</td>
                                    <td style="vertical-align: middle; text-align: center;">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td style="vertical-align: middle; text-align: center;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    <td style="vertical-align: middle; text-align: center;">{{ $item->jumlah_yg_diacc }}</td>
                                    <td style="vertical-align: middle; text-align: center;">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        @php
                                            $totalPengeluaran = $item->jumlah_yg_diacc * $item->harga_satuan;
                                        @endphp
                                        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                                    </td>
                    
                                    <!-- Sisa Jumlah -->
                                    <td style="vertical-align: middle; text-align: center;">
                                        @php
                                            $sisaJumlah = $item->banyak - $item->jumlah_yg_diacc;
                                        @endphp
                                        {{ $sisaJumlah }}
                                    </td>
                    
                                    <!-- Harga Satuan untuk Sisa -->
                                    <td style="vertical-align: middle; text-align: center;">
                                        Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                    </td>
                    
                                    <!-- Sisa Total -->
                                    <td style="vertical-align: middle; text-align: center;">
                                        @php
                                            $sisaTotal = $sisaJumlah * $item->harga_satuan;
                                        @endphp
                                        Rp {{ number_format($sisaTotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" style="text-align: center;">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
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

        $(document).ready(function() {
        // Ketika kode barang dipilih
        $('#kode_barang').change(function() {
            var kodeBarang = $(this).val(); // Ambil nilai kode barang yang dipilih

            if(kodeBarang) {
                $.ajax({
                    url: '/get-nusp/' + kodeBarang,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Kosongkan select nusp
                        $('#nusp').empty();
                        $('#nusp').append('<option value="" disabled selected>Pilih NUSP</option>');

                        // Tambahkan opsi nusp
                        $.each(data, function(key, value) {
                            $('#nusp').append('<option value="'+ value.nusp +'">' + value.nusp + '</option>');
                        });
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        // Ketika nusp dipilih
        $('#nusp').change(function() {
            var nusp = $(this).val(); // Ambil nilai nusp yang dipilih

            if (nusp) {
                // Jika ada nusp yang dipilih, kirim AJAX untuk mendapatkan nama_barang
                $.ajax({
                    url: '/get-nama-barang/' + nusp,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Isi nama barang otomatis berdasarkan nusp yang dipilih
                        $('#nama_barang').val(data.nama_barang);
                    }
                });
            } else {
                // Jika nusp kosong atau tidak dipilih, kosongkan field nama_barang
                $('#nama_barang').val('');
            }
        });

        // Jika nusp di-disable atau kosongkan pilihan, kosongkan nama_barang
        $('#nusp').on('change keyup', function() {
            if ($(this).val() === "" || $(this).prop("disabled")) {
                $('#nama_barang').val(''); // Kosongkan nama_barang jika nusp kosong atau disable
            }
        });
    });
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
