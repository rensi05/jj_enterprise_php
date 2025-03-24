@extends('Layouts.admin')
@section('content')

<div class="global-container login-page">
    <div class="card login-form">
        <div class="card-body">
            <img src="{{ asset('public/admin/images/logo.png') }}" alt="Youth Sports Index logo" class="img-fluid login-logo-img" alt="" />
            <h3>Login</h3>
            <div class="card-text">
                <form action="{{route('savelogin')}}" method="post" name="admin_login" id="admin_login">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="Enter Email Address">
                        <label for="email" class="error w-100"></label>
                    </div>
                    <div class="form-group mb-4 position-relative">
                        <!-- {{--<input id="password-field" type="password" class="form-control" name="password" value="secret">--}} -->
                        <label for="password-field">Password</label>
                        <i toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon password-eye toggle-password"></i>
                        <input type="password" name="password" maxlength="16" id="password-field" class="form-control"
                            placeholder="Enter Password">
                        <label for="password-field" class="error w-100"></label>
                    </div>
                    <button type="submit" class="btn mt-4 login-btn">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
@section('javascript')
<script>
jQuery("#admin_login").validate({
    rules: {
        email: {
            required: true,
            email: true,
        },
        password: {
            required: true,
            minlength : 6,
            maxlength : 16,
        }
    },
    messages: {
        email: {
            required: "Please enter email address",
            email: 'Please enter valid email address',
        },
        password: {
            required: 'Please enter password',
            minlength : 'Password must contain atleast 6 characters',
            maxlength : 'Password must contain maximum 16 characters',
        }
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
