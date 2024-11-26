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
                    
                        
                            @if($product-> category_id == 8)
                            <img src="{{$product->main_img}}" alt="{{$product->name}}"
                            style="height: 200px; object-fit: cover;">
                            <a href="{{ route('shop.show', ['category' => 'living-room', 'product' => $product->slug]) }}"
                            style="font-size: 1.5em; font-weight: bold;">{{ $product-> name}}</a>
                            <p>{{ $product->description }}</p>

                            @endif
                            @if($product-> category_id == 12)
                            <img src="{{$product->main_img}}" alt="{{$product->name}}"
                            style="height: 200px; object-fit: cover;">
                            <a href="{{ route('shop.show', ['category' => 'bedroom', 'product' => $product->slug]) }}"
                            style="font-size: 1.5em; font-weight: bold;">{{ $product-> name}}</a>
                            <p>{{ $product->description }}</p>
                            @endif

                            @if($product-> category_id == 16)
                            <img src="{{$product->main_img}}" alt="{{$product->name}}"
                            style="height: 200px; object-fit: cover;">
                            <a href="{{ route('shop.show', ['category' => 'child-room', 'product' => $product->slug]) }}"
                            style="font-size: 1.5em; font-weight: bold;">{{ $product->name}}</a>
                            <p>{{ $product->description }}</p>
                            @endif

                            @if($product-> category_id == 22)
                            <img src="{{$product->main_img}}" alt="{{$product->name}}"
                            style="height: 200px; object-fit: cover;">
                            <a href="{{ route('shop.show', ['category' => 'kitchen', 'product' => $product->slug]) }}"
                            style="font-size: 1.5em; font-weight: bold;">{{ $product-> name}}</a>
                            <p>{{ $product->description }}</p>
                            @endif

                            @if($product-> category_id == 26)
                            <img src="{{$product->main_img}}" alt="{{$product->name}}"
                            style="height: 200px; object-fit: cover;">
                            <a href="{{ route('shop.show', ['category' => 'bathroom', 'product' => $product->slug]) }}"
                            style="font-size: 1.5em; font-weight: bold;">{{ $product-> name}}</a>
                            <p>{{ $product->description }}</p>
                            @endif

                            @if($product-> category_id == 30)
                            <img src="{{$product->main_img}}" alt="{{$product->name}}"
                            style="height: 200px; object-fit: cover;">
                            <a href="{{ route('shop.show', ['category' => 'hall', 'product' => $product->slug]) }}"
                            style="font-size: 1.5em; font-weight: bold;">{{ $product-> name}}</a>
                            <p>{{ $product->description }}</p>
                            @endif

                            @if($product-> category_id == 32)
                            <img src="{{$product->main_img}}" alt="{{$product->name}}"
                            style="height: 200px; object-fit: cover;">
                            <a href="{{ route('shop.show', ['category' => 'office', 'product' => $product->slug]) }}"
                            style="font-size: 1.5em; font-weight: bold;">{{ $product-> name}}</a>
                            <p>{{ $product->description }}</p>
                            @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

@include('components.footer')
@endsection