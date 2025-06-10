<div class="main-sidebar sidebar-style-2">
    <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="index.html">RM. MANG MEDI</a>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <a href="index.html">EMPAL</a>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li class="{{ Request::is('home*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('home') }}"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
                </li>
                <li class="menu-header">Daftar Pengguna</li>
                <li class="{{ Request::is('user*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('user.index')}}"><i class="fas fa-user"></i><span>Pengguna</span></a>
                </li>
                <li class="menu-header">Daftar Kategori</li>
                <li class="{{ Request::is('category*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('category.index')}}"><i class="fas fa-list-alt"></i><span>Kategori</span></a>
                </li>
                <li class="menu-header">Daftar Menu</li>
                <li class="{{ Request::is('product*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('product.index')}}"><i class="fas fa-box"></i><span>Menu</span></a>
                </li>
                <li class="menu-header">Laporan Penjualan</li>
                <li class="{{ Request::is('report*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('report.index')}}"><i class="fas fa-box"></i><span>Laporan Penjualan</span></a>
                </li>
            </ul>
        </aside>
    </div>
</div>
