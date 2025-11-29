<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Zono admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Zono admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <title>{{ getSetting('company_name') ?? 'ThaiSmiles' }}</title>
    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}?v={{ time() }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.min.css') }}?v={{ time() }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.min.css') }}?v={{ time() }}">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.min.css') }}?v={{ time() }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}?v={{ time() }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}?v={{ time() }}">
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div>
                            <a class="logo" href="index.html">
                                <img class="img-fluid for-light" src="{{ getCompanyLogo() }}" alt="{{ getSetting('company_name', 'Company') }}" style="max-height: 60px; max-width: 250px; object-fit: contain;">
                                <img class="img-fluid for-dark" src="{{ getCompanyLogo() }}" alt="{{ getSetting('company_name', 'Company') }}" style="max-height: 60px; max-width: 250px; object-fit: contain;">
                            </a>
                        </div>
                        <div class="login-main">
                            <form class="theme-form" action="{{ route('admin.saveLogin') }}" method="POST">
                                @csrf
                                <h3>Sign in to account</h3>
                                <p>Enter your email & password to login</p>
                                <x-input label="User name" type="text" name="email" class="username" placeholder="Email / Username"  autocomplete="email" autofocus required/>
                                <x-password/>
                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input id="remember_me" name="remember_me" value="1" type="checkbox">
                                        <label class="text-muted" for="remember_me">Remember password</label>
                                    </div>
                                    {{-- <a class="link" href="forget-password.html">Forgot password?</a> --}}
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                                    </div>
                                </div>
                                {{-- <h6 class="text-muted mt-4 or">Or Sign in with</h6>
                                <div class="social mt-4">
                                    <div class="btn-showcase"><a class="btn btn-light" href="https://www.linkedin.com/login" target="_blank"><i class="txt-linkedin" data-feather="linkedin"></i> LinkedIn </a><a class="btn btn-light" href="https://twitter.com/login?lang=en" target="_blank"><i class="txt-twitter" data-feather="twitter"></i>twitter</a><a class="btn btn-light" href="https://www.facebook.com/" target="_blank"><i class="txt-fb" data-feather="facebook"></i>facebook</a></div>
                                </div>
                                <p class="mt-4 mb-0 text-center">Don't have account?<a class="ms-2" href="sign-up.html">Create Account</a></p> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- latest jquery-->
        <script src="{{ asset('assets/js/jquery.min.js') }}?v={{ time() }}"></script>
        <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}?v={{ time() }}"></script>
        <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}?v={{ time() }}"></script>
        <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}?v={{ time() }}"></script>
        <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}?v={{ time() }}"></script>
        <script src="{{ asset('assets/js/script.js') }}?v={{ time() }}"></script>
        <!-- Plugin used-->

        <script>
            $(document).ready( () =>{
                @if (Session::has('error'))
                    errorMessage('{{ Session::get('error') }}');
                @elseif (Session::has('success'))
                    successMessage('{{ Session::get('success') }}');
                @endif

                function successMessage(message) {
                    $.notify(
                        '<i class="fa fa-bell-o"></i><strong>' + message + '</strong>',
                        {
                            type: "theme",
                            allow_dismiss: true,
                            delay: 2000,
                            showProgressbar: true,
                            timer: 300,
                            animate: {
                                enter: "animated fadeInDown",
                                exit: "animated fadeOutUp",
                            },
                        }
                    )
                }

                function errorMessage(message) {
                    $.notify(
                        '<i class="fa fa-bell-o"></i><strong>' + message + '</strong>',
                        {
                            type: "danger",
                            allow_dismiss: true,
                            delay: 2000,
                            showProgressbar: false,
                            timer: 300,
                            animate: {
                                enter: "animated fadeInDown",
                                exit: "animated fadeOutUp",
                            },
                            onShow: function() {
                                $('.alert[data-notify="container"]').css('display', 'flex');
                            }
                        }
                    );
                }
            });
        </script>
    </div>
</body>

</html>
