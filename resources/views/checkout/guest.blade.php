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
                        <header>
                            <h4>Delivery Options</h4>
                            <span>Mandatory fields*</span>
                        </header>
                        <div class="button-group">
                            <input type="hidden" name="pick_up_at_warehouse" value="false">
                            <button aria-checked="true" aria-details="false" class="btn-d-opt">
                                <x-carbon-delivery-truck class="icon" />
                                <span>Ship</span>
                            </button>
                            <button aria-checked="false" aria-details="true" disabled title="Delivery Option is Not Available" class="btn-d-opt">
                                <x-carbon-location class="icon" />
                                <span>Pick Up</span>
                            </button>
                        </div>
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
