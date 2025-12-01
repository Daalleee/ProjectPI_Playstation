@extends('pelanggan.layout')

@section('pelanggan_content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="text-center py-5 mb-5 rounded-4 position-relative overflow-hidden" style="background: #0652DD; border: 1px solid #E5E7EB;">
        <div class="position-relative z-1">
            <h2 class="fw-bold display-5 mb-3" style="color: white;">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="lead mb-0" style="max-width: 600px; margin: 0 auto; color: white;">
                Temukan pengalaman gaming terbaikmu hari ini. Sewa konsol, game, dan aksesoris dengan mudah dan cepat.
            </p>
        </div>
    </div>

    <!-- Unit PS Section -->
    <section class="mb-5">
        <div class="position-relative mb-4">
            <div class="text-center mb-3">
                <h4 class="fw-bold d-inline-block" style="color: #000000;">
                    <i class="bi bi-controller me-2" style="color: #000000;"></i>Unit PlayStation
                </h4>
            </div>
            <div class="position-absolute end-0 top-50 translate-middle-y">
                <a href="{{ route('pelanggan.unitps.index') }}" class="btn btn-sm rounded-pill px-3" style="color: #0652DD; border: 1px solid #0652DD; background-color: transparent;" onmouseover="this.style.backgroundColor='#0652DD'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0652DD';">Lihat Semua</a>
            </div>
        </div>

        <div class="mt-4 row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
            @forelse($unitps as $unit)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm" style="background: #FFFFFF; border: 1px solid #E5E7EB;">
                        <div class="position-relative" style="height: 200px; overflow: hidden; border-radius: 16px 16px 0 0;">
                            @if($unit->foto)
                                <img src="{{ str_starts_with($unit->foto, 'http') ? $unit->foto : asset('storage/' . $unit->foto) }}"
                                     alt="{{ $unit->name }}"
                                     class="w-100 h-100 object-fit-cover"
                                     style="transition: transform 0.3s ease;">
                            @else
                                <img src="https://placehold.co/400x300/F5F6FA/222222?text={{ urlencode($unit->model) }}"
                                     alt="{{ $unit->name }}"
                                     class="w-100 h-100 object-fit-cover"
                                     style="transition: transform 0.3s ease;">
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="text-center mb-3">
                                <h5 class="card-title fw-bold mb-1" style="color: #000000;">{{ $unit->name }}</h5>
                                <p class="mb-1" style="font-size: 1rem; color: #6B7280; font-weight: 500;">{{ $unit->brand }}</p>
                                @php
                                    $stok = $unit->stock ?? 0;
                                @endphp
                                @if($stok > 0)
                                    <div class="mb-2" style="font-size: 1rem; color: #6B7280; font-weight: 500;">
                                        Tersedia {{ $stok }}
                                    </div>
                                @else
                                    <div class="mb-2" style="font-size: 1rem; color: #6B7280; font-weight: 500;">
                                        Habis
                                    </div>
                                @endif
                                <div class="fw-bold" style="color: #009432;">Rp {{ number_format($unit->price_per_hour, 0, ',', '.') }}<span class="small fw-normal" style="color: #009432;">/jam</span></div>
                            </div>
                            <div class="mt-auto">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary add-to-cart-btn"
                                        data-type="unitps"
                                        data-id="{{ $unit->id }}"
                                        data-name="{{ $unit->name }}"
                                        data-price="{{ $unit->price_per_hour }}"
                                        data-price_type="per_jam"
                                        style="padding: 0.375rem 0.75rem; color: #0652DD; border-color: #0652DD;"
                                        onmouseover="this.style.backgroundColor='#0652DD'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor=''; this.style.color='#0652DD';">
                                        <i class="bi bi-cart"></i>
                                    </button>
                                    <a href="{{ route('pelanggan.rentals.create') }}?type=unitps&id={{ $unit->id }}" class="btn btn-sm btn-primary flex-grow-1"
                                       style="background-color: #0652DD; border-color: #0652DD;"
                                       onmouseover="this.style.backgroundColor='#032a8a'; this.style.borderColor='#032a8a';"
                                       onmouseout="this.style.backgroundColor='#0652DD'; this.style.borderColor='#0652DD';">
                                        Sewa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info border-0" style="background-color: rgba(6, 182, 212, 0.1); border: 1px solid rgba(6, 182, 212, 0.2); color: #67e8f9;">
                        <i class="bi bi-info-circle me-2"></i>Tidak ada unit PlayStation tersedia saat ini.
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Games Section -->
    <section class="mb-5">
        <div class="position-relative mb-4">
            <div class="text-center mb-3">
                <h4 class="fw-bold d-inline-block" style="color: #000000;">
                    <i class="bi bi-disc me-2" style="color: #000000;"></i>Game
                </h4>
            </div>
            <div class="position-absolute end-0 top-50 translate-middle-y">
                <a href="{{ route('pelanggan.games.index') }}" class="btn btn-sm rounded-pill px-3" style="color: #0652DD; border: 1px solid #0652DD; background-color: transparent;" onmouseover="this.style.backgroundColor='#0652DD'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0652DD';">Lihat Semua</a>
            </div>
        </div>

        <div class="mt-4 row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
            @forelse($games as $game)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm" style="background: #FFFFFF; border: 1px solid #E5E7EB;">
                        <div class="position-relative" style="height: 200px; overflow: hidden; border-radius: 16px 16px 0 0;">
                            @if($game->gambar)
                                <img src="{{ str_starts_with($game->gambar, 'http') ? $game->gambar : asset('storage/' . $game->gambar) }}"
                                     alt="{{ $game->judul }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <img src="https://placehold.co/300x400/F5F6FA/222222?text={{ urlencode($game->judul) }}" alt="{{ $game->judul }}" class="w-100 h-100 object-fit-cover">
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="text-center mb-3">
                                <h5 class="card-title fw-bold mb-1 text-truncate" style="color: #000000;">{{ $game->judul }}</h5>
                                <p class="mb-1" style="font-size: 1rem; color: #6B7280; font-weight: 500;">{{ $game->platform }} • {{ $game->genre }}</p>
                                @php
                                    $stok = $game->stok ?? 0;
                                @endphp
                                @if($stok > 0)
                                    <div class="mb-2" style="font-size: 1rem; color: #6B7280; font-weight: 500;">
                                        Tersedia {{ $stok }}
                                    </div>
                                @else
                                    <div class="mb-2" style="font-size: 1rem; color: #6B7280; font-weight: 500;">
                                        Habis
                                    </div>
                                @endif
                                <div class="fw-bold" style="color: #009432;">Rp {{ number_format($game->harga_per_hari, 0, ',', '.') }}<span class="small fw-normal" style="color: #009432;">/hari</span></div>
                            </div>
                            <div class="mt-auto">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary add-to-cart-btn"
                                        data-type="game"
                                        data-id="{{ $game->id }}"
                                        data-name="{{ $game->judul }}"
                                        data-price="{{ $game->harga_per_hari }}"
                                        data-price_type="per_hari"
                                        style="padding: 0.375rem 0.75rem; color: #0652DD; border-color: #0652DD;"
                                        onmouseover="this.style.backgroundColor='#0652DD'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor=''; this.style.color='#0652DD';">
                                        <i class="bi bi-cart"></i>
                                    </button>
                                    <a href="{{ route('pelanggan.rentals.create') }}?type=game&id={{ $game->id }}" class="btn btn-sm btn-primary flex-grow-1"
                                       style="background-color: #0652DD; border-color: #0652DD;"
                                       onmouseover="this.style.backgroundColor='#032a8a'; this.style.borderColor='#032a8a';"
                                       onmouseout="this.style.backgroundColor='#0652DD'; this.style.borderColor='#0652DD';">
                                        Sewa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info border-0" style="background-color: rgba(6, 182, 212, 0.1); border: 1px solid rgba(6, 182, 212, 0.2); color: #67e8f9;">
                        <i class="bi bi-info-circle me-2"></i>Tidak ada game tersedia saat ini.
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Accessories Section -->
    <section class="mb-5">
        <div class="position-relative mb-4">
            <div class="text-center mb-3">
                <h4 class="fw-bold d-inline-block" style="color: #000000;">
                    <i class="bi bi-headset me-2" style="color: #000000;"></i>Aksesoris
                </h4>
            </div>
            <div class="position-absolute end-0 top-50 translate-middle-y">
                <a href="{{ route('pelanggan.accessories.index') }}" class="btn btn-sm rounded-pill px-3" style="color: #0652DD; border: 1px solid #0652DD; background-color: transparent;" onmouseover="this.style.backgroundColor='#0652DD'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0652DD';">Lihat Semua</a>
            </div>
        </div>

        <div class="mt-4 row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
            @forelse($accessories as $acc)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm" style="background: #FFFFFF; border: 1px solid #E5E7EB;">
                        <div class="position-relative" style="height: 200px; overflow: hidden; border-radius: 16px 16px 0 0;">
                            @if($acc->gambar)
                                <img src="{{ str_starts_with($acc->gambar, 'http') ? $acc->gambar : asset('storage/' . $acc->gambar) }}"
                                     alt="{{ $acc->nama }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <img src="https://placehold.co/400x300/F5F6FA/222222?text={{ urlencode($acc->nama) }}" alt="{{ $acc->nama }}" class="w-100 h-100 object-fit-cover">
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="text-center mb-3">
                                <h5 class="card-title fw-bold mb-1" style="color: #000000;">{{ $acc->nama }}</h5>
                                <p class="mb-1" style="font-size: 1rem; color: #6B7280; font-weight: 500;">{{ $acc->jenis }}</p>
                                @php
                                    $stok = $acc->stok ?? 0;
                                @endphp
                                @if($stok > 0)
                                    <div class="mb-2" style="font-size: 1rem; color: #6B7280; font-weight: 500;">
                                        Tersedia {{ $stok }}
                                    </div>
                                @else
                                    <div class="mb-2" style="font-size: 1rem; color: #6B7280; font-weight: 500;">
                                        Habis
                                    </div>
                                @endif
                                <div class="fw-bold" style="color: #009432;">Rp {{ number_format($acc->harga_per_hari, 0, ',', '.') }}<span class="small fw-normal" style="color: #009432;">/hari</span></div>
                            </div>
                            <div class="mt-auto">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary add-to-cart-btn"
                                        data-type="accessory"
                                        data-id="{{ $acc->id }}"
                                        data-name="{{ $acc->nama }}"
                                        data-price="{{ $acc->harga_per_hari }}"
                                        data-price_type="per_hari"
                                        style="padding: 0.375rem 0.75rem; color: #0652DD; border-color: #0652DD;"
                                        onmouseover="this.style.backgroundColor='#0652DD'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor=''; this.style.color='#0652DD';">
                                        <i class="bi bi-cart"></i>
                                    </button>
                                    <a href="{{ route('pelanggan.rentals.create') }}?type=accessory&id={{ $acc->id }}" class="btn btn-sm btn-primary flex-grow-1"
                                       style="background-color: #0652DD; border-color: #0652DD;"
                                       onmouseover="this.style.backgroundColor='#032a8a'; this.style.borderColor='#032a8a';"
                                       onmouseout="this.style.backgroundColor='#0652DD'; this.style.borderColor='#0652DD';">
                                        Sewa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info border-0" style="background-color: rgba(6, 182, 212, 0.1); border: 1px solid rgba(6, 182, 212, 0.2); color: #67e8f9;">
                        <i class="bi bi-info-circle me-2"></i>Tidak ada aksesoris tersedia saat ini.
                    </div>
                </div>
            @endforelse
        </div>
    </section>
</div>

<script>
    // Handle add to cart AJAX requests for dashboard items
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const price = parseFloat(this.getAttribute('data-price'));
            const price_type = this.getAttribute('data-price_type');

            // Validate data
            if(!type || !id || !name || isNaN(price)) {
                alert('Data item tidak lengkap');
                return;
            }

            // Disable button to prevent multiple clicks
            this.disabled = true;
            const originalHTML = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

            fetch('/pelanggan/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    type: type,
                    id: id,
                    quantity: 1, // Default quantity
                    price_type: price_type
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Show success message using global function if available
                    if(window.showFlashMessage) {
                        window.showFlashMessage(data.message, 'success');
                    } else {
                        alert(data.message);
                    }
                } else {
                    // Show error message
                    if(window.showFlashMessage) {
                        window.showFlashMessage(data.message || 'Gagal menambahkan ke keranjang', 'error');
                    } else {
                        alert(data.message || 'Gagal menambahkan ke keranjang');
                    }
                }

                // Restore button
                this.disabled = false;
                this.innerHTML = originalHTML;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menambahkan ke keranjang');
                // Restore button
                this.disabled = false;
                this.innerHTML = originalHTML;
            });
        });
    });
</script>
@endsection