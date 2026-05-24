<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="AxD">
    <meta name="description" content="For Storify">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('images/favicon-16x16.png') }}" type="image/x-icon">

    <!-- Bootstrap Core CSS v5.3 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">

    <!-- Link CSS Storify -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/storify-base-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/storify-admin-style.css') }}">

    <!-- Link fontGoogles -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,700&amp;display=swap" rel="stylesheet">

    <!-- Link Bootstrap Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap-icons/font/bootstrap-icons.css') }}">

    <!-- Link flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Link Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Stiker Thermal CSS --}}
    <link rel="stylesheet" href="{{ asset('css/storify-stiker-thermal.css') }}">
</head>

<body>
    <main>
        <div class="dx-container-adm">
            @include('partials.sidebar')

            <section class="dx-section d-flex flex-column min-vh-100">
                @include('partials.header')

                <div class="dx-content-wrap grow">
                    @yield('content')
                </div>

                @include('partials.footer')
            </section>

        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- JS Select2 and jQuery untuk Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Javascript Customs -->
    @stack('scripts')
    <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
    <!-- flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#tanggal", {
            disableMobile: "true",
            dateFormat: "Y-m-d", // Format yang dikirim ke database
            altInput: true, // Menampilkan input bayangan untuk user
            altFormat: "d-m-Y", // Format yang dilihat user (Indonesia)
            altInputClass: "flatpicker-input active",
        });
    </script>

</body>

</html>
