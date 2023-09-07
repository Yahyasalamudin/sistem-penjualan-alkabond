@php
    $user = auth()->user();
@endphp
@push('js')
    <script>
        const input_filter_kota = document.getElementById("input-filter-kota");
        const filterKotaForm = document.getElementById("filterKotaForm");

        if (input_filter_kota) {
            input_filter_kota.addEventListener("change", function() {
                filterKotaForm.submit();
            })
        }

        const input_cabang_kota = document.getElementById("input-filter-cabang-kota");
        const filterCabangKotaForm = document.getElementById("filterCabangKotaForm");

        input_cabang_kota.addEventListener("change", function() {
            filterCabangKotaForm.submit();
        })
    </script>
@endpush

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    @if ($user->role == 'owner')
        <label for="input-filter-kota" class="col-sm-1 col-form-label text-center">Cabang Gudang</label>
        <div class="col-2">
            <form action="{{ route('filterKota') }}" method="post" id="filterKotaForm">
                @csrf
                <select class="form-control  @error('active') is-invalid @enderror" name="filterKota"
                    id="input-filter-kota">
                    <option value="">Semua Cabang</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ session('filterKota') == $city->id ? 'selected' : '' }}>
                            {{ $city->city }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    @endif

    <label for="input-filter-cabang-kota" class="col-sm-1 col-form-label text-center">Kota</label>
    <div class="col-2">
        <form action="{{ route('filterCabangKota') }}" method="post" id="filterCabangKotaForm">
            @csrf
            <select class="form-control  @error('active') is-invalid @enderror" name="filterCabangKota"
                id="input-filter-cabang-kota">
                <option value="">Semua Kota</option>
                @foreach ($city_branches_topbar as $branch)
                    @if (
                        ($user->role === 'owner' && $branch->city_id == session('filterKota')) ||
                            ($user->role === 'admin' && $branch->city_id == $user->city_id))
                        <option value="{{ $branch->id }}"
                            {{ session('filterCabangKota') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->branch }}</option>
                    @endif
                @endforeach
            </select>
        </form>
    </div>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $user->name }}</span>
                <img class="img-profile rounded-circle" src="{{ asset('img/blank-profile-picture-973460_1280.webp') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
