@extends('layout.master')
@section('title', 'Edit User')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-6">
                        <h3 class="fw-bold text-secondary">Edit User</h3>
                    </div>
                    <div class="col-6">
                        <p class="text-muted text-end text-secondary">User &gt; Edit</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4 p-4 shadow">
                <h4 class=" text-secondary">Data User</h4>
                <hr>
                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('postEditUser', $userr->id) }}" method="POST" enctype="multipart/form-data"
                    class="form-group" onsubmit="return confirmSubmit(event)">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control border-0"
                                style="background-color: #ededed" value="{{ old('name', $userr->name) }}"
                                placeholder="Masukkan nama lengkap" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-3 col-12">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control border-0"
                                style="background-color: #ededed" value="{{ old('username', $userr->username) }}"
                                placeholder="Masukkan username" required>
                            @error('username')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if ($user->role == 'admin')
                            <div class="mt-3">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" name="role" class="form-control border-0"
                                    style="background-color: #ededed" required>
                                    <option value="" disabled {{ !$userr->role ? 'selected' : '' }}>Pilih Role</option>
                                    <option value="Akutansi Keuangan Lembaga"
                                        {{ old('role', $userr->role) == 'Akutansi Keuangan Lembaga' ? 'selected' : '' }}>
                                        Akutansi Keuangan Lembaga</option>
                                    <option value="Bisnis Daring Pemasaran"
                                        {{ old('role', $userr->role) == 'Bisnis Daring Pemasaran' ? 'selected' : '' }}>Bisnis
                                        Daring Pemasaran</option>
                                    <option value="Otomatisasi Tata Kelola Perkantoran"
                                        {{ old('role', $userr->role) == 'Otomatisasi Tata Kelola Perkantoran' ? 'selected' : '' }}>
                                        Otomatisasi Tata Kelola Perkantoran</option>
                                    <option value="Teknik Jaringan Komputer"
                                        {{ old('role', $userr->role) == 'Teknik Jaringan Komputer' ? 'selected' : '' }}>
                                        Teknik Jaringan Komputer</option>
                                    <option value="Rekayasa Perangkat Lunak"
                                        {{ old('role', $userr->role) == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>
                                        Rekayasa Perangkat Lunak</option>
                                    <option value="waka kurikulum"
                                        {{ old('role', $userr->role) == 'waka kurikulum' ? 'selected' : '' }}>Waka Kurikulum
                                    </option>
                                    <option value="waka sarpras"
                                        {{ old('role', $userr->role) == 'waka sarpras' ? 'selected' : '' }}>Waka Sarpras
                                    </option>
                                    <option value="waka hubin"
                                        {{ old('role', $userr->role) == 'waka hubin' ? 'selected' : '' }}>Waka Hubin
                                    </option>
                                    <option value="waka kesiswaan"
                                        {{ old('role', $userr->role) == 'waka kesiswaan' ? 'selected' : '' }}>Waka Kesiswaan
                                    </option>
                                    <option value="waka evbank"
                                        {{ old('role', $userr->role) == 'waka evbank' ? 'selected' : '' }}>Waka Evbank
                                    </option>
                                    <option value="admin" {{ old('role', $userr->role) == 'admin' ? 'selected' : '' }}>
                                        Admin</option>
                                </select>
                                @error('role')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" id="foto" name="foto" class="form-control border-0"
                                    style="background-color: #ededed; height: 300px;" placeholder="Masukkan gambar"
                                    onchange="previewImage(event)">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <label class="form-label">Preview Foto</label>
                            <div id="imagePreview" style="height: 300px; background-color: #ededed;">
                                @if ($userr->foto)
                                    <img id="preview" width="100%" style="height: 300px; border:none; object-fit:cover;"
                                        class="rounded-3 border-0" src="{{ asset($userr->foto) }}" alt="Preview Foto">
                                @else
                                    <img id="preview" width="100%"
                                        style="height: 300px; border:none; display: none; object-fit:cover;"
                                        class="rounded-3 border-0" src="" alt="Preview Foto">
                                @endif
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn text-white mt-3 btn-kuning"
                                style="background-color: #edbb05">Edit User</button>
                            <a class="btn text-white mt-3 btn-merah ms-1" href="{{ route('user') }}"
                                style="background-color: #d9261c">Kembali</a>
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
