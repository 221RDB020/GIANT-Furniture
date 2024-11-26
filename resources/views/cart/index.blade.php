@extends('layout')
@section('content')
    @include('components.header')
    <section class="container -card -hero">
        <div class="section-header padding-side-lg -list">
            <div class="left">
                <h4>Your Cart Overview</h4>
            </div>
        </div>
        <div class="flex padding-side-lg">
            <div class="cart-content">
                <div class="cart-content__left">
                    @if(count($cartItems) == 0)
                        <div class="cart-empty">
                            <h4>There are no items in your cart.</h4>
                        </div>
                    @endif
                    @foreach($cartItems as $item)
                        <div class="cart-item">
                            <div class="group">
                                <div class="cart-item__left">
                                    <div class="cart-item-image">
                                        <img src="{{$item['attributes']['image']}}" alt="">
                                    </div>
                                </div>
                                <div class="cart-item__right">
                                    <div class="indent">
                                        <a href="{{route('shop.show', ["category" => $item['attributes']['category']['slug'], "product" => $item['attributes']['slug']])}}" class="cart-item-name">{{$item['name']}}</a>
                                        <div class="price">
                                            @if($item['attributes']['discount'] > 0)
                                                <span class="cart-item-disPrice">
                                                    <x-carbon-currency-euro class="eur-icon" />
                                                    <span>{{$item['price'] * (1 - $item['attributes']['discount'])}}</span>
                                                </span>
                                                <span class="cart-item-fulPrice">€{{$item['price']}}</span>
                                            @else
                                                <span class="cart-item-disPrice">
                                                    <x-carbon-currency-euro class="eur-icon" />
                                                    <span>{{$item['price']}}</span>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="cart-item-category">{{$item['attributes']['category']['name']}}</p>
                                </div>
                            </div>
                            <div class="cart-item__bottom">
                                <div class="counter"
                                     data-item-id="{{$item['id']}}"
                                     data-current-quantity="{{$item['quantity']}}"
                                     data-update-route="{{ route('cart.update') }}"
                                     data-remove-route="{{ route('cart.remove', ['id' => $item['id']]) }}"
                                     data-csrf-token="{{ csrf_token() }}">

                                    @if($item['quantity'] == 1)
                                        <button type="button" class="action-btn" data-action="remove">
                                            <x-carbon-trash-can title="Remove Item" class="icon"/>
                                        </button>
                                    @else
                                        <button type="button" class="action-btn" data-action="decrease">
                                            <x-carbon-subtract title="Decrease Quantity" class="icon"/>
                                        </button>
                                    @endif
                                    <span class="quantity-display">{{$item['quantity']}}</span>
                                    <button type="button" class="action-btn" data-action="increase">
                                        <x-carbon-add title="Add Item" class="icon"/>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="cart-content__right">
                    <h4>Summary</h4>
                    <div class="group">
                        <div class="c-box">
                            <p>Subtotal</p>
                            <span>
                                <x-carbon-currency-euro class="eur-icon" />
                                {{$subtotal}}
                            </span>
                        </div>
                        <div class="c-box">
                            <p>Discount</p>
                            <span>
                                <x-carbon-currency-euro class="eur-icon" />
                                {{$total - $subtotal}}
                            </span>
                        </div>
                        <div class="c-box">
                            <p>Estimated Shipping & Handling</p>
                            <span>Free</span>
                        </div>
                        <div class="c-box">
                            <p>Estimated Tax</p>
                            <span>-</span>
                        </div>
                    </div>
                    <div class="c-box -indent">
                        <p>Total</p>
                        <span>
                            <x-carbon-currency-euro class="eur-icon" />
                            {{$total}}
                        </span>
                    </div>
                    <div class="wrap">
                        <a href="{{route('checkout.index')}}" aria-checked="false" class="primary-btn">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('components.footer')
@endsection
