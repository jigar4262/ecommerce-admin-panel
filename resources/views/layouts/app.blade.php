<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="stylesheet" href="{{ asset('build/assets/extensions/choices.js/public/assets/styles/choices.css') }}">
    <link rel="shortcut icon" href="{{ asset('build/assets/compiled/svg/favicon.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('build/assets/compiled/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/compiled/css/app-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/compiled/css/iconly.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet"
        href="{{ asset('build/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/compiled/css/table-datatable-jquery.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('build/assets/extensions/filepond/filepond.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/extensions/toastify-js/src/toastify.css') }}">
    <link rel="stylesheet"
        href="{{ asset('build/assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/extensions/flatpickr/flatpickr.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('build/assets/static/js/initTheme.js') }}"></script>
    <style>
        .choices .choices__inner {
            min-height: 40px;
            padding: 0 12px;
            display: flex;
            align-items: center;

        }

        input.form-control,
        select.form-select {
            height: 40px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <div id="app">
        @include('partials.admin_sidebar')
        <div id="main" class="d-flex flex-column flex-grow-1">
            @include('partials.header')
            <div class="page-content">
                @yield('content')
            </div>
            @include('partials.footer')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('build/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('build/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <!-- Delay Mazer init until DOM ready -->

    <script src="{{ asset('build/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('build/assets/compiled/js/mazer-fix.js') }}"></script>
    <!-- Optional dashboard charts
<script src="{{ asset('build/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('build/assets//tatic/js/pages/dashboard.js') }}"></script> -->

    <!-- Form validation with parsly -->
    <!-- <script src="{{ asset('build/assets/extensions/jquery/jquery.min.js') }}"></script> -->
    <script src="{{ asset('build/assets/extensions/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('build/assets/static/js/pages/parsley.js') }}"></script>

    <!-- choice -->
    <script src="{{ asset('build/assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('build/assets/static/js/pages/form-element-select.js') }}"></script>
    <!-- data table -->

    <script src="{{ asset('build/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('build/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('build/assets/static/js/pages/datatables.js') }}"></script>

    <script
        src="{{ asset('build/assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('build/assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}">
    </script>
    <script src="{{ asset('build/assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}">
    </script>
    <script
        src="{{ asset('build/assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ asset('build/assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js') }}">
    </script>
    <script
        src="{{ asset('build/assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script src="{{ asset('build/assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.min.js">
    </script>
    <script src="{{ asset('build/assets/extensions/filepond/filepond.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="{{ asset('build/assets/static/js/pages/filepond.js') }}"></script>
    <script src="{{ asset('build/assets/extensions/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('build/assets/static/js/pages/date-picker.js') }}"></script>


    <script>
        $(document).on('input', '.numeric', function() {
            this.value = this.value.replace(/\D/g, '');
            this.value = this.value.replace(/^0+/, '');
        });

        $(document).on('focus', '.numeric', function() {
            if (this.value === '0') {
                this.value = ''; // browser ka default 0 hatado focus pe
            }
        });
        $('.numeric').each(function() {
            if (this.value === '0') this.value = '';
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Find active submenu item
            const activeItem = document.querySelector(".submenu-item.active");
            if (activeItem) {
                const parent = activeItem.closest(".sidebar-item.has-sub");

                if (parent) {
                    parent.classList.add("active", "submenu-open");

                    const submenu = parent.querySelector(".submenu");
                    if (submenu) {
                        submenu.classList.add("active");
                        submenu.style.display = "block"; // Force visible
                    }
                }
            }

            const dropdownToggles = document.querySelectorAll('.navbar .dropdown-toggle');

            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const parent = this.closest('.dropdown');
                    const menu = parent.querySelector('.dropdown-menu');
                    // Close all other dropdowns
                    document.querySelectorAll('.navbar .dropdown.show').forEach(open => {
                        if (open !== parent) {
                            open.classList.remove('show');
                            open.querySelector('.dropdown-menu')?.classList.remove('show');
                        }
                    });
                    // Toggle current dropdown
                    parent.classList.toggle('show');
                    menu.classList.toggle('show');
                });
            });

            document.addEventListener('click', function() {
                document.querySelectorAll('.navbar .dropdown.show').forEach(open => {
                    open.classList.remove('show');
                    open.querySelector('.dropdown-menu')?.classList.remove('show');
                });
            });
        });
    </script>

</body>

</html>
