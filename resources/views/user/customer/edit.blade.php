@extends('Layouts.appadmin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-6">
                <h1 class="m-0 text-dark">
                    <a href="{{ route('customer') }}">
                        <img class="back-ic" src="{{ asset('public/admin/images/back-arrow.svg') }}">
                    </a> Edit Customer
                </h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <form method="POST" action="{{ route('updatecustomer') }}" id="edit_customer">
                        @csrf
                        <input type="hidden" name="customer_id" value="{{ base64_encode($customer_detail->id) }}">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Customer Name *</label>
                                        <input type="text" class="form-control" name="customer_name" value="{{ $customer_detail->customer_name }}" required>
                                        @error('customer_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" class="form-control" name="location" value="{{ $customer_detail->location }}">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" class="form-control" name="country" value="{{ $customer_detail->country }}">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <input type="text" class="form-control" name="state" value="{{ $customer_detail->state }}">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <input type="text" class="form-control" name="type" value="{{ $customer_detail->type }}">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>GST No</label>
                                        <input type="text" class="form-control" name="gst_no" value="{{ $customer_detail->gst_no }}">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('customer') }}" class="btn btn-default">Cancel</a>
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
<script>
    jQuery("#edit_customer").validate({
        ignore: [],
        rules: {
            customer_name: {
                required: true,
                minlength : 2,
                maxlength : 200,
            },
        },
        messages: {
            customer_name: {
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
