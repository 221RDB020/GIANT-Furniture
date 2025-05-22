@extends('layout')
@section('content')
    @include('components.header')
    <section class="container -card -hero">
        <div class="section-header padding-side-lg -list">
            <div class="left">
                <h4>Locate Warehouse</h4>
            </div>
        </div>
        <div class="flex padding-side-lg">
            <div id="map"></div>
        </div>
    </section>
    @include('components.footer')
@endsection
