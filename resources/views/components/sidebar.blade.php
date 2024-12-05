<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
<script src="https://unpkg.com/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>
        <div class="header_profile d-flex align-items-center dropdown">
            <button
                class="btn btn-link text-white dropdown-toggle text-decoration-none d-flex align-items-center justify-content-end"
                type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="header_img">
                    <img src="{{ asset($user->foto) }}" alt="Profile" class="rounded-circle"
                        style="width: 40px; height: 40px; object-fit: cover;">
                </div>
                Hi, {{ $user->name }}
            </button>
            <ul class="dropdown-menu mt-2 dropdown-menu-end" aria-labelledby="profileDropdown">
                <li>
                    <a href="{{ route('resetpw', $user->id) }}" class="dropdown-item d-flex align-items-center">
                        <i class="fa-solid fa-key nav_icon me-2"></i>
                        <span class="nav_name">Ganti Password</span>
                    </a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('editUser', $user->id) }}" class="dropdown-item d-flex align-items-center">
                        <i class="fa-solid fa-pen-to-square nav_icon me-2"></i>
                        <span class="nav_name">Edit Akun</span>
                    </a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('logout') }}" class="dropdown-item text-danger d-flex align-items-center">
                        <i class="fa-solid fa-right-from-bracket nav_icon me-2"></i>
                        <span class="nav_name text-danger">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <div class="ps-3">
                    <a href="#" class="nav_logo fw-bold"><img src="{{ asset('img/smkn-2.png') }}" width="30"
                            alt=""> <span class="nav_logo-name">Sarpras | Smea</span></a>
                    <div class="pb-4">
                        <div style="height: 3px; background-color: #d9261c;"></div>
                    </div>
                    <div class="nav_list">
                        <a href="{{ route('dashboard') }}"
                            class="nav_link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                            <i class='fa-solid fa-house-chimney nav_icon'></i><span class="nav_name">Dashboard</span>
                        </a>
                        <a href="{{ route('pengajuan') }}"
                            class="nav_link {{ Request::routeIs('pengajuan') ? 'active' : '' }}">
                            <i class='fa-solid fa-book-bookmark nav_icon'></i><span class="nav_name">Pengajuan</span>
                        </a>
                        <a href="{{ route('pengambilan') }}"
                            class="nav_link {{ Request::routeIs('pengambilan') ? 'active' : '' }}">
                            <i class="fa-solid fa-book nav_icon"></i><span class="nav_name">Pengambilan</span>
                        </a>
                        @if ($user->role == 'admin')
                            <a href="{{ route('dokumen') }}"
                                class="nav_link {{ Request::routeIs('dokumen') ? 'active' : '' }}">
                                <i class="fa-solid fa-folder nav-icon"></i><span class="nav_name">Dokumen</span>
                            </a>
                            <a href="{{ route('validasi') }}"
                                class="nav_link {{ Request::routeIs('validasi') ? 'active' : '' }}">
                                <i class="fa-solid fa-circle-check nav-icon"></i><span class="nav_name">Validasi</span>
                            </a>
                            <a href="{{ route('nomorVerifikasi') }}"
                                class="nav_link {{ Request::routeIs('nomorVerifikasi') ? 'active' : '' }}">
                                <i class="fa-solid fa-note-sticky nav-icon"></i><span class="nav_name">Nota Permintaan</span>
                            </a>
                            <a href="{{ route('suratPermintaan') }}"
                                class="nav_link {{ Request::routeIs('suratPermintaan') ? 'active' : '' }}">
                                <i class="fa-solid fa-envelope nav-icon"></i><span class="nav_name">Surat Permintaan</span>
                            </a>
                            <a href="{{ route('sppb') }}"
                                class="nav_link {{ Request::routeIs('sppb') ? 'active' : '' }}">
                                <i class="fa-solid fa-file-alt nav-icon"></i><span class="nav_name">SPPB</span>
                            </a>
                            <a href="{{ route('bast') }}"
                                class="nav_link {{ Request::routeIs('bast') ? 'active' : '' }}">
                                <i class="fa-solid fa-handshake nav-icon"></i><span class="nav_name">BAST</span>
                            </a>
                            <a href="{{ route('pengeluaran') }}"
                                class="nav_link {{ Request::routeIs('pengeluaran') ? 'active' : '' }}">
                                <i class="fa-solid fa-money-bill-wave nav-icon"></i><span class="nav_name">Pengeluaran</span>
                            </a>
                            <a href="{{ route('kartuPersediaan') }}"
                                class="nav_link {{ Request::routeIs('kartuPersediaan') ? 'active' : '' }}">
                                <i class="fa-solid fa-boxes-stacked nav-icon"></i><span class="nav_name">Kartu Persediaan</span>
                            </a>
                            <a href="{{ route('kodeBarang') }}"
                                class="nav_link {{ Request::routeIs('kodeBarang') ? 'active' : '' }}">
                                <i class="fa-solid fa-code nav-icon"></i><span class="nav_name">Kode Barang</span>
                            </a>
                            <a href="{{ route('jenisBarang') }}"
                                class="nav_link {{ Request::routeIs('jenisBarang') ? 'active' : '' }}">
                                <i class="fa-solid fa-layer-group nav-icon"></i><span class="nav_name">Jenis Barang</span>
                            </a>
                            <a href="{{ route('jurusan') }}"
                                class="nav_link {{ Request::routeIs('jurusan') ? 'active' : '' }}">
                                <i class="fa-solid fa-graduation-cap nav-icon"></i><span class="nav_name">Jurusan</span>
                            </a>
                            <a href="{{ route('dana') }}"
                                class="nav_link {{ Request::routeIs('dana') ? 'active' : '' }}">
                                <i class="fa-solid fa-money-check-dollar nav-icon"></i><span
                                    class="nav_name">Dana</span>
                            </a>
                            <a href="{{ route('user') }}"
                                class="nav_link {{ Request::routeIs('user') ? 'active' : '' }}">
                                <i class="fa-solid fa-user nav_icon"></i><span class="nav_name">User</span>
                            </a>
                            <a href="{{ route('setting') }}"
                                class="nav_link {{ Request::routeIs('setting') ? 'active' : '' }}">
                                <i class="fa-solid fa-gear nav_icon"></i><span class="nav_name">Setting</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <style>
        :root {
            --header-height: 3rem;
            --nav-width: 75px;
            --first-color: white;
            --first-color-light: #9b92bf;
            --white-color: #d9261c;
            --body-font: 'Nunito', sans-serif;
            --normal-font-size: 1rem;
            --z-fixed: 100
        }

        *,
        ::before,
        ::after {
            box-sizing: border-box
        }

        body {
            position: relative;
            margin: var(--header-height) 0 0 0;
            padding: 0 1rem;
            font-family: var(--body-font);
            font-size: var(--normal-font-size);
            transition: .5s
        }

        .header {
            width: 100%;
            height: var(--header-height);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            background-color: var(--white-color);
            z-index: var(--z-fixed);
            transition: .5s
        }

        .header_toggle {
            color: var(--first-color);
            font-size: 1.5rem;
            cursor: pointer
        }

        .header_img {
            width: 35px;
            height: 35px;
            display: flex;
            justify-content: center;
            border-radius: 50%;
            overflow: hidden
        }

        .header_profile {
            display: flex;
            align-items: center;
        }

        .header_profile span {
            color: #000;
            font-size: 1rem;
            font-weight: 500;
        }

        .header_img img {
            width: 40px
        }

        .l-navbar {
            position: sticky;
            overflow: hidden;
            top: 0;
            left: -30%;
            width: var(--nav-width);
            height: 100vh;
            background-color: var(--first-color);
            padding: .5rem 1rem 0 0;
            transition: .5s;
            z-index: var(--z-fixed);
        }

        @media (max-width: 992px) {
            .l-navbar {
                position: fixed;
                top: 0;
                left: -30%;
                width: var(--nav-width);
                height: 100vh;
                background-color: var(--first-color);
                padding: .5rem 1rem 0 0;
                transition: .5s;
                z-index: var(--z-fixed);
            }
        }

        .nav {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden
        }

        .nav_logo,
        .nav_link {
            text-decoration: none;
            display: grid;
            grid-template-columns: max-content max-content;
            align-items: center;
            column-gap: 1rem;
            padding: .5rem 0 .5rem 12px
        }

        .nav_logo {
            text-decoration: none;
            display: grid;
            grid-template-columns: max-content max-content;
            align-items: center;
            column-gap: 1rem;
            padding: .5rem 0.5rem 7px
        }

        .header_profile .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            /* Jarak antara gambar dan teks */
            padding: 0;
            /* Hindari padding bawaan */
            border: none;
            /* Hindari border tambahan */
            background: none;
            /* Hindari latar belakang tambahan */
            outline: none;
            /* Hindari outline saat diklik */
            box-shadow: none;
            /* Hilangkan bayangan jika ada */
        }

        .header_profile .dropdown-menu {
            margin: 0;
            /* Hindari margin bawaan */
            padding: 0.5rem;
            /* Atur padding sesuai keinginan */
        }



        .nav_logo {
            margin-bottom: 1.4rem
        }

        .nav_logo-icon {
            font-size: 1.25rem;
            color: var(--white-color)
        }

        .nav_logo-name {
            color: var(--white-color);
            font-weight: 700
        }

        .nav_link {
            position: relative;
            color: var(--first-color-light);
            margin-bottom: 0.5rem;
            transition: .1s
            font-size: 0.75rem; /* Perkecil ukuran teks */
    padding: 0.2rem 0.9rem; /* Kurangi padding */
        }

        @media screen and (max-height: 750px) {
    .nav_icon {
        font-size: 0.9rem !important;
    }

    .nav_link {
        font-size: 0.7rem;
        padding: 0.10rem 1rem;
    }
}


        .nav_icon {
            font-size: 1rem; /* Perkecil ukuran ikon */

        }
        .nav_link:hover {
            color: white;
            background-color: var(--white-color);

            overflow: hidden;
        }

        .show .nav_link:hover {}


        .show {
            left: 0
        }

        .body-pd {
            padding-left: calc(var(--nav-width) + 1rem)
        }

        .active {
            color: white;
            background-color: var(--white-color);

            overflow: hidden;
        }

        .show .active {
            /* When the sidebar is open, this handles full width */

        }

        .l-navbar:not(.show) .nav_link.active {
            /* Apply border-radius to both sides even when the sidebar is collapsed */

            width: calc(var(--nav-width) - 32px);
            /* Extend the width slightly when collapsed */
        }

        .l-navbar:not(.show) .nav_link:hover {
            /* Apply border-radius to both sides even when the sidebar is collapsed */

            width: calc(var(--nav-width) - 32px);
            /* Extend the width slightly when collapsed */
        }

        .height-100 {
            height: 100vh
        }

        @media print {

            .l-navbar,
            .header {
                display: none;
                /* Sembunyikan sidebar dan navbar saat mencetak */
            }

            body {
                margin: 0;
                /* Hapus margin saat mencetak */
                padding: 0;
                /* Hapus padding saat mencetak */
            }
        }

        @media screen and (min-width: 992px) {
            body {
                margin: calc(var(--header-height) + 1rem) 0 0 0;
                padding-left: calc(var(--nav-width) + 2rem)
            }

            .header {
                height: calc(var(--header-height) + 1rem);
                padding: 0 2rem 0 calc(var(--nav-width) + 2rem)
            }

            .header_img {
                width: 40px;
                height: 40px
            }

            .header_img img {
                width: 45px
            }

            .l-navbar {
                left: 0;
                padding: 1rem 1rem 0 0
            }

            .show {
                width: calc(var(--nav-width) + 156px)
            }

            .body-pd {
                padding-left: calc(var(--nav-width) + 188px)
            }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const showNavbar = (toggleId, navId, bodyId, headerId) => {
                const toggle = document.getElementById(toggleId),
                    nav = document.getElementById(navId),
                    bodypd = document.getElementById(bodyId),
                    headerpd = document.getElementById(headerId)

                // Cek apakah sidebar dalam keadaan terbuka di localStorage
                if (localStorage.getItem('sidebarOpen') === 'true') {
                    nav.classList.add('show');
                    toggle.classList.add('bx-x');
                    bodypd.classList.add('body-pd');
                    headerpd.classList.add('body-pd');
                }

                if (toggle && nav && bodypd && headerpd) {
                    toggle.addEventListener('click', () => {
                        // Toggle kelas 'show' untuk sidebar
                        nav.classList.toggle('show');
                        toggle.classList.toggle('bx-x');
                        bodypd.classList.toggle('body-pd');
                        headerpd.classList.toggle('body-pd');

                        // Simpan status sidebar ke localStorage
                        if (nav.classList.contains('show')) {
                            localStorage.setItem('sidebarOpen', 'true');
                        } else {
                            localStorage.setItem('sidebarOpen', 'false');
                        }
                    });
                }
            }

            showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header');

            const linkColor = document.querySelectorAll('.nav_link');

            function colorLink() {
                if (linkColor) {
                    linkColor.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                }
            }
            linkColor.forEach(l => l.addEventListener('click', colorLink));
        });
    </script>
</body>
