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
            height: calc(var(--header-height) - 8px); /* Kurangi sedikit tinggi header */
            display: flex;
            align-items: center;
            padding: 0 0.8rem; /* Kurangi padding */
            white-space: nowrap;
            background: inherit; /* Uses the same background as sidebar */
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
            padding: 0.8rem 1rem; /* Kurangi padding lebih jauh */
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.2rem; /* Kurangi jarak antar menu lebih jauh */
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.4rem 1rem; /* Kurangi padding vertikal lebih jauh */
            color: white;
            text-decoration: none;
            border-radius: 10px; /* Kurangi border radius */
            transition: all 0.2s ease;
            white-space: nowrap;
            font-weight: 500;
            font-size: 0.9rem; /* Sedikit kecilkan ukuran font */
            margin: 0; /* Pastikan tidak ada margin tambahan */
        }

        /* Tambahkan override lebih kuat untuk semua menu item */
        .sidebar-menu .nav-link {
            margin-bottom: 0 !important;
        }

        .nav-link:hover {
            color: white;
            background: #0652DD; /* Same blue color as base */
            transform: translateX(4px);
        }

        .nav-link.active {
            color: white;
            background: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)), #0652DD; /* More darkening overlay without changing base color */
            font-weight: 600;
        }

        .nav-link i {
            font-size: 1.25rem;
            min-width: 24px;
            display: flex;
            justify-content: center;
            margin-right: 12px;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.9rem 0;
        }

        .sidebar.collapsed .nav-link:hover {
            transform: none;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        /* Sidebar Heading */
        .sidebar-heading {
            color: #E5E7EB;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.6rem; /* Kecilkan font lebih jauh */
            letter-spacing: 0.4px; /* Kurangi letter spacing lebih jauh */
            padding: 0 1rem;
            margin-top: 0.6rem; /* Kurangi margin atas lebih jauh */
            margin-bottom: 0.2rem; /* Kurangi margin bawah lebih jauh */
            white-space: nowrap;
            opacity: 1;
            transition: opacity 0.2s;
        }

        .sidebar.collapsed .sidebar-heading {
            opacity: 0;
            display: none;
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
            background: white; /* White background to maintain light theme */
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
            
            <div class="mt-auto pt-4 border-top border-white border-opacity-10">
                <form method="POST" action="{{ route('logout') }}" onsubmit="confirmLogout(event)">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent text-danger">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
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
            <div class="dropdown">
                <button class="btn btn-link text-white text-decoration-none dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <div id="navbarAvatar" class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold overflow-hidden" style="width: 32px; height: 32px;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-100 h-100 object-fit-cover">
                        @else
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        @endif
                    </div>
                    <span class="d-none d-sm-block">{{ Auth::user()->name ?? 'User' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark border border-white border-opacity-10 shadow-lg">
                    <li><h6 class="dropdown-header">Signed in as {{ Auth::user()->role ?? 'User' }}</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Profile</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" onsubmit="confirmLogout(event)">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
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

        // Global Flash Message Function using SweetAlert2
        function showFlashMessage(message, type = 'success') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#FFFFFF',
                color: '#222222',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: type,
                title: message
            });
        }

        // Global Confirm Action Helper
        function confirmAction(message, formId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0652DD', // Primary color (blue)
                cancelButtonColor: '#ef4444', // Danger color
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Batal',
                background: '#FFFFFF',
                color: '#222222'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
            return false;
        }

        // Global Logout Confirmation Helper
        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: 'Anda akan keluar dari sesi ini.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0652DD', // Primary color (blue)
                cancelButtonColor: '#ef4444', // Danger color
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                background: '#FFFFFF',
                color: '#222222'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Find the form associated with this logout action and submit it
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
                title: 'Yakin ingin keluar?',
                text: 'Anda akan keluar dari sesi ini.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0652DD', // Primary color (blue)
                cancelButtonColor: '#ef4444', // Danger color
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                background: '#FFFFFF',
                color: '#222222'
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
