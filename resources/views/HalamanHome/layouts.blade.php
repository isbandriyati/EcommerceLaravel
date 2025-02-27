<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <title>@yield('title')</title>
</head>
<body>

@include('Components.navbar', ['categories' => $categories, 'carts' => $cartItems])


    <main>
        @yield('content')
    </main>

    <!-- Flash Message Alert -->
    @if(session('success'))
    <div id="alert-message" class="alert alert-success position-fixed top-0 start-50 translate-middle-x mt-3" role="alert">
        {{ session('success') }}
    </div>
    @endif
    
    @include('HalamanHome.footer')

    <!-- jQuery (Pastikan ini ada sebelum script.js) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Script -->
    <script src="{{ asset('script.js') }}"></script>



</body>
</html>
