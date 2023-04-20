 <ul class="navbar-nav bg-gradient-color sidebar sidebar-dark accordion" id="accordionSidebar">
     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
         <div class="sidebar-brand-icon ">
             {{-- <i class="fas fa-laugh-wink"></i> --}}
             <img src="{{ asset('img/logo.png') }}" width="40px" alt="">
         </div>
         <div class="sidebar-brand-text mx-3">Sejahtera Bersama</div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item {{ Route::is('dashboard*') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('dashboard') }}">
             <i class="fas fa-fw fa-solid fa-home"></i>
             <span>Dashboard</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         Interface
     </div>

     <li class="nav-item {{ Route::is(['city*', 'type*', 'store*', 'product*']) ? 'active' : '' }}">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
             aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-fw fa-cog"></i>
             <span>Master Data</span>
         </a>
         <div id="collapseTwo" class="collapse {{ Route::is(['city*', 'type*', 'store*', 'product*']) ? 'show' : '' }}"
             aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Master Data :</h6>

                 <a class="collapse-item {{ Route::is('city*') ? 'active' : '' }}" href="{{ route('city.index') }}">
                     Kota
                 </a>

                 <a class="collapse-item {{ Route::is('type*') ? 'active' : '' }}" href="{{ route('type.index') }}">
                     Jenis Produk
                 </a>

                 <a class="collapse-item {{ Route::is('store*') ? 'active' : '' }}" href="{{ route('store.index') }}">
                     Toko
                 </a>

                 <a class="collapse-item {{ Route::is('product*') ? 'active' : '' }}"
                     href="{{ route('product.index') }}">
                     Produk
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

     <li class="nav-item {{ Route::is('transaction*') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('transaction.index') }}">
             <i class="fas fa-fw fa-table"></i>
             <span>Transaksi</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         Addons
     </div>

     <li class="nav-item {{ Route::is('user*') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('user.index') }}">
             <i class="fas fa-fw fa-chart-area"></i>
             <span>Pengguna</span>
         </a>
     </li>

     <!-- Nav Item - Tables -->
     <li class="nav-item {{ Route::is('sales*') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('sales.index') }}">
             <i class="fas fa-fw fa-chart-area"></i>
             <span>Sales</span>
         </a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">

     <div class="sidebar-heading">
         Addons
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
