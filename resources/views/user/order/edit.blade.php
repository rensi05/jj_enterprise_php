@extends('Layouts.appadmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-6">
                <h1 class="m-0 text-dark"><a href="{{route('order')}}"><img class="back-ic" src="{{ asset('public/admin/images/back-arrow.svg')}}"></a> Edit Order</h1>
            </div>
            <div class="col-lg-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('order')}}">Orders Management</a></li>
                    <li class="breadcrumb-item active">Edit Order</li>
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
                    <form method="post" id="edit_order" name="edit_order" action="{{route('updateorder')}}" enctype="multipart/form-data">
                        <input type="hidden" name="order_id" value="{{base64_encode($order_detail->id)}}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <select class="form-control select2" id="customer_id" name="customer_id">
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                            <option data-address="{{ $customer->location }}" value="{{ $customer->id }}" {{ $customer->id == $order_detail->customer_id ? 'selected' : '' }}>
                                                {{ $customer->customer_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Item</label>
                                        <select class="form-control select2" id="item_id" name="item_id">
                                            <option value="">Select Item</option>
                                            @foreach($items as $item)
                                            <option value="{{ $item->id }}"
                                                data-category1="{{ $item->category_1 }}" 
                                                data-category2="{{ $item->category_2 }}" 
                                                data-category3="{{ $item->category_3 }}"
                                                {{ $item->id == $order_detail->item_id ? 'selected' : '' }}>
                                                {{ $item->item_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Order Type</label>
                                        <input type="text" class="form-control" name="order_type" value="{{ $order_detail->order_type }}" placeholder="Enter Order Type" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" class="form-control" name="location" value="{{ $order_detail->location }}" placeholder="Enter Location" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Bill No</label>
                                        <input type="text" class="form-control" name="bill_no" value="{{ $order_detail->bill_no }}" placeholder="Enter Bill No" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Vehicle No</label>
                                        <input type="text" class="form-control" name="vehicle_no" value="{{ $order_detail->vehicle_no }}" placeholder="Enter Vehicle No" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ $order_detail->address }}" placeholder="Enter Address" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control" name="quantity" value="{{ $order_detail->quantity }}" placeholder="Enter Quantity" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <input type="text" class="form-control" name="unit" value="{{ $order_detail->unit }}" placeholder="Enter Unit" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Category 1</label>
                                        <select name="category_1" id="category_1" class="form-control select2">
                                            <option value="">Select Category 1</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Category 2</label>
                                        <select name="category_2" id="category_2" class="form-control select2">
                                            <option value="">Select Category 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Category 3</label>
                                        <select name="category_3" id="category_3" class="form-control select2">
                                            <option value="">Select Category 3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Order Date</label>
                                        <input type="date" class="form-control" name="order_date" value="{{ $order_detail->order_date }}" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Delivery Date</label>
                                        <input type="date" class="form-control" name="delivery_date" value="{{ $order_detail->delivery_date }}" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Close Date</label>
                                        <input type="date" class="form-control" name="close_date" value="{{ $order_detail->close_date }}" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="remarks" placeholder="Enter Remarks">{{ $order_detail->remarks }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"> Update </button>
                                        <a href="{{route('order')}}" class="btn btn-default"> Cancel </a>
                                    </div>
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
    $('#customer_id').change(function () {
        let selectedOption = $(this).find('option:selected');
        let address = selectedOption.data('address');
        $('input[name="address"]').val(address);
    });
</script>
<script>
    $(document).ready(function () {
        // Select2 for item selection
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
        
        // Handle the item category change
        $('#item_id').change(function () {
            let itemId = $(this).val();
            
            // Reset category dropdowns
            $('#category_1').empty().append('<option value="">Select Category 1</option>');
            $('#category_2').empty().append('<option value="">Select Category 2</option>');
            $('#category_3').empty().append('<option value="">Select Category 3</option>');
            
            if (itemId) {
                $.ajax({
                    url: "{{ route('getitemcategories') }}",
                    type: "GET",
                    data: { item_id: itemId },
                    success: function (res) {
                        res.category1.forEach(cat => {
                            $('#category_1').append(`<option value="${cat}">${cat}</option>`);
                        });
                        res.category2.forEach(cat => {
                            $('#category_2').append(`<option value="${cat}">${cat}</option>`);
                        });
                        res.category3.forEach(cat => {
                            $('#category_3').append(`<option value="${cat}">${cat}</option>`);
                        });
                        
                        // Pre-select categories if the order has categories
                        if ('{{ $order_detail->category_1 }}') {
                            $('#category_1').val('{{ $order_detail->category_1 }}').trigger('change');
                        }
                        if ('{{ $order_detail->category_2 }}') {
                            $('#category_2').val('{{ $order_detail->category_2 }}').trigger('change');
                        }
                        if ('{{ $order_detail->category_3 }}') {
                            $('#category_3').val('{{ $order_detail->category_3 }}').trigger('change');
                        }
                    }
                });
            }
        });
        
        // Initialize the categories based on the selected item
        if ("{{ $order_detail->item_id }}") {
            $('#item_id').val("{{ $order_detail->item_id }}").trigger('change');
        }
    });
</script>
<script>
    $(document).ready(function () {
        function updateCategoryFields() {
            var selectedItem = $("#item_id").find(":selected");

            var category1 = selectedItem.data("category1") || "";
            var category2 = selectedItem.data("category2") || "";
            var category3 = selectedItem.data("category3") || "";

            $("input[name='category_1']").val(category1);
            $("input[name='category_2']").val(category2);
            $("input[name='category_3']").val(category3);
        }

        updateCategoryFields();

        $("#item_id").change(function () {
            updateCategoryFields();
        });
    });
</script>
<script>
    jQuery("#edit_order").validate({
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
