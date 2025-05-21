<!-- Header Section -->
<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ url('/') }}">Cafe<span>Hub</span></a>
            
            <!-- Toggle button for smaller screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list"></i>
            </button>
            
            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="bi bi-house-door me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('transactions*') ? 'active' : '' }}" href="{{ route('transactions') }}">
                            <i class="bi bi-receipt me-1"></i> Transactions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products') }}">
                            <i class="bi bi-cup-hot me-1"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('raw-materials*') ? 'active' : '' }}" href="{{ route('raw_materials') }}">
                            <i class="bi bi-box-seam me-1"></i> Inventory
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('bill-of-materials*') ? 'active' : '' }}" href="{{ route('bill_of_materials') }}">
                            <i class="bi bi-clipboard-data me-1"></i> Recipes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('suppliers*') ? 'active' : '' }}" href="{{ route('suppliers') }}">
                            <i class="bi bi-truck me-1"></i> Suppliers
                        </a>
                    </li>
                </ul>
                
                <!-- Right side user controls -->
                <div class="d-flex align-items-center ms-auto">
                    <!-- Notifications -->
                    <div class="dropdown me-3">
                        <a class="nav-link position-relative" href="#" role="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationsDropdown">
                            <li><h6 class="dropdown-header">Notifications</h6></li>
                            <li><a class="dropdown-item" href="#">Low stock alert: Coffee beans</a></li>
                            <li><a class="dropdown-item" href="#">New supplier application</a></li>
                            <li><a class="dropdown-item" href="#">Weekly report available</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="#">View all</a></li>
                        </ul>
                    </div>
                    
                    <!-- User profile -->
                    <div class="dropdown">
                        <a href="#" class="user-avatar" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name=Cafe+Manager&background=0D8ABC&color=fff" alt="User">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li><h6 class="dropdown-header">Hey, Manager!</h6></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <button class="mobile-menu-close d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Close menu">
        <i class="bi bi-list"></i>
    </button>
</header>