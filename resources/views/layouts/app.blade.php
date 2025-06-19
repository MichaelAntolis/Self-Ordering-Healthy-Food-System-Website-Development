<!-- layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Healthy Food Self-Ordering</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.4)), url('https://images.unsplash.com/photo-1490645935967-10de6ba17061?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2053&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white;
            padding: 140px 0 120px 0;
            min-height: 70vh;
            position: relative;
            margin-top: -100px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(119, 255, 151, 0.8), rgba(32, 201, 151, 0.6));
            z-index: 1;
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
        }

        @media (max-width: 768px) {
            .hero-section {
                background-attachment: scroll;
                padding: 80px 0;
                min-height: 60vh;
            }
        }

        .feature-card {
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .menu-item-image {
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .navbar {
            background-color: #ffffff;
            border-bottom: 2px solid #f1f1f1;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1075;
        }

        body {
            padding-top: 100px; /* Increased padding to prevent content overlap */
        }

        /* Additional spacing for main content areas */
        .container {
            margin-top: 20px;
        }

        .container.py-5 {
            padding-top: 3rem !important;
        }

        section.container.py-5 {
            padding-top: 3rem !important;
        }

        /* Specific fix for pages with immediate content */
        .main-content {
            padding-top: 20px;
        }

        /* Ensure all page content starts below navbar */
        .container:first-child,
        .row:first-child,
        section:first-child {
            margin-top: 20px !important;
        }

        /* Fix for cards and content that might be too close to navbar */
        .card,
        .table-container,
        .page-header {
            margin-top: 10px;
        }

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            body {
                padding-top: 80px;
            }
            
            .hero-section {
                margin-top: -80px;
                padding-top: 120px;
            }
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 24px;
            color: #28a745;
        }

        .nav-link {
            font-size: 16px;
            font-weight: 500;
            color: #333;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #28a745;
        }

        .modal-content {
            background: linear-gradient(135deg, #f5f5f5, #ffffff);
            border: none;
            border-radius: 10px;
            padding: 20px;
        }
        
        /* Fix z-index untuk modal dan notifikasi */
        .modal {
            z-index: 1080 !important;
        }
        
        .modal-backdrop {
            z-index: 1079 !important;
        }
        
        /* Notifikasi harus di atas modal */
        .alert.position-fixed {
            z-index: 1085 !important;
        }
        
        /* Loading overlay */
        #loadingOverlay {
            z-index: 1090 !important;
        }

        .modal-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }

        .modal-title {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }

        .modal-body p {
            font-size: 16px;
            color: #333;
        }

        .modal-footer .btn {
            font-size: 16px;
            border-radius: 50px;
            transition: background-color 0.3s ease;
        }

        .modal-footer .btn:hover {
            background-color: #28a745;
            color: white;
        }

        .btn-close {
            color: #28a745;
        }

        .modal-dialog-centered {
            max-width: 500px;
        }

        .profile-link:hover {
            text-decoration: underline;
            color: #28a745;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex-grow: 1;
        }

        footer {
            margin-top: auto;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fab-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            min-width: 22px;
            box-shadow: 0 3px 10px rgba(220, 53, 69, 0.4);
            border: 2px solid white;
            animation: pulse 2s infinite;
            z-index: 2;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #28a745, #20c997);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-radius: 10px;
            padding: 0.5rem 0;
            min-width: 250px;
            z-index: 1090 !important;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            pointer-events: auto !important;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-toggle::after {
            margin-left: 0.5rem;
        }

        .nav-link.dropdown-toggle {
            cursor: pointer;
            pointer-events: auto !important;
            position: relative;
            z-index: 1100 !important;
            background: transparent !important;
        }
        
        .nav-item.dropdown {
            position: relative;
            z-index: 1095 !important;
        }
        
        /* Debug CSS untuk dropdown */
        .nav-link.dropdown-toggle:hover {
            background-color: rgba(40, 167, 69, 0.1) !important;
            border-radius: 8px !important;
        }
        
        .nav-link.dropdown-toggle:focus {
            outline: 2px solid #28a745 !important;
            outline-offset: 2px !important;
        }

        .dropdown-header {
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 0.25rem;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }



    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="text-success">Healthy</span>Order
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('menu') }}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            Cart
                            <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
                        </a>
                    </li>
                    
                    @auth('customer')
                        <!-- Profile Dropdown for Desktop -->
                        <li class="nav-item dropdown d-none d-lg-block">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" 
                               href="#" 
                               id="navbarProfileDropdown" 
                               role="button" 
                               data-bs-toggle="dropdown" 
                               aria-expanded="false">
                                <div class="user-avatar me-2">{{ Auth::guard('customer')->user()->initials }}</div>
                                <span class="d-none d-xl-inline">{{ Str::limit(Auth::guard('customer')->user()->name, 15) }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="navbarProfileDropdown">
                                <li class="dropdown-header">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-2" style="width: 24px; height: 24px; font-size: 12px;">
                                            {{ Auth::guard('customer')->user()->initials }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ Auth::guard('customer')->user()->name }}</div>
                                            <small class="text-muted">{{ Auth::guard('customer')->user()->email }}</small>
                                        </div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        Profile Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.history') }}">
                                        Riwayat Pesanan
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('cart.index') }}">
                                        Keranjang Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Profile Links for Mobile -->
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="{{ route('profile') }}">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="{{ route('orders.history') }}">
                                Riwayat Pesanan
                            </a>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                                Logout
                            </a>
                        </li>

                        <!-- Hidden Logout Forms -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="main-content">


        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><span class="text-success">Healthy</span>Order</h5>
                    <p>Empowering healthy eating with convenient digital ordering.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-decoration-none text-white">Home</a></li>
                        <li><a href="{{ route('menu') }}" class="text-decoration-none text-white">Menu</a></li>
                        @auth('customer')
                            <li><a href="{{ route('profile') }}" class="text-decoration-none text-white">Profile</a></li>
                            <li><a href="{{ route('orders.history') }}" class="text-decoration-none text-white">Riwayat Pesanan</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-decoration-none text-white">Login</a></li>
                            <li><a href="{{ route('register') }}" class="text-decoration-none text-white">Register</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p><i class="fas fa-envelope me-2"></i> info@healthyorder.com</p>
                    <p><i class="fas fa-phone me-2"></i> +62 123 456 7890</p>
                </div>
            </div>
            <div class="text-center mt-3">
                <p>&copy; {{ date('Y') }} HealthyOrder. All rights reserved.</p>
            </div>
        </div>
    </footer>



    <!-- Bootstrap JavaScript via CDN untuk memastikan berfungsi -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        
        // Debug Bootstrap dan Dropdown
        console.log('Bootstrap:', typeof bootstrap !== 'undefined' ? 'Loaded' : 'Not loaded');
        console.log('jQuery:', typeof $ !== 'undefined' ? 'Loaded' : 'Not loaded');
        
        // Test dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownElements = document.querySelectorAll('.dropdown-toggle');
            console.log('Dropdown elements found:', dropdownElements.length);
            
            dropdownElements.forEach((element, index) => {
                console.log(`Dropdown ${index}:`, element);
            });
        });
        // Update cart badge
        function updateCartBadge() {
            fetch('{{ route("cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    const badges = ['cartBadge'];
                    badges.forEach(badgeId => {
                        const badge = document.getElementById(badgeId);
                        if (badge) {
                            if (data.count > 0) {
                                badge.textContent = data.count;
                                badge.style.display = 'flex';
                            } else {
                                badge.style.display = 'none';
                            }
                        }
                    });
                })
                .catch(error => console.log('Error:', error));
        }

        // Force dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for Bootstrap to load
            setTimeout(function() {
                const dropdownToggle = document.getElementById('navbarProfileDropdown');
                const dropdownMenu = dropdownToggle ? dropdownToggle.nextElementSibling : null;
                
                console.log('Dropdown toggle found:', dropdownToggle);
                console.log('Dropdown menu found:', dropdownMenu);
                console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
                
                if (dropdownToggle && dropdownMenu) {
                    // Remove any existing event listeners
                    dropdownToggle.replaceWith(dropdownToggle.cloneNode(true));
                    const newDropdownToggle = document.getElementById('navbarProfileDropdown');
                    
                    // Try Bootstrap dropdown first
                    if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
                        try {
                            const dropdown = new bootstrap.Dropdown(newDropdownToggle);
                            console.log('Bootstrap dropdown initialized');
                        } catch (error) {
                            console.log('Bootstrap dropdown failed:', error);
                        }
                    }
                    
                    // Manual fallback
                    newDropdownToggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        console.log('Dropdown clicked');
                        
                        // Toggle dropdown
                        const isVisible = dropdownMenu.classList.contains('show');
                        
                        // Hide all other dropdowns
                        document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                            menu.classList.remove('show');
                        });
                        
                        // Toggle current dropdown
                        if (!isVisible) {
                            dropdownMenu.classList.add('show');
                            newDropdownToggle.setAttribute('aria-expanded', 'true');
                            console.log('Dropdown opened');
                        } else {
                            dropdownMenu.classList.remove('show');
                            newDropdownToggle.setAttribute('aria-expanded', 'false');
                            console.log('Dropdown closed');
                        }
                    });
                }
            }, 1000);
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.remove('show');
                        dropdownToggle.setAttribute('aria-expanded', 'false');
                    }
                });
                
                // Prevent dropdown from closing when clicking inside
                dropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });

        // Auto dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    if (alert.querySelector('.btn-close')) {
                        alert.querySelector('.btn-close').click();
                    }
                });
            }, 5000);
        });
    </script>
    @stack('scripts')
</body>

</html>