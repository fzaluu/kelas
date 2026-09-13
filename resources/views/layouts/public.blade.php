<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Website Kelas PPLG') - SMKN 4 Kota Tasikmalaya</title>
</head>
<body style="margin: 0; font-family: sans-serif; background: #f8fafc; color: #334155;">
    @include('partials.public-navbar')

    <main style="min-height: 80vh;">
        @yield('content')
    </main>

    @include('partials.public-footer')
</body>
</html>