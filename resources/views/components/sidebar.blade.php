<div class="sidebar-wrapper inactive">
    <div class="sidebar-header position-relative">
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
                <a href="{{ route('products.index') }}">
                    <img src="{{ asset('image/icon.JPG') }}" alt="Logo">
                </a>
            </div>
            <div class="sidebar-toggler x">
                <a href="#" class="sidebar-hide d-xl-none d-block text-white fw-bold">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>

            {{-- @can('lihat-beranda')
                <li class="sidebar-item {{ request()->routeIs('products.index') ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}" class="sidebar-link">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Beranda</span>
                    </a>
                </li>
            @endcan --}}

            @can('kelola-product')
                <li
                    class="sidebar-item {{ request()->routeIs('products.index') ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}" class="sidebar-link">
                        <i class="bi bi-stack"></i>
                        <span>Products</span>
                    </a>
                </li>
            @endcan

            @can('kelola-kategori-product')
                <li
                    class="sidebar-item {{ request()->routeIs('products-categories.index') ? 'active' : '' }}">
                    <a href="{{ route('products-categories.index') }}" class="sidebar-link">
                        <i class="bi bi-file-earmark-medical-fill"></i>
                        <span>Kategori Produk</span>
                    </a>
                </li>
            @endcan

            @if (auth()->user()->can('manage-konselor') ||
                    auth()->user()->can('kelola-pengguna') ||
                    auth()->user()->can('lihat-peran') ||
                    auth()->user()->can('lihat-perizinan'))
                <li class="sidebar-title">Kontrol Akses Berbasis Peran</li>
            @endif

            @can('manage-konselor')
                <li class="sidebar-item {{ request()->routeIs('konselor.index') ? 'active' : '' }}">
                    <a href="{{ route('konselor.index') }}" class="sidebar-link">
                        <i class="bi bi-people-fill"></i>
                        <span>Data Konselor</span>
                    </a>
                </li>
            @endcan

            @can('kelola-pengguna')
                <li class="sidebar-item {{ request()->routeIs('manage-users.index') ? 'active' : '' }}">
                    <a href="{{ route('manage-users.index') }}" class="sidebar-link">
                        <i class="bi bi-person-gear"></i>
                        <span>Kelola Pengguna</span>
                    </a>
                </li>
            @endcan

            @can('lihat-peran')
                <li class="sidebar-item {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}" class="sidebar-link">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Peran</span>
                    </a>
                </li>
            @endcan

            @can('lihat-perizinan')
                <li class="sidebar-item {{ request()->routeIs('permissions.index') ? 'active' : '' }}">
                    <a href="{{ route('permissions.index') }}" class="sidebar-link">
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>Perizinan</span>
                    </a>
                </li>
            @endcan

            <li class="sidebar-title">Keluar</li>
            <li class="sidebar-item">
                <a type="button" class="sidebar-link" id="button-logout">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Keluar</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
