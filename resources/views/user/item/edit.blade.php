@extends('Layouts.appadmin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-6">
                <h1 class="m-0 text-dark">
                    <a href="{{ route('item') }}">
                        <img class="back-ic" src="{{ asset('public/admin/images/back-arrow.svg') }}">
                    </a> Edit Item
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
                    <form method="POST" action="{{ route('updateitem') }}">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ base64_encode($item_detail->id) }}">

                        <div class="card-body">
                            <div class="row">
                                <!-- Customer -->
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <select class="form-control" name="customer_id">
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" 
                                                    {{ $item_detail->customer_id == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->customer_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Item Name *</label>
                                        <input type="text" class="form-control" name="item_name" value="{{ $item_detail->item_name }}" required />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Category 1</label>
                                        <input type="text" class="form-control" name="category_1" value="{{ $item_detail->category_1 }}" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Category 2</label>
                                        <input type="text" class="form-control" name="category_2" value="{{ $item_detail->category_2 }}" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Category 3</label>
                                        <input type="text" class="form-control" name="category_3" value="{{ $item_detail->category_3 }}" />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control" name="quantity" value="{{ $item_detail->quantity }}" />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <input type="text" class="form-control" name="unit" value="{{ $item_detail->unit }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="remarks">{{ $item_detail->remarks }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Order Date</label>
                                        <input type="date" class="form-control" name="order_date" value="{{ $item_detail->order_date }}" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Delivery Date</label>
                                        <input type="date" class="form-control" name="delivery_date" value="{{ $item_detail->delivery_date }}" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Close Date</label>
                                        <input type="date" class="form-control" name="close_date" value="{{ $item_detail->close_date }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" class="form-control" name="location" value="{{ $item_detail->location }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Order No</label>
                                        <input type="text" class="form-control" name="order_no" value="{{ $item_detail->order_no }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Vehicle No</label>
                                        <input type="text" class="form-control" name="vehicle_no" value="{{ $item_detail->vehicle_no }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Bill No</label>
                                        <input type="text" class="form-control" name="bill_no" value="{{ $item_detail->bill_no }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Order Type</label>
                                        <input type="text" class="form-control" name="order_type" value="{{ $item_detail->order_type }}" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('item') }}" class="btn btn-default">Cancel</a>
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
    jQuery("#add_unit").validate({
        ignore: [],
        rules: {
            item_name: {
                required: true,
                minlength: 2,
                maxlength: 200,
            },
        },
        messages: {
            item_name: {
                required: 'Please enter name',
                minlength: 'Name should be minimum 2 characters',
                maxlength: 'Name should be maximum 200 characters'
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.appendTo(element.parent().last());
        }
    });
</script>
@endsection
