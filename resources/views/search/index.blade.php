@extends('layout')
@section('content')
    @include('components.header')
    <section class="container -card -hero">
        <div class="section-header padding-side-sm -list -fixed">
            <div class="left">
                <h4>Search Results for "{{$query}}" ({{$productsCount}})</h4>
            </div>
            <div class="right">
                <button class="h-filters">
                    <span>Hide Filters</span>
                    <x-carbon-settings-adjust class="icon"/>
                </button>
                <button aria-expanded="false" class="sort-drop">
                    <span>Sort By:</span>
                    <span class="sort-drop-text">Featured</span>
                    <span class="arrow arrow-down"></span>
                </button>
                <div aria-expanded="false" class="drop-list">
                    <button name="featured" data-order="desc" class="featured">Featured</button>
                    <button name="id" data-order="desc" class="newest">Newest</button>
                    <button name="price" data-order="desc" class="p-desc">Price: High-Low</button>
                    <button name="price" data-order="asc" class="p-asc">Price: Low-High</button>
                </div>
            </div>
        </div>
        <div class="flex padding-side-sm -hero">
            <aside aria-expanded="true" class="filters-side">
                <div class="accordion">
                    <div class="item">
                        <button aria-expanded="false" itemid="1" class="accordion-header">
                            <span>Sale & Offers</span>
                            <span class="arrow arrow-down"></span>
                        </button>
                        <div aria-expanded="false" itemid="1" class="accordion-content">
                            <div class="option">
                                <x-checkbox name="sale"/>
                                <span>Sale</span>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <button aria-expanded="false" itemid="2" class="accordion-header">
                            <span>Availability</span>
                            <span class="arrow arrow-down"></span>
                        </button>
                        <div aria-expanded="false" itemid="2" class="accordion-content">
                            <div class="option">
                                <x-checkbox name="in-warehouse"/>
                                <span>In Warehouse</span>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <button aria-expanded="false" itemid="3" class="accordion-header">
                            <span>Color</span>
                            <span class="arrow arrow-down"></span>
                        </button>
                        <div aria-expanded="false" itemid="3" class="accordion-content">
                            <div class="grid">
                                @foreach($allColors as $color)
                                    <button aria-checked="false" aria-details="{{$color}}" class="color-picker">
                                        <span class="color" style="background-color: {{$color}}"></span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <button aria-expanded="false" itemid="4" class="accordion-header">
                            <span>Price</span>
                            <span class="arrow arrow-down"></span>
                        </button>
                        <div aria-expanded="false" itemid="4" class="accordion-content">
                            <x-slider name="price" min="{{$minMaxPrice->min_price}}" max="{{$minMaxPrice->max_price}}">
                                <x-carbon-currency-euro title="EUR" class="icon" />
                            </x-slider>
                        </div>
                    </div>
                    <div class="item">
                        <button aria-expanded="false" itemid="5" class="accordion-header">
                            <span>Dimensions</span>
                            <span class="arrow arrow-down"></span>
                        </button>
                        <div aria-expanded="false" itemid="5" class="accordion-content">
                            <x-slider name="length" min="{{$minMaxDimensions->min_length}}" max="{{$minMaxDimensions->max_length}}">
                                <x-carbon-arrow-right title="Length" class="icon" />
                            </x-slider>
                            <x-slider name="height" min="{{$minMaxDimensions->min_height}}" max="{{$minMaxDimensions->max_height}}">
                                <x-carbon-arrow-up-right title="Height" class="icon" />
                            </x-slider>
                            <x-slider name="width" min="{{$minMaxDimensions->min_width}}" max="{{$minMaxDimensions->max_width}}">
                                <x-carbon-arrow-up title="Width" class="icon" />
                            </x-slider>
                        </div>
                    </div>
                </div>
            </aside>
            <div aria-expanded="false" class="product-list">
                @if($productsCount > 0)
                    @foreach($paginatedProducts as $product)
                        <a href="{{route('shop.show', ['category' => $product->category->slug, 'product' => $product->slug])}}" class="product-item">
                            <div class="cover-img">
                                <img src="{{$product->main_img}}" alt="{{$product->name}}">
                            </div>
                            <div class="product-info">
                                <div>
                                    <p class="title">{{$product->name}}</p>
                                    <span class="color" style="background-color: {{$product->color}}"></span>
                                </div>
                                <div class="dimensions">
                                    <span><x-carbon-arrow-right class="arrow" /><span>{{json_decode($product->specification)->length}}mm</span></span>
                                    <span><x-carbon-arrow-up-right class="arrow" /><span>{{json_decode($product->specification)->width}}mm</span></span>
                                    <span><x-carbon-arrow-up class="arrow" /><span>{{json_decode($product->specification)->height}}mm</span></span>
                                </div>
                                <p class="price">
                                    @php
                                        if ($product->discount > 0) {
                                            $price = $product->price * (1 - $product->discount);
                                        } else {
                                            $price = $product->price;
                                        }
                                        $discount = $product->discount;
                                    @endphp

                                    <span>
                                    <x-carbon-currency-euro title="EUR" class="eur-icon" />
                                    <span class="disc-price">{{$price}}</span>
                                </span>

                                    @if($discount > 0)
                                        <span class="orig-price">
                                        <span>€{{$product->price}}</span>
                                    </span>
                                    @endif
                                </p>
                            </div>
                        </a>
                    @endforeach
                    <div class="pagination-controls">
                        {{$paginatedProducts->links('components.paginator')}}
                    </div>
                @else
                    <p>Nothing found</p>
                @endif
            </div>
        </div>
    </section>
    @include('components.footer')
@endsection
