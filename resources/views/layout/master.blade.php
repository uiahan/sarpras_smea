<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('img/smkn-2.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/smkn-2.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <title>Sarpras | @yield('title')</title>
</head>

<body style="background-color: #f4f4f4; margin: 0; padding: 0; max-width: 100%; overflow-x: hidden;">

    @yield('content')

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "200", // Waktu muncul lebih cepat
                "hideDuration": "500", // Waktu hilang lebih cepat
                "timeOut": "3000", // Durasi waktu tampilan notifikasi (3000ms = 3 detik)
                "extendedTimeOut": "1000", // Durasi waktu saat mouse hover (1000ms = 1 detik)
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            @if (session('notif'))
                toastr.success("{{ session('notif') }}");
            @endif
        });

        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "200", // Waktu muncul lebih cepat
                "hideDuration": "500", // Waktu hilang lebih cepat
                "timeOut": "3000", // Durasi waktu tampilan notifikasi (3000ms = 3 detik)
                "extendedTimeOut": "1000", // Durasi waktu saat mouse hover (1000ms = 1 detik)
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"

            };

            @if (session('error'))
                toastr.error("{{ session('error') }}"); // Menampilkan notifikasi error
            @endif
        });


        $(document).on('click', '.delete-btn', function(event) {
    event.preventDefault(); // Hindari navigasi default dari tag <a>

    const url = $(this).attr('href'); // Ambil URL dari atribut href

    // SweetAlert konfirmasi
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data ini akan dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim permintaan GET menggunakan fetch
            fetch(url, {
                method: 'GET', // Karena Anda menggunakan GET
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Identifikasi sebagai AJAX
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Terhapus!', data.message, 'success');
                    $('#example').DataTable().ajax.reload(); // Reload DataTable
                } else {
                    Swal.fire('Gagal!', data.message || 'Gagal menghapus data.', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
                console.error('Error:', error);
            });
        }
    });
});

    </script>
    <style>
        .toast {
            opacity: 0.9 !important;
            background-color: #00983d !important;
            padding: 15px 20px;
            margin: 10px;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .toast.toast-error {
            background-color: #dc3545 !important;
            /* Warna merah */
            color: white !important;
            /* Teks berwarna putih */
        }

        .toast:hover {
            transform: scale(1.01);
        }

        .toast .toast-message {
            color: #ffffff;
        }
    </style>
</body>

</html>
