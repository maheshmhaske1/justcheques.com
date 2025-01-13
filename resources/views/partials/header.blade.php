<div class="navigation">
    <nav class="navbar navbar-custom" role="navigation">
        <div class="navbar-main-collapse navbar-collapse d-flex justify-content-center">
            <div class="team">
                <ul class="nav navbar-nav logoImg">
                    <li class="first-nav">
                        <a href="/">
                            <img src="{{ asset('assets/front/img/logo/logo.webp') }}" class="img-fluid w-80 h-80 rounded" alt="Second slide" width="130px" height="40px">

                        </a>
                    </li>
                </ul>
                <button type="button" class="navbar-menu responsive-menu" onclick="team()">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>

            </div>
            <div class="navbar-collapse navbar-main-collapse">
                <ul class="nav navbar-nav navbar-right navbar-navs align-items-end">
                    <li class="topmenu first-nav">
                        <a href="/">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    <!-- Category Navigation -->
                    <li class="topmenu hasSub no-js extrimg"
                        data-main="includes/templates/chequesplus/images/nav-images/quickbooks-cheques.png">
                        <a class="category-top" href="{{ url('manual-cheque-list/' . 1) }}">Manual Cheques</a>
                    </li>
                    <li class="topmenu hasSub no-js extrimg"
                        data-main="includes/templates/chequesplus/images/nav-images/quickbooks-cheques.png">
                        <a class="category-top" href="{{ url('laser-cheque') }}">Laser Cheques</a>
                    </li>
                    <li class="topmenu extrimg" data-main="">
                        <a class="category-top" href="{{ url('personal-cheque') }}">Personal Cheques</a>
                    </li>
                    <li class="topmenu hasSub no-js extrimg"
                        data-main="includes/templates/chequesplus/images/nav-images/quickbooks-cheques.png">
                        <a class="category-top" href="{{ url('about-us') }}">About Us</a>
                    </li>
                    <li class="topmenu hasSub no-js extrimg dropdown" data-main="">
                        <a href="login" class="my-auto category-top dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user fa-2x"></i>
                        </a>
                        <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton">
                            <ul>
                                @guest
                                <li><a class="dropdown-item" href="/login">Login</a></li>
                                @endguest
                                @if (Auth::check() && in_array(Auth::user()->role, ['vendor', 'admin']))
                                <li>
                                    <a class="dropdown-item" href="{{ url('/customer-history') }}">Customers</a>
                                </li>
                                @endif
                                @if (Auth::check() && in_array(Auth::user()->role, ['vendor', 'admin']))
                                <li>
                                    <a class="dropdown-item" href="{{ url('/order-history') }}">Orders</a>
                                </li>
                                @endif
                                @auth
                                <li>
                                    <a class="category-top text-decoration-none dropdown-item" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" method="POST" action="{{ route('logout') }}"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                                @endauth
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<script>
    function team() {
        const navbarCollapse = document.querySelector('.navbar-collapse');

        if (navbarCollapse) {
            // If navbar-collapse exists, remove it
            navbarCollapse.classList.toggle('navbar-collapse');
        } else {
            // If navbar-collapse doesn't exist, add it to the first element with the class "navbar-collapse"
            const navbar = document.querySelector('.navbar-main-collapse');
            if (navbar) {
                navbar.classList.add('navbar-collapse');
            }
        }
    }
</script>