@extends('layout')
@section('content')

    <div class="container">
        <h1>Search Results for "{{ $query }}"</h1>

        @if ($results->isEmpty())
            <p>No results found.</p>
        @else
            <ul style="list-style: none;>
                @foreach ($results as $product)
                    <li>
                        <img src="{{$product->main_img}}" alt="{{$product->name}}" style="height: 200px; object-fit: cover;">
                        <a href="{{ route('shop.show', ['category' => $product->category->slug, 'product' => $product->slug]) }}"
                        style="font-size: 1.5em; font-weight: bold;">{{ $product-> name}}</a>
                        <p>{{ $product->description }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

@include('components.footer')
@endsection