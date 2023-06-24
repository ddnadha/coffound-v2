<div class="mt-4 mb-3">
    <a href="{{ url('/owner/cafe/' . $cafe->id . '/category') }}" class=" btn btn-primary btn-icon mr-1">
        <i class="fas fa-boxes mr-1"></i> Kategori
    </a>
    <a href="{{ url('/owner/cafe/' . $cafe->id . '/image') }}" class=" btn btn-primary btn-icon mr-1">
        <i class="fas fa-image mr-1"></i> Foto
    </a>
    <a href="{{ url('/owner/cafe/' . $cafe->id . '/menu') }}" class=" btn btn-primary btn-icon mr-1">
        <i class="fas fa-hamburger mr-1"></i> Menu
    </a>
    <a href="{{ url('/owner/cafe/' . $cafe->id . '/url') }}" class=" btn btn-primary btn-icon mr-1">
        <i class="fab fa-tiktok mr-1"></i> Video Tiktok
    </a>
    <a href="{{ url('/owner/cafe/' . $cafe->id . '/review') }}" class=" btn btn-primary btn-icon mr-1">
        <i class="fas fa-message mr-1"></i> Review
    </a>
</div>
