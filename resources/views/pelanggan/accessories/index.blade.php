@extends('pelanggan.layout')

@section('pelanggan_content')
    <div class="container-fluid">

        <!-- Search & Filter Section -->
        <div class="card card-hover-lift mb-4 animate-fade-in">
            <div class="card-body">
                <form method="GET" action="{{ route('pelanggan.accessories.list') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small text-uppercase fw-bold" style="color: #6B7280;">{{ __('catalog.type') }}</label>
                        <select name="jenis" class="form-select"
                            style="background-color: #FFFFFF; border-color: #A3A3A3; color: #222222;">
                            <option value="">{{ __('catalog.all_types') }}</option>
                            @foreach (['Headset', 'Kabel', 'Adapter', 'Charger', 'Tas', 'Lainnya'] as $opt)
                                <option value="{{ $opt }}" @selected(request('jenis') === $opt)>{{ $opt }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-uppercase fw-bold" style="color: #6B7280;">{{ __('catalog.brand') }}</label>
                        <input type="text" name="brand" value="{{ request('brand') }}" class="form-control"
                            style="background-color: #FFFFFF; border-color: #A3A3A3; color: #222222;"
                            placeholder="{{ __('catalog.brand_placeholder') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-uppercase fw-bold" style="color: #6B7280;">{{ __('catalog.search_accessory') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #FFFFFF; border-color: #A3A3A3; color: #6B7280;"><i
                                    class="bi bi-search"></i></span>
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                style="background-color: #FFFFFF; border-color: #A3A3A3; color: #222222;"
                                placeholder="{{ __('catalog.search_accessory_placeholder') }}">
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
                            @php
                                $jenisKey = $acc->jenis ?? 'Acc';
                                $iconMap = [
                                    'Headset' => 'headset',
                                    'Controller' => 'controller',
                                    'Kabel' => 'plug',
                                    'Charger' => 'battery-charging',
                                    'Adapter' => 'usb-plug',
                                    'Tas' => 'bag',
                                ];
                                $iconName = $iconMap[$jenisKey] ?? 'gear';
                            @endphp
                            <div class="card h-100 shadow-sm position-relative card-blue-left" style="border-radius: 16px;">
                                <!-- Jenis Badge -->
                                <div class="position-absolute" style="top: 12px; left: 12px; z-index: 10;">
                                    <span class="d-flex align-items-center justify-content-center" style="background: #0652DD; color: #fff; width: 44px; height: 44px; border-radius: 50%; font-size: 1.1rem; box-shadow: 0 3px 10px rgba(6,82,221,0.4);">
                                        <i class="bi bi-{{ $iconName }}"></i>
                                    </span>
                                </div>
                                <div class="position-relative"
                                    style="height: 200px; overflow: hidden; border-radius: 0;">
                                    @if ($acc->gambar)
                                        <img src="{{ str_starts_with($acc->gambar, 'http') ? $acc->gambar : asset('storage/' . $acc->gambar) }}"
                                            alt="{{ $acc->nama }}" class="w-100 h-100 object-fit-cover"
                                            style="transition: transform 0.3s ease;">
                                    @else
                                        <img src="https://placehold.co/300x400/F5F6FA/222222?text={{ urlencode($acc->nama) }}"
                                            alt="{{ $acc->nama }}" class="w-100 h-100 object-fit-cover"
                                            style="transition: transform 0.3s ease;">
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="text-center mb-3">
                                        <h5 class="card-title fw-bold mb-1" style="color: #000000;">{{ $acc->nama }}</h5>
                                        <p class="mb-1" style="font-size: 1rem; color: #6B7280; font-weight: 500;">
                                            {{ $acc->jenis }}</p>
                                        @php
                                            $stok = $acc->stok ?? 0;
                                        @endphp
                                        @if ($stok > 0)
                                            <div class="mb-2" style="font-size: 1rem; color: #6B7280; font-weight: 500;">
                                                {{ __('catalog.available') }} {{ $stok }}
                                            </div>
                                        @else
                                            <div class="mb-2" style="font-size: 1rem; color: #6B7280; font-weight: 500;">
                                                {{ __('catalog.out_of_stock') }}
                                            </div>
                                        @endif
                                        <div class="fw-bold" style="color: #009432;">Rp
                                            {{ number_format($acc->harga_per_hari, 0, ',', '.') }}<span
                                                class="small fw-normal" style="color: #009432;">{{ __('catalog.per_day') }}</span></div>
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
                                <p class="mt-3 mb-0" style="color: #6B7280;">{{ __('catalog.no_accessories') }}</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="card-footer border-0 bg-transparent py-3" style="border-top: 1px solid #E5E7EB; color: #222222;">
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
