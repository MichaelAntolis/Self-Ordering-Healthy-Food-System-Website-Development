<!-- layout/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Healthy Food Self-Ordering</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        #content {
            width: 100%;
            min-height: 100vh;
            transition: all 0.3s;
        }

        .sidebar-link {
            padding: 10px 15px;
            color: #333;
            transition: all 0.3s;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background-color: #e9ecef;
            text-decoration: none;
        }

        .sidebar-link i {
            margin-right: 10px;
            width: 25px;
            text-align: center;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }

            #sidebar.active {
                margin-left: 0;
            }
        }

        .modal-dialog {
            max-width: 600px;
            margin: 1.75rem auto;
        }

        .modal-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
            padding-top: 0;
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 1020;
            margin-bottom: 20px;
        }
        
        /* Fix z-index untuk modal dan notifikasi admin */
        .modal {
            z-index: 1080 !important;
        }
        
        .modal-backdrop {
            z-index: 1079 !important;
        }
        
        /* Alert dan notifikasi */
        .alert.position-fixed {
            z-index: 1085 !important;
        }

        /* Add padding to prevent content overlap */
        .container-fluid.py-4 {
            padding-top: 2rem !important;
        }

        /* Ensure page headers have proper spacing */
        .page-header {
            margin-top: 20px !important;
        }

        /* Additional spacing for admin content */
        #content {
            padding-top: 10px;
        }

        /* Fix for admin cards and tables */
        .stats-card,
        .table-container,
        .card {
            margin-top: 15px;
        }

        /* Ensure first elements have proper spacing */
        .container-fluid > *:first-child {
            margin-top: 20px !important;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-light shadow-sm">
            <div class="p-3 border-bottom">
                <h3 class="text-center"><span class="text-success">Healthy</span>Order</h3>
                <p class="text-center text-muted small">Admin Dashboard</p>
            </div>
            <div class="p-3">
                <div class="mb-4">
                    <h6 class="text-muted text-uppercase small fw-bold">Main</h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted text-uppercase small fw-bold">Master Data</h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('admin.foods.index') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.foods.*') ? 'active' : '' }}">
                                <i class="fas fa-utensils"></i> Foods
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                <i class="fas fa-list"></i> Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.customers.index') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                                <i class="fas fa-users"></i> Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                <i class="fas fa-shopping-cart"></i> Orders
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted text-uppercase small fw-bold">Reports</h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.category-foods') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.reports.category-foods') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar"></i> Categories with Most Foods
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.top-customers') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.reports.top-customers') ? 'active' : '' }}">
                                <i class="fas fa-user-check"></i> Top Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.popular-foods') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.reports.popular-foods') ? 'active' : '' }}">
                                <i class="fas fa-star"></i> Popular Foods
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.sales') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
                                <i class="fas fa-chart-line"></i> Sales Report
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.payment-stats') }}" class="nav-link sidebar-link {{ request()->routeIs('admin.reports.payment-stats') ? 'active' : '' }}">
                                <i class="fas fa-credit-card"></i> Payment Statistics
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link profile-link" href="{{ route('admin.profile') }}">
                                    <i class="fas fa-user-circle"></i> Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="fas fa-home"></i> Back to Landing Page
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Main Content Area -->
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </div>
    </div>


   
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script>
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>

</html>