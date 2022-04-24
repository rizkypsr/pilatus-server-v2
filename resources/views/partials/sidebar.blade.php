 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="{{ url('/') }}" class="brand-link">
         <span class="brand-text">Pilatus Showroom</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <li class="nav-item">
                     <a href="{{ url('/') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ url('users') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-user-alt"></i>
                         <p>
                             Users
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ url('products') }}"
                         class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-gifts"></i>
                         <p>
                             Produk
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ url('categories') }}"
                         class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-align-justify"></i>
                         <p>
                             Kategori
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ url('orders') }}" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-cash-register"></i>
                         <p>
                             Transaksi
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ url('reports') }}"
                         class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-receipt"></i>
                         <p>
                             Laporan
                         </p>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
