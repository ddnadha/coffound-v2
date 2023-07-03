<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3 btn-back-nav">
            <li class="text-dark " onclick="history.back()">
                <i class="fas fa-angle-left"></i>
            </li>
        </ul>
        <ul class="navbar-nav mr-3">
            <li class="text-dark">
                @yield('nav')
            </li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">

        @auth
            @php
                $notif = auth()->user()->notif;
                $is_unopened = false;
                for ($i = 0; $i < (count($notif) > 5 ? 5 : count($notif)); $i++) {
                    if ($notif[$i]->status = 'unopened') {
                        $is_unopened = true;
                    }
                }
                $i = 0;
            @endphp
            <li class="dropdown dropdown-list-toggle">
                <a href="#" data-toggle="dropdown"
                    class="text-primary nav-link notification-toggle nav-link-lg @if ($is_unopened) beep @endif">
                    <i class="far fa-bell"></i>
                </a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                    <div class="dropdown-header">Notifikasi
                        <div class="float-right">
                            <a href="#">Tandai semua sudah dibaca</a>
                        </div>
                    </div>
                    <div class="dropdown-list-content dropdown-list-icons">
                        @foreach (auth()->user()->notif as $item)
                            @if ($i <= 5)
                                <a href="#" class="dropdown-item dropdown-item-unread">
                                    @if (str_contains($item->notification, 'ditolak'))
                                        <div class="dropdown-item-icon bg-danger text-white">
                                            <i class="fas fa-ban"></i>
                                        </div>
                                    @elseif (str_contains($item->notification, 'disetujui'))
                                        <div class="dropdown-item-icon bg-success text-white">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    @else
                                        <div class="dropdown-item-icon bg-primary text-white">
                                            <i class="fas fa-info"></i>
                                        </div>
                                    @endif
                                    <div class="dropdown-item-desc">
                                        {{ $item->notification }}
                                        @if ($item->created_at->isToday())
                                            <div class="time text-primary">{{ $item->created_at->format('H:i') }}</div>
                                        @else
                                            <div class="time text-primary">{{ $item->created_at->format('d F Y') }}</div>
                                        @endif
                                    </div>
                                </a>
                            @endif
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </div>
                </div>
            </li>
            <li class="dropdown"><a data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img alt="image" src="{{ asset(auth()->user()->img) }}" class="rounded-circle mr-1">
                    <div class="d-sm-none text-dark d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-title">Masuk {{ auth()->user()->updated_at->diffForHumans() }}</div>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endauth
        @guest
            <li>
                <a href="{{ url('login') }}" class="nav-link nav-link-lg text-primary">
                    <i class="fas fa-sign-in"></i>
                </a>
            </li>
        @endguest
    </ul>
</nav>
