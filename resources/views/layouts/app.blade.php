<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Game Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Navbar Styling */
        .navbar {
            background: linear-gradient(to right, #141e30, #243b55);
        }

        .navbar-brand,
        .nav-link {
            color: white !important;
            transition: 0.3s;
        }

        .nav-link:hover {
            color: #ff4b2b !important;
        }

        .dropdown-menu {
            background: #243b55;
        }

        .dropdown-item {
            color: white !important;
        }

        .dropdown-item:hover {
            background: #ff4b2b;
        }

        /* Badge untuk keranjang */
        .cart-badge {
            font-size: 12px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 3px 7px;
            position: absolute;
            top: 8px;
            right: -5px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">🎮 Toko Game</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>

                    <!-- Keranjang -->
                    <li class="nav-item position-relative">
                        <a class="nav-link" href="{{ route('cart.view') }}">
                            🛒 
                            <span class="cart-badge">
                                {{ auth('customer')->check() ? \App\Models\Cart::where('customer_id', auth('customer')->id())->sum('quantity') : 0 }}
                            </span>
                        </a>
                    </li>


                    <!-- User Authentication -->
                    @if (auth()->guard('customer')->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown">
                                👤 {{ auth()->guard('customer')->user()->username }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('customer.profile') }}">Profil</a></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn btn-warning text-dark fw-bold px-3"
                                href="{{ route('login') }}">Login</a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
