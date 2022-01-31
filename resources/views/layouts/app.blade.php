<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield ('title', 'Главная')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('style', '')
        <style>


        a:active,
        a:hover {
    text-decoration: underline;
        }
        a {
            text-decoration: none;
            color: black;
        }

        .card:hover{
            box-shadow: 0.4em 0.4em 5px rgb(122 122 122 / 50%);
        }

        .card-basket-buttons {
            display: flex;
            justify-content: space-between;
        }
        .card-basket-quantity {
            line-height: 34px;
        }
        .card-price {
            text-align: center;
            font-size: 20px;
            margin-top: 10px;
        }
        .card-text {
            height:70px;
        }
        .card-title {
            height:45px;
            text-align: center;
            font-weight: bold;
        }
    
        .dropdown-login{
            padding: 0.25rem 1rem;
        }
        .nav-link-picture{
            padding: 0;
        }

        .card-img{ width: 300px; 
            height: 240px; 
            object-fit: cover;

        }
        
            

        </style>
    
   
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('basket') }}">
                                Корзина ({{ array_sum(session('products') ?? []) }})
                            </a>
                        </li>
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @if (Auth::user()->roles->pluck('name')->contains('Admin'))
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin') }}">Админка</a>
                            </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link-picture dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img
                                        alt="{{ Auth::user()->name }}"
                                        style="height:40px; border-radius:40px; border:1px solid grey" 
                                        src="{{asset('storage/image/users/')}}/{{Auth::user()->picture}}"
                                    >
                                    
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <span class="dropdown-login"><strong>{{ Auth::user()->name }}</strong></span>
                                <a class="dropdown-item" href ="{{ route ('profile') }}">Личный кабинет</a>
                                <a class="dropdown-item" href ="{{ route ('orders') }}">Заказы</a>    
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Выход') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
