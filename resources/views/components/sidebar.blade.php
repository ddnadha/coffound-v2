<?php
$user = Auth::user();
$role = $user->priv;

?>
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">{{ config('app.name') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">{{ substr(config('app.name'), 0, 2) }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item">
                <a href="{{ $role == 'admin' ? url('/admin/') : url('/owner/') }}" class="nav-link">
                    <i class="fas fa-fire"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @if ($role == 'admin')
                <li class="menu-header">Review dan Laporan</li>
                <li class="nav-item">
                    <a href="{{ url('/admin/review') }}" class="nav-link">
                        <i class="far fa-message"></i>
                        <span>Review</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/report') }}" class="nav-link">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li class="menu-header">Master Data</li>
                <li class="nav-item">
                    <a href="{{ url('/admin/category') }}" class="nav-link">
                        <i class="fas fa-boxes"></i>
                        <span>Kategori</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/user') }}" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span>User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/cafe') }}" class="nav-link">
                        <i class="fas fa-store"></i>
                        <span>Caffee</span>
                    </a>
                </li>
            @endif

            @if ($role == 'pemilik_cafe')
                <li class="menu-header">Caffee</li>
                <li class="nav-item">
                    <a href="{{ url('/owner/cafe') }}" class="nav-link">
                        <i class="far fa-message"></i>
                        <span>Caffee</span>
                    </a>
                </li>
            @endif
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-user"></i> Butuh Bantuan ?
            </a>
        </div>
    </aside>
</div>
