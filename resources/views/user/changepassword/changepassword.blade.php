@extends('Layouts.appadmin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Change Password</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Change Password</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <!--                    <div class="card-header">
                        <h3 class="card-title">Change  <small>Password</small></h3>
                    </div>-->
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="post" id="change_password_form" name="change_password_form" action="{{route('updatepassword')}}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Current Password *</label>
                                        <i toggle="#c_password"  class="fa fa-fw fa-eye-slash field-icon password-eye toggle-password"></i>
                                        <input type="password" name="c_password" class="form-control" id="c_password" placeholder="Please Enter Current Password">
                                        @error('c_password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="password-field">New Password *</label>
                                        <i toggle="#n_password"  class="fa fa-fw fa-eye-slash field-icon password-eye toggle-password"></i>
                                        <input type="password" name="n_password" class="form-control" maxlength="16" id="n_password" placeholder="Please Enter New Password">
                                        @error('n_password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Confirm Password *</label>
                                        <i toggle="#con_password"  class="fa fa-fw fa-eye-slash field-icon password-eye toggle-password"></i>
                                        <input type="password" name="con_password" class="form-control" maxlength="16" id="con_password" placeholder="Please Enter Confirm Password">
                                        @error('con_password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">

            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>


<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="delete_modal_content">
        </div>
    </div>
</div>
<div id="changestatus_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="status_modal_content">
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>
    $.validator.addMethod(
        "password_regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Password should have at least 1 lowercase and 1 uppercase and 1 number and 1 symbol."
    );
    jQuery("#change_password_form").validate({
        rules: {
            c_password: {
                required: true
            },
            n_password: {
                required: true,
                minlength : 8,
                maxlength : 16,
                password_regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/,
            },
            con_password: {
                required: true,
                equalTo: "#n_password",
                minlength : 8,
                maxlength : 16,
                password_regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/,
            }
        },
        messages: {
            c_password: {
                required: 'Please enter current password.',
            },
            n_password: {
                required: 'Please enter new password.',
                minlength : 'New Password should be minimum 8 characters',
                maxlength : 'New Password should be maximum 16 characters',
                //pattern   : 'New Password should have at least 1 lowercase and 1 uppercase and 1 number and 1 symbol.',
            },
            con_password: {
                required: 'Please enter confirm password.',
                equalTo: 'Password and confirm password does not match.',
                minlength : 'Confirm password should be minimum 8 characters',
                maxlength : 'Confirm password should be maximum 16 characters',
                //pattern   : 'Confirm password should have at least 1 lowercase and 1 uppercase and 1 number and 1 symbol.',
            },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.appendTo(element.parent().last());
        }
    });
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>
@endsection