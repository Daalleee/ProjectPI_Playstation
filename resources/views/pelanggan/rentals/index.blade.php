@extends('pelanggan.layout')

@section('pelanggan_content')
<div class="container-fluid">
    <!-- Header & Filter -->
    <div class="card card-hover-lift mb-4 animate-fade-in">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mb-4">
                <h4 class="mb-0 fw-bold" style="color: #222222;"><i class="bi bi-clock-history me-2" style="color: #222222;"></i><span style="color: #222222;">Riwayat Penyewaan</span></h4>
            </div>

            @if(session('status'))
                <div class="alert alert-success" style="background-color: rgba(34, 197, 94, 0.25); border: 1px solid rgba(34, 197, 94, 0.4); color: #6ee7b7;" class="mb-4">{{ session('status') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" style="background-color: rgba(239, 68, 68, 0.25); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5;" class="mb-4">{{ session('error') }}</div>
            @endif

            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small text-uppercase fw-bold" style="color: #6B7280;">Status</label>
                    <select name="status" class="form-select" style="background-color: #FFFFFF; border-color: #A3A3A3; color: #222222;">
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu Pembayaran</option>
                        <option value="sedang_disewa">Sedang Disewa</option>
                        <option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>
                        <option value="selesai">Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-uppercase fw-bold" style="color: #6B7280;">Tanggal</label>
                    <input type="date" name="date" class="form-control" style="background-color: #FFFFFF; border-color: #A3A3A3; color: #222222;" />
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-uppercase fw-bold" style="color: #6B7280;">Cari Riwayat</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #FFFFFF; border-color: #A3A3A3; color: #6B7280;"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control" style="background-color: #FFFFFF; border-color: #A3A3A3; color: #222222;" placeholder="ID Transaksi...">
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="bi bi-filter me-1"></i> Filter</button>
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
                        <th style="color: #222222;">No. Transaksi</th>
                        <th style="color: #222222;">Tanggal</th>
                        <th style="color: #222222;">Durasi</th>
                        <th style="color: #222222;">Item Disewa</th>
                        <th style="color: #222222;">Total Harga</th>
                        <th style="color: #222222;">Status</th>
                        <th style="color: #222222;">Pembayaran</th>
                        <th style="color: #222222;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rentals as $rental)
                        <tr>
                            <td><span class="font-monospace" style="color: #222222;">{{ $rental->kode ?? '#'.$rental->id }}</span></td>
                            <td style="color: #222222;">{{ $rental->created_at->format('d/m/Y') }}</td>
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
                                <span style="color: #222222;">{{ $duration }}</span>
                            </td>
                            <td>
                                @foreach($rental->items->take(2) as $item)
                                    @php
                                        $itemName = 'Item';
                                        if($item->rentable) {
                                            $itemName = $item->rentable->name ?? $item->rentable->nama ?? $item->rentable->judul ?? 'Item';
                                        }
                                    @endphp
                                    <div style="color: #222222;">{{ $itemName }}</div>
                                @endforeach
                                @if($rental->items->count() > 2)
                                    <span style="color: #222222;">+{{ $rental->items->count() - 2 }} lainnya</span>
                                @endif
                            </td>
                            <td style="color: #222222;">Rp {{ number_format($rental->total, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $statusText = match($rental->status) {
                                        'pending' => 'Menunggu Pembayaran',
                                        'sedang_disewa' => 'Sedang Disewa',
                                        'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                                        'selesai' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                        default => ucfirst($rental->status)
                                    };
                                @endphp
                                @if($rental->status === 'pending')
                                    <span class="badge" style="background-color: #fbc531; color: #222222; border: 1px solid #fbc531;">Menunggu Pembayaran</span>
                                @elseif($rental->status === 'sedang_disewa')
                                    <span class="badge" style="background-color: #44bd32; color: #FFFFFF; border: 1px solid #44bd32;">Sedang Disewa</span>
                                @elseif($rental->status === 'menunggu_konfirmasi')
                                    <span class="badge" style="background-color: #fbc531; color: #222222; border: 1px solid #fbc531;">Menunggu Konfirmasi</span>
                                @elseif($rental->status === 'selesai')
                                    <span class="badge" style="background-color: #44bd32; color: #FFFFFF; border: 1px solid #44bd32;">Selesai</span>
                                @elseif($rental->status === 'cancelled')
                                    <span class="badge" style="background-color: #e84118; color: #FFFFFF; border: 1px solid #e84118;">Dibatalkan</span>
                                @else
                                    <span class="badge" style="background-color: #94a3b8; color: #222222; border: 1px solid #94a3b8;">{{ $statusText }}</span>
                                @endif
                            </td>
                            <td>
                                @if($rental->paid >= $rental->total)
                                    <span class="badge" style="background-color: #44bd32; color: #FFFFFF; border: 1px solid #44bd32;">LUNAS</span>
                                @elseif($rental->paid > 0)
                                    <span class="badge" style="background-color: #fbc531; color: #222222; border: 1px solid #fbc531;">KURANG</span>
                                @else
                                    <span class="badge" style="background-color: #e84118; color: #FFFFFF; border: 1px solid #e84118;">BELUM</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pelanggan.rentals.show', $rental) }}" class="btn btn-sm" style="color: #FFFFFF; background-color: #0652DD; border-color: #0652DD;">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5" style="color: #222222;">
                                <i class="bi bi-clock-history fs-1 d-block mb-2" style="color: #222222;"></i>
                                Belum ada riwayat penyewaan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer border-0 bg-transparent py-3" style="border-top: 1px solid #E5E7EB; color: #222222;">
            {{ $rentals->links() }}
        </div>
    </div>
</div>
@endsection