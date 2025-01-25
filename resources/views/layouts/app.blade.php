<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Business Cheques Online - Beat the Bank | ChequesPlus</title>
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="icon" href="{{ asset('assets/front/img/favicon.ico') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('assets/front/img/favicon.ico') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('assets/front/img/apple-touch-icon.png?v=1636052792') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('assets/front/img/favicon-32x32.png?v=1636052792') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('assets/front/img/favicon-16x16.png?v=1636052792') }}">
    <link rel="mask-icon" href="{{ asset('assets/front/img/safari-pinned-tab.svg?v=1636052792') }}" color="#5bbad5">
    <link rel="shortcut icon" href="{{ asset('assets/front/img/favicon.ico?v=1636052792') }}">

    <link rel="stylesheet" href="{{ asset('assets/front/css/style-shipping.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/style_custom_footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/stylesheet.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/owl.carousel.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/front/css/font-style.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/front/css/new.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/front/css/account_menu.css') }}" />

    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet" />


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/style-shipping.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/style_bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/style_custom_footer.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/style_font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/style_main.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/style_open-sans.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/style_responsive.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/stylesheet_ajax_cart.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/index_home.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/ajaxcartslide.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/jquery.fancybox.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/skin.css') }}" />
    <link rel="stylesheet" src="{{ asset('assets/front/css/jquery_bxslider.css') }}">

    <link rel="preload" data-rocket-preload as="font"
        href="https://use.fontawesome.com/releases/v4.7.0/fonts/fontawesome-webfont.woff2" crossorigin>
    <link rel="preload" data-rocket-preload as="font"
        href="https://fonts.gstatic.com/s/nunito/v26/XRXI3I6Li01BKofiOc5wtlZ2di8HDLshdTQ3jw.woff2" crossorigin>
    <link rel="preload" data-rocket-preload as="font"
        href="https://fonts.gstatic.com/s/opensans/v40/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4gaVI.woff2"
        crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.4.47/css/materialdesignicons.min.css"
        integrity="sha512-/k658G6UsCvbkGRB3vPXpsPHgWeduJwiWGPCGS14IQw3xpr63AEMdA8nMYG2gmYkXitQxDTn6iiK/2fD4T87qA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="content-wrapper">
        <div class="wrapper">
                @include('partials.header')

            <div class="container">
                @yield('content')
            </div>
            @include('partials.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="{{ asset('assets/front/js/jscript_jquery_1.12.4.js') }}"></script>
    <script src="{{ asset('assets/front/js/jscript_zbootstrap.min.js') }}"></script>
    <script data-cfasync="false" src="{{ asset('assets/front/js/email-decode.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/front/js/customJs.js') }}"></script>
    <script src="{{ asset('assets/front/js/pushy.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.fancybox.js?v=2.1.5') }}"></script>
    <!--scripts for mobile menu-->
    <link rel="stylesheet" href="{{ asset('assets/front/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/pushy.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/jquery-ui.css') }}">
    <!-- owl crousal -->
    <script src="includes/templates/chequesplus/jscript/hammer.jsv"></script>
    <script src="{{ asset('assets/front/js/responsive-switch.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.bxslider.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.are-you-sure.js') }}"></script>
    <script src="https://apis.google.com/js/platform.js?onload=renderBadge" async defer></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"8b524e90cf987eaf","serverTiming":{"name":{"cfL4":true}},"version":"2024.8.0","token":"b8434debb5974ff084ba27a65b5d29ae"}'
        crossorigin="anonymous"></script>
</body>

</html>
