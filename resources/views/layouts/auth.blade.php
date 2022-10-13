<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.css">

    <link rel="shortcut icon" href="/assets/images/logo-simetri.png" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/app.css">
</head>

<body>
    <div id="auth">

        <div class="container">
            @yield('auth_content')
        </div>

    </div>
    <script src="/assets/js/feather-icons/feather.min.js"></script>
    <script src="/assets/js/app.js"></script>

    <script src="/assets/js/main.js"></script>
</body>

</html>
