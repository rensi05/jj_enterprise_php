@extends('Layouts.appadmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-6">
                <h1 class="m-0 text-dark">
                    <a href="{{ route('order') }}">
                        <img class="back-ic" src="{{ asset('public/admin/images/back-arrow.svg') }}">
                    </a> 
                    Add Order
                </h1>
            </div>
            <div class="col-lg-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('order') }}">Order Management</a></li>
                    <li class="breadcrumb-item active">Add Order</li>
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
                    <form method="post" id="add_order" name="add_order" action="{{ route('saveorder') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Customer*</label>
                                        <select class="form-control select2" id="customer_id" name="customer_id">
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Item*</label>
                                        <select class="form-control select2" name="item_id" id="item_id">
                                            <option value="">Select Item</option>
                                            @foreach($items as $item)
                                            <option value="{{ $item->id }}" 
                                                data-category1="{{ $item->category_1 }}" 
                                                data-category2="{{ $item->category_2 }}" 
                                                data-category3="{{ $item->category_3 }}">
                                                {{ $item->item_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Order Type</label>
                                        <input type="text" class="form-control" name="order_type" placeholder="Enter Order Type" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" class="form-control" name="location" placeholder="Enter Location" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Bill No</label>
                                        <input type="text" class="form-control" name="bill_no" placeholder="Enter Bill No" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Vehicle No</label>
                                        <input type="text" class="form-control" name="vehicle_no" placeholder="Enter Vehicle No" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" placeholder="Enter Address" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control" name="quantity" placeholder="Enter Quantity" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <input type="text" class="form-control" name="unit" placeholder="Enter Unit" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Category 1</label>
                                        <input type="text" class="form-control" name="category_1" placeholder="Enter Category 1" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Category 2</label>
                                        <input type="text" class="form-control" name="category_2" placeholder="Enter Category 2" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Category 3</label>
                                        <input type="text" class="form-control" name="category_3" placeholder="Enter Category 3" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Order Date</label>
                                        <input type="date" class="form-control" name="order_date" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Delivery Date</label>
                                        <input type="date" class="form-control" name="delivery_date" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Close Date</label>
                                        <input type="date" class="form-control" name="close_date" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="remarks" placeholder="Enter Remarks"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Add Order</button>
                                        <a href="{{ route('order') }}" class="btn btn-default">Cancel</a>
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
        $("#item_id").select2({
            placeholder: "Select an item",
            allowClear: true,
            minimumResultsForSearch: 0,
            language: {
                noResults: function () {
                    return "No results found";
                }
            }
        });
        $("#item_id").on('select2:open', function () {
            let input = $('.select2-search__field');
            if (input.length) {
                input[0].focus();
            }
        });
                
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
    $(document).ready(function () {
        $("#item_id").change(function () {
            var selectedItem = $(this).find(":selected");

            var category1 = selectedItem.data("category1") || "";
            var category2 = selectedItem.data("category2") || "";
            var category3 = selectedItem.data("category3") || "";

            $("input[name='category_1']").val(category1);
            $("input[name='category_2']").val(category2);
            $("input[name='category_3']").val(category3);
        });
    });
</script>
<script>
    jQuery("#add_order").validate({
        ignore: [],
        rules: {
            customer_id: {
                required: true,
            },
            item_id: {
                required: true,
            },
        },
        messages: {
            customer_id: {
                required: 'Please select customer',
            },
            item_id: {
                required: 'Please enter name',
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.appendTo(element.parent().last());
        }
    });
</script>
@endsection
