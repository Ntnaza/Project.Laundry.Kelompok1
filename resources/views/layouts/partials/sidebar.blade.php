<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.pengaturan.edit') }}">
        <div class="sidebar-brand-icon">
            @if ($pengaturan && $pengaturan->logo)
                <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" style="height: 40px; border-radius: 50%;">
            @else
                <i class="fas fa-laugh-wink"></i>
            @endif
        </div>
        <div class="sidebar-brand-text mx-3">{{ $pengaturan->nama_laundry ?? 'Laundry' }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen
    </div>

    <!-- Nav Item - Transaksi -->
    <li class="nav-item {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.transaksi.index') }}">
            <i class="fas fa-fw fa-cash-register"></i>
            <span>Transaksi</span></a>
    </li>

    <!-- Nav Item - Paket -->
    <li class="nav-item {{ request()->routeIs('admin.paket.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.paket.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>Paket Laundry</span></a>
    </li>
    <!--Nav Item Diskon -->
    <li class="nav-item {{ request()->routeIs('admin.diskon.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.diskon.index') }}">
            <i class="fas fa-fw fa-percent"></i>
            <span>Manajemen Diskon</span></a>
    </li>
    <!-- Nav Item - Pelanggan -->
    <li class="nav-item {{ request()->routeIs('admin.pelanggan.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pelanggan.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Pelanggan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan
    </div>

    <!-- Nav Item - Laporan -->
    <li class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.laporan.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan Transaksi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pengaturan
    </div>

    <!-- Nav Item - Profil Laundry -->
    <li class="nav-item {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pengaturan.edit') }}">
            <i class="fas fa-fw fa-store"></i>
            <span>Profil Laundry</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
