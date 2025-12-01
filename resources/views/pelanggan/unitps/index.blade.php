@extends('pelanggan.layout')

@section('pelanggan_content')
    <div class="container-fluid">
        <!-- Search & Filter Section -->
        <div class="card card-hover-lift mb-4 animate-fade-in">
            <div class="card-body">
                <form method="GET" action="{{ route('pelanggan.unitps.list') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small text-uppercase fw-bold" style="color: #6B7280;">Model</label>
                        <select name="model" class="form-select"
                            style="background-color: #FFFFFF; border-color: #A3A3A3; color: #222222;">
                            <option value="">Semua Model</option>
                            @foreach (['PS3', 'PS4', 'PS5'] as $opt)
                                <option value="{{ $opt }}" @selected(request('model') === $opt)>{{ $opt }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-uppercase fw-bold" style="color: #6B7280;">Merek</label>
                        <select name="brand" class="form-select"
                            style="background-color: #FFFFFF; border-color: #A3A3A3; color: #222222;">
                            <option value="">Semua Merek</option>
                            <option value="Sony" @selected(request('brand') === 'Sony')>Sony</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-uppercase fw-bold" style="color: #6B7280;">Cari Unit</label>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #FFFFFF; border-color: #A3A3A3; color: #6B7280;"><i
                                    class="bi bi-search"></i></span>
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                style="background-color: #FFFFFF; border-color: #A3A3A3; color: #222222;"
                                placeholder="Nama unit...">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Units List -->
        <div class="card">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
                    @forelse($units as $unit)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm"
                                style="background: #FFFFFF; border: 1px solid #E5E7EB;">
                                <div class="position-relative"
                                    style="height: 200px; overflow: hidden; border-radius: 16px 16px 0 0;">
                                    @if ($unit->foto)
                                        <img src="{{ str_starts_with($unit->foto, 'http') ? $unit->foto : asset('storage/' . $unit->foto) }}"
                                            alt="{{ $unit->name }}" class="w-100 h-100 object-fit-cover"
                                            style="transition: transform 0.3s ease;">
                                    @else
                                        <img src="https://placehold.co/400x300/F5F6FA/222222?text={{ urlencode($unit->model) }}"
                                            alt="{{ $unit->name }}" class="w-100 h-100 object-fit-cover"
                                            style="transition: transform 0.3s ease;">
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="text-center mb-3">
                                        <h5 class="card-title fw-bold mb-1" style="color: #000000;">{{ $unit->name }}</h5>
                                        <p class="mb-1" style="font-size: 1rem; color: #6B7280; font-weight: 500;">
                                            {{ $unit->brand }}</p>
                                        @php
                                            $stok = $unit->stock ?? 0;
                                        @endphp
                                        @if ($stok > 0)
                                            <div class="mb-2" style="font-size: 1rem; color: #6B7280; font-weight: 500;">
                                                Tersedia {{ $stok }}
                                            </div>
                                        @else
                                            <div class="mb-2" style="font-size: 1rem; color: #6B7280; font-weight: 500;">
                                                Habis
                                            </div>
                                        @endif
                                        <div class="fw-bold" style="color: #009432;">Rp
                                            {{ number_format($unit->price_per_hour, 0, ',', '.') }}<span
                                                class="small fw-normal" style="color: #009432;">/jam</span></div>
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
                            <div class="text-center py-5">
                                <i class="bi bi-controller" style="color: #6B7280; font-size: 3rem;"></i>
                                <p class="mt-3 mb-0" style="color: #6B7280;">Tidak ada unit PlayStation yang sesuai
                                    kriteria.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="card-footer border-0 bg-transparent py-3" style="border-top: 1px solid #E5E7EB; color: #222222;">
                {{ $units->withQueryString()->links() }}
            </div>
        </div>
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

                fetch('{{ route("pelanggan.cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
