<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @auth
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                    
                    {{-- Logika untuk menampilkan foto profil atau inisial --}}
                    @if (Auth::user()->foto_profil)
                        <img class="img-profile rounded-circle" src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Foto Profil" style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        @php
                            $nameParts = explode(' ', Auth::user()->name);
                            $initials = '';
                            foreach ($nameParts as $part) {
                                if (!empty($part)) {
                                    $initials .= strtoupper(substr($part, 0, 1));
                                }
                            }
                        @endphp
                         <div class="img-profile rounded-circle d-flex justify-content-center align-items-center bg-primary text-white" style="width: 40px; height: 40px; font-weight: bold;">
                            {{ $initials }}
                        </div>
                    @endif

                @else
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Guest</span>
                    <img class="img-profile rounded-circle"
                        src="https://ui-avatars.com/api/?name=Guest&background=random">
                @endauth
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                
                @auth
                    @if(Auth::user()->role == 'admin')
                        <a class="dropdown-item" href="{{ route('admin.profil.index') }}">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profil
                        </a>
                    @elseif(Auth::user()->role == 'pelanggan')
                        <a class="dropdown-item" href="{{ route('pelanggan.profil.index') }}">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profil Saya
                        </a>
                    @endif
                    <div class="dropdown-divider"></div>
                @endauth

                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->

