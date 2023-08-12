 <ul class="navbar-nav bg-gradient-color sidebar sidebar-dark accordion" id="accordionSidebar">
     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
         <div class="sidebar-brand-icon ">
             <img src="{{ asset('img/logo.png') }}" width="40px" alt="">
         </div>
         <div class="sidebar-brand-text mx-3">Mortar Alkabon</div>
     </a>

     <hr class="sidebar-divider my-0">

     <li class="nav-item {{ Route::is('dashboard*') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('dashboard') }}">
             <i class="fas fa-fw fa-solid fa-home"></i>
             <span>Beranda</span></a>
     </li>

     <hr class="sidebar-divider">

     <div class="sidebar-heading">
         Data
     </div>

     <li class="nav-item {{ Route::is(['city*', 'type*', 'store*', 'product*']) ? 'active' : '' }}">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
             aria-expanded="true" aria-controls="collapseOne">
             <i class="fas fa-fw fa-cog"></i>
             <span>Master Data</span>
         </a>
         <div id="collapseOne" class="collapse {{ Route::is(['city*', 'type*', 'store*', 'product*']) ? 'show' : '' }}"
             aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Master Data :</h6>

                 <a class="collapse-item {{ Route::is('city*') ? 'active' : '' }}" href="{{ route('city.index') }}">
                     Kota
                 </a>

                 <a class="collapse-item {{ Route::is('type*') ? 'active' : '' }}" href="{{ route('type.index') }}">
                     Jenis Produk
                 </a>

                 <a class="collapse-item {{ Route::is('product*') ? 'active' : '' }}"
                     href="{{ route('product.index') }}">
                     Produk
                 </a>

                 <a class="collapse-item {{ Route::is('store*') ? 'active' : '' }}" href="{{ route('store.index') }}">
                     Toko
                 </a>
             </div>
         </div>
     </li>

     <!-- Nav Item - Utilities Collapse Menu -->
     {{-- <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
             aria-expanded="true" aria-controls="collapseUtilities">
             <i class="fas fa-fw fa-wrench"></i>
             <span>Transaksi</span>
         </a>

         <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">

                 <a class="collapse-item" href="">Transaksi</a>
             </div>
         </div>
     </li> --}}

     {{-- <li class="nav-item {{ Route::is('transaction*') ? 'active' : '' }}">
     <a class="nav-link" href="{{ route('transaction.index') }}">
         <i class="fas fa-fw fa-cash-register"></i>
         <span>Transaksi</span></a>
     </li> --}}

     <li class="nav-item {{ Route::is('transaction*') && !Request::is('transactions/archive*') ? 'active' : '' }}">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
             aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-fw fa-cash-register"></i>
             <span>Transaksi</span>
         </a>
         <div id="collapseTwo"
             class="collapse {{ Route::is('transaction*') && !Request::is('transactions/archive*') ? 'show' : '' }}"
             aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Transaksi :</h6>

                 <a class="collapse-item {{ Request::is('transactions/unsent*') ? 'active' : '' }}"
                     href="{{ route('transaction.index', 'unsent') }}">
                     Pre-Order
                 </a>

                 <a class="collapse-item {{ Request::is('transactions/proccess*') ? 'active' : '' }}"
                     href="{{ route('transaction.index', 'proccess') }}">
                     Proses
                 </a>

                 {{-- <a class="collapse-item {{ Request::is('transactions/sent*') ? 'active' : '' }}"
                     href="{{ route('transaction.index', 'sent') }}">
                     Dikirim
                 </a> --}}

                 <a class="collapse-item {{ Request::is('transactions/partial*') || Request::is('transactions/sent*') ? 'active' : '' }}"
                     href="{{ route('transaction.index', 'partial') }}">
                     Dicicil
                 </a>

                 <a class="collapse-item {{ Request::is('transactions/paid*') ? 'active' : '' }}"
                     href="{{ route('transaction.index', 'paid') }}">
                     Selesai
                 </a>
             </div>
         </div>
     </li>

     <li class="nav-item {{ Request::is('transactions/archive*') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('transaction.archive') }}">
             <i class="fas fa-fw fa-file"></i>
             <span>Arsip Transaksi</span>
         </a>
     </li>

     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         User
     </div>

     @if (auth()->user()->role == 'owner')
         <li class="nav-item {{ Route::is('user*') ? 'active' : '' }}">
             <a class="nav-link" href="{{ route('user.index') }}">
                 <i class="fas fa-fw fa-user"></i>
                 <span>Owner</span>
             </a>
         </li>
     @endif

     <li class="nav-item {{ Route::is('admin*') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('admin.index') }}">
             <i class="fas fa-fw fa-user-friends"></i>
             <span>Admin</span>
         </a>
     </li>

     <!-- Nav Item - Tables -->
     <li class="nav-item {{ Route::is('sales*') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('sales.index') }}">
             <i class="fas fa-fw fa-users"></i>
             <span>Sales</span>
         </a>
     </li>

     <hr class="sidebar-divider">

     <div class="sidebar-heading">
         Laporan
     </div>
     <li class="nav-item {{ Route::is('report.transaction') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('report.transaction') }}">
             <i class="fas fa-fw fa-solid fa-file-pdf"></i>
             <span>Laporan Transaksi</span>
         </a>
     </li>
     <li class="nav-item ">
         <a class="nav-link" href="{{ route('incomeReport') }}" target="_blank">
             <i class="fas fa-fw fa-solid fa-file-pdf"></i>
             <span>Laporan Pendapatan</span>
         </a>
     </li>

     <hr class="sidebar-divider d-none d-md-block">

     <div class="sidebar-heading">
         Keluar
     </div>

     <li class="nav-item">
         <a class="nav-link" href="{{ route('logout') }}">
             <i class="fas fa-sign-out-alt"></i>
             <span>Logout</span></a>
     </li>

     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>
 </ul>
