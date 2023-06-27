<nav class="navbar-bottom">
    <a href="{{ url('mobile/home') }}" class="nav-item-bottom" id="nav-item-home">
        <i class="fas fa-home"></i> Beranda
    </a>
    <a href="{{ url('mobile/favourite') }}" class="nav-item-bottom" id="nav-item-fav">
        <i class="fas fa-heart"></i> Favorit
    </a>
    <a href="{{ url('mobile/discover') }}" class="nav-item-bottom nav-item-special">
        <div class="circle-button">
            <i class="icon-special fas fa-search m-auto"></i>
        </div>
    </a>
    <a href="{{ url('mobile/open') }}" class="nav-item-bottom" id="nav-item-open">
        <i class="fas fa-shop"></i> Kafe
    </a>
    <a href="{{ url('mobile/profile') }}" class="nav-item-bottom" id="nav-item-profile">
        <i class="fas fa-user"></i> Profil
    </a>
</nav>
