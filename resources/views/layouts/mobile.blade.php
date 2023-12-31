<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @stack('style')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-mobile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .pl-1 {
            padding-left: 0.5rem !important
        }

        .pr-1 {
            padding-right: 0.5rem !important
        }

        .btn-back-nav {
            display: none;
        }

        #toast-container {
            position: fixed;
            bottom: 90px;
            right: 30px;
            left: 30px;
            z-index: 9999;
            text-align: center;
        }

        .toast {
            background-color: #000;
            opacity: 0.8 !important;
            color: #fff;
            padding: 10px !important;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <!-- Header -->
            @include('components.mobile.header')

            <!-- Content -->
            <div style="min-height: 90vh">
                @yield('main')

            </div>
            @include('components.mobile.nav')
            <div id="toast-container"></div>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <script>
        function showToast(message) {
            // Create a new toast element
            var $toast = $('<div class="toast text-center">' + message + '</div>');

            // Append the toast to the container
            $('#toast-container').append($toast);

            // Set a timeout to remove the toast after a certain time
            setTimeout(function() {
                $toast.remove();
            }, 3000); // 3000 milliseconds = 3 seconds
        }


        @if (session()->has('success'))
            showToast("{{ session('success') }}");
        @endif

        @if (session()->has('error'))
            showToast("{{ session('error') }}")
        @endif
    </script>


    @stack('scripts')

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

</body>

</html>
