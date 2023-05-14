@extends('frontend.layouts.frontend_master')

@section('title', 'Home')

@section('content')
<!--start carousel-->
<section class="slider-section">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4"></button>
        </div>
        <div class="carousel-inner">
            @php
                $slider_colors = ['bg-primary', 'bg-red', 'bg-purple', 'bg-yellow', 'bg-green']
            @endphp
            @forelse (App\Models\Product::where('status', 'Active')->orderBy('selling_quantity', 'DESC')->take(5)->get() as $product)
            <div class="carousel-item {{ ($loop->first == 1) ? 'active' : '' }} {{ ($loop->index == 0) ? 'bg-primary' : '' }} {{ ($loop->index == 1) ? 'bg-red' : '' }} {{ ($loop->index == 2) ? 'bg-purple' : '' }} {{ ($loop->index == 3) ? 'bg-yellow' : '' }} {{ ($loop->index == 4) ? 'bg-green' : '' }}">
                <div class="row d-flex align-items-center">
                    <div class="col d-none d-lg-flex justify-content-center">
                        <div class="">
                            <h3 class="h3 fw-light text-white fw-bold">Top Selling Product</h3>
                            <h1 class="h1 text-white fw-bold">{{ $product->product_name }}</h1>
                            <p class="text-white fw-bold"><i>
                                @if ($product->selling_price == 0)
                                <span class="badge bg-info">Coming Soon</span>
                                @else
                                Price: {{ $product->selling_price }}
                                @endif
                            </i></p>
                        </div>
                    </div>
                    <div class="col py-5 d-flex justify-content-center">
                        <img width="400" height="400" src="{{ asset('uploads/product_photo')}}/{{ $product->product_photo }}" class="img-fluid" alt="...">
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-warning">
                <strong>Data not found</strong>
            </div>
            @endforelse
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
<!--end carousel-->

<!--start Featured Products slider-->
<section class="section-padding">
    <div class="container">
        <div class="text-center pb-3">
            <h3 class="mb-0 h3 fw-bold">Latest Products</h3>
            <p class="mb-0 text-capitalize">The purpose of lorem ipsum</p>
        </div>
        <div class="product-thumbs">
            @forelse ($products as $product)
            <div class="card">
                <div class="position-relative overflow-hidden">
                    <div class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal{{ $product->id }}"><i class="bi bi-zoom-in"></i></a>
                    </div>
                    <a href="javascript:;">
                        <img src="{{ asset('uploads/product_photo')}}/{{ $product->product_photo }}" class="card-img-top" alt="...">
                    </a>
                </div>
            <div class="card-body">
                <div class="product-info text-center">
                        <h6 class="mb-1 fw-bold product-name">{{ $product->product_name }}</h6>
                        <p class="mb-0 h6 fw-bold product-price">
                            @if ($product->selling_price == 0)
                            <span class="badge bg-info">Coming Soon</span>
                            @else
                            Price: {{ $product->selling_price }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-warning">
                <strong>Data not found</strong>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!--end Featured Products slider-->

<!--start tabular product-->
<section class="product-tab-section section-padding bg-light">
    <div class="container">
        <div class="text-center pb-3">
            <h3 class="mb-0 h3 fw-bold">Category Wise Products</h3>
            <p class="mb-0 text-capitalize">The purpose of lorem ipsum</p>
        </div>
        <div class="row">
            <div class="col-auto mx-auto">
                <div class="product-tab-menu table-responsive">
                    <ul class="nav nav-pills flex-nowrap" id="pills-tab" role="tablist">
                        @foreach ($categories as $category)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ ($loop->first == 1) ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#category{{ $category->id }}" type="button">{{ $category->category_name }}</button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <hr>
        <div class="tab-content tabular-product">
            @foreach ($categories as $category)
            <div class="tab-pane fade {{ ($loop->first == 1) ? 'show active' : '' }}" id="category{{ $category->id }}">
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-4">
                    @forelse (App\Models\Product::where('category_id', $category->id)->get() as $product)
                    <div class="col">
                        <div class="card">
                            <div class="position-relative overflow-hidden">
                                <div class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal{{ $product->id }}"><i class="bi bi-zoom-in"></i></a>
                                </div>
                                <a href="javascript:;">
                                    <img src="{{ asset('uploads/product_photo')}}/{{ $product->product_photo }}" class="card-img-top" alt="...">
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="product-info text-center">
                                    <h6 class="mb-1 fw-bold product-name">{{ $product->product_name }}</h6>
                                    <p class="mb-0 h6 fw-bold product-price">
                                    @if ($product->selling_price == 0)
                                        <span class="badge bg-info">Coming Soon</span>
                                    @else
                                        Price: {{ $product->selling_price }}
                                    @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="alert alert-warning">
                        <strong>Data not found</strong>
                    </div>
                    @endforelse
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--end tabular product-->

<!--start features-->
<section class="product-thumb-slider section-padding">
    <div class="container">
        <div class="text-center pb-3">
            <h3 class="mb-0 h3 fw-bold">What We Offer!</h3>
            <p class="mb-0 text-capitalize">The purpose of lorem ipsum</p>
        </div>
        <div class="row">
            <div class="col d-flex">
                <div class="card depth border-0 rounded-0 border-bottom border-danger border-3 w-100">
                    <div class="card-body text-center">
                        <div class="h1 fw-bold my-2 text-danger">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <h5 class="fw-bold">Secure Payment</h5>
                        <p class="mb-0">Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
                    </div>
                </div>
            </div>
            <div class="col d-flex">
                <div class="card depth border-0 rounded-0 border-bottom border-success border-3 w-100">
                    <div class="card-body text-center">
                        <div class="h1 fw-bold my-2 text-success">
                            <i class="bi bi-minecart-loaded"></i>
                        </div>
                        <h5 class="fw-bold">Free Returns</h5>
                        <p class="mb-0">Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
                    </div>
                </div>
            </div>
            <div class="col d-flex">
                <div class="card depth border-0 rounded-0 border-bottom border-warning border-3 w-100">
                    <div class="card-body text-center">
                        <div class="h1 fw-bold my-2 text-warning">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h5 class="fw-bold">24/7 Support</h5>
                        <p class="mb-0">Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--end features-->

<!--start Brands-->
<section class="section-padding">
    <div class="container">
        <div class="text-center pb-3">
            <h3 class="mb-0 h3 fw-bold">Shop By Brands</h3>
            <p class="mb-0 text-capitalize">Select your favorite brands and purchase</p>
        </div>
        <div class="brands">
            <div class="row row-cols-2 row-cols-lg-5 g-4">
                @forelse ($brands as $brand)
                <div class="col">
                    <div class="p-3 border rounded brand-box">
                        <div class="d-flex align-items-center">
                            <a href="javascript:;">
                                <img src="{{ asset('uploads/brand_photo') }}/{{ $brand->brand_photo }}" class="img-fluid" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-warning">
                    <strong>Data not found</strong>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
<!--end Brands-->

<!--start cartegory slider-->
<section class="cartegory-slider section-padding bg-section-2">
    <div class="container">
        <div class="text-center pb-3">
            <h3 class="mb-0 h3 fw-bold">All Categories</h3>
            <p class="mb-0 text-capitalize">Select your favorite categories and purchase</p>
        </div>
        <div class="cartegory-box">
            @forelse ($categories as $category)
            <a href="javascript:;">
                <div class="card">
                    <div class="card-body">
                        <div class="overflow-hidden">
                            <img src="{{ asset('uploads/category_photo')}}/{{ $category->category_photo }}" class="card-img-top rounded-0" alt="...">
                        </div>
                        <div class="text-center">
                            <h5 class="mb-1 cartegory-name mt-3 fw-bold">{{ $category->category_name }}</h5>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="alert alert-warning">
                <strong>Data not found</strong>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!--end cartegory slider-->

<!--subscribe banner-->
<section class="product-thumb-slider subscribe-banner p-5">
    <div class="row">
        <div class="col-12 col-lg-4 mx-auto">
            <div class="text-center">
                <h3 class="mb-3 fw-bold text-white">Any Query <br> Please Send Message</h3>
            <form action="#" method="POST" id="contactMessageForm">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Enter your name" />
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="email" class="form-control" placeholder="Enter your email" />
                        <span class="text-danger error-text email_error"></span>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="phone_number" class="form-control" placeholder="Enter your phone number" />
                        <span class="text-danger error-text phone_number_error"></span>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="subject" class="form-control" placeholder="Enter your subject" />
                        <span class="text-danger error-text subject_error"></span>
                    </div>
                    <div class="mb-3">
                        <textarea name="message" class="form-control" placeholder="Enter your message"></textarea>
                        <span class="text-danger error-text message_error"></span>
                    </div>
                    <button class="btn btn-success" id="contactMessageBtn" type="submit">Send Message</button>
                </form>
            </div>
        </div>
        <div class="col-12 col-lg-4 mx-auto">
            <div class="footer-widget-9">
                <h5 class="mb-3 fw-bold text-light">Follow Us</h5>
                <div class="social-link d-flex align-items-center gap-2 ">
                    <a class="text-light" href="{{ $default_setting->facebook_link }}"><i class="bi bi-facebook"></i></a>
                    <a class="text-light" href="{{ $default_setting->twitter_link }}"><i class="bi bi-twitter"></i></a>
                    <a class="text-light" href="{{ $default_setting->instagram_link }}"><i class="bi bi-instagram"></i></a>
                    <a class="text-light" href="{{ $default_setting->linkedin_link }}"><i class="bi bi-linkedin"></i></a>
                    <a class="text-light" href="{{ $default_setting->youtube_link }}"><i class="bi bi-youtube"></i></a>
                </div>
                <div class="mb-3 mt-3">
                    <h5 class="mb-0 fw-bold text-light">Support</h5>
                    <p class="mb-0 text-light">{{ $default_setting->support_email }}</p>
                </div>
                <div class="mb-3 mt-3">
                    <h5 class="mb-0 fw-bold text-light">Toll Free</h5>
                    <p class="mb-0 text-light">{{ $default_setting->support_phone }}</p>
                </div>
                <div class="">
                    <h5 class="mb-0 fw-bold text-light">Address</h5>
                    <p class="mb-0 text-light">{{ $default_setting->address }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--subscribe banner-->
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Send Message
        $("#contactMessageForm").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#contactMessageBtn").text('Sending.....');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('contact.message.send') }}',
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        })
                    }else{
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Contact Message send successfully'
                        })
                        $("#contactMessageBtn").text('Send Message...');
                        $("#contactMessageForm")[0].reset();
                    }
                }
            });
        });
    });
</script>
@endsection
