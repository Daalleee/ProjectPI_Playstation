@extends('pelanggan.layout')

@section('pelanggan_content')
<style>
    /* Readable badge styles */
    .badge-pending {
        background-color: #fef3c7 !important;
        color: #92400e !important;
        border: 1px solid #f59e0b !important;
        font-weight: 600;
    }
    .badge-active {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
        border: 1px solid #10b981 !important;
        font-weight: 600;
    }
    .badge-waiting {
        background-color: #cffafe !important;
        color: #0e7490 !important;
        border: 1px solid #06b6d4 !important;
        font-weight: 600;
    }
    .badge-done {
        background-color: #e0e7ff !important;
        color: #3730a3 !important;
        border: 1px solid #6366f1 !important;
        font-weight: 600;
    }
    .badge-cancelled {
        background-color: #fee2e2 !important;
        color: #991b1b !important;
        border: 1px solid #ef4444 !important;
        font-weight: 600;
    }
    .badge-neutral {
        background-color: #f1f5f9 !important;
        color: #475569 !important;
        border: 1px solid #94a3b8 !important;
        font-weight: 600;
    }
    .badge-paid {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
        border: 1px solid #10b981 !important;
        font-weight: 600;
    }
    .badge-unpaid {
        background-color: #fee2e2 !important;
        color: #991b1b !important;
        border: 1px solid #ef4444 !important;
        font-weight: 600;
    }
    .badge-partial {
        background-color: #fef3c7 !important;
        color: #92400e !important;
        border: 1px solid #f59e0b !important;
        font-weight: 600;
    }
    
    /* Card styling */
    .rental-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    /* Info row styling */
    .info-row {
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-label {
        color: #64748b;
        font-size: 0.9rem;
    }
    .info-value {
        color: #1e293b;
        font-weight: 500;
    }
    
    /* Alert styling */
    .alert-success-custom {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }
    .alert-danger-custom {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
    }
    .alert-warning-custom {
        background-color: #fef3c7;
        color: #92400e;
        border: 1px solid #f59e0b;
    }
    .alert-info-custom {
        background-color: #cffafe;
        color: #0e7490;
        border: 1px solid #06b6d4;
    }
    
    /* Table styling */
    .table-custom th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 600;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-custom td {
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="rental-card mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold" style="color: #1e293b;"><i class="bi bi-receipt me-2" style="color: #3b82f6;"></i>Detail Penyewaan #{{ $rental->id }}</h4>
                    <p class="mb-0 small" style="color: #64748b;">Informasi lengkap transaksi penyewaan Anda</p>
                </div>
                <div>
                    <a href="{{ route('pelanggan.rentals.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('status'))
        <div class="alert alert-success-custom mb-4 d-flex align-items-center rounded-3">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('status') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger-custom mb-4 d-flex align-items-center rounded-3">
            <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning-custom mb-4 d-flex align-items-center rounded-3">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div>{{ session('warning') }}</div>
        </div>
    @endif

    <div class="row g-4">
        <!-- Left Column: Rental Information -->
        <div class="col-lg-6">
            <div class="rental-card h-100">
                <div class="card-body p-4">
                    <h5 class="mb-4 fw-bold" style="color: #1e293b;"><i class="bi bi-info-circle me-2" style="color: #3b82f6;"></i>Informasi Penyewaan</h5>

                    <div class="info-row">
                        <div class="row align-items-center">
                            <div class="col-5 info-label">Kode Rental</div>
                            <div class="col-7 info-value fw-bold">{{ $rental->kode ?? '#'.$rental->id }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="row align-items-center">
                            <div class="col-5 info-label"><i class="bi bi-calendar-event me-1"></i> Tanggal Sewa</div>
                            <div class="col-7 info-value">{{ \Carbon\Carbon::parse($rental->start_at)->format('d M Y, H:i') }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="row align-items-center">
                            <div class="col-5 info-label"><i class="bi bi-calendar-x me-1"></i> Tanggal Kembali</div>
                            <div class="col-7 info-value">{{ \Carbon\Carbon::parse($rental->due_at)->format('d M Y, H:i') }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="row align-items-center">
                            <div class="col-5 info-label"><i class="bi bi-hourglass me-1"></i> Durasi</div>
                            <div class="col-7 info-value">
                                {{ \Carbon\Carbon::parse($rental->start_at)->diffInDays(\Carbon\Carbon::parse($rental->due_at)) }} hari
                            </div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="row align-items-center">
                            <div class="col-5 info-label"><i class="bi bi-tag me-1"></i> Status</div>
                            <div class="col-7">
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
                                    <span class="badge badge-pending"><i class="bi bi-clock me-1"></i>{{ $statusText }}</span>
                                @elseif($rental->status === 'sedang_disewa')
                                    <span class="badge badge-active"><i class="bi bi-play-circle me-1"></i>{{ $statusText }}</span>
                                @elseif($rental->status === 'menunggu_konfirmasi')
                                    <span class="badge badge-waiting"><i class="bi bi-hourglass-split me-1"></i>{{ $statusText }}</span>
                                @elseif($rental->status === 'selesai')
                                    <span class="badge badge-done"><i class="bi bi-check-circle me-1"></i>{{ $statusText }}</span>
                                @elseif($rental->status === 'cancelled')
                                    <span class="badge badge-cancelled"><i class="bi bi-x-circle me-1"></i>{{ $statusText }}</span>
                                @else
                                    <span class="badge badge-neutral">{{ $statusText }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="row align-items-center">
                            <div class="col-5 info-label"><i class="bi bi-cash me-1"></i> Total</div>
                            <div class="col-7 fw-bold fs-5" style="color: #059669;">Rp {{ number_format($rental->total, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="row align-items-center">
                            <div class="col-5 info-label"><i class="bi bi-credit-card me-1"></i> Status Bayar</div>
                            <div class="col-7">
                                @if($rental->paid >= $rental->total)
                                    <span class="badge badge-paid"><i class="bi bi-check-circle-fill me-1"></i> LUNAS</span>
                                @elseif($rental->paid > 0)
                                    <span class="badge badge-partial"><i class="bi bi-exclamation-circle-fill me-1"></i> KURANG BAYAR</span>
                                @else
                                    <span class="badge badge-unpaid"><i class="bi bi-x-circle-fill me-1"></i> BELUM LUNAS</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($rental->notes)
                    <div class="info-row">
                        <div class="info-label mb-2"><i class="bi bi-sticky me-1"></i> Catatan</div>
                        <div class="p-3 rounded" style="background-color: #f8fafc; border: 1px solid #e2e8f0; color: #1e293b;">{{ $rental->notes }}</div>
                    </div>
                    @endif

                    <!-- Actions -->
                    @if($rental->status === 'sedang_disewa')
                        <div class="mt-4">
                            <form method="POST" action="{{ route('pelanggan.rentals.return', $rental) }}" onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan barang ini? Silakan pastikan barang dalam kondisi baik.')">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100 fw-bold" style="color: #222222;">
                                    <i class="bi bi-box-arrow-in-down me-2"></i> Kembalikan Barang
                                </button>
                            </form>
                        </div>
                    @endif

                    @if($rental->status === 'menunggu_konfirmasi')
                        <div class="alert alert-info-custom mt-4 mb-0 rounded-3">
                            <i class="bi bi-info-circle-fill me-2"></i> Pengembalian Anda sedang menunggu konfirmasi dari kasir.
                        </div>
                    @endif

                    @if($rental->status === 'pending')
                        <div class="mt-4">
                            <!-- Tombol Lanjutkan Pembayaran -->
                            <a href="{{ route('pelanggan.rentals.continue-payment', $rental) }}" class="btn btn-success w-100 fw-bold mb-3 py-2">
                                <i class="bi bi-credit-card me-2"></i> Lanjutkan Pembayaran
                            </a>
                            
                            @if($rental->payments->count() > 0)
                                @php
                                    $pendingPayment = $rental->payments->where('transaction_status', 'pending')->first();
                                @endphp
                                <button id="check-payment-btn" class="btn btn-outline-primary w-100 fw-bold mb-3" data-order-id="{{ $pendingPayment->order_id ?? '' }}">
                                    <i class="bi bi-arrow-clockwise me-2"></i> Cek Status Pembayaran
                                </button>
                                <div class="small mb-3 text-center" style="color: #64748b;">
                                    <i class="bi bi-info-circle me-1"></i> Klik jika Anda sudah membayar tapi status belum berubah.
                                </div>
                            @endif
                            
                            <!-- Tombol Batalkan Pesanan -->
                            <form method="POST" action="{{ route('pelanggan.rentals.cancel', $rental) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100 fw-bold">
                                    <i class="bi bi-x-circle me-2"></i> Batalkan Pesanan
                                </button>
                            </form>
                        </div>
                        
                        <!-- Info Pembayaran Tertunda -->
                        <div class="alert alert-warning-custom mt-4 mb-0 rounded-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                                <div>
                                    <strong>Pembayaran Belum Selesai</strong>
                                    <p class="mb-0 small mt-1">Silakan klik tombol "Lanjutkan Pembayaran" untuk menyelesaikan pembayaran Anda. Anda dapat memilih metode pembayaran seperti QRIS, Transfer Bank, atau E-Wallet.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Rental Items -->
        <div class="col-lg-6">
            <div class="rental-card h-100">
                <div class="card-body p-4">
                    <h5 class="mb-4 fw-bold" style="color: #1e293b;"><i class="bi bi-box-seam me-2" style="color: #10b981;"></i>Item yang Disewa</h5>

                    @forelse($rental->items as $item)
                        @php
                            $itemName = 'Item Tidak Ditemukan';
                            $itemImage = null;
                            $itemImageField = '';

                            if($item->rentable) {
                                $itemName = $item->rentable->nama ?? $item->rentable->judul ?? $item->rentable->name ?? 'Unknown';

                                // Get image field based on type
                                if (str_contains($item->rentable_type, 'UnitPS')) {
                                    $itemImageField = 'foto';
                                } else {
                                    $itemImageField = 'gambar';
                                }

                                if(isset($item->rentable->$itemImageField)) {
                                    $itemImage = $item->rentable->$itemImageField;
                                }
                            }

                            $itemType = class_basename($item->rentable_type);
                        @endphp

                        <div class="d-flex align-items-start mb-3 pb-3" style="{{ !$loop->last ? 'border-bottom: 1px solid #f1f5f9;' : '' }}">
                            <!-- Image -->
                            <div class="flex-shrink-0 me-3">
                                @if($itemImage)
                                    <img src="{{ str_starts_with($itemImage, 'http') ? $itemImage : asset('storage/' . $itemImage) }}"
                                         alt="{{ $itemName }}"
                                         class="rounded shadow-sm"
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <div class="rounded d-flex align-items-center justify-content-center" style="background-color: #f8fafc; border: 1px solid #e2e8f0; color: #64748b; width: 80px; height: 80px;">
                                        <i class="bi bi-box-seam fs-3"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-2" style="color: #1e293b;">{{ $itemName }}</h6>
                                <div class="small mb-1">
                                    <span class="badge badge-neutral">{{ $itemType }}</span>
                                </div>
                                <div class="small mb-1" style="color: #64748b;"><i class="bi bi-123 me-1"></i> Jumlah: <span style="color: #1e293b;">{{ $item->quantity }}</span></div>
                                <div class="small mb-1" style="color: #64748b;"><i class="bi bi-tag me-1"></i> Harga: <span style="color: #1e293b;">Rp {{ number_format($item->price, 0, ',', '.') }}</span></div>
                                <div class="fw-bold mt-2" style="color: #059669;"><i class="bi bi-cash me-1"></i> Subtotal: Rp {{ number_format($item->total, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-box" style="color: #94a3b8; font-size: 3rem;"></i>
                            <p class="mt-3" style="color: #64748b;">Tidak ada item</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Payment History -->
    @if($rental->payments->count() > 0)
    <div class="rental-card mt-4">
        <div class="card-body p-4">
            <h5 class="mb-4 fw-bold" style="color: #1e293b;"><i class="bi bi-clock-history me-2" style="color: #f59e0b;"></i>Riwayat Pembayaran</h5>

            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rental->payments as $payment)
                        <tr>
                            <td>{{ $payment->created_at->format('d M Y, H:i') }}</td>
                            <td class="fw-bold" style="color: #059669;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td><span class="badge badge-neutral">{{ ucfirst($payment->method ?? 'N/A') }}</span></td>
                            <td>
                                @php
                                    $status = $payment->transaction_status ?? 'pending';
                                @endphp
                                @if(in_array($status, ['settlement', 'capture']))
                                    <span class="badge badge-paid"><i class="bi bi-check-circle me-1"></i> Lunas</span>
                                @elseif($status == 'pending')
                                    <span class="badge badge-pending"><i class="bi bi-hourglass-split me-1"></i> Menunggu</span>
                                @elseif(in_array($status, ['cancel', 'expire', 'deny']))
                                    <span class="badge badge-cancelled"><i class="bi bi-x-circle me-1"></i> {{ ucfirst($status) }}</span>
                                @else
                                    <span class="badge badge-neutral">{{ ucfirst($status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkBtn = document.getElementById('check-payment-btn');
    if (checkBtn) {
        checkBtn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            const originalText = this.innerHTML;
            
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memeriksa...';
            
            fetch(`/midtrans/status/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Status check:', data);
                    if (data.status && (data.status.transaction_status === 'settlement' || data.status.transaction_status === 'capture')) {
                        alert('Pembayaran berhasil dikonfirmasi! Halaman akan dimuat ulang.');
                        window.location.reload();
                    } else {
                        alert('Status pembayaran saat ini: ' + (data.status ? data.status.transaction_status : 'Belum tersedia'));
                        this.disabled = false;
                        this.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memeriksa status.');
                    this.disabled = false;
                    this.innerHTML = originalText;
                });
        });
    }
});
</script>
