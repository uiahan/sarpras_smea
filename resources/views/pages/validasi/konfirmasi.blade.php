@extends('layout.master')
@section('title', 'Konfirmasi')
@section('content')
    <div class="d-flex">
        @include('components.sidebar')
        <div class="container mt-4 mt-md-5 py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="cool-xl-6 col-12">
                        <h3 class="fw-bold text-secondary">Konfirmasi Pengajuan</h3>
                        <h6 class="text-secondary">Spesifikasi nama barang : {{ $pengajuan->barang }}</h6>
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
                                <select id="status" name="status" class="form-control border-0"
                                    style="background-color: #ededed">
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
                                <input type="text" id="harga_beli" value="{{ $pengajuan->harga_beli }}" name="harga_beli"
                                    class="form-control border-0" style="background-color: #ededed" min="0"
                                    placeholder="Masukkan harga beli"
                                    oninput="updateFormatted('harga_beli', 'formattedHargaBeli')">
                                <div id="formattedHargaBeli" style="margin-top: 5px; color: #888;"></div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="satuan_barang" class="form-label">Satuan Barang*</label>
                                <input type="text" id="satuan_barang" required value="{{ $pengajuan->satuan_barang }}"
                                    name="satuan_barang" class="form-control border-0" style="background-color: #ededed"
                                    min="0" placeholder="Masukan satuan barang">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="jenis_barang" class="form-label">Jenis Barang*</label>
                                <select id="jenis_barang" required name="jenis_barang" class="form-control border-0"
                                    style="background-color: #ededed">
                                    <option value="" disabled selected>pilih jenis Barang</option>
                                    @foreach ($jenisBarang as $item)
                                        <option value="{{ $item->jenis_barang }}"
                                            {{ $pengajuan->jenis_barang == $item->jenis_barang ? 'selected' : '' }}>
                                            {{ $item->jenis_barang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Select kode_barang -->
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="kode_barang" class="form-label">Kode Barang*</label>
                                <select id="kode_barang" name="kode_barang_id" class="form-control border-0"
                                    style="background-color: #ededed">
                                    <option value="" disabled selected>Pilih Kode Barang</option>
                                    @foreach ($kodeBarang as $item)
                                        <option value="{{ $item->id }}" data-kode-barang="{{ $item->kode_barang }}"
                                            {{ $pengajuan->kode_barang == $item->kode_barang ? 'selected' : '' }}>
                                            {{ $item->kode_barang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Input hidden untuk kode_barang -->
                        <input type="hidden" id="kode_barang_hidden" name="kode_barang"
                            value="{{ $pengajuan->kode_barang }}">


                            <div class="col-6 mt-3">
                                <div>
                                    <label for="nusp" class="form-label">NUSP*</label>
                                    <select id="nusp" name="nusp" class="form-control border-0"
                                        style="background-color: #ededed">
                                        <option value="" disabled {{ empty($pengajuan->nusp) ? 'selected' : '' }}>Pilih NUSP</option>
                                        @foreach ($detailKodeBarang as $item)
                                            <option value="{{ $item->nusp }}" 
                                                data-kode-barang="{{ $item->kode_barang_id }}" 
                                                data-nama-barang="{{ $item->nama_barang }}" 
                                                {{ $pengajuan->nusp == $item->nusp ? 'selected' : '' }}>
                                                {{ $item->nusp }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-3">
                                <div>
                                    <label for="nama_barang" class="form-label">Nama Barang*</label>
                                    <select id="nama_barang" name="nama_barang" class="form-control border-0"
                                        style="background-color: #ededed">
                                        <option value="" disabled {{ empty($pengajuan->nama_barang) ? 'selected' : '' }}>Pilih Nama Barang</option>
                                        @foreach ($detailKodeBarang as $item)
                                            <option value="{{ $item->nama_barang }}" 
                                                data-kode-barang="{{ $item->kode_barang_id }}" 
                                                data-nusp="{{ $item->nusp }}" 
                                                {{ $pengajuan->nama_barang == $item->nama_barang ? 'selected' : '' }}>
                                                {{ $item->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            

                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="nomor_permintaan" class="form-label">Nomor Permintaan*</label>
                                <input type="text" required id="nomor_permintaan"
                                    value="{{ $pengajuan->nomor_permintaan }}" name="nomor_permintaan"
                                    class="form-control border-0" style="background-color: #ededed" min="0"
                                    placeholder="Masukkan nomor permintaan">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 mt-3">
                            <div>
                                <label for="tanggal_realisasi" class="form-label">Tanggal Realisasi (opsional)</label>
                                <input type="date" id="tanggal_realisasi" value="{{ $pengajuan->tanggal_realisasi }}"
                                    required name="tanggal_realisasi" class="form-control border-0"
                                    style="background-color: #ededed">
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
                                onclick="window.history.back();" style="background-color: #d9261c">
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

        document.getElementById('kode_barang').addEventListener('change', function() {

            let kodeBarang = this.value;
            console.log(kodeBarang);

            if (kodeBarang) {
                fetch(`/get-nusp/${kodeBarang}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Debugging untuk melihat data yang diterima
                        let nuspSelect = document.getElementById('nusp');
                        nuspSelect.innerHTML = ''; // Clear existing options
                        let defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.disabled = true;
                        defaultOption.selected = true;
                        defaultOption.textContent = '(Pilih kode barang terlebih dahulu)';
                        nuspSelect.appendChild(defaultOption);

                        data.forEach(item => {
                            let option = document.createElement('option');
                            option.value = item.nusp; // Pastikan item.nusp berisi nilai yang benar
                            option.textContent = item.nusp;
                            nuspSelect.appendChild(option);
                        });
                    });
            }
        });

        $(document).ready(function() {

            // Ketika kode_barang dipilih
            $('#kode_barang').change(function() {
                var kodeBarangId = $(this).val(); // Ambil nilai kode_barang yang dipilih

                // Menampilkan hanya nama_barang yang sesuai dengan kode_barang
                $('#nama_barang').find('option').each(function() {
                    var optionKodeBarang = $(this).data('kode-barang');

                    // Menyembunyikan nama_barang yang tidak sesuai dengan kode_barang
                    if (optionKodeBarang != kodeBarangId && kodeBarangId != "") {
                        $(this).hide();
                    } else {
                        $(this).show(); // Menampilkan nama_barang yang sesuai
                    }
                });
                // Menampilkan hanya nama_barang yang sesuai dengan kode_barang
                $('#nusp').find('option').each(function() {
                    var optionKodeBarang = $(this).data('kode-barang');

                    // Menyembunyikan nama_barang yang tidak sesuai dengan kode_barang
                    if (optionKodeBarang != kodeBarangId && kodeBarangId != "") {
                        $(this).hide();
                    } else {
                        $(this).show(); // Menampilkan nama_barang yang sesuai
                    }
                });

                // Reset nilai nama_barang dan nusp jika kode_barang diubah
                $('#nama_barang').val('');
                $('#nusp').val('');
            });

            // Ketika nama_barang dipilih
            $('#nama_barang').change(function() {
                var selectedOption = $(this).find('option:selected');
                var kodeBarangId = selectedOption.data('kode-barang');
                var nusp = selectedOption.data('nusp');

                // Menyembunyikan nama_barang yang tidak sesuai dengan kode_barang
                $('#nama_barang').find('option').each(function() {
                    var optionKodeBarang = $(this).data('kode-barang');

                    // Menyembunyikan nama_barang yang tidak sesuai dengan kode_barang
                    if (optionKodeBarang != kodeBarangId && kodeBarangId != "") {
                        $(this).hide();
                    } else {
                        $(this).show(); // Menampilkan nama_barang yang sesuai
                    }
                });

                $('#nusp').find('option').each(function() {
                    var optionKodeBarang = $(this).data('kode-barang');

                    // Menyembunyikan nama_barang yang tidak sesuai dengan kode_barang
                    if (optionKodeBarang != kodeBarangId && kodeBarangId != "") {
                        $(this).hide();
                    } else {
                        $(this).show(); // Menampilkan nama_barang yang sesuai
                    }
                });

                // Mengupdate kode_barang
                $('#kode_barang').val(kodeBarangId); // Mengisi kode_barang tanpa menonaktifkan select

                // Mengupdate nusp sesuai dengan nama_barang yang dipilih
                $('#nusp').val(nusp); // Mengisi nusp otomatis sesuai nama_barang yang dipilih
            });


        });

        $(document).ready(function() {

            // When nusp changes
            $('#nusp').change(function() {
                var nusp = $(this).val(); // Get the selected nusp value

                if (nusp) {
                    // Make an AJAX request to fetch nama_barang based on the selected nusp
                    $.ajax({
                        url: '/get-nama-barang/' +
                        nusp, // Assuming this is your route to get the nama_barang
                        method: 'GET',
                        success: function(data) {
                            if (data.nama_barang) {
                                // Set the nama_barang and kode_barang based on the response
                                $('#nama_barang').val(data
                                .nama_barang); // Set the nama_barang field
                                $('#kode_barang').val(data
                                .kode_barang_id); // Set the kode_barang_id field
                            }
                        },
                        error: function() {
                            // Handle the case where no matching nusp is found
                            $('#nama_barang').val(''); // Clear nama_barang field if no match
                            $('#kode_barang').val(''); // Clear kode_barang field if no match
                        }
                    });
                } else {
                    // Reset if nusp is cleared
                    $('#nama_barang').val('');
                    $('#kode_barang').val('');
                }
            });

        });

        $(document).ready(function() {
            $('#submit-btn').on('click', function() {
                // Ambil data kode_barang yang dipilih dari atribut data-kode-barang
                const selectedOption = $('#kode_barang option:selected');
                const kodeBarang = selectedOption.data(
                'kode-barang'); // Ambil data-kode-barang dari opsi terpilih

                // Set nilai input hidden dengan kode_barang
                if (kodeBarang) {
                    $('#kode_barang_hidden').val(kodeBarang); // Masukkan kode_barang ke input hidden
                }

                // Kirimkan form
                $('#form-edit-pengajuan').submit();
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
