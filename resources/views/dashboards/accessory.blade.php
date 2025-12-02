@extends('pelanggan.layout')

@section('pelanggan_content')
<div class="container-fluid">

    <!-- Header & Filter -->
    <div class="card card-hover-lift mb-4 animate-fade-in">
        <div class="card-body">
            <form method="GET" action="{{ route('pelanggan.accessories.list') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small text-uppercase fw-bold text-muted">{{ __('catalog.type') }}</label>
                    <select name="jenis" class="form-select">
                        <option value="">{{ __('catalog.all_types') }}</option>
                        @foreach (['Headset','Kabel','Adapter','Charger','Tas','Lainnya'] as $opt)
                            <option value="{{ $opt }}" @selected(request('jenis')===$opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-uppercase fw-bold text-muted">{{ __('catalog.brand') }}</label>
                    <input type="text" name="brand" value="{{ request('brand') }}" class="form-control" placeholder="{{ __('catalog.brand_placeholder') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-uppercase fw-bold text-muted">{{ __('catalog.search_accessory') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="{{ __('catalog.search_placeholder_accessory') }}">
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">{{ __('catalog.filter') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Accessories List -->
    <div class="card">
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
                @forelse($accessories as $acc)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="position-relative" style="height: 200px; overflow: hidden; border-radius: 16px 16px 0 0;">
                                @if($acc->gambar)
                                    <img src="{{ str_starts_with($acc->gambar, 'http') ? $acc->gambar : asset('storage/' . $acc->gambar) }}"
                                         alt="{{ $acc->nama }}"
                                         class="w-100 h-100 object-fit-cover"
                                         style="transition: transform 0.3s ease;">
                                @else
                                    <img src="https://placehold.co/300x400/F5F6FA/222222?text={{ urlencode($acc->nama) }}"
                                         alt="{{ $acc->nama }}"
                                         class="w-100 h-100 object-fit-cover"
                                         style="transition: transform 0.3s ease;">
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="text-center mb-3">
                                    <h5 class="card-title fw-bold mb-1">{{ $acc->nama }}</h5>
                                    <p class="mb-1 text-muted" style="font-size: 1rem; font-weight: 500;">{{ $acc->jenis }}</p>
                                    @php
                                        $stok = $acc->stok ?? 0;
                                    @endphp
                                    @if($stok > 0)
                                        <div class="mb-2 text-muted" style="font-size: 1rem; font-weight: 500;">
                                            {{ __('catalog.available', ['count' => $stok]) }}
                                        </div>
                                    @else
                                        <div class="mb-2 text-muted" style="font-size: 1rem; font-weight: 500;">
                                            {{ __('catalog.out_of_stock') }}
                                        </div>
                                    @endif
                                    <div class="fw-bold" style="color: #009432;">Rp {{ number_format($acc->harga_per_hari, 0, ',', '.') }}<span class="small fw-normal" style="color: #009432;">{{ __('catalog.per_day') }}</span></div>
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
                                            {{ __('catalog.rent') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-headset" style="color: #6B7280; font-size: 3rem;"></i>
                            <p class="mt-3 mb-0" style="color: #6B7280;">{{ __('catalog.no_accessories_found') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="card-footer border-0 bg-transparent py-3" style="border-top: 1px solid var(--card-border);">
            {{ $accessories->withQueryString()->links() }}
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
                alert('{{ __('dashboard.js_incomplete_data') }}');
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
                        window.showFlashMessage(data.message || '{{ __('dashboard.js_add_failed') }}', 'error');
                    } else {
                        alert(data.message || '{{ __('dashboard.js_add_failed') }}');
                    }
                }

                // Restore button
                this.disabled = false;
                this.innerHTML = originalHTML;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('{{ __('dashboard.js_error') }}');
                // Restore button
                this.disabled = false;
                this.innerHTML = originalHTML;
            });
        });
    });
</script>
@endsection