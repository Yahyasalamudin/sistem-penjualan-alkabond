 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
         <div class="sidebar-brand-icon ">
             {{-- <i class="fas fa-laugh-wink"></i> --}}
             <img src="{{ asset("img/logo.png") }}" width="40px" alt="">
         </div>
         <div class="sidebar-brand-text mx-3">Sejahtera Bersama</div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item active">
         <a class="nav-link" href="{{ route('dashboard') }}">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         Interface
     </div>

     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
             aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-fw fa-cog"></i>
             <span>Master Data</span>
         </a>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Master Data :</h6>
                 <a class="collapse-item" href="{{ route('city.index') }}">Kota</a>
                 <a class="collapse-item" href="{{ route('type.index') }}">Jenis Produk</a>
             </div>
         </div>
     </li>

     <!-- Nav Item - Utilities Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
             aria-expanded="true" aria-controls="collapseUtilities">
             <i class="fas fa-fw fa-wrench"></i>
             <span>Transaksi</span>
         </a>

         <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="{{ route('store.index') }}">Toko</a>
                 <a class="collapse-item" href="{{ route('product.index') }}">Produk</a>
                 <a class="collapse-item" href="{{ route('transaction.index') }}">Transaksi</a>
             </div>
         </div>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         Addons
     </div>

     <li class="nav-item">
         <a class="nav-link" href="{{ route('user.index') }}">
             <i class="fas fa-fw fa-chart-area"></i>
             <span>Pengguna</span>
         </a>
         <a class="nav-link" href="{{ route('sales.index') }}">
             <i class="fas fa-fw fa-chart-area"></i>
             <span>Sales</span>
         </a>
     </li>

     <!-- Nav Item - Tables -->
     <li class="nav-item">
         <a class="nav-link" href="tables.html">
             <i class="fas fa-fw fa-table"></i>
             <span>Tables</span></a>
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
     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>
 </ul>
