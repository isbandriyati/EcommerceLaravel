<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <title>@yield('title')</title>

<style>

html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
   
}

main {
    flex-grow: 1;  /* Membuat konten utama mengisi sisa ruang */
}

footer {
    background-color:rgb(1, 7, 12); /* atau #f8f9fa untuk abu-abu lebih terang */
    color: white;
}

</style>
</head>
<body>
    <x-navbar />
<main>
    @yield('content')
</main>

@include('HalamanHome.footer')


</body>
</html>
