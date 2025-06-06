@extends('Layouts.appadmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-6">
                <h1 class="m-0 text-dark"><a href="{{route('unit')}}"><img class="back-ic" src="{{ asset('public/admin/images/back-arrow.svg')}}"></a> Edit Unit</h1>
            </div><!-- /.col -->
            <div class="col-lg-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('unit')}}">Units Management</a></li>
                    <li class="breadcrumb-item active">Edit Unit</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <form method="post" id="edit_unit" name="edit_unit" action="{{route('updateunit')}}" enctype="multipart/form-data">
                        <input type="hidden" name="unit_id" value="{{base64_encode($unit_detail->id)}}">

                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Name*</label>
                                        <input type="text" class="form-control" id="name" name="name" maxlength="200" value="{{$unit_detail->name}}" placeholder="Please Enter Unit Name" />
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="submit" id="save_page_btn" class="btn btn-primary waves-effect waves-light"> Update </button>
                                        <a href="{{route('unit')}}" class="btn btn-default waves-effect m-l-5"> Cancel </a>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
@section('javascript')
<script>
    jQuery("#edit_unit").validate({
        ignore: [],
        rules: {
            name: {
                required: true,
                minlength : 2,
                maxlength : 200,
            },
        },
        messages: {
            name: {
                required: 'Please enter name',
                minlength : 'Name should be minimum 2 characters',
                maxlength : 'Name should be maximum 200 characters'
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.appendTo(element.parent().last());
        }
    });
</script>
@endsection
