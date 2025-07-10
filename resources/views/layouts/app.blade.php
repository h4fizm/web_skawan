<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UPT Bimbingan Konseling - Universitas Negeri Medan - @yield('title') </title>

    <link rel="shortcut icon" href="{{ asset('images/logo-upt-bk.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('images/logo-upt-bk.png') }}" />

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{ filemtime(public_path('css/custom.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/app-dark.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- datatable css --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.1/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <style>
        .bawah {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            /* Optional: Add background color if needed */
            box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
            /* Optional: Add a shadow for better visibility */
            z-index: 1000;
            /* Ensure it stays on top of other content */
        }

        .announcement-bar {
            /* background-color: #feffce; */
            color: #1a1a1a;
            font-size: 14px;
            font-weight: 500;
            height: 40px;
            text-align: center;
            font-size: 14px;
        }

        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        .whatsapp-float:hover {
            background-color: #1ebe57;
        }

        .my-float {
            margin-top: 16px;
        }

        @media screen and (max-width: 992px) {
            .announcement-bar {
                font-size: 12px;
                font-weight: 400;
            }

            #main {
                margin-left: 0;
                /* Allow full width when sidebar collapses on mobile */
            }

        }

        .has-icon-left {
            display: flex;
            align-items: center;
        }

        /* Add red asterisk after label for required inputs */
        label:has(+ input[required]),
        label:has(+ select[required]),
        label:has(+ textarea[required]),
        label:has(+ .summernote[required]) {
            position: relative;
        }

        label:has(+ input[required])::after,
        label:has(+ select[required])::after,
        label:has(+ textarea[required])::after,
        label:has(+ .summernote[required])::after {
            content: " *";
            color: red;
            position: absolute;
            right: -10px;
        }
    </style>

    @yield('style')

</head>

<body>
    <div id="app">
        @include('sweetalert::alert')
        <div id="sidebar">
            @include('components.sidebar')
        </div>
        <div id="main" class="position-relative">
            @include('components.header')
            <!-- Start content here -->
            @yield('content')
            <!-- End content -->
        </div>
        @include('components.footer')
    </div>
    <script src="{{ asset('js/initTheme.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('js/dark.js') }}"></script> --}}
    <script src="{{ asset('js/perfect-scrollbar.min.js') }}"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.3.1/js/dataTables.fixedHeader.min.js"></script>
    <script src="{{ asset('js/simple-datatables.js') }}?v={{ filemtime(public_path('js/simple-datatables.js')) }}">
    </script>

    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/toast.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        const sidebar = document.getElementById('sidebar');
        // const toggleButton = document.querySelector('.sidebar-hide');

        // toggleButton.addEventListener('click', () => {
        //     sidebar.classList.add('inactive');
        //     sidebar.classList.remove('active');
        // });

        // Optional: If you have a toggle/open button
        const openSidebarBtn = document.querySelector('#toggle-sidebar'); // Replace with your actual button
        if (openSidebarBtn) {
            openSidebarBtn.addEventListener('click', () => {
                sidebar.classList.add('active');
                sidebar.classList.remove('inactive');
            });
        }
        // window.addEventListener('resize', () => {
        //     const sidebar = document.getElementById('sidebar');
        //     if (window.innerWidth >= 1200) {
        //         sidebar.classList.remove('inactive');
        //         sidebar.classList.add('active');
        //     }
        // });

        function formatDateIndonesian(dateString) {
            if (!dateString) {
                return '-';
            }

            const optionsDate = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };

            const optionsTime = {
                hour: 'numeric',
                minute: 'numeric',
                hour12: true
            };

            const date = new Date(dateString);

            // Check if the dateString contains a time component (e.g., "YYYY-MM-DDTHH:MM:SS")
            if (dateString.includes('T') || dateString.includes(':')) {
                // Include both date and time formatting
                return date.toLocaleDateString('id-ID', optionsDate) + ' ' + date.toLocaleTimeString('id-ID', optionsTime);
            } else {
                // Only format the date without time
                return date.toLocaleDateString('id-ID', optionsDate);
            }
        }

        function formatToIndonesianCurrency(number) {
            // Force the number to an integer by rounding down
            const integerNumber = Math.floor(Number(number));
            return 'Rp ' + integerNumber.toLocaleString('id-ID', {
                minimumFractionDigits: 0
            });
        }

        function showImageModal(imageUrl) {
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageUrl;
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#button-back-admin").click(function() {
                Swal.fire({
                    title: 'Kembali ke Admin?',
                    text: "Apakah anda yakin ingin kembali ke admin?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#logout-form-admin").submit();
                    }
                });
            });

            $("#button-logout").click(function() {
                Swal.fire({
                    title: 'Keluar?',
                    text: "Anda akan keluar dari aplikasi!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#logout-form").submit();
                    }
                });
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
