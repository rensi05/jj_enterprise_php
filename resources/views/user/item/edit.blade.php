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
                    <form method="POST" id="edit_item" action="{{ route('updateitem') }}">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ base64_encode($item_detail->id) }}">

                        <div class="card-body">
                            <div class="row">
                                <!-- Customer -->
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Customer*</label>
                                        <select class="form-control select2" id="customer_id" name="customer_id">
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
                                        <label>Item Name*</label>
                                        <input type="text" class="form-control" name="item_name" value="{{ $item_detail->item_name }}" placeholder="Enter Item Name" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Quantity 1</label>
                                        <input type="number" class="form-control" name="quantity" value="{{ $item_detail->quantity }}" placeholder="Enter Quantity" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Unit 1</label>
                                        <input type="text" class="form-control" name="unit" value="{{ $item_detail->unit }}" placeholder="Enter Unit" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Quantity 2</label>
                                        <input type="number" class="form-control" name="quantity_1" value="{{ $item_detail->quantity_1 }}" placeholder="Enter Quantity" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Unit 2</label>
                                        <input type="text" class="form-control" name="unit_1" value="{{ $item_detail->unit_1 }}" placeholder="Enter Unit" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" class="form-control" name="location" value="{{ $item_detail->location }}" placeholder="Enter Location" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Category 1</label>
                                        <input type="text" class="form-control" name="category_1" value="{{ $item_detail->category_1 }}" placeholder="Enter Category 1" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Category 2</label>
                                        <input type="text" class="form-control" name="category_2" value="{{ $item_detail->category_2 }}" placeholder="Enter Category 2" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Category 3</label>
                                        <input type="text" class="form-control" name="category_3" value="{{ $item_detail->category_3 }}" placeholder="Enter Category 3" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="remarks" placeholder="Enter Remarks">{{ $item_detail->remarks }}</textarea>
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
    $(document).ready(function () {                
        $("#customer_id").select2({
            placeholder: "Select an item",
            allowClear: true,
            minimumResultsForSearch: 0,
            language: {
                noResults: function () {
                    return "No results found";
                }
            }
        });
        $("#customer_id").on('select2:open', function () {
            let input = $('.select2-search__field');
            if (input.length) {
                input[0].focus();
            }
        });
    });
</script>
<script>
    jQuery("#edit_item").validate({
        ignore: [],
        rules: {
            customer_id: {
                required: true,
            },
            item_name: {
                required: true,
                minlength: 2,
                maxlength: 200,
            },
        },
        messages: {
            customer_id: {
                required: 'Please select customer',
            },
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
