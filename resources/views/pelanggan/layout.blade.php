@extends('layouts.dashboard')

@section('title', 'Dashboard Pelanggan')

@section('header_title', 'PlayStation')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('sidebar_menu')
    <a href="{{ route('dashboard.pelanggan') }}" class="nav-link {{ request()->routeIs('dashboard.pelanggan') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ __('dashboard.home') }}">
        <i class="bi bi-grid"></i>
        <span>{{ __('dashboard.home') }}</span>
    </a>
    
    <div class="sidebar-heading">{{ __('dashboard.shop') }}</div>
    
    <a href="{{ route('pelanggan.unitps.index') }}" class="nav-link {{ request()->routeIs('pelanggan.unitps.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ __('dashboard.rent_ps') }}">
        <i class="bi bi-controller"></i>
        <span>{{ __('dashboard.rent_ps') }}</span>
    </a>
    <a href="{{ route('pelanggan.games.index') }}" class="nav-link {{ request()->routeIs('pelanggan.games.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ __('dashboard.rent_game') }}">
        <i class="bi bi-disc"></i>
        <span>{{ __('dashboard.rent_game') }}</span>
    </a>
    <a href="{{ route('pelanggan.accessories.index') }}" class="nav-link {{ request()->routeIs('pelanggan.accessories.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ __('dashboard.rent_accessory') }}">
        <i class="bi bi-headset"></i>
        <span>{{ __('dashboard.rent_accessory') }}</span>
    </a>
    
    <div class="sidebar-heading">{{ __('dashboard.transactions') }}</div>

    <a href="{{ route('pelanggan.cart.index') }}" class="nav-link {{ request()->routeIs('pelanggan.cart.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ __('dashboard.cart') }}">
        <i class="bi bi-cart"></i>
        <span>{{ __('dashboard.cart') }}</span>
    </a>
    <a href="{{ route('pelanggan.rentals.index') }}" class="nav-link {{ request()->routeIs('pelanggan.rentals.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ __('dashboard.rental_history') }}">
        <i class="bi bi-clock-history"></i>
        <span>{{ __('dashboard.rental_history') }}</span>
    </a>
    
    <div class="sidebar-heading">{{ __('dashboard.account') }}</div>

    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ __('dashboard.my_profile') }}">
        <i class="bi bi-person-circle"></i>
        <span>{{ __('dashboard.my_profile') }}</span>
    </a>
@endsection

@push('styles')
<style>
    /* Premium Card Enhancements */
    .card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: var(--card-bg);
        border: 1px solid var(--card-border);
        color: var(--text-main);
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); /* Ringan/halus */
    }

    /* Card dengan garis biru kiri */
    .card.card-blue-left {
        border-left: 4px solid #0652DD !important;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(30, 64, 255, 0.1), transparent);
        transition: left 0.5s;
    }

    .card:hover::before {
        left: 100%;
    }

    .card-hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(30, 64, 255, 0.1);
    }

    .card-glow:hover {
        box-shadow: 0 0 20px rgba(30, 64, 255, 0.2), 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    /* Interactive Table Enhancements */
    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(30, 64, 255, 0.05);
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* Table text color */
    .table th {
        color: var(--text-main);
    }

    .table td {
        color: var(--text-main);
    }

    [data-theme="dark"] .table {
        color: var(--text-main);
        --bs-table-color: var(--text-main);
        --bs-table-hover-color: var(--text-main);
    }

    [data-theme="dark"] .table th,
    [data-theme="dark"] .table td,
    [data-theme="dark"] .table span,
    [data-theme="dark"] .table th,
    [data-theme="dark"] .table td,
    [data-theme="dark"] .table span,
    [data-theme="dark"] .table div,
    [data-theme="dark"] .table strong,
    [data-theme="dark"] .table b,
    [data-theme="dark"] .table .fw-bold,
    [data-theme="dark"] .table * {
        color: #ffffff !important;
    }

    [data-theme="dark"] .table tbody tr {
        background-color: transparent;
        color: #ffffff !important;
    }

    [data-theme="dark"] .table thead th {
        background-color: var(--card-bg);
        color: #ffffff !important;
        border-bottom-color: var(--card-border);
    }

    [data-theme="dark"] .text-muted {
        color: #94a3b8 !important;
    }

    /* Premium Button Effects */
    .btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .btn::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn:active::after {
        width: 300px;
        height: 300px;
    }

    .btn-primary:hover, .btn-success:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
    }

    /* Badge Enhancements */
    .badge-pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.8; transform: scale(1.05); }
    }

    /* Form Input Enhancements */
    .form-control, .form-select {
        background-color: var(--card-bg);
        border-color: var(--card-border);
        border-width: 2px;
        color: var(--text-main);
    }

    [data-theme="dark"] .form-control,
    [data-theme="dark"] .form-select {
        color: var(--text-main) !important;
        background-color: var(--card-bg);
    }

    .form-control::placeholder {
        color: var(--text-muted);
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1), 0 0 12px rgba(37, 99, 235, 0.2); /* Biru Focus Ring */
        transform: translateY(-1px);
        border-color: #2563EB; /* Biru Focus Ring */
    }

    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Glassmorphism - Updated for light theme */
    .glass-card {
        background: rgba(255, 255, 255, 0.7); /* Putih untuk tema terang */
        backdrop-filter: blur(20px);
        border: 1px solid #E5E7EB; /* Abu Border Tipis */
    }

    /* Gradient Text */
    .gradient-text {
        background: linear-gradient(135deg, #1E40FF, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Hover Scale */
    .hover-scale:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }

    /* Dynamic Grid Resizing Logic */
    @media (min-width: 1200px) {
        /* Sidebar Open: 3 Columns (Wider Cards) */
        body:not(.sidebar-collapsed) .main-content .row-cols-lg-4 > *,
        body:not(.sidebar-collapsed) .main-content .row-cols-xl-4 > * {
            --card-bg: #1e293b;
            --card-bg: #1e293b;
            --card-border: rgba(255, 255, 255, 0.2); /* Lebih terang/jelas untuk dark mode */
            flex: 0 0 auto;
            width: 33.3333%;
        }

        /* Sidebar Collapsed: 5 Columns (Smaller Cards) */
        body.sidebar-collapsed .main-content .row-cols-lg-4 > *,
        body.sidebar-collapsed .main-content .row-cols-xl-4 > * {
            flex: 0 0 auto;
            width: 20%;
        }
    }

    /* Smooth Transition for Grid Items */
    .main-content .row > * {
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s ease;
    }

    .card {
        background-color: var(--card-bg);
        border: 1px solid var(--card-border);
        color: var(--text-main);
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    [data-theme="dark"] .card {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5), 0 2px 4px -1px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.25); /* Paksa border lebih terang */
    }

    /* Custom Tooltip Styling */
    .tooltip-inner {
        background-color: var(--card-bg);
        color: var(--text-main);
        border: 1px solid var(--card-border);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 8px 12px;
        font-family: 'Outfit', sans-serif;
        font-size: 0.85rem;
        border-radius: 6px;
    }

    .tooltip.bs-tooltip-end .tooltip-arrow::before {
        border-right-color: var(--card-border);
    }

    /* Mengatur lebar konten agar tetap seimbang dengan sidebar yang lebih ramping */
    .main-content {
        padding: 2rem; /* Kembali ke padding normal */
    }

</style>
@endpush

@section('content')
    @yield('pelanggan_content')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                trigger: 'hover' // Explicitly set trigger to hover
            })
        });

        // Optional: Disable tooltips when sidebar is expanded (if desired)
        const body = document.body;
        const sidebar = document.getElementById('sidebar');

        function updateTooltips() {
            if (body.classList.contains('sidebar-collapsed')) {
                tooltipList.forEach(t => t.enable());
            } else {
                tooltipList.forEach(t => t.disable());
            }
        }

        // Initial check
        updateTooltips();

        // Listen for sidebar toggle events (assuming toggle button clicks toggle the class)
        const toggleBtn = document.getElementById('sidebarToggle');
        if(toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                // Wait a bit for class toggle to happen
                setTimeout(updateTooltips, 50);
            });
        }

        // Function to show flash messages (success/error)
        window.showFlashMessage = function(message, type = 'success') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: type,
                title: message
            });
        };

        // Check for flash messages on page load
        @if(session('success'))
            window.showFlashMessage('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            window.showFlashMessage('{{ session('error') }}', 'error');
        @endif
    });
</script>
@endpush
