@extends('layout.master')
@section('title', 'Edit Pengajuan')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-xl-6 col-12">
                        <h3 class="fw-bold text-secondary">Edit Pengajuan</h3>
                    </div>
                    <div class="col-xl-6 col-12">
                        <p class="text-muted text-xl-end text-secondary">Pengajuan &gt; Edit</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4 p-4 shadow">
                <h4 class=" text-secondary">Data Pengajuan</h4>
                <hr>
                <form id="form-edit-pengajuan" action="{{ route('postEditPengajuan', $pengajuan->id) }}" method="POST"
                    enctype="multipart/form-data" class="form-group">
                    @csrf
                    <div class="row">
                        @if (in_array($user->role, ['admin']))
                            <div class="col-xl-6 col-12">
                                <div>
                                    <label for="jurusan" class="form-label">Nama Jurusan</label>
                                    <select id="jurusan" name="jurusan" class="form-control border-0"
                                        style="background-color: #ededed">
                                        <option value="" disabled selected>pilih Jurusan</option>
                                        @foreach ($jurusan as $item)
                                            <option value="{{ $item->jurusan }}"
                                                {{ $pengajuan->jurusan == $item->jurusan ? 'selected' : '' }}>
                                                {{ $item->jurusan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <div class="col-xl-6 col-12" hidden>
                                <div>
                                    <label for="jurusan" class="form-label">Nama Jurusan</label>
                                    <input type="text" id="jurusan" name="jurusan" readonly
                                        value="{{ $pengajuan->jurusan }}" class="form-control border-0"
                                        style="background-color: #ededed" placeholder="masukan nama jurusan" required>
                                </div>
                            </div>
                        @endif
                       
                         
                      
                        @if (in_array($user->role, ['admin']))
                            <div class="col-xl-6 col-12 mt-3 mt-xl-0">
                                <div>
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" id="status" name="status" value="{{ $pengajuan->status }}"
                                        readonly class="form-control border-0" style="background-color: #ededed" required>
                                </div>
                            </div>
                            @else
                            <div class="col-xl-6 col-12" hidden>
                                <div>
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" id="status" name="status" value="{{ $pengajuan->status }}"
                                        readonly class="form-control border-0" style="background-color: #ededed" required>
                                </div>
                            </div>
                        @endif
                        @if (in_array($user->role, ['admin']))
                            <div class="col-xl-6 col-12 mt-3">
                                <div>
                                    <label for="barang" class="form-label">Nama Barang</label>
                                    <input type="text" id="barang" name="barang" value="{{ $pengajuan->barang }}"
                                        class="form-control border-0" style="background-color: #ededed"
                                        placeholder="masukan nama barang" required>
                                </div>
                            </div>
                            @else
                            <div class="col-xl-6 col-12 mt-3 mt-xl-0">
                                <div>
                                    <label for="barang" class="form-label">Nama Barang</label>
                                    <input type="text" id="barang" name="barang" value="{{ $pengajuan->barang }}"
                                        class="form-control border-0" style="background-color: #ededed"
                                        placeholder="masukan nama barang" required>
                                </div>
                            </div>
                        @endif
                        @if ($user->role == 'admin')
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="program_kegiatan" class="form-label">Program Kegiatan</label>
                                <input type="text" id="program_kegiatan" value="{{ $pengajuan->program_kegiatan }}"
                                    name="program_kegiatan" class="form-control border-0" style="background-color: #ededed"
                                    placeholder="masukan program kegiatan" required>
                            </div>
                        </div>
                        @else
                        <div class="col-xl-6 col-12 mt-3 mt-xl-0">
                            <div>
                                <label for="program_kegiatan" class="form-label">Program Kegiatan</label>
                                <input type="text" id="program_kegiatan" value="{{ $pengajuan->program_kegiatan }}"
                                    name="program_kegiatan" class="form-control border-0" style="background-color: #ededed"
                                    placeholder="masukan program kegiatan" required>
                            </div>
                        </div>
                        @endif                   
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="tahun" class="form-label">Tahun Pengajuan</label>
                                <input type="number" id="tahun" value="{{ $pengajuan->tahun }}" name="tahun"
                                    placeholder="masukan tahun pengajuan" class="form-control border-0"
                                    style="background-color: #ededed" required>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="sumber_dana" class="form-label">Sumber Dana</label>
                                <select id="sumber_dana" name="sumber_dana" class="form-control border-0"
                                    style="background-color: #ededed">
                                    <option value="" disabled selected>pilih Sumber Dana</option>
                                    @foreach ($sumberDana as $item)
                                        <option value="{{ $item->sumber_dana }}"
                                            {{ $pengajuan->sumber_dana == $item->sumber_dana ? 'selected' : '' }}>
                                            {{ $item->sumber_dana }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="harga_satuan" class="form-label">Harga Satuan</label>
                                <input type="text" value="{{ $pengajuan->harga_satuan }}" id="harga_satuan" name="harga_satuan" class="form-control border-0"
                                    style="background-color: #ededed" placeholder="Masukkan harga satuan"
                                    oninput="updateFormatted('harga_satuan', 'formattedAnggaran')" required>
                                <div id="formattedAnggaran" style="margin-top: 5px; color: #888;"></div>
                            </div>
                        </div>
                        @if ($user->role == 'admin')     
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="harga_beli" class="form-label">Harga Beli</label>
                                <input type="text" id="harga_beli" value="{{ $pengajuan->harga_beli }}" name="harga_beli" class="form-control border-0"
                                    style="background-color: #ededed" min="0" placeholder="Masukkan harga beli (boleh dikosongkan dahulu)"
                                    oninput="updateFormatted('harga_beli', 'formattedHargaBeli')">
                                <div id="formattedHargaBeli" style="margin-top: 5px; color: #888;"></div>
                            </div>
                        </div>
                        @endif
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="banyak" class="form-label">Banyak Barang</label>
                                <input type="number" value="{{ $pengajuan->banyak }}" id="banyak" name="banyak"
                                    class="form-control border-0" style="background-color: #ededed" min="0"
                                    placeholder="masukan banyak barang" required>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="total_harga" class="form-label">Total Harga</label>
                                <input value="{{ $pengajuan->total_harga }}" type="text" id="total_harga" name="total_harga" class="form-control border-0"
                                    style="background-color: #ededed" placeholder="Total harga otomatis muncul" readonly>
                                <div id="formattedTotalHarga" style="margin-top: 5px; color: #888;"></div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="tanggal_ajuan" class="form-label">Tanggal Ajuan</label>
                                <input type="date" value="{{ $pengajuan->tanggal_ajuan }}" id="tanggal_ajuan"
                                    name="tanggal_ajuan" class="form-control border-0" style="background-color: #ededed"
                                    required>
                            </div>
                        </div>
                        @if ($user->role == 'admin')    
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="tanggal_realisasi" class="form-label">Tanggal Realisasi</label>
                                <input type="date" id="tanggal_realisasi"
                                    value="{{ $pengajuan->tanggal_realisasi }}" required name="tanggal_realisasi"
                                    class="form-control border-0" style="background-color: #ededed">
                            </div>
                        </div>
                        @endif
                        <div class="col-12 mt-3">
                            <div>
                                <label for="keperluan" class="form-label">keperluan</label>
                                <textarea id="keperluan" name="keperluan" class="form-control border-0" required
                                    style="background-color: #ededed;" placeholder="masukan keperluan">{{ $pengajuan->keperluan }}</textarea>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div>
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea id="keterangan" name="keterangan" class="form-control border-0" required
                                    style="background-color: #ededed; height: 7rem" placeholder="masukan keterangan">{{ $pengajuan->keterangan }}</textarea>
                            </div>
                        </div>
                        <div>
                            <button type="button" id="submit-btn" class="btn text-white mt-3 btn-kuning"
                                style="background-color: #edbb05">
                                Ubah Pengajuan
                            </button>
                            <a class="btn text-white mt-3 btn-kuning ms-1 btn-merah" href="{{ route('pengajuan') }}"
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

        function updateFormatted(inputId, formattedId) {
            const input = document.getElementById(inputId);
            const value = input.value.replace(/[^\d]/g, '');
            const formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            document.getElementById(formattedId).textContent = 'Rp ' + formattedValue;
        }

        document.addEventListener("DOMContentLoaded", function() {
            const hargaSatuan = document.getElementById('harga_satuan');
            const banyakBarang = document.getElementById('banyak');
            const totalHarga = document.getElementById('total_harga');
            const formattedTotalHarga = document.getElementById('formattedTotalHarga');

            function hitungTotalHarga() {
                const harga = parseFloat(hargaSatuan.value.replace(/[^\d]/g, '')) || 0;
                const banyak = parseFloat(banyakBarang.value) || 0;
                const total = harga * banyak;
                totalHarga.value = total;
                formattedTotalHarga.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }

            hargaSatuan.addEventListener('input', hitungTotalHarga);
            banyakBarang.addEventListener('input', hitungTotalHarga);
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
