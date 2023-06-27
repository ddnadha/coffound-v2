<div class="mt-4 mb-2">
    <a href="{{ url('/owner/cafe/' . $cafe->id) }}"
        class=" btn btn-icon mr-1 mb-1 @if (!Request::is('owner/cafe/' . $cafe->id)) btn-outline-primary @else btn-primary @endif">
        <i class="fas fa-boxes mr-1 mb-1"></i> Detail Kafe
    </a>
    <a href="{{ url('/owner/cafe/' . $cafe->id . '/category') }}"
        class=" btn btn-icon mr-1 mb-1 @if (!Request::is('owner/cafe/' . $cafe->id . '/category')) btn-outline-primary @else btn-primary @endif">
        <i class="fas fa-boxes mr-1 mb-1"></i> Kategori
    </a>
    <a href="{{ url('/owner/cafe/' . $cafe->id . '/image') }}"
        class=" btn btn-icon mr-1 mb-1 @if (!Request::is('owner/cafe/' . $cafe->id . '/image')) btn-outline-primary @else btn-primary @endif">
        <i class="fas fa-image mr-1 mb-1"></i> Foto
    </a>
    <a href="{{ url('/owner/cafe/' . $cafe->id . '/menu') }}"
        class=" btn btn-icon mr-1 mb-1 @if (!Request::is('owner/cafe/' . $cafe->id . '/menu')) btn-outline-primary @else btn-primary @endif">
        <i class="fas fa-hamburger mr-1 mb-1"></i> Menu
    </a>
    <a href="{{ url('/owner/cafe/' . $cafe->id . '/url') }}"
        class=" btn btn-icon mr-1 mb-1 @if (!Request::is('owner/cafe/' . $cafe->id . '/url')) btn-outline-primary @else btn-primary @endif">
        <i class="fab fa-tiktok mr-1 mb-1"></i> Video Tiktok
    </a>
    <a href="{{ url('/owner/cafe/' . $cafe->id . '/review') }}"
        class=" btn  btn-icon mr-1 mb-1 @if (!Request::is('owner/cafe/' . $cafe->id . '/review')) btn-outline-primary @else btn-primary @endif">
        <i class="fas fa-message mr-1 mb-1"></i> Review
    </a>
</div>
