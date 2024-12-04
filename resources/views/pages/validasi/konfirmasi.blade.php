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
                                <label for="status" class="form-label">Status*</label>
                                <select id="status" name="status" class="form-control border-0" style="background-color: #ededed">
                                    <option value="" disabled selected>Pilih Status</option>
                                    @foreach (['Diajukan', 'Diterima', 'Diperbaiki', 'Dibelikan', 'Di Sarpras', 'Dijurusan', 'Rusak'] as $statusOption)
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
                                <label for="harga_beli" class="form-label">Harga Beli (opsional)</label>
                                <input type="text" id="harga_beli" value="{{ $pengajuan->harga_beli }}" name="harga_beli" class="form-control border-0"
                                    style="background-color: #ededed" min="0" placeholder="Masukkan harga beli"
                                    oninput="updateFormatted('harga_beli', 'formattedHargaBeli')">
                                <div id="formattedHargaBeli" style="margin-top: 5px; color: #888;"></div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="satuan_barang" class="form-label">Satuan Barang*</label>
                                <input type="text" id="satuan_barang" required value="{{ $pengajuan->satuan_barang }}" name="satuan_barang" class="form-control border-0"
                                    style="background-color: #ededed" min="0" placeholder="Masukan satuan barang">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="kode_barang" class="form-label">Kode Barang*</label>
                                <select id="kode_barang" name="kode_barang" class="form-control border-0" style="background-color: #ededed">
                                    <option value="" disabled selected>pilih Kode Barang</option>
                                    @foreach ($kodeBarang as $item)
                                        <option value="{{ $item->kode_barang }}">{{ $item->kode_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="nusp" class="form-label">NUSP*</label>
                                <select id="nusp" name="nusp" class="form-control border-0" style="background-color: #ededed">
                                    <option value="" disabled selected>( Pilih kode barang terlebih dahulu )</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="nama_barang" class="form-label">Nama Barang*</label>
                                <input type="text" id="nama_barang" value="" readonly name="nama_barang" class="form-control border-0"
                                    style="background-color: #ededed" min="0" placeholder="Nama barang otomatis muncul">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="jenis_barang" class="form-label">Jenis Barang*</label>
                                <select id="jenis_barang" required name="jenis_barang" class="form-control border-0" style="background-color: #ededed">
                                    <option value="" disabled selected>pilih jenis Barang</option>
                                    @foreach ($jenisBarang as $item)
                                        <option value="{{ $item->jenis_barang }}">{{ $item->jenis_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="nomor_permintaan" class="form-label">Nomor Permintaan*</label>
                                <input type="text" required id="nomor_permintaan" value="{{ $pengajuan->nomor_permintaan }}" name="nomor_permintaan" class="form-control border-0"
                                    style="background-color: #ededed" min="0" placeholder="Masukkan nomor permintaan">
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div>
                                <label for="tanggal_realisasi" class="form-label">Tanggal Realisasi (opsional)</label>
                                <input type="date" id="tanggal_realisasi"
                                    value="{{ $pengajuan->tanggal_realisasi }}" required name="tanggal_realisasi"
                                    class="form-control border-0" style="background-color: #ededed">
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div>
                                <label for="catatan" class="form-label">Catatan (opsional)</label>
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
