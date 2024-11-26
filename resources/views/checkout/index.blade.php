@extends('layout')
@section('content')
    @include('components.header')
    <section class="container -hero">
        <div class="section-header padding-side-lg -list">
            <div class="left">
                <h4>Checkout</h4>
            </div>
        </div>
        <div class="flex padding-side-lg">
            <div class="checkout-content">
                <div class="checkout-form">
                    <form action="">
                        d
                    </form>
                </div>
                <div class="cart-content__right">
                    <h4>Summary</h4>
                    <div class="group">
                        <div class="c-box">
                            <p>Subtotal</p>
                            <span>
                                <x-carbon-currency-euro class="eur-icon" />
                                {{$contents['cartSubtotal']}}
                            </span>
                        </div>
                        <div class="c-box">
                            <p>Discount</p>
                            <span>
                                <x-carbon-currency-euro class="eur-icon" />
                                {{$contents['cartTotal'] - $contents['cartSubtotal']}}
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
                            {{$contents['cartTotal']}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('components.footer')
@endsection
