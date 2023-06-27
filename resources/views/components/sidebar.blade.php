<?php
$user = Auth::user();
$role = $user->priv;

?>
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand" style="height: 78px; line-height: 78px">
            <img src="/logo.png" alt="logo" height="50"><br>
            <p class="font-weight-bold m-0">Coffound</p>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            {{-- <a href="#">{{ substr(config('app.name'), 0, 2) }}</a> --}}
            <a href="">
                <img src="/logo.png" alt="logo" width="50">
            </a>
        </div>
        <ul class="sidebar-menu pt-3">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item @if (Request::is('admin') or Request::is('owner')) active @endif ">
                <a href="{{ $role == 'admin' ? url('/admin/') : url('/owner/') }}" class="nav-link">
                    <i class="fas fa-fire"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @if ($role == 'admin')
                <li class="menu-header">Review dan Laporan</li>
                <li class="nav-item @if (Request::is('admin/review')) active @endif">
                    <a href="{{ url('/admin/review') }}" class="nav-link">
                        <i class="far fa-message"></i>
                        <span>Review</span>
                    </a>
                </li>
                <li class="nav-item @if (Request::is('admin/report')) active @endif">
                    <a href="{{ url('/admin/report') }}" class="nav-link">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li class="menu-header">Permintaan Hapus dan Aktivasi</li>
                <li class="nav-item @if (Request::is('admin/deletion')) active @endif">
                    <a href="{{ url('/admin/deletion') }}" class="nav-link">
                        <i class="fas fa-trash"></i>
                        <span>Permintaan Hapus Kafe</span>
                    </a>
                </li>
                <li class="nav-item @if (Request::is('admin/activation')) active @endif">
                    <a href="{{ url('/admin/activation') }}" class="nav-link">
                        <i class="fas fa-power-off  "></i>
                        <span>Permintaan Aktivasi </span>
                    </a>
                </li>
                <li class="menu-header">Master Data</li>
                <li class="nav-item @if (Request::is('admin/category')) active @endif">
                    <a href="{{ url('/admin/category') }}" class="nav-link">
                        <i class="fas fa-boxes"></i>
                        <span>Kategori</span>
                    </a>
                </li>
                <li class="nav-item @if (Request::is('admin/user')) active @endif">
                    <a href="{{ url('/admin/user') }}" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span>User</span>
                    </a>
                </li>
                <li class="nav-item @if (Request::is('admin/cafe')) active @endif">
                    <a href="{{ url('/admin/cafe') }}" class="nav-link">
                        <i class="fas fa-store"></i>
                        <span>Caffee</span>
                    </a>
                </li>
            @endif

            @if ($role == 'pemilik_cafe')
                <li class="menu-header">Caffee</li>
                <li class="nav-item @if (Request::is('owner/cafe/*')) active @endif">
                    <a href="{{ url('/owner/cafe') }}" class="nav-link">
                        <i class="far fa-message"></i>
                        <span>Caffee</span>
                    </a>
                </li>
            @endif
        </ul>
        @if ($role != 'admin')
            <div class="mt-4
        mb-4 p-3 hide-sidebar-mini">
                <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                    <i class="fas fa-user"></i> Butuh Bantuan ?
                </a>
            </div>
        @endif
    </aside>
</div>
