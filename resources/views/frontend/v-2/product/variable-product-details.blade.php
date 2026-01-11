@extends('frontend.v-2.master')
@push('style')
    {{-- <!-- Flowbite -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"
      rel="stylesheet"
    /> --}}
    <!-- Fontawesome -->
    <script
      src="https://kit.fontawesome.com/942922f9a6.js"
      crossorigin="anonymous"
    ></script>
    <!-- Slick slider -->
    <link
      rel="stylesheet"
      type="text/css"
      href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"
    />
    {{-- <!-- Tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                variableproduct: '#4DBD35',
              }
            },
          },
        };
      </script> --}}
@endpush

@section('title')
    Product Details
@endsection

@section('content-v2')
    <!-- Product Details -->
    <section class="container mx-auto px-2 my-6" id="product-section">
        <div class="row mx-auto justify-content-between">
            <div class="col-lg-9">
                <div class="row mx-auto justify-content-center align-items-center">
                    <!-- Product Image Slider -->
                    <div class="col-md-6">
                        <div id="carousel-product" class=" mx-auto">
                            <!-- Carousel Wrapper -->
                            <div id="slide" class="position-relative">
                                @foreach ($details->productImages as $image)
                                    <div class="mySlides">
                                        <img src="{{ asset('galleryImage/' . $image->gallery_image) }}" class="img-fluid">
                                    </div>
                                @endforeach

                                {{-- <!-- Slider Navigation -->
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <div class="d-flex align-items-center justify-content-between">
                                       <div>
                                        <button class="prev bg-dark text-white rounded-start p-2 md-p-3 lg-p-4" onclick="plusSlides(-1)">&#10094;</button>
                                       </div>
                                      <div>
                                        <button class="next bg-dark text-white rounded-end p-2 md-p-3 lg-p-4" onclick="plusSlides(1)">&#10095;</button>
                                      </div>
                                    </div>
                                </div> --}}
                            </div>


                            <!-- Thumbnail Images -->
                            <div class="d-flex align-items-center justify-content-center mt-3">
                                @foreach ($details->productImages as $image)
                                    <div class="column">
                                        <img class="thumbnail cursor w-50" src="{{ asset('galleryImage/' . $image->gallery_image) }}" onclick="currentSlide({{ $loop->index + 1 }})" alt="gallery_image">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Product Information -->
                    <div class="col-md-6">
                        <h2 class="text-lg lg-text-2xl font-semibold text-dark">{{ $details->name }}</h2>

                        <form action="{{url('/add/to/cart/variable-details/page/'.$details->id)}}" id="addToCartForm" method="POST">
                            @csrf
                            <div class="my-4 d-flex align-items-center justify-content-center md-justify-content-start gap-3" id="buttonGroup">
                                @foreach ($details->productImages as $image)
                                    @if ($image->color != null)
                                        <button id="button" type="button" class="px-4 py-2 bg-light text-dark rounded" onclick="currentSlide({{$loop->index+1}}),ProductColor('{{$image->color}}')">{{$image->color}}</button>
                                    @endif
                                @endforeach
                                <input type="hidden" name="inputcolor" id="inputcolor" value="">
                            </div>

                            <div id="size" class="hidden sizeButtonGroups">
                                <div class="d-flex align-items-center justify-content-center lg-justify-content-start gap-2 lg-gap-4">
                                    @foreach ($details->productImages as $image)
                                       @if ($image->size != null)
                                       <button type="button" class="px-4 py-2 bg-light text-dark rounded" onclick="productSize({{ $image->price }}, '{{ $image->size }}')">{{$image->size}}</button>
                                       @endif
                                    @endforeach
                                    <input type="hidden" name="inputsize" id="inputsize" value="">
                                </div>
                            </div>

                            <div class="text-xl text-dark lg-text-3xl my-4 md-d-flex align-items-center gap-2 font-medium">
                                <p class="text-dark text-center md-text-start">
                                    <span id="price" style="font-size: 20px">
                                        @if ($details->discount_price != null)
                                            {{$details->discount_price}}
                                        @else
                                            {{$details->regular_price}}
                                        @endif
                                    </span> TK.
                                </p>
                                @if ($details->discount_price != null)
                                    <input type="hidden" id="inputPrice" name="inputPrice" value="{{$details->discount_price}}">
                                @else
                                    <input type="hidden" id="inputPrice" name="inputPrice" value="{{$details->regular_price}}">
                                @endif
                            </div>

                            <div class="my-4 d-flex align-items-center justify-content-center md-justify-content-start gap-3 mx-auto text-xl font-md">
                                {{-- <button type="button" class="quantity-btn btn btn-dark border border-dark px-2 py-1 rounded-circle">-</button>
                                <div class="quantity-display border-dark border px-4 py-1 rounded text-dark">1</div>
                                <input type="hidden" name="inputQty" id="inputQty" value="1">
                                <button type="button" class="quantity-btn btn btn-dark border border-dark px-2 py-1 rounded-circle">+</button> --}}
                                <input type="hidden" name="inputQty" id="inputQty" value="1">
                            </div>

                            <div class="my-4 gap-3 font-medium">
                                <input type="hidden" name="button_action" id="buttonAction" value="">
                                <div class="my-2">
                                    <button type="button" onclick="handleAddToCart('buyNow')" class="font-medium order-btn btn py-2 w-100 lg-w-60">
                                        <i class="fa-solid fa-truck"></i> Order Now
                                    </button>
                                </div>
                            </div>

                            <div class="my-2">
                                <button type="button" onclick="handleAddToCart('addToCart')" class="font-medium order-btn btn py-2 w-100 lg-w-60">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </div>

                            <div class="">
                                <button class="font-medium order-btn btn py-2 w-100 lg-w-60">
                                    <i class="fa-solid fa-phone"></i> For Call : {{$setting->phone}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!--Product details Tabs -->
                <div class="my-5 bg-white border border-gray-200 rounded-xl">
                    <!-- Tab button -->
                    <ul class="nav nav-pills flex-column flex-sm-row gap-3 px-4 mt-3 justify-content-start" id="tabContainer">
                        <li class="nav-item my-1">
                            <button class=" order-btn text-white rounded-pill" data-bs-toggle="pill" data-bs-target="#descriptionTab">Description</button>
                        </li>
                        <li class="nav-item my-1">
                            <button class=" order-btn text-white rounded-pill" data-bs-toggle="pill" data-bs-target="#reviewTab">Reviews</button>
                        </li>
                        {{-- <li class="nav-item my-1">
                            <button class="nav-link bg-gray-200 rounded-pill" data-bs-toggle="pill" data-bs-target="#policyTab">Product Policy</button>
                        </li> --}}
                    </ul>
                    <!--Description Tab content -->
                    <div class="tab-content px-2 lg-px-5">
                        <div class="tab-pane fade show active my-4" id="descriptionTab">
                            {!!$details->long_description!!}
                            
                            @if($details->youtube_video_link)
                            <div class="product-video-section mt-4">
                                <h4>Product Video</h4>
                                <div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                    <?php
                                    // Extract YouTube video ID from various URL formats
                                    $videoId = '';
                                    $url = $details->youtube_video_link;
                                    
                                    // Check for different YouTube URL formats
                                    if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
                                        $videoId = $matches[1];
                                    } elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $matches)) {
                                        $videoId = $matches[1];
                                    } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
                                        $videoId = $matches[1];
                                    } elseif (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $matches)) {
                                        $videoId = $matches[1];
                                    } elseif (preg_match('/youtube\.com\/shorts\/([^\&\?\/]+)/', $url, $matches)) {
                                        $videoId = $matches[1];
                                    }
                                    ?>
                                    @if($videoId)
                                    <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" 
                                            src="https://www.youtube.com/embed/{{ $videoId }}" 
                                            frameborder="0" allowfullscreen>
                                    </iframe>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        <!-- Review Tab Content -->
                        <div class="tab-pane fade my-4" id="reviewTab">
                            @foreach ($details->reviews as $review)
                            <div class="review-item-wrapper">
                                
                                <div class="review-item-right">
                                    <h4 class="review-author-name">
                                        {{$review->name}}
                                        <span class=" d-inline bg-danger badge-sm badge text-white">Verified</span>
                                    </h4>
                                    <p class="review-item-message">
                                        {{$review->message}}
                                    </p>
                                    <span class="review-item-rating-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                    <i class="fa-star fas"></i>
                                                @else
                                                    <i class="fa-star far"></i>
                                                @endif
                                            @endfor
                                        </span>
                                </div>
                                <div class="review-item-left">
                                    <i class="fas fa-user"></i>
                                    @if($review->photo)
                                    <div class="review-photo mt-2">
                                        <img src="{{ asset('reviews/' . $review->photo) }}" alt="Review Photo" style="max-width: 80px; max-height: 80px; border-radius: 5px;">
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{-- <!-- policy tab -->
                        <div class="tab-pane fade my-4" id="policyTab">
                            {!!$details->policy!!}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <div style="display: none">
        <input type="text" id="product_name" value="{{ $details->name }}">
        <input type="text" id="price" value="{{ $details->regular_price }}">
        <input type="text" id="product_id" value="{{ $details->id }}">
        <input type="text" id="category" value="{{ $details->category->name ?? 'Unknown' }}">
    </div>
@endsection

@push('script')
    <!-- js -->
    <script src="{{ asset('frontend/v-2/assets/js/playground.js') }}"></script>

   <!-- Slick slider -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script
       type="text/javascript"
       src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"
   ></script>

   <!-- flowbite -->
   {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script> --}}

    <script>
        // Handle add to cart event
        function handleAddToCart(action) {
            // Set the action value in the hidden input
            document.getElementById('buttonAction').value = action;
            
            var form = document.getElementById('addToCartForm');
            var formData = new FormData(form);
            
            // Get product details for datalayer
            var product_name = document.getElementById('product_name').value;
            var price = document.getElementById('price').value;
            var product_id = document.getElementById('product_id').value;
            var category = document.getElementById('category').value;
            var qty = document.getElementById('inputQty').value;
            
            // Push to datalayer
            dataLayer = window.dataLayer || [];
            dataLayer.push({
                ecommerce: null
            });
            dataLayer.push({
                event: "add_to_cart",
                ecommerce: {
                    items: [{
                        item_name: product_name,
                        item_id: product_id,
                        price: price,
                        item_brand: "Unknown",
                        item_category: category,
                        item_variant: "",
                        item_list_name: "",
                        item_list_id: "",
                        index: 0,
                        quantity: parseInt(qty)
                    }]
                }
            });
            
            // Submit form via AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Show Lobibox notification
                    Lobibox.notify('success', {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-check-circle',
                        msg: data.message
                    });
                    
                    // Emit event to update cart count
                    if (typeof Reload !== 'undefined') {
                        Reload.$emit('afterAddToCart');
                    }
                    
                    // Redirect to checkout for buyNow action
                    if (action === 'buyNow' && data.redirect) {
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 1000);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Lobibox.notify('error', {
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    position: 'top right',
                    icon: 'bx bx-x-circle',
                    msg: 'An error occurred while adding the product to cart.'
                });
            });
        }
        
        // Existing functions from the original file
        function ProductColor(color) {
            document.getElementById("inputcolor").value = color;
            document.getElementById("size").classList.remove("hidden");
        }
        
        function productSize(price, size) {
            document.getElementById("inputsize").value = size;
            document.getElementById("inputPrice").value = price;
            document.getElementById("price").innerHTML = price;
        }
    </script>
@endpush