<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg glass-card overflow-hidden position-relative">
            <!-- Decorative Background Element -->
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-primary opacity-10" style="z-index: -1;"></div>
            
            <div class="card-body p-5">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="text-center mb-5">
                        <div class="position-relative d-inline-block mb-3">
                            <div id="avatar-preview-container" class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center text-white fw-bold shadow-lg" style="width: 140px; height: 140px; font-size: 3.5rem; background: linear-gradient(135deg, #0652DD 0%, #0043b8 100%); border: 4px solid var(--card-bg);">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-100 h-100 object-fit-cover">
                                @else
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                @endif
                            </div>
                            <label for="avatar" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow hover-scale" style="cursor: pointer; width: 42px; height: 42px; right: 5px; bottom: 5px; border: 3px solid var(--card-bg);" data-bs-toggle="tooltip" title="{{ __('profile.change_photo') }}">
                                <i class="bi bi-camera-fill"></i>
                                <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*" onchange="previewImage(this)">
                            </label>
                        </div>
                        <h4 class="fw-bold mb-1" style="color: var(--text-main);">{{ Auth::user()->name }}</h4>
                        <p class="mb-3" style="color: var(--text-muted);">{{ Auth::user()->email }}</p>
                        
                        <div class="d-flex justify-content-center gap-2">
                            @if(Auth::user()->avatar)
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="confirmDeleteAvatar()">
                                    <i class="bi bi-trash me-1"></i> {{ __('profile.delete_photo') }}
                                </button>
                            @endif
                        </div>
                        
                        <p class="small mt-2 mb-0" style="color: var(--text-dim);">
                            <i class="bi bi-info-circle me-1"></i>{{ __('profile.photo_help') }}
                        </p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold" style="color: var(--text-main);">{{ __('profile.name') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-person text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold" style="color: var(--text-main);">{{ __('profile.email') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-envelope text-primary"></i></span>
                                <input type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold" style="color: var(--text-main);">{{ __('profile.phone') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-telephone text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                            </div>
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label fw-semibold" style="color: var(--text-main);">{{ __('profile.address') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-geo-alt text-primary"></i></span>
                                <textarea class="form-control border-start-0 ps-0 @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', Auth::user()->address) }}</textarea>
                            </div>
                            @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-5">
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill shadow-sm hover-scale">
                            <i class="bi bi-save me-2"></i>{{ __('profile.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Form untuk hapus avatar -->
<form id="delete-avatar-form" action="{{ route('profile.avatar.delete') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

<script>
    // Preview image function
    function previewImage(input) {
        if (input.files && input.files[0]) {
            // Validate file size (max 2MB)
            if (input.files[0].size > 2 * 1024 * 1024) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('profile.file_too_big_title') }}',
                        text: '{{ __('profile.file_too_big_text') }}',
                        confirmButtonColor: '#0652DD'
                    });
                } else {
                    alert('{{ __('profile.file_too_big_text') }}');
                }
                input.value = '';
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                // Update main profile avatar
                var container = document.getElementById('avatar-preview-container');
                if (container) {
                    var img = container.querySelector('img');
                    if (img) {
                        img.src = e.target.result;
                    } else {
                        container.innerHTML = '<img src="' + e.target.result + '" alt="Avatar" class="w-100 h-100 object-fit-cover">';
                    }
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Confirm delete avatar
    function confirmDeleteAvatar() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: '{{ __('profile.confirm_delete_title') }}',
                text: '{{ __('profile.confirm_delete_text') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('profile.yes_delete') }}',
                cancelButtonText: '{{ __('profile.cancel') }}',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                background: document.documentElement.getAttribute('data-theme') === 'dark' ? '#1e293b' : '#ffffff',
                color: document.documentElement.getAttribute('data-theme') === 'dark' ? '#f8fafc' : '#1e293b',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-avatar-form').submit();
                }
            });
        } else if (confirm('{{ __('profile.confirm_delete_title') }}')) {
            document.getElementById('delete-avatar-form').submit();
        }
    }
</script>
