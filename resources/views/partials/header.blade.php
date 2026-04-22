<header class="mb-3">
    <nav class="navbar navbar-expand navbar-light">
        <div class="container-fluid">
            <a href="javascript:void(0)" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <div class="navbar-brand ms-3">
                <h3 class="mb-0">@yield('page-title')</h3>
            </div>

            {{-- Optional right side (user profile, notifications) --}}
            <div class="navbar-nav ms-auto">
                {{-- Extend later if needed --}}
            </div>
        </div>
    </nav>
</header>
