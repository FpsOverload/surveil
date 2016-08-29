<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<header id="main-page-header">
    <h1>Surveil <small>Simple Server Management</small></h1>
    <nav>
        <ul class="nav navbar-nav navbar-right">
            @if (Auth::guest())
                <li><a href="{{ url('/login') }}">Login</a></li>
                <li><a href="{{ url('/register') }}">Register</a></li>
            @else
                 <li>
                    <a href="{{ url('/logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            @endif
        </ul>
    </nav>
</header>

<main id="main-page-container">
    <nav>
        <h2>Sidebar</h2>
    </nav>

    <div class="container">
        @yield('content')
    </div>
</main>
    

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    @include('_partials.head')
</head>
<body>
    
@include('_partials.header')

<main id="page-container">
    <div class="container">
        @yield('content')
    </div>
</main>

<!-- Scripts -->
<script src="/js/app.js"></script>
</body>
</html>
