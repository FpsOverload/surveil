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
