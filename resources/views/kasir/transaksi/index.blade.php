@extends('kasir.layout')
@section('title','Transaksi - Kasir')
@section('kasir_content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card p-3 mb-3">
        <form method="GET" action="" class="row g-2 align-items-end">
            <div class="col-sm-6 col-md-4">
                <label class="form-label">Kode Transaksi</label>
                <input type="text" name="rental_kode" value="{{ request('rental_kode') }}" class="form-control" placeholder="Masukkan kode / ID">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i> Cari</button>
            </div>
            <div class="col-auto">
                <a href="{{ route('dashboard.kasir') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
        @if(isset($rental) && $rental)
            <hr class="text-white-50">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted">Transaksi ditemukan</div>
                    <div class="h6 mb-0">#{{ $rental->kode ?? $rental->id }}</div>
                </div>
                <a href="{{ route('kasir.transaksi.show', $rental) }}" class="btn btn-light">Lihat Detail</a>
            </div>
        @endif
    </div>

    <div class="card p-3">
        <h6 class="mb-3 text-light">Daftar Semua Transaksi</h6>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th class="text-end">Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($rentals as $r)
                    <tr>
                        <td>{{ $r->kode ?? $r->id }}</td>
                        <td>{{ $r->customer->name ?? '-' }}</td>
                        <td>
                            @php
                                $statusText = match($r->status) {
                                    'pending' => 'Menunggu Pembayaran',
                                    'paid' => 'Dibayar',
                                    'active' => 'Sedang Disewa',
                                    'returned' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                    default => ucfirst($r->status)
                                };
                            @endphp
                            @if($r->status === 'pending')
                                <span class="badge text-bg-warning text-dark">Menunggu Pembayaran</span>
                            @elseif($r->status === 'paid')
                                <span class="badge text-bg-success">Dibayar</span>
                            @elseif($r->status === 'active')
                                <span class="badge text-bg-primary">Sedang Disewa</span>
                            @elseif($r->status === 'returned')
                                <span class="badge text-bg-success">Selesai</span>
                            @elseif($r->status === 'cancelled')
                                <span class="badge text-bg-danger">Dibatalkan</span>
                            @else
                                <span class="badge text-bg-secondary">{{ ucfirst($r->status) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($r->paid >= $r->total)
                                <span class="badge text-bg-success">LUNAS</span>
                            @elseif($r->paid > 0)
                                <span class="badge text-bg-warning text-dark">KURANG</span>
                            @else
                                <span class="badge text-bg-danger">BELUM</span>
                            @endif
                        </td>
                        <td class="text-end">Rp {{ number_format($r->total,0,',','.') }}</td>
                        <td><a href="{{ route('kasir.transaksi.show', $r) }}" class="btn btn-sm btn-primary">Detail</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
