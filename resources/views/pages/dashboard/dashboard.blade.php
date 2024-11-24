@extends('layout.master')
@section('title', 'Dashboard')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-6">
                        <h3 class="fw-bold text-secondary">Dashboard</h3>
                    </div>
                    <div class="col-6">
                        <p class="text-muted text-xl-end text-secondary">Dashboard &gt; Home</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4 col-12">
                    <div class="card card-nasabah w-100 count-card border-0 mt-4 shadow bg-primary">
                        <div class="row px-3 py-4">
                            <div class="col-7 text-white">
                                <h5>Total Anggaran:</h5>
                                <h4>Rp{{ number_format($totalAnggaran, 0, ',', '.') }}</h4>
                                <!-- Menampilkan total anggaran -->
                            </div>
                            <div class="col-5 d-flex align-items-center" style="height: 100%;">
                                <i class='fa-solid fa-money-check-dollar nav_icon text-white' style="font-size: 5rem"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-12">
                    <div class="card card-nasabah w-100 count-card border-0 mt-4 shadow bg-warning">
                        <div class="row px-3 py-4">
                            <div class="col-7 text-white">
                                <h5>Total Pengajuan:</h5>
                                <h4>Rp{{ number_format($totalPengajuan, 0, ',', '.') }}</h4>
                                <!-- Menampilkan total pengajuan -->
                            </div>
                            <div class="col-5 d-flex align-items-center" style="height: 100%;">
                                <i class='fa-solid fa-cart-shopping nav_icon text-white' style="font-size: 5rem"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-12">
                    <div
                        class="card card-nasabah w-100 count-card border-0 mt-4 shadow 
                        {{ $sisaAnggaran < 0 ? 'bg-danger' : 'bg-success' }}">
                        <div class="row px-3 py-4">
                            <div class="col-7 text-white">
                                <h5>Sisa Anggaran:</h5>
                                <h4>Rp{{ number_format($sisaAnggaran, 0, ',', '.') }}</h4>
                                <!-- Menampilkan sisa anggaran -->
                            </div>
                            <div class="col-5 d-flex align-items-center" style="height: 100%;">
                                <i class='fa-solid fa-money-bills nav_icon text-white' style="font-size: 5rem"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            @if ($user->role == 'admin')
                <div class="card border-0 mt-4 p-4 shadow">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="me-auto text-secondary">Tabel Anggaran</h4>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ route('dashboard') }}" method="GET">
                        <div class="row">
                            <div class="col-xl-8 col-12 mt-xl-0">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control border-0"
                                    style="background-color: #ededed">
                                    <option value="" disabled {{ old('jurusan') ? '' : 'selected' }}>Pilih Role</option>
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
                                    <th scope="col">Foto</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Total Anggaran</th>
                                    <th scope="col">Total Pengajuan</th>
                                    <th scope="col">Sisa Anggaran</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody style="background-color: #f2f2f2">
                                @foreach ($userr as $item)
                                    <tr>
                                        <td style="vertical-align: middle;" scope="row">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;"><img src="{{ asset($item->foto) }}"
                                                class=" rounded-circle" width="40" height="40"
                                                style="object-fit: cover" alt=""></td>
                                        <td style="vertical-align: middle;">{{ $item->name }}</td>
                                        <td style="vertical-align: middle;">{{ $item->username }}</td>
                                        <td style="vertical-align: middle;">{{ $item->role }}</td>
                                        <td style="vertical-align: middle;">
                                            @if ($item->anggaran)
                                                Rp{{ number_format($item->anggaran, 0, ',', '.') }}
                                            @else
                                                <span class="text-danger">Belum diberi anggaran</span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            @if ($item->pengajuan_sum_total_harga)
                                                Rp{{ number_format($item->pengajuan_sum_total_harga, 0, ',', '.') }}
                                            @else
                                                <span class="text-danger">Belum ada pengajuan</span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            @if ($item->sisa_anggaran < 0)
                                                <span
                                                    class="text-danger">Rp{{ number_format($item->sisa_anggaran, 0, ',', '.') }}</span>
                                            @else
                                                Rp{{ number_format($item->sisa_anggaran, 0, ',', '.') }}
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="d-flex">
                                                <a href="{{ route('tambahAnggaran', $item->id) }}"
                                                    class="btn btn-success ms-1" style="padding: 12px 15px;">
                                                    <i class="fa-solid fa-money-check-dollar"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="card border-0 mt-4 p-4 shadow">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="me-auto text-secondary">Profil Anda</h4>
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive pb-2">
                        <table class="table table-secondary">
                            <thead style="background-color: #f2f2f2">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Jurusan / Role</th>
                                    <th scope="col">Total Anggaran</th>
                                    <th scope="col">Total Pengajuan</th>
                                    <th scope="col">Sisa Anggaran</th>
                                </tr>
                            </thead>
                            <tbody style="background-color: #f2f2f2">
                                @foreach ($userr as $item)
                                    <tr>
                                        <td style="vertical-align: middle;" scope="row">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;"><img src="{{ asset($item->foto) }}"
                                                class=" rounded-circle" width="40" height="40"
                                                style="object-fit: cover" alt=""></td>
                                        <td style="vertical-align: middle;">{{ $item->name }}</td>
                                        <td style="vertical-align: middle;">{{ $item->username }}</td>
                                        <td style="vertical-align: middle;">{{ $item->role }}</td>
                                        <td style="vertical-align: middle;">
                                            @if ($item->anggaran)
                                                Rp{{ number_format($item->anggaran, 0, ',', '.') }}
                                            @else
                                                <span class="text-danger">Belum diberi anggaran</span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            @if ($item->pengajuan_sum_total_harga)
                                                Rp{{ number_format($item->pengajuan_sum_total_harga, 0, ',', '.') }}
                                            @else
                                                <span class="text-danger">Belum ada pengajuan</span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            @if ($item->sisa_anggaran < 0)
                                                <span
                                                    class="text-danger">Rp{{ number_format($item->sisa_anggaran, 0, ',', '.') }}</span>
                                            @else
                                                Rp{{ number_format($item->sisa_anggaran, 0, ',', '.') }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
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

        document.querySelectorAll('.delete-btn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah default action (link follow)

                const url = button.getAttribute('data-url'); // Ambil URL dari atribut data-url

                // Menampilkan SweetAlert konfirmasi
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data detail ini akan dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika tombol "Ya" diklik, kirim request POST ke URL yang diberikan
                        fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token untuk Laravel
                                },
                                body: JSON
                                    .stringify({}) // Bisa ditambahkan data lain jika diperlukan
                            })
                            .then(response => response.json())
                            .then(data => {
                                Swal.fire('Terhapus!', 'Detail berhasil dihapus.', 'success');
                                // Optionally, refresh halaman atau lakukan aksi lain setelah sukses
                                location.reload();
                            })
                            .catch(error => {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.',
                                    'error');
                            });
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
