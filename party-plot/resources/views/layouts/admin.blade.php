<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <title>{{ getSetting('company_name') ?? 'ThaiSmiles' }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/solid.min.css" integrity="sha512-7QvB4QqFd3ZxD9mv3J/rZSLp6wpnaI4vzyFj5B4a71wB4mH5EMe4dkfz5dlC62UizKf/M+daMnzz4g0F6+LX9Sg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.min.css') }}?v={{ time() }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.min.css') }}?v={{ time() }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.min.css') }}?v={{ time() }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.min.css') }}?v={{ time() }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}?v={{ time() }}">
    <!-- Plugins css start-->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick-theme.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.min.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.min.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/filepond.min.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/filepond-plugin-image-preview.css') }}?v={{ time() }}">
    <!-- flatpickr css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}?v={{ time() }}">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.min.css') }}?v={{ time() }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}?v={{ time() }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/' . getThemeColor() . '.css') }}?v={{ time() }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}?v={{ time() }}">
    <!-- Notifications css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/notifications.css') }}?v={{ time() }}">

    @yield('links')
    @yield('css')

    <style>
        :root {
            --theme-default: {{ getPrimaryColor() }} !important;
            --theme-secondary: {{ getSecondaryColor() }} !important;
        }
    </style>
</head>
<body class="{{ getDarkMode() === 'dark-only' ? 'dark-only' : '' }} {{ getLayoutType() === 'rtl' ? 'rtl' : '' }} {{ getLayoutType() === 'box-layout' ? 'box-layout' : '' }}">
    <div class="loader-wrapper">
        <div class="theme-loader">
            <div class="loader-p"></div>
        </div>
    </div>

    <div class="tap-top"><i data-feather="chevrons-up"></i></div>

    <div class="page-wrapper {{ getSidebarType() === 'compact-sidebar' ? 'compact-wrapper' : 'horizontal-wrapper' }} {{ getLayoutType() === 'box-layout' ? 'box-layout' : '' }}" id="pageWrapper">

        @include('layouts.header')

        <main class="main">

            <div class="page-body-wrapper">

                @include('layouts.sidebar')

                <div class="page-body">
                    @yield('content')
                </div>

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 p-0 footer-copyright">
                                <p class="mb-0">Copyright 2024 © Rextertech.</p>
                            </div>
                            <div class="col-md-6 p-0">
                                <p class="heart mb-0">Hand crafted &amp; made with
                                    <svg class="footer-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#heart') }}"></use>
                                    </svg>
                                </p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </main>
    </div>

    <!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery.min.js') }}?v={{ time() }}"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}?v={{ time() }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}?v={{ time() }}"></script>
    <!-- scrollbar js-->
    <script src="{{ asset('assets/js/scrollbar/simplebar.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/scrollbar/custom.js') }}?v={{ time() }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/js/config.js') }}?v={{ time() }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/sidebar-menu.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/sidebar-pin.js') }}?v={{ time() }}"></script>

    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}?v={{ time() }}"></script>

    <!-- data-table cdn -->
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom1.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/jszip.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.autoFill.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/custom.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- select 2 cdn -->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}?v={{ time() }}"></script>

    <!-- ck-editor cdn -->
    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.custom.js') }}?v={{ time() }}"></script>

    <!-- file pond cdn -->
    <script src="{{ asset('assets/js/filepond/filepond-plugin-image-preview.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/filepond/filepond-plugin-file-rename.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/filepond/filepond-plugin-image-transform.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/filepond/filepond-plugin-file-validate-type.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/filepond/filepond.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/filepond/custom-filepond.js') }}?v={{ time() }}"></script>

    <!-- flatpickr cdn -->
    <script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/custom-flatpickr.js') }}?v={{ time() }}"></script>

    <script src="{{ asset('assets/js/script.js') }}?v={{ time() }}"></script>

    @yield('js')

    <script>
        @if(session('toast'))
            $(document).ready(function() {
                var toast = @json(session('toast'));
                if (toast && toast.type && toast.message) {
                    switch(toast.type) {
                        case 'success':
                            successMessage(toast.message);
                            break;
                        case 'error':
                            errorMessage(toast.message);
                            break;
                        case 'warning':
                            $.notify(
                                '<i class="fa fa-exclamation-triangle"></i><strong>' + toast.message + '</strong>', {
                                    type: "warning",
                                    allow_dismiss: true,
                                    delay: 2000,
                                    showProgressbar: true,
                                    timer: 300,
                                    animate: {
                                        enter: "animated fadeInDown",
                                        exit: "animated fadeOutUp",
                                    },
                                }
                            );
                            break;
                        case 'info':
                            $.notify(
                                '<i class="fa fa-info-circle"></i><strong>' + toast.message + '</strong>', {
                                    type: "info",
                                    allow_dismiss: true,
                                    delay: 2000,
                                    showProgressbar: true,
                                    timer: 300,
                                    animate: {
                                        enter: "animated fadeInDown",
                                        exit: "animated fadeOutUp",
                                    },
                                }
                            );
                            break;
                        default:
                            successMessage(toast.message);
                    }
                }
            });
        @endif

        $(document).ready(() => {
            $('.media-delete-btn').click((e) => {
                let type = $(e.target).parents('.media-section').attr('data-type');
                let table = $(e.target).parents('.media-section').attr('data-table');
                let column = $(e.target).parents('.media-section').attr('data-column');
                let doc_path = $(e.target).parents('.media-section').attr('data-path');
                let id = $(e.target).parents('.media-section').attr('data-id');

                let payload = {};
                payload._token = "{{ csrf_token() }}";
                payload.type = type;
                payload.id = id;
                payload.table = table;
                payload.column = column;
                payload.path = doc_path;

                if (type == "multiple-image") {
                    payload.arrayKey = $(e.target).parents('.media-section').attr('data-arrayKey');
                } else if (type == "multiple-dimensional-image") {
                    payload.arrayKey = $(e.target).parents('.media-section').attr('data-arrayKey');
                    payload.key = $(e.target).parents('.media-section').attr('data-key');
                }

                if (table && type && column) {
                    $.ajax({
                        url: "{{ route('admin.media-delete') }}",
                        method: "post",
                        data: payload,
                        success: (data) => {
                            $(e.target).parents('.media-section').remove();
                        }
                    });
                }
            });

            $(document).on('change', '.switch', (e) => {
                let table = $(e.target).parent('.switch').data('table');
                let id = $(e.target).val();
                let status = $(e.target).is(':checked') ? 1 : 0;

                if (table && id) {
                    $.ajax({
                        url: "{{ route('admin.updateStatus') }}",
                        type: "POST",
                        data: {
                            table: table,
                            id: id,
                            status: status,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                successMessage(response.message);
                            } else {
                                errorMessage(response.message);
                            }
                        },
                        error: function(xhr) {
                            errorMessage(xhr.responseJSON.message);
                        }
                    });
                }
            });

            @if (Session::has('error'))
                errorMessage('{{ Session::get('error') }}');
            @elseif (Session::has('success'))
                successMessage('{{ Session::get('success') }}');
            @endif

            $('.btn[data-filter]').on('click', function() {
                $('.btn[data-filter]').removeClass('active');
                $(this).addClass('active');
            });

            $('.select2').select2();
        });

            async function apiCrud(url, method, data, isFormData = 0) {
                let result;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                await $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    contentType: isFormData ? false : 'application/x-www-form-urlencoded',
                    processData: isFormData ? false : true,
                    success: (Response) => {
                        if (method == "GET") {
                            result = Response;
                        } else {
                            $.each(Response, function(key, value) {
                                if (key == "success") {
                                successMessage(value)
                                }
                            });
                            $('.close').click();

                            result = Response;
                        }
                    },
                    error: (Response) => {
                        let errors = Response.responseJSON;
                        $.each(errors, function(key, value) {
                        errorMessage(value)
                        });

                        result = Response;
                    }
                })

                return result;
            }

        function successMessage(message) {
            $.notify(
                '<i class="fa fa-bell-o"></i><strong>' + message + '</strong>', {
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
                '<i class="fa fa-bell-o"></i><strong>' + message + '</strong>', {
                    type: "danger",
                    allow_dismiss: true,
                    delay: 2000,
                    showProgressbar: true,
                    timer: 300,
                    animate: {
                        enter: "animated fadeInDown",
                        exit: "animated fadeOutUp",
                    },
                }
            );
        }
    </script>

    <!-- Notifications JavaScript -->
    <script src="{{ asset('assets/js/notifications.js') }}?v={{ time() }}"></script>
</body>
</html>
