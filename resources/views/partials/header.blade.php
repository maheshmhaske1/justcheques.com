<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Better Navbar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: tan;
            padding: 10px 20px;
            position: relative;
            z-index: 10;
            display: flex !important;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            width: 120px;
            height: auto;
        }

        .menu {
            display: flex;
            list-style: none;
            justify-content: flex-end;
            position: relative;
            align-items: center;
        }

        .menu li a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            padding: 8px 12px;
            display: block;
        }

        .menu li a:hover {
            color: #000;
        }

        .menu-toggle {
            display: none;
            font-size: 28px;
            cursor: pointer;
        }

        /* Mobile styles */
        @media (max-width: 896px) {
            .navbar{
                display: block !important;
            }
            .menu-toggle {
                display: block;
            }

            .menu {
                flex-direction: column;
                width: 100%;
                display: none;
                margin-top: 10px;
            }

            .menu.active {
                display: flex;
            }

            .menu li {
                text-align: center;
                padding: 12px 0;
                border-top: 1px solid #ddd;
            }

            .menu li:first-child {
                border-top: none;
            }
        }

        /* Example page content styling */
        .page-content {
            padding: 20px;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-toggle {
            color: #333;
            font-size: 24px;
            text-decoration: none;
            padding: 8px;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            /* align right by default */
            background-color: tan;
            min-width: 180px;
            /* increased from 160px to fit text */
            list-style: none;
            padding: 0;
            margin: 0;
            border: 1px solid #ddd;
            z-index: 1000;
            box-sizing: border-box;
        }

        .dropdown-menu li {
            border-bottom: 1px solid #ddd;
        }

        .dropdown-menu li:last-child {
            border-bottom: none;
        }

        .dropdown-menu li a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            white-space: nowrap;
            /* prevent text wrapping */
        }

        .dropdown-menu li a:hover {
            background-color: #f0f0f0;
        }

        /* Responsive fix for small screens */
        @media screen and (max-width: 400px) {
            .dropdown-menu {
                right: auto;
                left: 0;
                /* switch to left alignment if no space on right */
            }
        }

        @media screen and (min-width: 768px) {
            .user-login-toggle {
                left: auto;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <a href="/">
                    <img src="{{ asset('assets/front/img/logo/logo.webp') }}" alt="Logo">
                </a>
            </div>
            <div class="menu-toggle" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        <ul class="menu" id="menu">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="{{ url('manual-cheque-list/' . 1) }}">Manual Cheques</a></li>
            <li><a href="{{ url('laser-cheque') }}">Laser Cheques</a></li>
            <li><a href="{{ url('personal-cheque') }}">Personal Cheques</a></li>
            <li><a href="{{ url('about-us') }}">About Us</a></li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle" id="user-toggle">
                    <i class="fa fa-user"></i>
                </a>
                <ul class="dropdown-menu user-login-toggle" id="user-dropdown">
                    @guest
                        <li><a href="/login">Login</a></li>
                    @endguest
                    @if (Auth::check() && in_array(Auth::user()->role, ['vendor', 'admin']))
                        <li><a href="{{ url('/customer-history') }}">Customers</a></li>
                        <li><a href="{{ url('/order-history') }}">Orders</a></li>
                    @endif
                    @auth
                        <li>
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endauth
                </ul>
            </li>

        </ul>
    </nav>

    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('menu');

        menuToggle.addEventListener('click', () => {
            menu.classList.toggle('active');
        });

        const userToggle = document.getElementById('user-toggle');
        const userDropdown = document.getElementById('user-dropdown');

        userToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.style.display = (userDropdown.style.display === 'block') ? 'none' : 'block';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!userDropdown.contains(e.target) && e.target !== userToggle) {
                userDropdown.style.display = 'none';
            }
        });
    </script>

</body>

</html>
