@extends('pelanggan.layout')

@section('pelanggan_content')
<div class="container-fluid">
    @push('styles')
    <style>
        html[data-theme="dark"] .table {
            --bs-table-color: #ffffff;
            --bs-table-hover-color: #ffffff;
            color: #ffffff !important;
        }
        
        html[data-theme="dark"] .table th,
        html[data-theme="dark"] .table td,
        html[data-theme="dark"] .table span,
        html[data-theme="dark"] .table div,
        html[data-theme="dark"] .table strong,
        html[data-theme="dark"] .table b,
        html[data-theme="dark"] .table .fw-bold,
        html[data-theme="dark"] .table * {
            color: #ffffff !important;
        }

        html[data-theme="dark"] .table thead th {
            background-color: var(--card-bg);
            color: #ffffff !important;
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }

        html[data-theme="dark"] .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
    </style>
    @endpush
    <!-- Header & Filter -->
    <div class="card card-hover-lift mb-4 animate-fade-in">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mb-4">
                <h4 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i><span>{{ __('cart.history_title') }}</span></h4>
            </div>

            @if(session('status'))
                <div class="alert rounded-3 mb-4 d-flex align-items-center" style="background-color: #d1fae5; border: 1px solid #10b981; color: #065f46;">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert rounded-3 mb-4 d-flex align-items-center" style="background-color: #fee2e2; border: 1px solid #ef4444; color: #991b1b;">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small text-uppercase fw-bold text-muted">{{ __('cart.status_label') }}</label>
                    <select name="status" class="form-select">
                        <option value="">{{ __('cart.all_status') }}</option>
                        <option value="pending">{{ __('cart.status_pending') }}</option>
                        <option value="sedang_disewa">{{ __('cart.status_active') }}</option>
                        <option value="menunggu_konfirmasi">{{ __('cart.status_confirm') }}</option>
                        <option value="selesai">{{ __('cart.status_completed') }}</option>
                        <option value="cancelled">{{ __('cart.status_cancelled') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-uppercase fw-bold text-muted">{{ __('cart.date_label') }}</label>
                    <input type="date" name="date" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-uppercase fw-bold text-muted">{{ __('cart.search_history') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control" placeholder="{{ __('cart.search_placeholder') }}">
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="bi bi-filter me-1"></i> {{ __('cart.filter') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Rental List -->
    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                    <tr>
                        <th>{{ __('cart.table_no') }}</th>
                        <th>{{ __('cart.table_date') }}</th>
                        <th>{{ __('cart.table_duration') }}</th>
                        <th>{{ __('cart.table_items') }}</th>
                        <th>{{ __('cart.table_total') }}</th>
                        <th>{{ __('cart.table_status') }}</th>
                        <th>{{ __('cart.table_payment') }}</th>
                        <th>{{ __('cart.table_action') }}</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rentals as $rental)
                        <tr>
                            <td><span class="font-monospace">{{ $rental->kode ?? '#'.$rental->id }}</span></td>
                            <td>{{ $rental->created_at->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $start = \Carbon\Carbon::parse($rental->start_at);
                                    $end = \Carbon\Carbon::parse($rental->due_at);
                                    $diff = $start->diffInDays($end);
                                    if ($diff == 0) {
                                        $diff = $start->diffInHours($end);
                                        $duration = $diff . ' Jam';
                                    } else {
                                        $duration = $diff . ' Hari';
                                    }
                                @endphp
                                <span>{{ $duration }}</span>
                            </td>
                            <td>
                                @foreach($rental->items->take(2) as $item)
                                    @php
                                        $itemName = 'Item';
                                        if($item->rentable) {
                                            $itemName = $item->rentable->name ?? $item->rentable->nama ?? $item->rentable->judul ?? 'Item';
                                        }
                                    @endphp
                                    <div>{{ $itemName }}</div>
                                @endforeach
                                @if($rental->items->count() > 2)
                                    <span>{{ __('cart.other_items', ['count' => $rental->items->count() - 2]) }}</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($rental->total, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $statusText = match($rental->status) {
                                        'pending' => __('cart.status_pending'),
                                        'sedang_disewa' => __('cart.status_active'),
                                        'menunggu_konfirmasi' => __('cart.status_confirm'),
                                        'selesai' => __('cart.status_completed'),
                                        'cancelled' => __('cart.status_cancelled'),
                                        default => ucfirst($rental->status)
                                    };
                                @endphp
                                @if($rental->status === 'pending')
                                    <span class="badge" style="background-color: #fbc531; color: #222222; border: 1px solid #fbc531;">{{ __('cart.status_pending') }}</span>
                                @elseif($rental->status === 'sedang_disewa')
                                    <span class="badge" style="background-color: #44bd32; color: #FFFFFF; border: 1px solid #44bd32;">{{ __('cart.status_active') }}</span>
                                @elseif($rental->status === 'menunggu_konfirmasi')
                                    <span class="badge" style="background-color: #fbc531; color: #222222; border: 1px solid #fbc531;">{{ __('cart.status_confirm') }}</span>
                                @elseif($rental->status === 'selesai')
                                    <span class="badge" style="background-color: #44bd32; color: #FFFFFF; border: 1px solid #44bd32;">{{ __('cart.status_completed') }}</span>
                                @elseif($rental->status === 'cancelled')
                                    <span class="badge" style="background-color: #e84118; color: #FFFFFF; border: 1px solid #e84118;">{{ __('cart.status_cancelled') }}</span>
                                @else
                                    <span class="badge" style="background-color: #94a3b8; color: #222222; border: 1px solid #94a3b8;">{{ $statusText }}</span>
                                @endif
                            </td>
                            <td>
                                @if($rental->paid >= $rental->total)
                                    <span class="badge" style="background-color: #44bd32; color: #FFFFFF; border: 1px solid #44bd32;">{{ __('cart.paid') }}</span>
                                @elseif($rental->paid > 0)
                                    <span class="badge" style="background-color: #fbc531; color: #222222; border: 1px solid #fbc531;">{{ __('cart.partial') }}</span>
                                @else
                                    <span class="badge" style="background-color: #e84118; color: #FFFFFF; border: 1px solid #e84118;">{{ __('cart.unpaid') }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pelanggan.rentals.show', $rental) }}" class="btn btn-sm" style="color: #FFFFFF; background-color: #0652DD; border-color: #0652DD;">
                                    <i class="bi bi-eye me-1"></i> {{ __('cart.detail') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-clock-history fs-1 d-block mb-2"></i>
                                {{ __('cart.no_history') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer border-0 bg-transparent py-3" style="border-top: 1px solid var(--card-border);">
            {{ $rentals->links() }}
        </div>
    </div>
</div>
@endsection