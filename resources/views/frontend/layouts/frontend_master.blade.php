<!doctype html>
<html lang="en" class="light-theme">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--favicon-->
    <link rel="icon" href="{{ asset('uploads/default_photo')}}/{{ $default_setting->favicon }}" type="image/webp" />

    <!-- CSS files -->
    <link href="{{ asset('frontend')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- Plugins -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend')}}/plugins/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend')}}/plugins/slick/slick-theme.css" />

    <link href="{{ asset('frontend')}}/css/style.css" rel="stylesheet">
    <link href="{{ asset('frontend')}}/css/dark-theme.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/sweetalert2/sweetalert2.min.css')}}">

    <title>{{ env('APP_NAME') }} || @yield('title')</title>
</head>

<body>

    <!--page loader-->
    <div class="loader-wrapper">
        <div class="d-flex justify-content-center align-items-center position-absolute top-50 start-50 translate-middle">
            <div class="spinner-border text-dark" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    <!--end loader-->

    <!--start top header-->
    <header class="top-header">
        <nav class="navbar navbar-expand-xl w-100 navbar-dark container gap-3">
        <a class="navbar-brand d-none d-xl-inline" href="{{ route('index') }}"><img src="{{ asset('uploads/default_photo')}}/{{ $default_setting->logo_photo }}" class="logo-img" alt=""></a>
        <a class="mobile-menu-btn d-inline d-xl-none" href="javascript:;" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar">
            <i class="bi bi-list"></i>
        </a>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
            <div class="offcanvas-header">
            <div class="offcanvas-logo"><img src="{{ asset('uploads/default_photo')}}/{{ $default_setting->logo_photo }}" class="logo-img" alt="">
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body primary-menu">
            <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
                <li class="nav-item">
                <a class="nav-link {{(Route::currentRouteName() == 'index') ? 'active' : ''}}" href="{{ route('index') }}">Home</a>
                </li>
            </ul>
            </div>
        </div>
        <ul class="navbar-nav secondary-menu flex-row">
            <li class="nav-item">
            <a class="nav-link dark-mode-icon" href="javascript:;">
                <div class="mode-icon">
                <i class="bi bi-moon"></i>
                </div>
            </a>
            </li>
        </ul>
        </nav>
    </header>
    <!--end top header-->

    <!--start page content-->
    <div class="page-content">
        @yield('content')
    </div>
    <!--end page content-->

    <footer class="footer-strip text-center py-3 bg-section-2 border-top positon-absolute bottom-0">
        <p class="mb-0 text-muted">© {{ date('Y') }}. {{ env('APP_NAME') }} | All rights reserved.</p>
    </footer>

    <!--start quick view-->
    @foreach (App\Models\Product::where('status', 'Active')->get() as $product)
    <div class="modal fade" id="QuickViewModal{{ $product->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-xl-6">
                            <div class="wrap-modal-slider">
                                <img src="{{ asset('uploads/product_photo')}}/{{ $product->product_photo }}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-12 col-xl-6 py-5">
                            <div class="product-info">
                                <h4 class="product-title fw-bold mb-1">{{ $product->product_name }}</h4>
                                <div class="product-rating">
                                    <div class="hstack gap-2 border p-1 mt-3 width-content">
                                        <div><span class="rating-number">Category: {{ $product->relationtocategory->category_name }}</span></div>
                                    </div>
                                    <div class="hstack gap-2 border p-1 mt-3 width-content">
                                        <div><span class="rating-number">Brand: {{ $product->relationtobrand->brand_name }}</span></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="product-price d-flex align-items-center gap-3">
                                    <div class="h4 fw-bold">
                                        @if ($product->selling_price == 0)
                                        <span class="badge bg-info">Coming Soon</span>
                                        @else
                                        Price: {{ $product->selling_price }}
                                        @endif
                                    </div>
                                </div>
                                <p class="fw-bold mb-0 mt-1 text-success">
                                    @if ($product->purchase_quantity - $product->selling_quantity == 0)
                                        <span class="badge bg-warning">Stock Out</span>
                                    @else
                                    <span class="badge bg-info">
                                        Available: {{ $product->purchase_quantity - $product->selling_quantity }} {{ $product->relationtounit->unit_name }}
                                    </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!--end quick view-->

    <!--Start Back To Top Button-->
    <a href="javaScript:;" class="back-to-top"><i class="bi bi-arrow-up"></i></a>
    <!--End Back To Top Button-->

    <!-- JavaScript files -->
    <script src="{{ asset('frontend')}}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend')}}/js/jquery.min.js"></script>
    <script src="{{ asset('frontend')}}/plugins/slick/slick.min.js"></script>
    <script src="{{ asset('frontend')}}/js/main.js"></script>
    <script src="{{ asset('frontend')}}/js/index.js"></script>
    <script src="{{ asset('frontend')}}/js/loader.js"></script>

    <script src="{{ asset('frontend/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>

    @yield('script')

</body>

</html>
