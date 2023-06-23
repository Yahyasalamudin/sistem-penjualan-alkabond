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
                     Belum dikirim
                 </a>

                 <a class="collapse-item {{ Request::is('transactions/proccess*') ? 'active' : '' }}"
                     href="{{ route('transaction.index', 'proccess') }}">
                     Proses
                 </a>

                 <a class="collapse-item {{ Request::is('transactions/sent*') ? 'active' : '' }}"
                     href="{{ route('transaction.index', 'sent') }}">
                     Dikirim
                 </a>

                 <a class="collapse-item {{ Request::is('transactions/partial*') ? 'active' : '' }}"
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

     <li class="nav-item {{ Route::is('user*') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('user.index') }}">
             <i class="fas fa-fw fa-user"></i>
             <span>Pengguna</span>
         </a>
     </li>

     <!-- Nav Item - Tables -->
     <li class="nav-item {{ Route::is('sales*') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('sales.index') }}">
             <i class="fas fa-fw fa-users"></i>
             <span>Sales</span>
         </a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         Laporan
     </div>

     <li class="nav-item ">
         <a class="nav-link" href="#" data-toggle="modal" data-target="#filter-tanggal">
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


     <!-- Divider -->
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

     {{-- Modal Filter Laporan --}}
     <div class="modal fade" id="filter-tanggal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <form action="{{ route('transactionReport') }}" target="_blank" method="post">
                     @csrf
                     <div class="modal-body">
                         <label for="status">Status Transaksi</label>
                         <select class="form-control mb-3" name="status" id="status">
                             <option value="semua">Semua</option>
                             <option value="unsent">Belum Dikirim</option>
                             <option value="process">Proses</option>
                             <option value="sent">Dikirim</option>
                             <option value="partial">Cicilan</option>
                             <option value="paid">Selesai / Lunas</option>
                         </select>

                         <label for="tgl_awal">Tanggal Awal Transaksi</label>
                         <input class="form-control mb-3" type="date" name="tgl_awal" id="tgl_awal">

                         <label for="tgl_akhir">Tanggal Akhir Transaksi</label>
                         <input class="form-control mb-3" type="date" name="tgl_akhir" id="tgl_akhir"
                             placeholder="Masukkan Nama Merk">
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                         <button type="submit" class="btn btn-primary">Cetak Data</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </ul>
