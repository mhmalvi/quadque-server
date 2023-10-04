<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta property="og:title" content="{{ $blog->title }}" />
    <meta property="og:description" content="{{ $blog->meta_description }}" />
    <meta property="og:keyword" content="{{ $blog->meta_keyword }}" />
    <meta property="og:image" content="https://latest-server.quadque.tech/public/{{ $blog->thumbnail }}" />


    <meta property="twitter:title" content="{{ $blog->title }}" />
    <meta property="twitter:description" content="{{ $blog->meta_description }}" />
    <meta property="twitter:keyword" content="{{ $blog->meta_keyword }}" />
    <meta property="twitter:image" content="https://latest-server.quadque.tech/public/{{ $blog->thumbnail }}" />
    <meta name="twitter:card" content="summary_large_image">




    <!-- Bootstrap CSS -->
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>@yield('title')</title>
    @stack('styles')
</head>
<body>
    <p>{!! $blog->text !!}</p>
</body>
</html>