@extends('layouts.appadmin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-6">
                <h1 class="m-0 text-dark"><a href="{{ route('user') }}"><img class="back-ic" src="{{ asset('public/admin/images/back-arrow.svg') }}"></a> Add User</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <form method="POST" action="{{ route('saveuser') }}" id="add_user">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>User Name*</label>
                                        <input type="text" class="form-control" name="user_name" placeholder="Enter User Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Email*</label>
                                        <input type="email" name="email" class="form-control" id="email" value="" placeholder="Please Enter email">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Phone Number*</label>
                                        <input name="phone_number" class="form-control" id="phone_number" value="" placeholder="Please Enter Mobile Number" maxlength="12">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <a href="{{ route('user') }}" class="btn btn-default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/4.0.8/jquery.inputmask.bundle.min.js"></script>
<script>
$("#phone_number").on("change keyup paste", function (e) {
    var t, n = $(this).val();
    if (8 != e.keyCode) {
        var r = (n = n.replace(/[^0-9]/g, "")).substr(0, 3),
                s = n.substr(3, 3),
                a = n.substr(6, 4);
        r.length < 3 ? t = "" + r : 3 == r.length && s.length < 3 ? t = "" + r + "" + s : 3 == r.length && 3 == s.length && (t = "" + r + "-" + s + "-" + a), $("#phone_number").val(t)
    }
});
$('#phone_number').trigger('keyup');
    jQuery("#add_user").validate({
        ignore: [],
        rules: {
            user_name: {
                required: true,
                minlength : 2,
                maxlength : 200,
            },
            email: {
                required: true,
                email: true
            },
            phone_number: {
                required: true,
                customphone: true,
            }
        },
        messages: {
            user_name: {
                required: 'Please enter name',
                minlength : 'Name should be minimum 2 characters',
                maxlength : 'Name should be maximum 200 characters'
            },
            email: {
                required: "Please enter email",
                email: 'Please enter valid email'
            },
            phone_number: {
                required: "Please enter mobile number",
                minlength: "Mobile number should be greater than 9 digits",
                maxlength: "Mobile number should be less than 12 digits",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.appendTo(element.parent().last());
        }
    });
</script>
@endsection
