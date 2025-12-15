<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-popover-x.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-icon">
    <title>kragncy</title>
</head>

<body>
    <!-- ==========Preloader========== -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ==========Preloader========== -->

    <!-- ==========Overlay========== -->
    <div class="overlay"></div>
    <a href="#" class="scrollToTop">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- ==========Overlay========== -->

    <!-- ==========Header-Section========== -->
    <div id="header"></div>

    <!-- ==========Results-Section========== -->
    <section class="results mt-4">
        <div class="lottery-result result-page">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="log-reg-inner">
                            <h2 class="title">
                                Login
                            </h2>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="main-content">
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Your Mobile</label>
                                        <input type="text" class="my-form-control" name="mobile" required
                                            placeholder="Enter Your Mobile Number">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="my-form-control" name="password"
                                            placeholder="Enter Your Password">
                                    </div>
                                    <div class="button-wrapper">
                                        <button type="submit" class="custom-button2">Sign In</button>
                                    </div>
                                    <div class="button-wrapper" style="margin-top: 15px; text-align:center;">
                                        <a href="{{ $link }}" class="custom-button2"
                                            style="background:#25D366; display:inline-block; text-align:center;">
                                            Join Now on WhatsApp
                                        </a>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Results-Section========== -->

    <!-- ==========Newslater-Section========== -->
    <div id="footer"></div>
    <!-- ==========Newslater-Section========== -->
    <!-- All js link starts hear -->
    <script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/js/plugins.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap-popover-x.min.js') }}"></script>
    <script src="{{ asset('frontend/js/amd.js') }}"></script>
    <script src="{{ asset('frontend/js/nice-select.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
</body>

</html>
