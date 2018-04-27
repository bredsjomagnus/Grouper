<header class="header">
    <div class="container-fluid">

        <div class="row">
            <div class="navbar-wrap flex-row space-between main-nav">
                <!-- <div class="logo-wrap">
                    <a href="{{ URL::to('/') }}"><img src="{{ asset('img/rdc_logo.png') }}" alt="logo" class="contained-img"></a>
                </div> -->
                <div id="navbar" class="navbar-collapse collapse">

                    <!-- <ul class="nav navbar-nav">
                        <li {{ Request::path() == "/" ? 'class=active' : '' }}>
                            <a href="{{ URL::to('/') }}">Home</a></li>
                        <li {{ Request::path() == "products-amu-coating" ? 'class=active' : '' }}>
                            <a href="{{ URL::to('/products-amu-coating') }}">Product</a></li> -->
                        <!-- <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Products <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('/products-amu-coating') }}">Architectural & Multi-Use (AMU) Coating</a></li>
                            <li><a href="{{ URL::to('/products-roof-coating') }}">Roof Coating</a></li>
                          </ul>
                        </li> -->
                        <!-- <li {{ Request::path() == "future-products" ? 'class=active' : '' }}>
                            <a href="{{ URL::to('/future-products') }}">Future Products</a></li>
                            <li {{ Request::path() == "materials-applications" ? 'class=active' : '' }}>
                                <a href="{{ URL::to('/materials-applications') }}">Uses/Applications</a>
                            </li> -->
                        <!-- <li class="dropdown {{ Request::path() == "uses-applications" ? 'active' : '' }}">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Uses/Applications <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('/materials-applications') }}">Materials</a></li>
                            <li><a href="{{ URL::to('/commercial-applications') }}">Commercial applications</a></li>
                          </ul>
                        </li> -->
                        <!-- <li class="dropdown {{  Request::is('research/*') ? 'active' : '' }}">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Research & Development <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li {{ Request::path() == "research/performance-test" ? 'class=active' : '' }}><a href="{{ URL::to('/research/performance-test') }}">Performance tests</a></li>
                            <li {{ Request::path() == "research/research" ? 'class=active' : '' }}><a href="{{ URL::to('/research/research') }}">Research results</a></li>
                          </ul>
                        </li>
                        <li {{ Request::path() == "about" ? 'class=active' : '' }}>
                            <a href="{{ URL::to('/about') }}">About Us</a></li>
                        <li {{ Request::path() == "contact" ? 'class=active' : '' }}>
                            <a href="{{ URL::to('/contact') }}">Contact</a></li>
                    </ul> -->
                </div>

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <img src="{{asset('img/hamburger.png')}}" class="img-responsive hamburger-icon">
                </button>
                @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                    <li style='list-style-type: none;' class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('groupsdashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                        <!-- <a href="{{ route('login') }}">Login</a> -->
                        <!-- <a href="{{ route('register') }}">Register</a> -->
                    @endauth
                </div>
            @endif
            </div>
        </div>


    </div>
</header>
