<header class="main-header">
    <div class="left">
        <button aria-expanded="false" class="mobile-menu-toggle-left">
            <span class="mobile-menu-icon">
                <span></span>
            </span>
            <span class="mobile-menu-options">
                <span>Menu</span>
                <span>Close.</span>
            </span>
        </button>
        <div class="search-box">
            <form action="{{ route('search') }}" method="GET">
                <input
                    type="text"
                    name="query"
                    placeholder="Search"
                    class="search-input"
                    aria-label="Search"
                    required
                />
                <button type="submit" class="search-button">
                    <x-carbon-search class="search-icon" />
                </button>
            </form>
        </div>
    </div>
    <div class="logo"><a href="{{route('home')}}">GIANT</a></div>
    <div class="right">
        <div class="contact">
            <p>Call Us</p>
        </div>
        <div class="items">
            <a href="{{route('cart.index')}}"><x-carbon-shopping-cart title="Cart" class="cart-icon" /></a>
            <a href="{{route('wishlist.index')}}"><x-carbon-favorite title="Wishlist" class="favorite-icon" /></a>
            @guest
                <x-carbon-user title="Account" class="user-icon mobile-menu-toggle-right" />
            @endguest
            @auth
                <a href="{{route('profile.index')}}"><x-carbon-user title="Account" class="user-icon" /></a>
            @endauth
        </div>
    </div>
    <div id="mobile-menu-left" aria-expanded="false" class="mobile-menu-left">
        <aside class="side-container">
            <div class="options">
                @foreach($mainCategories as $category)
                    <a href="{{route('shop.index', ['category' => $category->slug])}}" class="opt-box">
                        <span class="option">{{$category->name}}</span>
                        <span class="arrow arrow-right"></span>
                    </a>
                @endforeach
            </div>
            <div class="secondary-options">
                <a href="">Find a Warehouse</a>
                <a href="">Can we help you?</a>
            </div>
        </aside>
    </div>
    <div id="mobile-menu-right" aria-expanded="false" class="mobile-menu-right">
        <aside class="side-container">
            <div class="header">
                <h4>Identification</h4>
                <span class="mobile-menu-toggle-right"><x-carbon-close class="close-icon"/></span>
            </div>
            <div class="l-form-container">
                <h4>I already have an account</h4>
                <span>Mandatory fields*</span>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="email-container">
                        <label for="email">{{ __('Login*') }}</label>
                        <div>
                            <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="pass-container">
                        <label for="password">{{ __('Password*') }}</label>
                        <div>
                            <div>
                                <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <x-carbon-view-off title="Show password" class="view-icon view-pass-toggle" />
                                <x-carbon-view title="Hide password" class="view-icon hidden view-pass-toggle" />
                            </div>
                            @if (Route::has('password.request'))
                            <a class="pass-reset" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <div>
                            <button class="proceed-btn -primary" type="submit">
                                {{ __('Sign in') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="r-form-container">
                <h4>I don't have an account</h4>
                <p>Enjoy added benefits and a richer experience by creating a personal account</p>
                <a href="{{"register"}}" class="proceed-btn -secondary">Create My GIANT account</a>
            </div>
        </aside>
    </div>
</header>
