@extends('Layouts.appadmin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Profile</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <form method="post" id="profile_form" name="profile_form" action="{{route('updateprofile')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>First Name *</label>
                                        <input type="text" name="first_name" class="form-control" maxlength="32" id="first_name" value="{{$user_detail->first_name}}" placeholder="Please Enter First Name">
                                        @error('first_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Last Name *</label>
                                        <input type="text" name="last_name" class="form-control" maxlength="32" id="last_name" value="{{$user_detail->last_name}}" placeholder="Pleae Enter Last Name">
                                        @error('last_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Email *</label>
                                        <input type="email" name="email" class="form-control" id="email" value="{{$user_detail->email}}" placeholder="Please Enter email">
                                        @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Mobile Number *</label>
                                        <input name="number" class="form-control" id="number" value="{{$user_detail->number}}" placeholder="Please Enter Mobile Number" maxlength="12">
                                        @error('number')
                                        {{--<div class="alert alert-danger">{{ $message }}
                                    </div>--}}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <label>Profile Picture</label>
                                    <div class="custom-file edit-file">
                                        <input type="file" name="image" onchange="previewImage(this);" class="custom-file-input" id="image">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    @if(!empty($user_detail->image))
                                    <img id="preview" class="profile-img" src="{{ URL::asset('public/uploads/admin_profile/'.$user_detail->image) }}" height="100" width="100">
                                    @else
                                    <img id="preview" class="profile-img" src="{{ asset('public/admin/images/dummy.png') }}">
                                    @endif
                                    @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
                                            $("#number").on("change keyup paste", function (e) {
                                                var t, n = $(this).val();
                                                if (8 != e.keyCode) {
                                                    var r = (n = n.replace(/[^0-9]/g, "")).substr(0, 3),
                                                            s = n.substr(3, 3),
                                                            a = n.substr(6, 4);
                                                    r.length < 3 ? t = "" + r : 3 == r.length && s.length < 3 ? t = "" + r + "" + s : 3 == r.length && 3 == s.length && (t = "" + r + "-" + s + "-" + a), $("#number").val(t)
                                                }
                                            });
                                            $('#number').trigger('keyup');
</script>
<script>
    $.validator.addMethod('customphone', function (value, element) {
        return this.optional(element) || /^\d{3}-\d{3}-\d{4}$/.test(value);
    }, "Please enter a valid phone number");
    jQuery("#profile_form").validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2,
                maxlength: 32,
            },
            last_name: {
                required: true,
                minlength: 2,
                maxlength: 32,
            },
            email: {
                required: true,
                email: true
            },
            number: {
                required: true,
                customphone: true,
            }
        },
        messages: {
            first_name: {
                required: 'Please enter first name',
                minlength: 'First name should be minimum 2 characters',
                maxlength: 'First name should be maximum 32 characters',
            },
            last_name: {
                required: 'Please enter last name',
                minlength: 'Last name should be minimum 2 characters',
                maxlength: 'Last name should be maximum 32 characters',
            },
            email: {
                required: "Please enter email.",
                email: 'Please enter valid email.'
            },
            number: {
                required: "Please enter mobile number.",
                minlength: "Mobile number should be greater than 9 digits.",
                maxlength: "Mobile number should be less than 12 digits.",
//                number: "Please enter a valid mobile number."
            }
        }
    });
    function previewImage(input) {
        var file = $("input[name=image]").get(0).files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function () {
                $("#preview").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
    function previewMainImage(input) {
        var file = $("input[name=main_logo]").get(0).files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function () {
                $("#main_preview").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
    function previewContentImage(input) {
        var file = $("input[name=header_logo]").get(0).files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function () {
                $("#header_preview").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection