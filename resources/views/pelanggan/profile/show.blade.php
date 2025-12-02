@extends('pelanggan.layout')

@section('pelanggan_content')
<div class="container-fluid">
    <!-- Header -->
    <div class="card card-hover-lift mb-4 animate-fade-in">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #1E40FF;"><i class="bi bi-person-circle me-2" style="color: #1E40FF;"></i>Profil Pelanggan</h4>
                <p class="mb-0 small" style="color: #6B7280;">Kelola informasi akun dan data diri Anda</p>
            </div>
            <div>
                <a href="{{ route('pelanggan.profile.edit') }}" class="btn btn-primary fw-bold">
                    <i class="bi bi-pencil-square me-2"></i>Edit Profil
                </a>
            </div>
        </div>
    </div>

    @if(session('status'))
        <div class="alert d-flex align-items-center rounded-3" style="background-color: #d1fae5; color: #065f46; border: 1px solid #10b981;">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('status') }}</div>
        </div>
    @endif

    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card h-100 text-center p-4">
                <div class="card-body">
                    <div class="position-relative d-inline-block mb-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-lg"
                             style="background-color: #F5F6FA; width: 120px; height: 120px; border: 4px solid #E5E7EB;">
                            <i class="bi bi-person-fill display-1" style="color: #6B7280;"></i>
                        </div>
                        <div class="position-absolute bottom-0 end-0 rounded-circle p-2"
                             style="background-color: #22c55e; border: 2px solid #FFFFFF; width: 24px; height: 24px;"></div>
                    </div>

                    <h4 class="fw-bold mb-1" style="color: #222222;">{{ $user->name }}</h4>
                    <p class="mb-4" style="color: #6B7280;">{{ $user->email }}</p>

                    <div class="d-flex flex-column gap-2 text-start">
                        <div class="p-3 rounded" style="background-color: #F5F6FA; border: 1px solid #E5E7EB;">
                            <small class="d-block text-uppercase fw-bold" style="color: #6B7280; font-size: 0.7rem;">Status Akun</small>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <span class="badge" style="background-color: #d1fae5; color: #065f46; border: 1px solid #10b981; font-weight: 600;">Aktif</span>
                                <i class="bi bi-shield-check ms-auto" style="color: #22c55e;"></i>
                            </div>
                        </div>
                        <div class="p-3 rounded" style="background-color: #F5F6FA; border: 1px solid #E5E7EB;">
                            <small class="d-block text-uppercase fw-bold" style="color: #6B7280; font-size: 0.7rem;">Bergabung Sejak</small>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <span class="fw-bold" style="color: #222222;">{{ $user->created_at->format('d M Y') }}</span>
                                <i class="bi bi-calendar-check ms-auto" style="color: #1E40FF;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header" style="background-color: transparent; border-bottom: 1px solid #E5E7EB;">
                    <h5 class="mb-0 fw-bold" style="color: #222222;">Informasi Pribadi</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="small text-uppercase fw-bold mb-2" style="color: #6B7280;">Nama Lengkap</label>
                                <div class="form-control" style="background-color: #FFFFFF; border-color: #A3A3A3; color: #222222;">{{ $user->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="small text-uppercase fw-bold mb-2" style="color: #6B7280;">Email</label>
                                <div class="form-control" style="background-color: #FFFFFF; border-color: #A3A3A3; color: #222222;">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="small text-uppercase fw-bold mb-2" style="color: #6B7280;">Nomor Telepon</label>
                                <div class="form-control d-flex align-items-center justify-content-between" style="background-color: #FFFFFF; border-color: #A3A3A3; color: #222222;">
                                    <span>{{ $user->phone ?? '-' }}</span>
                                    @if(empty($user->phone))
                                        <i class="bi bi-exclamation-circle" data-bs-toggle="tooltip" title="Wajib diisi untuk penyewaan" style="color: #f59e0b;"></i>
                                    @else
                                        <i class="bi bi-check-circle" style="color: #22c55e;"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="small text-uppercase fw-bold mb-2" style="color: #6B7280;">Alamat Lengkap</label>
                                <div class="form-control d-flex align-items-center justify-content-between" style="background-color: #FFFFFF; border-color: #A3A3A3; color: #222222;">
                                    <span class="text-truncate">{{ $user->address ?? '-' }}</span>
                                    @if(empty($user->address))
                                        <i class="bi bi-exclamation-circle" data-bs-toggle="tooltip" title="Wajib diisi untuk penyewaan" style="color: #f59e0b;"></i>
                                    @else
                                        <i class="bi bi-check-circle" style="color: #22c55e;"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(empty($user->phone) || empty($user->address))
                        <div class="alert rounded-3" style="background-color: #fef3c7; color: #92400e; border: 1px solid #f59e0b; margin-top: 1rem; margin-bottom: 0; display: flex; align-items: flex-start;">
                            <i class="bi bi-exclamation-triangle-fill me-3 fs-4 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #92400e;">Profil Belum Lengkap</h6>
                                <p class="mb-2 small" style="color: #78350f;">Mohon lengkapi <strong>Nomor Telepon</strong> dan <strong>Alamat</strong> Anda untuk dapat melakukan penyewaan unit atau game.</p>
                                <a href="{{ route('pelanggan.profile.edit') }}" class="btn btn-sm btn-warning fw-bold" style="color: #78350f;">Lengkapi Sekarang</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection