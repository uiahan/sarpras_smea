@extends('layout.master')
@section('title', 'Tambah Detail')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-xl-6 col-12">
                        <h3 class="fw-bold text-secondary">Tambah Detail Barang</h3>
                    </div>
                    <div class="col-xl-6 col-12">
                        <p class="text-muted text-xl-end text-secondary">Pengajuan &gt; Detail &gt; Tambah</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4 p-4 shadow">
                <h4 class=" text-secondary">Data Detail Barang</h4>
                <hr>
                <form action="{{ route('postTambahDetail') }}" method="POST" enctype="multipart/form-data"
                    class="form-group">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 col-12">
                            <div>
                                <label for="nama" class="form-label">Nama*</label>
                                <input type="text" id="nama" name="nama" class="form-control border-0"
                                    style="background-color: #ededed" placeholder="masukan nama" required>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3 mt-xl-0">
                            <div>
                                <label for="keterangan" class="form-label">Keterangan*</label>
                                <input type="text" id="keterangan" name="keterangan" class="form-control border-0"
                                    style="background-color: #ededed" placeholder="masukan keterangan" required>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="gambar" class="form-label">Gambar (opsional)</label>
                                <input type="file" id="gambar" name="gambar" class="form-control border-0"
                                    style="background-color: #ededed; height: 300;" placeholder="masukan gambar" required
                                    onchange="previewImage(event)">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <label class="form-label">Preview Gambar</label>
                            <div id="imagePreview" class="" style="height: 300; background-color: #ededed;">
                                <img id="preview" width="100%" style="height: 300; border:none; display: none; object-fit:cover;"
                                    class="rounded-3 border-0" src="" alt="Preview Gambar"
                                    >
                            </div>
                        </div>
                        <div class="col-12 mt-3" hidden>
                            <label for="pengajuan_id" class="form-label">Pengajuan Id</label>
                            <input type="text" id="pengajuan_id" name="pengajuan_id" readonly
                                class="form-control border-0" style="background-color: #ededed"
                                placeholder="masukan pengajuan_id" required value="{{ $pengajuan_id }}">
                        </div>
                        <div>
                            <button type="submit" class="btn text-white mt-3 btn-kuning" style="background-color: #edbb05"
                                onclick="confirmSubmit(event)">
                                Kirim Detail
                            </button>
                            <a class="btn text-white mt-3 btn-kuning ms-1 btn-merah" href="javascript:void(0);"
                                onclick="window.history.back();" style="background-color: #d9261c">
                                Kembali
                            </a>
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

        function previewImage(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0]; // Ambil file yang dipilih

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Set sumber gambar ke data URL yang dihasilkan
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Menampilkan gambar
                };

                reader.readAsDataURL(file); // Membaca file sebagai data URL
            } else {
                preview.style.display = 'none'; // Sembunyikan gambar jika tidak ada file
            }
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
