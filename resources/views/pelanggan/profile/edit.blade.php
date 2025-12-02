@extends('pelanggan.layout')

@push('styles')
<style>
    /* Specific override for this page to prevent overflow */
    body .main-content {
        overflow-x: clip !important;
    }

    /* Limit container width specifically for profile edit page */
    .profile-edit-wrapper {
        width: 100% !important;
        max-width: calc(100% - 80px) !important; /* Safe margin */
        margin-left: auto !important;
        margin-right: auto !important;
    }

    /* More specific selector to override any conflicting styles */
    .main-content .profile-edit-wrapper {
        width: calc(100% - 40px) !important; /* Extra safe margin */
        max-width: none !important;
    }

    /* For larger screens, consider sidebar width */
    @media (min-width: 1200px) {
        .main-content .profile-edit-wrapper {
            max-width: calc(100vw - 300px) !important; /* Account for 260px sidebar + 40px padding */
        }

        body.sidebar-collapsed .main-content .profile-edit-wrapper {
            max-width: calc(100vw - 120px) !important; /* Account for 80px sidebar + 40px padding */
        }
    }

    /* Additional safeguard */
    .main-content .container-fluid,
    .main-content .row {
        overflow-x: hidden !important;
    }

    /* Specific override to force constrain content */
    .main-content .card {
        max-width: 100vw !important;
        overflow-x: clip !important;
    }

    /* Limit card body width more strictly */
    .main-content .card-body {
        max-width: 100% !important;
        overflow-x: hidden !important;
    }
</style>
@endpush

@section('pelanggan_content')
<div class="container-fluid" style="max-width: 100%; padding-left: 10px; padding-right: 10px;">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10 mx-auto">
            <!-- Header -->
            <div class="card mb-4">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div class="text-center text-md-start">
                        <h4 class="mb-1 fw-bold" style="color: #222222;"><i class="bi bi-pencil-square me-2" style="color: #1E40FF;"></i>Edit Profil</h4>
                        <p class="mb-0 small" style="color: #6B7280;">Perbarui informasi akun dan data diri Anda</p>
                    </div>
                    <div>
                        <a href="{{ route('pelanggan.profile.show') }}" class="btn btn-sm rounded-pill px-3" style="color: #0652DD; border: 1px solid #0652DD; background-color: transparent;" onmouseover="this.style.backgroundColor='#0652DD'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0652DD';">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>

            @if(session('status'))
                <div class="alert mb-4 d-flex align-items-center rounded-3" style="background-color: #d1fae5; color: #065f46; border: 1px solid #10b981;">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert mb-4 d-flex align-items-center rounded-3" style="background-color: #fee2e2; color: #991b1b; border: 1px solid #ef4444;">
                    <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert mb-4 d-flex align-items-start rounded-3" style="background-color: #fef3c7; color: #92400e; border: 1px solid #f59e0b;">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-4 mt-1"></i>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: #92400e;">Profil Belum Lengkap!</h6>
                        <p class="mb-0 small" style="color: #78350f;">{{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            @if(empty($user->phone) || empty($user->address))
                <div class="alert mb-4 d-flex align-items-start rounded-3" style="background-color: #cffafe; color: #0e7490; border: 1px solid #06b6d4;">
                    <i class="bi bi-info-circle-fill me-3 fs-4 mt-1"></i>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: #0e7490;">Informasi Penting</h6>
                        <p class="mb-0 small" style="color: #155e75;">Nomor HP dan Alamat <strong>WAJIB</strong> diisi untuk melakukan pemesanan rental. Lengkapi data Anda sekarang!</p>
                    </div>
                </div>
            @endif

            <div class="card" style="max-width: calc(100vw - 40px); margin-left: auto; margin-right: auto; overflow-x: hidden;">
                <div class="card-body p-4" style="overflow-x: hidden;">
                    <form method="POST" action="{{ route('pelanggan.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-4 justify-content-center">
                            <div class="col-12 col-md-10">
                                <h5 class="fw-bold text-center" style="color: #222222; border-bottom: 1px solid #E5E7EB; padding-bottom: 0.5rem; margin-bottom: 1rem;">Informasi Dasar</h5>
                            </div>

                            <div class="col-12 col-md-10 mb-3">
                                <label class="form-label fw-bold small text-uppercase d-block text-center" style="color: #6B7280;">Nama Lengkap</label>
                                <div class="d-flex align-items-center justify-content-center gap-2" style="border: 2px solid #A3A3A3; border-radius: 0.375rem; background-color: #FFFFFF;">
                                    <i class="bi bi-person ms-3" style="color: #6B7280;"></i>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                           class="form-control border-0 flex-grow-1" style="background-color: transparent; color: #222222; outline: none; box-shadow: none;" @error('name') style="border-color: #ef4444;" @enderror placeholder="Nama Lengkap">
                                </div>
                                @error('name')
                                    <small class="text-danger mt-1 d-block text-center">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 col-md-10 mb-3">
                                <label class="form-label fw-bold small text-uppercase d-block text-center" style="color: #6B7280;">Email</label>
                                <div class="d-flex align-items-center justify-content-center gap-2" style="border: 2px solid #A3A3A3; border-radius: 0.375rem; background-color: #FFFFFF;">
                                    <i class="bi bi-envelope ms-3" style="color: #6B7280;"></i>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                           class="form-control border-0 flex-grow-1" style="background-color: transparent; color: #222222; outline: none; box-shadow: none;" @error('email') style="border-color: #ef4444;" @enderror placeholder="Alamat Email">
                                </div>
                                @error('email')
                                    <small class="text-danger mt-1 d-block text-center">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <h5 class="fw-bold text-center" style="color: #222222; border-bottom: 1px solid #E5E7EB; padding-bottom: 0.5rem; margin-bottom: 1rem;">Kontak & Alamat</h5>
                            </div>

                            <div class="col-12 col-md-10 mb-3">
                                <label class="form-label fw-bold small text-uppercase d-block text-center" style="color: #6B7280;">Nomor Telepon <span class="text-danger" style="color: #ef4444 !important;">*</span></label>
                                <div class="d-flex align-items-center justify-content-center gap-2" style="border: 2px solid #A3A3A3; border-radius: 0.375rem; background-color: #FFFFFF;">
                                    <i class="bi bi-telephone ms-3" style="color: #6B7280;"></i>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                                           class="form-control border-0 flex-grow-1" style="background-color: transparent; color: #222222; outline: none; box-shadow: none;" @error('phone') style="border-color: #ef4444;" @enderror
                                           placeholder="Contoh: +6281234567890">
                                </div>
                                @error('phone')
                                    <small class="text-danger mt-1 d-block text-center">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 col-md-10 mb-3">
                                <label class="form-label fw-bold small text-uppercase d-block text-center" style="color: #6B7280;">Alamat Lengkap <span class="text-danger" style="color: #ef4444 !important;">*</span></label>
                                <div class="d-flex align-items-center justify-content-center gap-2" style="border: 2px solid #A3A3A3; border-radius: 0.375rem; background-color: #FFFFFF;">
                                    <i class="bi bi-geo-alt ms-3" style="color: #6B7280;"></i>
                                    <input type="text" name="address" value="{{ old('address', $user->address) }}" required
                                           class="form-control border-0 flex-grow-1" style="background-color: transparent; color: #222222; outline: none; box-shadow: none;" @error('address') style="border-color: #ef4444;" @enderror
                                           placeholder="Jalan, Nomor Rumah, Kota">
                                </div>
                                @error('address')
                                    <small class="text-danger mt-1 d-block text-center">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <h5 class="fw-bold text-center" style="color: #222222; border-bottom: 1px solid #E5E7EB; padding-bottom: 0.5rem; margin-bottom: 1rem;">Keamanan</h5>
                            </div>

                            <div class="col-12 col-md-10 mb-3">
                                <label class="form-label fw-bold small text-uppercase d-block text-center" style="color: #6B7280;">Password Baru</label>
                                <div class="d-flex align-items-center justify-content-center gap-2" style="border: 2px solid #A3A3A3; border-radius: 0.375rem; background-color: #FFFFFF;">
                                    <i class="bi bi-lock ms-3" style="color: #6B7280;"></i>
                                    <input type="password" name="password"
                                           class="form-control border-0 flex-grow-1" style="background-color: transparent; color: #222222; outline: none; box-shadow: none;" @error('password') style="border-color: #ef4444;" @enderror
                                           placeholder="Kosongkan jika tidak ingin mengubah">
                                </div>
                                @error('password')
                                    <small class="text-danger mt-1 d-block text-center">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 col-md-10 mb-3">
                                <label class="form-label fw-bold small text-uppercase d-block text-center" style="color: #6B7280;">Konfirmasi Password</label>
                                <div class="d-flex align-items-center justify-content-center gap-2" style="border: 2px solid #A3A3A3; border-radius: 0.375rem; background-color: #FFFFFF;">
                                    <i class="bi bi-lock-fill ms-3" style="color: #6B7280;"></i>
                                    <input type="password" name="password_confirmation"
                                           class="form-control border-0 flex-grow-1" style="background-color: transparent; color: #222222; outline: none; box-shadow: none;"
                                           placeholder="Ulangi password baru">
                                </div>
                            </div>

                            <div class="col-12 mt-5 d-flex flex-column flex-md-row gap-3 justify-content-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold shadow-lg">
                                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('pelanggan.profile.show') }}" class="btn btn-outline-secondary btn-lg px-4">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Function to adjust container width based on sidebar state
    function adjustContainerWidth() {
        // Calculate available width based on sidebar state
        const isSidebarCollapsed = document.body.classList.contains('sidebar-collapsed') ||
                                 document.querySelector('.sidebar')?.classList.contains('collapsed');

        if (window.innerWidth >= 992) {
            const sidebarWidth = isSidebarCollapsed ? 80 : 260;
            const availableWidth = window.innerWidth - sidebarWidth - 60; // -60 for padding

            // Set max-width for content container
            const container = document.querySelector('.profile-edit-wrapper');
            if (container) {
                container.style.maxWidth = `${availableWidth}px`;
            }
        } else {
            // On mobile, use full width
            const container = document.querySelector('.profile-edit-wrapper');
            if (container) {
                container.style.maxWidth = '100%';
            }
        }
    }

    // Run when page loads
    document.addEventListener('DOMContentLoaded', adjustContainerWidth);

    // Run when window is resized
    window.addEventListener('resize', adjustContainerWidth);

    // Run when sidebar is toggled
    if (typeof MutationObserver !== 'undefined') {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    adjustContainerWidth();
                }
            });
        });

        observer.observe(document.body, {
            attributes: true,
            attributeFilter: ['class']
        });
    }
</script>
@endpush
@endsection