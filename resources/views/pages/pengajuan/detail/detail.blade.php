@extends('layout.master')
@section('title', 'Detail Barang')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-xl-6 cool-12">
                        <h3 class="fw-bold text-secondary">Detail {{ $pengajuan->barang }}</h3>
                    </div>
                    <div class="col-xl-6 cool-12">
                        <p class="text-muted text-xl-end text-secondary">Pengajuan &gt; Detail {{ $pengajuan->barang }}</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4 p-4 shadow">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="me-auto text-secondary">Tabel Detail {{ $pengajuan->barang }}</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end d-none d-xl-block">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('tambahDetail') }}" class="btn ms-2 rounded-4 text-white btn-kuning"
                                style="background-color: #edbb05">
                                Tambah detail {{ $pengajuan->barang }} <i class="ms-1 fa-solid fa-plus"></i>
                            </a>
                            <a href="{{ route('pengajuan') }}"
                                class="btn ms-2 rounded-4 text-white btn-kuning" style="background-color: #edbb05">
                                Kembali <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 d-block d-xl-none">
                        <div>
                            <a href="{{ route('tambahDetail') }}" class="btn w-100 mt-3 rounded-4 text-white btn-kuning"
                                style="background-color: #edbb05">
                                Tambah detail {{ $pengajuan->barang }} <i class="ms-1 fa-solid fa-plus"></i>
                            </a>
                            <a href="{{ route('pengajuan') }}"
                                class="btn mt-3 w-100 rounded-4 text-white btn-kuning" style="background-color: #edbb05">
                                Kembali <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="table-responsive pb-2">
                    <table class="table" id="example">
                        <thead style="background-color: #f2f2f2">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Gambar</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #f2f2f2">
                            @foreach ($detail as $item)
                                <tr>
                                    <td style="vertical-align: middle;" scope="row">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ asset($item->gambar) }}" data-lightbox="image-{{ $item->id }}" data-title="{{ $item->name }}">
                                            <img src="{{ asset($item->gambar) }}" width="50" height="50" style="object-fit: cover" alt="">
                                        </a>
                                    </td>
                                    <td style="vertical-align: middle;">{{ $item->nama }}</td>
                                    <td style="vertical-align: middle;">{{ $item->keterangan }}</td>
                                    <td style="vertical-align: middle;">
                                        <div class="d-flex">
                                            <a href="{{ route('editDetail', $item->id) }}" class="btn btn-success ms-1"
                                                style="padding: 12px 15px;">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="btn text-white ms-1 btn-merah delete-btn"
                                                style="padding: 12px 15px; background-color:#d9261c;"
                                                data-url="{{ route('postHapusDetail', $item->id) }}">
                                                <i class="fa-solid fa-trash"></i>
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
