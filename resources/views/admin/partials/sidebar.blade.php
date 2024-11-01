<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="admin" class="app-brand-link mx-5">
            <span class="app-brand-logo demo">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">
                <img src="{{ asset('assets/front/img/logo/logo.webp') }}" class="img-fluid w-80 h-80 rounded" alt="Second slide" width="60px" height="40px">
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item active">
            <a href="{{ url('admin') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-view-dashboard"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

         <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-checkbook-arrow-right"></i>
                <div data-i18n="Layouts">Cheques</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ url('admin/manualcheques') }}" class="menu-link">
                        <div data-i18n="Without menu">
                            Manual Cheques
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('admin/lasercheques') }}" class="menu-link">
                        <div data-i18n="Without navbar">
                            Laser Cheques
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('admin/personalcheques') }}" class="menu-link">
                        <div data-i18n="Container">
                            Personal Cheques
                        </div>
                    </a>
                </li>
            </ul>
        </li>

         <li class="menu-item">
            <a href="{{ route('admin.customer') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-account-group"></i>
                <div data-i18n="Analytics">Customers</div>
            </a>
        </li>

         <li class="menu-item">
            <a href="index.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div data-i18n="Analytics">Cheques Categories</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div data-i18n="Analytics">Logout</div>
            </a>
        </li>

        <!-- Layouts -->
        {{-- <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Layouts</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="layouts-without-menu.html" class="menu-link">
                        <div data-i18n="Without menu">
                            Without menu
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-without-navbar.html" class="menu-link">
                        <div data-i18n="Without navbar">
                            Without navbar
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-container.html" class="menu-link">
                        <div data-i18n="Container">
                            Container
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-fluid.html" class="menu-link">
                        <div data-i18n="Fluid">Fluid</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-blank.html" class="menu-link">
                        <div data-i18n="Blank">Blank</div>
                    </a>
                </li>
            </ul>
        </li> --}}
    </ul>
</aside>
