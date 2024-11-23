@extends('layout.master')
@section('title', 'Edit Detail')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="cool-xl-6 col-12">
                        <h3 class="fw-bold text-secondary">Edit Detail Barang</h3>
                    </div>
                    <div class="cool-xl-6 col-12">
                        <p class="text-muted text-xl-end text-secondary">Pengajuan &gt; Detail &gt; Edit</p>
                    </div>
                </div>
            </div>
            <div class="card border-0 mt-4 p-4 shadow">
                <h4 class=" text-secondary">Data Detail Barang</h4>
                <hr>
                <form action="{{ route('postEditDetail', $detail->id) }}" id="your-form-id" method="POST"
                    enctype="multipart/form-data" class="form-group">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 col-12">
                            <div>
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control border-0"
                                    style="background-color: #ededed" placeholder="Masukkan nama" required
                                    value="{{ $detail->nama }}">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3 mt-xl-0">
                            <div>
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input type="text" id="keterangan" name="keterangan" class="form-control border-0"
                                    style="background-color: #ededed" placeholder="Masukkan keterangan" required
                                    value="{{ $detail->keterangan }}">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3 mt-3">
                            <div>
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" id="gambar" name="gambar" class="form-control border-0"
                                    style="background-color: #ededed; height: 300px;" placeholder="Masukkan gambar"
                                    onchange="previewImage(event)">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3 mt-3">
                            <label class="form-label">Preview Gambar</label>
                            <div id="imagePreview" style="height: 300px; background-color: #ededed;">
                                @if ($detail->gambar)
                                <a href="{{ asset($detail->gambar) }}" data-lightbox="image-{{ $detail->id }}" data-title="{{ $detail->name }}">
                                    <img id="preview" width="100%" style="height: 300px; border:none; object-fit:cover;"
                                        class="rounded-3 border-0" src="{{ asset($detail->gambar) }}" alt="Preview Gambar">
                                </a>
                                @else
                                    <img id="preview" width="100%"
                                        style="height: 300px; border:none; display: none; object-fit:cover;"
                                        class="rounded-3 border-0" src="" alt="Preview Gambar">
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mt-3" hidden>
                            <label for="pengajuan_id" class="form-label">Pengajuan Id</label>
                            <input type="text" id="pengajuan_id" name="pengajuan_id" readonly
                                class="form-control border-0" style="background-color: #ededed"
                                value="{{ $detail->pengajuan_id }}">
                        </div>
                        <div>
                            <button type="submit" class="btn text-white mt-3 btn-kuning" style="background-color: #edbb05"
                                id="submit-button">
                                Ubah Detail
                            </button>
                            <a class="btn text-white mt-3 btn-kuning ms-1 btn-merah" href="javascript:void(0);"
                                onclick="window.history.back();" style="background-color: #d9261c">Kembali</a>
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

        document.getElementById('submit-button').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah pengiriman form untuk sementara

            // Menampilkan SweetAlert konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data detail akan diperbarui!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, ubah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika tombol "Ya" diklik, kirim form
                    document.getElementById('your-form-id')
                .submit(); // Ganti 'your-form-id' dengan ID form yang sesuai
                }
            });
        });

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

        function previewImage(event) {
            var reader = new FileReader(); // Membaca file gambar

            // Ketika file dibaca, tampilkan gambar di preview
            reader.onload = function() {
                var preview = document.getElementById('preview');
                var imagePreview = document.getElementById('imagePreview');

                preview.src = reader.result; // Menetapkan src dengan hasil pembacaan file
                preview.style.display = 'block'; // Menampilkan elemen gambar
                imagePreview.style.backgroundColor = 'transparent'; // Menyembunyikan background
            }

            // Membaca file yang dipilih
            reader.readAsDataURL(event.target.files[0]);
        }

        function confirmSubmit(event) {
            event.preventDefault(); // Mencegah form dikirim sebelum konfirmasi

            // Menampilkan SweetAlert2
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pastikan data yang Anda kirim sudah benar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengonfirmasi, kirim form
                    event.target.form.submit(); // Mengirim form
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
