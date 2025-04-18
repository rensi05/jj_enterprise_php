<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>JJ Enterprise</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href="{{ asset('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- JQVMap -->
        <link rel="stylesheet" href="{{ asset('public/plugins/jqvmap/jqvmap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('public/plugins/dist/css/adminlte.min.css') }}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{ asset('public/plugins/daterangepicker/daterangepicker.css') }}">
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('public/plugins/summernote/summernote-bs4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/plugins/select2/css/select2.min.css') }}">
        <!-- Alertify -->
        <link rel="stylesheet" href="{{ asset('public/admin/css/alertify.min.css')}}">
        {{--<link rel="stylesheet" href="{{ admin/css/summernote-bs4.min.css')}}">--}}
        <script src="{{ asset('public/admin/ckeditor/ckeditor.js')}}"></script>
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('public/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/admin/plugins/datatables/scroller.bootstrap.min.css') }}">
        <link rel="stylesheet"
              href="{{ asset('public/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/admin/plugins/datatables/responsive.bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ asset('public/admin/css/jquery-ui.css')}}">
        <!-- new css -->
        <link rel="stylesheet" href="{{ asset('public/admin/css/admin-new.css')}}">

        <!--Favicon icon-->
        <link rel="icon" href="{{ asset('public/admin/images/favicon.jpeg') }}" id="fav-icon" type="image/x-icon">

        @yield('stylesheet')
        <style>
            .chip {
                display: inline-block;
                background-color: #007bff;
                color: white;
                padding: 5px 10px;
                border-radius: 15px;
                margin: 5px;
            }
            .chip .close {
                margin-left: 10px;
                cursor: pointer;
            }
        </style>

    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="{{asset('public/admin/images/logo.png')}}" alt="" width="150">
            </div>

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->
            <?php $current_route = Route::currentRouteName(); ?>
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="" class="brand-link big">
                    <img src="{{ asset('public/admin/images/logo.png') }}" alt="" class="brand-image" style="opacity: .8">
                    <!-- <span class="brand-text font-weight-light">HOME - COOK</span> -->
                </a>
                <a href="" class="brand-link smail">
                    <img src="{{ asset('public/admin/images/logo.png') }}" alt="" class="brand-image" style="opacity: .8">
                    <!-- <span class="brand-text font-weight-light">HOME - COOK</span> -->
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <?php
                    $value = DB::table('admins')->select('image')->first();
                    ?>
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            @if(!empty(Auth::User()->image))
                            <img src="{{ URL::asset('public/uploads/admin_profile/'.Auth::User()->image) }}" class="elevation-2" alt="User Image">
                            @else
                            <img src="{{ URL::asset('public/admin/images/dummy.png') }}" class="elevation-2" alt="User Image">
                            @endif
                        </div>
                        <div class="info">
                            <a class="d-block">
                                {{Auth::User()->first_name.' '.Auth::User()->last_name}}
                            </a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{route('profile')}}" class="nav-link {{ (request()->is('admincp/profile')) ? 'active' : '' }} ">
                                    <i class="far fas fa-user-tie nav-icon"></i>
                                    <p>Profile Management</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('changepassword')}}" class="nav-link {{ (request()->is('admincp/changepassword')) ? 'active' : '' }} ">
                                    <i class="fa fa-key nav-icon"></i>
                                    <p>
                                        Change Password
                                    </p>
                                </a>
                            </li>
                            <?php
                            $user = '';
                            if ($current_route == 'user' || 
                                    $current_route == 'adduser' || 
                                    $current_route == 'edituser'
                            ) {
                                $user = 'active';
                            }
                            ?>
                            <li class="nav-item">
                                <a href="{{route('user')}}" class="nav-link {{$user}} ">
                                    <i class="fa fa-user nav-icon"></i>
                                    <p>User Management</p>
                                </a>
                            </li>
                            <?php
                            $unit = '';
                            if ($current_route == 'unit' || 
                                    $current_route == 'addunit' || 
                                    $current_route == 'editunit'
                            ) {
                                $unit = 'active';
                            }
                            ?>
                            <li class="nav-item">
                                <a href="{{route('unit')}}" class="nav-link {{$unit}} ">
                                    <i class="fa fa-user nav-icon"></i>
                                    <p>Unit Management</p>
                                </a>
                            </li>
                            <?php
                            $customer = '';
                            if ($current_route == 'customer' || 
                                    $current_route == 'addcustomer' || 
                                    $current_route == 'editcustomer'
                            ) {
                                $customer = 'active';
                            }
                            ?>
                            <li class="nav-item">
                                <a href="{{route('customer')}}" class="nav-link {{$customer}} ">
                                    <i class="fa fa-user nav-icon"></i>
                                    <p>Customer Management</p>
                                </a>
                            </li>
                            <?php
                            $item = '';
                            if ($current_route == 'item' || 
                                    $current_route == 'additem' || 
                                    $current_route == 'edititem'
                            ) {
                                $item = 'active';
                            }
                            ?>
                            <li class="nav-item">
                                <a href="{{route('item')}}" class="nav-link {{$item}} ">
                                    <i class="fa fa-box nav-icon"></i>
                                    <p>Item Management</p>
                                </a>
                            </li>
                            <?php
                            $order = '';
                            if ($current_route == 'order' || 
                                    $current_route == 'addorder' || 
                                    $current_route == 'editorder'
                            ) {
                                $order = 'active';
                            }
                            ?>
                            <li class="nav-item">
                                <a href="{{route('order')}}" class="nav-link {{$order}} ">
                                    <i class="fa fa-shopping-basket nav-icon"></i>
                                    <p>Order Management</p>
                                </a>
                            </li>
                            <?php
                            $checkbook = '';
                            if ($current_route == 'checkbook' || 
                                    $current_route == 'addcheckbook' || 
                                    $current_route == 'editcheckbook'
                            ) {
                                $checkbook = 'active';
                            }
                            ?>
                            <li class="nav-item">
                                <a href="{{route('checkbook')}}" class="nav-link {{$checkbook}} ">
                                    <i class="fa fa-book nav-icon"></i>
                                    <p>CheckBook Management</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('logout')}}" class="nav-link">
                                    <i class="fas fa-sign-out-alt nav-icon"></i>
                                    <p>Logout</p>
                                </a>
                            </li>

                        </ul>

                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->

            <!-- Image preview Model -->
            <div class="modal fade" id="imagePreviewModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="imagepreviewdiv">
                                <img class="priviewimage" src="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Image preview Model -->


            <footer class="main-footer">
                <!--    <div class="row align-items-center">
                        <div class="d-none d-sm-inline-block col-4">Copyright &copy; <?php echo date('Y'); ?>.</div>
                        <div class="float-right text-right d-none d-sm-inline-block col-8">
                            Website Designed & Developed by <b><a target="_blank" href="https://www.octosglobal.com/">Octos
                                    Global Solutions. <img src="{{ asset('public/admin/images/octos_logo.png')}}"
                                        alt="Octos Global" class="ml-1" width="70"></a></b>
                        </div>
                    </div>-->
            </footer>
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset('public/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
$.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- ChartJS -->
        <script src="{{ asset('public/plugins/chart.js/Chart.min.js') }}"></script>
        <!-- Sparkline -->
        <script src="{{ asset('public/plugins/sparklines/sparkline.js') }}"></script>
        <!-- JQVMap -->
        <script src="{{ asset('public/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('public/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{ asset('public/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
        <!-- daterangepicker -->
        <script src="{{ asset('public/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('public/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{ asset('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <!-- Summernote -->
        <script src="{{ asset('public/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ asset('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('public/plugins/dist/js/adminlte.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <!--<script src="{{ asset('public/plugins/dist/js/demo.js') }}"></script>-->
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{ asset('public/plugins/dist/js/pages/dashboard.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/jquery.dataTables.js') }}"></script>
        <!--<script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>-->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- Jquery validate -->
        <script src="{{ asset('public/admin/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('public/admin/js/additional-methods.min.js') }}"></script>
        <!-- Alertify -->
        <script src="{{ asset('public/admin/js/alertify.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>

        <!-- DataTables  & Plugins -->
        <script src="{{ asset('public/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/admin/plugins/datatables/dataTables.scroller.min.js') }}"></script>
        <script src="{{ asset('public/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/admin/plugins/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('public/admin/js/morris.min.js') }}"></script>
        <script src="{{ asset('public/admin/js/jquery.minicolors.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!--<script src="{{ asset('public/user/js/lightbox.js') }}"></script>-->
        <link rel="stylesheet" href="{{ asset('public/plugins/select2/js/select2.min.js') }}">


        <!-- Image priview script -->
        <script>
jQuery(document).on("click", ".imagePriview", function (e) {
    e.preventDefault();
    var image = jQuery(this).attr('src');
    if (image) {
        jQuery('.priviewimage').attr('src', image);
        jQuery('#imagePreviewModel').modal('show');
    }
});
        </script>
        <!-- Image priview script -->
        @yield('javascript')

<!--<script>
    $(function() {
        $(".info-btn").click(function() {
            $('.profile-ul').removeClass('d-none');
        });
        $(".profile-panel").mouseleave(function() {
            $('.profile-ul').addClass('d-none');
        });
    });
    </script>-->
        @if(Session::get("error"))
        <script>
            jQuery(document).ready(function () {
                //alert(1);
                alertify.set('notifier', 'position', 'top-right');
                var notification = alertify.notify('{{Session::get("error")}}', 'error', 6);
            });
        </script>
        @endif
        @if(Session::get("success"))
        <script>
            jQuery(document).ready(function () {
                //alert(2);
                //return alertify.notify("Verification code sent successfully", "success", 3);
                alertify.set('notifier', 'position', 'top-right');
                return alertify.notify('{{Session::get("success")}}', 'success', 6);
            });
        </script>

        @endif
        <script>
            $(document).ready(function () {
                $('#keywords').select2({
                    placeholder: "Select Keywords", // Placeholder text
                    allowClear: true, // Allows clearing the selection
                    tags: false                    // Disables custom typing (only predefined keywords)
                });
            });

        </script>
    </body>
</html>
