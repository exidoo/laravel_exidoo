<!DOCTYPE html>

@include('subs.menu')
<!-- =========================================================
* Sneat - Template Admin HTML Bootstrap 5 - Pro | v1.0.0
==============================================================

* Halaman Produk: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Dibuat oleh: ThemeSelection
* Lisensi: Anda harus memiliki lisensi yang sah untuk dapat menggunakan tema ini secara legal dalam proyek Anda.
* Hak Cipta ThemeSelection (https://themeselection.com)

========================================================= -->
<!-- beautify ignore:start -->
<html
lang="id"
class="light-style layout-menu-fixed"
dir="ltr"
data-theme="theme-default"
data-assets-path="../assets/"
data-template="vertical-menu-template-free"
>
    <head>
        @include('subs.header-meta')
        @stack('styles')
    </head>

    <body>
        <!-- Pembungkus Tata Letak -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                @stack('content-menu')
                <!-- Kontainer Tata Letak -->
                <div class="layout-page">
                    <!-- Navbar -->
                    @include('subs.navbar')
                    <!-- / Navbar -->

                    <!-- Pembungkus Konten -->
                    <div class="content-wrapper">
                        <!-- Konten -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Pembungkus Tata Letak -->

        @include('subs.footer-script')
        @stack('scripts')

    </body>
</html>
