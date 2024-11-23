@extends('layout.master')
@section('title', 'Edit Pengajuan')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="cool-xl-6 col-12">
                        <h3 class="fw-bold text-secondary">Konfirmasi Pengajuan</h3>
                    </div>
                    <div class="cool-xl-6 col-12">
                        <p class="text-muted text-xl-end text-secondary">Validasi &gt; Konfirmasi</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4 p-4 shadow">
                <h4 class=" text-secondary">Data Pengajuan</h4>
                <hr>
                <form id="form-edit-pengajuan" action="{{ route('update', $pengajuan->id) }}" method="POST"
                    enctype="multipart/form-data" class="form-group">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 col-12">
                            <div>
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-control border-0" style="background-color: #ededed">
                                    <option value="" disabled selected>Pilih Status</option>
                                    @foreach (['Diajukan', 'Diterima', 'Diperbaiki', 'Dibelikan', 'Di Sarpras', 'Dijurusan'] as $statusOption)
                                        <option value="{{ $statusOption }}"
                                            {{ $pengajuan->status == $statusOption ? 'selected' : '' }}>
                                            {{ $statusOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                        
                        <div class="col-xl-6 col-12 mt-3 mt-xl-0">
                            <div>
                                <label for="tanggal_realisasi" class="form-label">Tanggal Realisasi</label>
                                <input type="date" id="tanggal_realisasi"
                                    value="{{ $pengajuan->tanggal_realisasi }}" required name="tanggal_realisasi"
                                    class="form-control border-0" style="background-color: #ededed">
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div>
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea id="catatan" name="catatan" class="form-control border-0" required
                                    style="background-color: #ededed; height: 7rem" placeholder="masukan catatan">{{ $pengajuan->catatan }}</textarea>
                            </div>
                        </div>
                        <div>
                            <button type="button" id="submit-btn" class="btn text-white mt-3 btn-kuning"
                                style="background-color: #edbb05">
                                Konfirmasi Pengajuan
                            </button>
                            <a class="btn text-white mt-3 btn-kuning ms-1 btn-merah" href="javascript:void(0);"
                                onclick="window.history.back();"
                                style="background-color: #d9261c">
                                Kembali</a>
                        </div>
                    </div>
                </form>
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

        document.addEventListener("DOMContentLoaded", function() {
            const hargaSatuan = document.getElementById('harga_satuan');
            const banyakBarang = document.getElementById('banyak');
            const totalHarga = document.getElementById('total_harga');

            function hitungTotalHarga() {
                const harga = parseFloat(hargaSatuan.value) || 0; // Jika kosong, set ke 0
                const banyak = parseFloat(banyakBarang.value) || 0; // Jika kosong, set ke 0
                totalHarga.value = harga * banyak; // Hitung total
            }

            // Tambahkan event listener ke input harga satuan dan banyak barang
            hargaSatuan.addEventListener('input', hitungTotalHarga);
            banyakBarang.addEventListener('input', hitungTotalHarga);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const submitButton = document.getElementById('submit-btn');
            const form = document.getElementById('form-edit-pengajuan');

            submitButton.addEventListener('click', function() {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Perubahan ini akan disimpan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Mengirimkan formulir jika dikonfirmasi
                    }
                });
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
