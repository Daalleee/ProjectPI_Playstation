<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — PlayStation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Light Theme Palette */
            --bg-light: #F5F6FA;      /* Abu Sangat Terang - Global Container */
            --sidebar-bg: #0652DD;    /* Warna biru - Blue for sidebar */
            --sidebar-hover-bg: #0652DD; /* Warna biru - Same blue for sidebar hover */
            --card-bg: #FFFFFF;       /* Putih Murni - White for card background */
            --card-border: #E5E7EB;   /* Abu Border Tipis - Light gray for borders */

            --primary: #0652DD;       /* Warna biru - Blue as main */
            --primary-hover: #0652DD; /* Warna biru - Same blue for hover */
            --secondary: #06b6d4;     /* Cyan 500 */

            --text-main: #000000;     /* HITAM MURNI - Main text color */
            --text-muted: #000000;    /* HITAM MURNI - Muted text */
            --text-dim: #000000;      /* HITAM MURNI - For less important details */

            --success: #22c55e;       /* Green 500 */
            --warning: #eab308;       /* Yellow 500 */
            --danger: #ef4444;        /* Red 500 */

            --sidebar-width: 230px; /* Kurangi lebar sidebar */
            --sidebar-collapsed-width: 70px;
            --header-height: 70px;
        }

        [data-theme="dark"] {
            --bg-light: #0f172a;
            --sidebar-bg: #1e293b;
            --sidebar-hover-bg: #334155;
            --card-bg: #1e293b;
            --card-border: #334155;
            
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-dim: #64748b;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
            margin: 0;
            line-height: 1.6;
        }

        /* Subtle Grid Background */
        .bg-grid {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
            z-index: -2;
            pointer-events: none;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            z-index: 1040;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            box-shadow: none;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            height: 56px;
            display: flex;
            align-items: center;
            padding: 0 1rem;
            white-space: nowrap;
            background: inherit;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 0.5rem;
        }

        .logo-icon {
            min-width: 28px;
            height: 28px;
            background: #0652DD;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            margin-right: 8px;
            box-shadow: none;
        }

        .logo-text {
            font-weight: 800;
            font-size: 1.1rem; /* Kurangi ukuran font lebih jauh */
            color: white;
            letter-spacing: 0.4px;
            opacity: 1;
            transition: opacity 0.2s;
        }

        .sidebar.collapsed .logo-text {
            opacity: 0;
            pointer-events: none;
            display: none;
        }

        .sidebar-menu {
            flex: 1;
            padding: 0 0.75rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.6rem 0.85rem;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            white-space: nowrap;
            font-weight: 500;
            font-size: 0.875rem;
            margin: 0;
        }

        .sidebar-menu .nav-link {
            margin-bottom: 0 !important;
        }

        .nav-link:hover {
            color: white;
            background: #0652DD;
            transform: translateX(3px);
        }

        .nav-link.active {
            color: white;
            background: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)), #0652DD;
            font-weight: 600;
        }

        .nav-link i {
            font-size: 1.15rem;
            min-width: 22px;
            display: flex;
            justify-content: center;
            margin-right: 10px;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem 0;
        }

        .sidebar.collapsed .nav-link:hover {
            transform: none;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        /* Center logo when sidebar is collapsed */
        .sidebar.collapsed .sidebar-header {
            justify-content: center;
            padding: 0;
            border-bottom: none;
        }

        .sidebar.collapsed .logo-icon {
            margin-right: 0;
        }

        /* Sidebar Heading */
        .sidebar-heading {
            color: #E5E7EB;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.65rem;
            letter-spacing: 0.5px;
            padding: 0.75rem 0.85rem 0.4rem;
            margin: 0;
            white-space: nowrap;
        }

        .sidebar.collapsed .sidebar-heading {
            opacity: 0;
            display: none;
        }
        
        /* Logout section */
        .sidebar-menu .mt-auto {
            margin-top: auto !important;
            padding-top: 0.75rem !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        /* Utility Overrides for Dark Theme */
        .text-muted {
            color: var(--text-muted) !important;
        }
        
        .text-white {
            color: var(--text-main) !important;
        }
        
        .text-secondary {
            color: var(--secondary) !important;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding-top: calc(var(--header-height) + 2rem); /* Nilai default sebelumnya */
        }

        body.sidebar-collapsed .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Top Navbar */
        .top-navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: var(--header-height);
            background: var(--card-bg); /* Use variable for background */
            z-index: 1030;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: none;
        }

        .sidebar.collapsed + .main-content .top-navbar,
        body.sidebar-collapsed .top-navbar {
            left: var(--sidebar-collapsed-width);
        }

        .toggle-btn {
            background: transparent;
            border: none;
            color: var(--text-main);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .toggle-btn:hover {
            background: #0652DD;
            color: white;
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: #FFFFFF; /* PUTIH MURNI */
            border-bottom: 1px solid var(--card-border);
            padding: 1.25rem 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Tables - Light Theme */
        .table {
            --bs-table-bg: transparent;
            --bs-table-color: #000000; /* HITAM MURNI */
            --bs-table-border-color: var(--card-border);
            margin-bottom: 0;
        }

        .table th {
            color: #000000; /* HITAM MURNI */
            font-weight: 600;
            background: #FFFFFF; /* PUTIH MURNI */
            border-bottom: 2px solid var(--card-border);
            padding: 1rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table td {
            vertical-align: middle;
            padding: 1rem;
            border-bottom: 1px solid var(--card-border);
            color: #000000; /* HITAM MURNI */
        }

        .table tbody tr:hover {
            background-color: rgba(30, 64, 255, 0.05);
        }

        /* Badges - Light Theme Contrast */
        .badge {
            font-weight: 600;
            padding: 0.5em 0.8em;
            letter-spacing: 0.025em;
            border-radius: 6px;
        }

        /* Colors that provide good contrast on light backgrounds */
        .bg-success-subtle {
            background-color: rgba(34, 197, 94, 0.15) !important;
            color: #000000 !important; /* HITAM MURNI untuk kontras maksimal */
            border: 1px solid rgba(34, 197, 94, 0.3);
        }
        .bg-warning-subtle {
            background-color: rgba(234, 179, 8, 0.15) !important;
            color: #000000 !important; /* HITAM MURNI untuk kontras maksimal */
            border: 1px solid rgba(234, 179, 8, 0.3);
        }
        .bg-danger-subtle {
            background-color: rgba(239, 68, 68, 0.15) !important;
            color: #000000 !important; /* HITAM MURNI untuk kontras maksimal */
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        .bg-primary-subtle {
            background-color: rgba(30, 64, 255, 0.15) !important;
            color: #000000 !important; /* HITAM MURNI untuk kontras maksimal */
            border: 1px solid rgba(30, 64, 255, 0.3);
        }
        .bg-secondary-subtle {
            background-color: rgba(148, 163, 184, 0.15) !important;
            color: #000000 !important; /* HITAM MURNI untuk kontras maksimal */
            border: 1px solid rgba(148, 163, 184, 0.3);
        }
        .bg-info-subtle {
            background-color: rgba(6, 182, 212, 0.15) !important;
            color: #000000 !important; /* HITAM MURNI untuk kontras maksimal */
            border: 1px solid rgba(6, 182, 212, 0.3);
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        /* Pagination Styles */
        .pagination {
            margin: 0;
            gap: 0.25rem;
        }
        
        .pagination .page-link {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--card-border);
            color: var(--text-muted);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        
        .pagination .page-link:hover:not(.disabled) {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-main);
            border-color: var(--primary);
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        
        .pagination .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: transparent;
        }

        .pagination .page-link svg {
            width: 14px;
            height: 14px;
            vertical-align: middle;
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0 !important;
            }
            
            .top-navbar {
                left: 0 !important;
            }
            
            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.7); /* Darker overlay */
                backdrop-filter: blur(4px);
                z-index: 1035;
                display: none;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
        }
        /* Form Controls Light Theme */
        .form-control, .form-select {
            background-color: #FFFFFF;
            border-color: #A3A3A3;
            color: #000000; /* HITAM MURNI */
        }
        .form-control:focus, .form-select:focus {
            background-color: #FFFFFF;
            border-color: var(--primary);
            color: #000000; /* HITAM MURNI */
            box-shadow: 0 0 0 0.25rem rgba(30, 64, 255, 0.25);
        }
        .form-control::placeholder {
            color: #000000; /* HITAM MURNI */
            opacity: 0.7;
        }
        .input-group-text {
            background-color: #F5F6FA;
            border-color: #A3A3A3;
            color: #000000; /* HITAM MURNI */
        }

        /* Ensure text is readable in all containers */
        .card, .modal-content, .dropdown-menu {
            color: var(--text-main);
        }

        /* Fix for specific text-dark usages that might be on dark background */
        /* We target text-dark that is NOT inside a badge, alert, or light background */
        body:not(.bg-light):not(.bg-white) .text-dark:not(.badge):not(.alert):not(.btn):not(.bg-white):not(.bg-light):not(.bg-warning) {
            color: var(--text-muted) !important;
        }

        /* Specific logout link color */
        .text-danger {
            color: white !important;
        }
        
        /* Prevent dark navy/blue colors on badges that would blend with background */
        .badge.bg-dark, .badge[style*="background-color: #1e293b"], 
        .badge[style*="background-color: #0f172a"],
        .badge[style*="background: #1e293b"],
        .badge[style*="background: #0f172a"] {
            background-color: rgba(99, 102, 241, 0.3) !important;
            color: #a5b4fc !important;
            border: 1px solid rgba(99, 102, 241, 0.5);
        }
        
        /* Ensure no text uses colors similar to background */
        .text-navy, .text-slate-900, .text-slate-800,
        [style*="color: #0f172a"], [style*="color: #1e293b"],
        [style*="color: #003087"] {
            color: var(--text-main) !important;
        }
        
        /* Override Bootstrap default badge colors for better contrast */
        .badge.bg-dark {
            background-color: rgba(71, 85, 105, 0.4) !important;
            color: #e2e8f0 !important;
        }
        
        .badge.bg-primary {
            background-color: var(--primary) !important;
            color: #ffffff !important;
        }
        
        .badge.bg-info {
            background-color: var(--secondary) !important;
            color: #ffffff !important;
        }

        /* ===== Stylish SweetAlert2 Custom Styles ===== */
        .swal-logout-popup {
            border-radius: 20px !important;
            padding: 2rem !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            border: none !important;
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%) !important;
        }

        .swal-logout-popup .swal2-title {
            color: #1e293b !important;
            font-family: 'Outfit', sans-serif !important;
            padding: 0 !important;
            margin-bottom: 0 !important;
        }

        .swal-logout-popup .swal2-html-container {
            color: #64748b !important;
            font-family: 'Outfit', sans-serif !important;
            margin: 1rem 0 !important;
        }

        .swal-actions {
            gap: 12px !important;
            margin-top: 1.5rem !important;
        }

        .swal-confirm-btn {
            background: linear-gradient(135deg, #0652DD 0%, #0043b8 100%) !important;
            color: white !important;
            border: none !important;
            padding: 12px 28px !important;
            border-radius: 12px !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            font-family: 'Outfit', sans-serif !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 15px rgba(6, 82, 221, 0.35) !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .swal-confirm-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(6, 82, 221, 0.45) !important;
        }

        .swal-confirm-btn:active {
            transform: translateY(0) !important;
        }

        .swal-cancel-btn {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
            color: #475569 !important;
            border: 1px solid #cbd5e1 !important;
            padding: 12px 28px !important;
            border-radius: 12px !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            font-family: 'Outfit', sans-serif !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .swal-cancel-btn:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        .swal-cancel-btn:active {
            transform: translateY(0) !important;
        }

        /* Success/Error/Warning popup styles */
        .swal-success-popup {
            border-radius: 20px !important;
            padding: 2rem !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            background: linear-gradient(145deg, #ffffff 0%, #f0fdf4 100%) !important;
        }

        .swal-error-popup {
            border-radius: 20px !important;
            padding: 2rem !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            background: linear-gradient(145deg, #ffffff 0%, #fef2f2 100%) !important;
        }

        .swal-warning-popup {
            border-radius: 20px !important;
            padding: 2rem !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            background: linear-gradient(145deg, #ffffff 0%, #fffbeb 100%) !important;
        }

        /* Toast notification styles */
        .swal2-popup.swal2-toast {
            border-radius: 12px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
            padding: 12px 20px !important;
        }

        .swal2-popup.swal2-toast .swal2-title {
            font-family: 'Outfit', sans-serif !important;
            font-weight: 500 !important;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="bg-grid"></div>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">
                <i class="bi bi-playstation fs-4"></i>
            </div>
            <span class="logo-text" style="font-size: 1.1rem;">PlayStation</span>
        </div>
        
        <nav class="sidebar-menu">
            @yield('sidebar_menu')
            
            <div class="mt-auto">
                <form method="POST" action="{{ route('logout') }}" onsubmit="confirmLogout(event)">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent text-danger">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>{{ __('dashboard.logout') }}</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Top Navbar -->
    <header class="top-navbar" id="topNavbar">
        <div class="d-flex align-items-center gap-3">
            <button class="toggle-btn" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <h5 class="m-0 fw-semibold d-none d-md-block">@yield('header_title', 'Dashboard')</h5>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <!-- Language Switcher -->
            <div class="dropdown">
                <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-translate fs-5" style="color: var(--text-main);"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="background-color: var(--card-bg); border-color: var(--card-border);">
                    <li><a class="dropdown-item" href="{{ route('lang.switch', 'id') }}" style="color: var(--text-main);">🇮🇩 Indonesia</a></li>
                    <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}" style="color: var(--text-main);">🇬🇧 English</a></li>
                </ul>
            </div>

            <!-- Dark Mode Toggle -->
            <button class="btn btn-link text-decoration-none" id="darkModeToggle">
                <i class="bi bi-moon-stars fs-5" style="color: var(--text-main);"></i>
            </button>

            <div class="dropdown">
                <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <div id="navbarAvatar" class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold overflow-hidden" style="width: 32px; height: 32px;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-100 h-100 object-fit-cover">
                        @else
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        @endif
                    </div>
                    <span class="d-none d-sm-block" style="color: var(--text-main);">{{ Auth::user()->name ?? 'User' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark border border-white border-opacity-10 shadow-lg">
                    <li><h6 class="dropdown-header">{{ __('dashboard.signed_in_as') }} {{ Auth::user()->role ?? 'User' }}</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> {{ __('dashboard.profile') }}</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" onsubmit="confirmLogout(event)">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> {{ __('dashboard.logout') }}</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const topNavbar = document.getElementById('topNavbar');
            const toggleBtn = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');
            const body = document.body;
            
            const darkModeToggle = document.getElementById('darkModeToggle');
            const icon = darkModeToggle.querySelector('i');

            // Dark Mode Logic
            const currentTheme = localStorage.getItem('theme');
            if (currentTheme) {
                document.documentElement.setAttribute('data-theme', currentTheme);
                if (currentTheme === 'dark') {
                    icon.classList.replace('bi-moon-stars', 'bi-sun');
                }
            }

            darkModeToggle.addEventListener('click', () => {
                let theme = 'light';
                if (document.documentElement.getAttribute('data-theme') !== 'dark') {
                    theme = 'dark';
                    icon.classList.replace('bi-moon-stars', 'bi-sun');
                } else {
                    icon.classList.replace('bi-sun', 'bi-moon-stars');
                }
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
            });

            // Check local storage for preference
            const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
            if (isCollapsed && window.innerWidth >= 992) {
                sidebar.classList.add('collapsed');
                body.classList.add('sidebar-collapsed');
                // Adjust navbar position manually since CSS variable dependency in calc() might lag
                topNavbar.style.left = 'var(--sidebar-collapsed-width)';
            }

            function toggleSidebar() {
                if (window.innerWidth >= 992) {
                    // Desktop: Collapse/Expand
                    sidebar.classList.toggle('collapsed');
                    body.classList.toggle('sidebar-collapsed');
                    
                    const collapsed = sidebar.classList.contains('collapsed');
                    localStorage.setItem('sidebar-collapsed', collapsed);
                    
                    // Update navbar position
                    if (collapsed) {
                        topNavbar.style.left = 'var(--sidebar-collapsed-width)';
                    } else {
                        topNavbar.style.left = 'var(--sidebar-width)';
                    }
                } else {
                    // Mobile: Show/Hide
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                }
            }

            toggleBtn.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // Handle resize
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    
                    // Restore collapsed state
                    if (localStorage.getItem('sidebar-collapsed') === 'true') {
                        sidebar.classList.add('collapsed');
                        topNavbar.style.left = 'var(--sidebar-collapsed-width)';
                    } else {
                        sidebar.classList.remove('collapsed');
                        topNavbar.style.left = 'var(--sidebar-width)';
                    }
                } else {
                    sidebar.classList.remove('collapsed');
                    topNavbar.style.left = '0';
                }
            });
        });

        // Global Flash Message Function using SweetAlert2 - Stylish Version
        function showFlashMessage(message, type = 'success') {
            const iconColors = {
                success: '#10b981',
                error: '#ef4444',
                warning: '#f59e0b',
                info: '#0652DD'
            };
            
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                background: '#ffffff',
                color: '#1e293b',
                iconColor: iconColors[type] || iconColors.info,
                customClass: {
                    popup: 'swal2-toast-custom'
                },
                showClass: {
                    popup: 'animate__animated animate__slideInRight animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__slideOutRight animate__faster'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: type,
                title: `<span style="font-weight: 500; font-size: 0.95rem;">${message}</span>`
            });
        }

        // Global Confirm Action Helper - Stylish Version
        function confirmAction(message, formId) {
            Swal.fire({
                title: '<span style="font-weight: 700; font-size: 1.5rem;">Konfirmasi Aksi</span>',
                html: `
                    <div style="margin-top: 10px;">
                        <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-exclamation-triangle" style="font-size: 2.5rem; color: #d97706;"></i>
                        </div>
                        <p style="color: #64748b; font-size: 1rem; margin: 0;">${message}</p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-lg me-2"></i>Ya, Lanjutkan',
                cancelButtonText: '<i class="bi bi-x-lg me-2"></i>Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'swal-logout-popup',
                    confirmButton: 'swal-confirm-btn',
                    cancelButton: 'swal-cancel-btn',
                    actions: 'swal-actions'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
            return false;
        }

        // Global Logout Confirmation Helper - Stylish Version
        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: '<span style="font-weight: 700; font-size: 1.5rem;">Keluar dari Akun?</span>',
                html: `
                    <div style="margin-top: 10px;">
                        <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-box-arrow-right" style="font-size: 2.5rem; color: #dc2626;"></i>
                        </div>
                        <p style="color: #64748b; font-size: 1rem; margin: 0;">Anda akan keluar dari sesi ini.<br>Yakin ingin melanjutkan?</p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-lg me-2"></i>Ya, Keluar',
                cancelButtonText: '<i class="bi bi-x-lg me-2"></i>Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'swal-logout-popup',
                    confirmButton: 'swal-confirm-btn',
                    cancelButton: 'swal-cancel-btn',
                    actions: 'swal-actions'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Logging out...',
                        html: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        background: '#ffffff',
                        customClass: {
                            popup: 'swal-logout-popup'
                        }
                    });
                    
                    const form = event.target.closest('form');
                    if (form) {
                        form.submit();
                    }
                }
            });
        }

        // Logout confirmation for partial nav
        function confirmLogoutPartial(event) {
            event.preventDefault();
            Swal.fire({
                title: '<span style="font-weight: 700; font-size: 1.5rem;">Keluar dari Akun?</span>',
                html: `
                    <div style="margin-top: 10px;">
                        <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-box-arrow-right" style="font-size: 2.5rem; color: #dc2626;"></i>
                        </div>
                        <p style="color: #64748b; font-size: 1rem; margin: 0;">Anda akan keluar dari sesi ini.<br>Yakin ingin melanjutkan?</p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-lg me-2"></i>Ya, Keluar',
                cancelButtonText: '<i class="bi bi-x-lg me-2"></i>Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'swal-logout-popup',
                    confirmButton: 'swal-confirm-btn',
                    cancelButton: 'swal-cancel-btn',
                    actions: 'swal-actions'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = event.target;
                    form.submit();
                }
            });
        }
    </script>
    @yield('scripts')
</body>
</html>
