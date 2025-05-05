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
                                            <option value="add_new" class="add-new-option">+ Add New Customer</option>
                                            @foreach($customers as $customer)
                                            <option data-address="{{ $customer->location }}" value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
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
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" placeholder="Enter Address" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Order Date*</label>
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
                            </div>
                            <div id="item-section-wrapper">
                                <div class="item-section row border rounded p-3 mb-3 bg-light">
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="form-group">
                                            <label>Item*</label>
                                            <select class="form-control select2 item_id" name="item_id[]">
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
                                    <div class="col-lg-2 col-sm-4">
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control" name="quantity[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-4">
                                        <div class="form-group">
                                            <label>Unit</label>
                                            <select class="form-control select2" name="unit_id[]">
                                                <option value="">Select Unit</option>
                                                @foreach($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-4">
                                        <div class="form-group">
                                            <label>Category 1</label>
                                            <select class="form-control select2 category_1" name="category_1[]"></select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-4">
                                        <div class="form-group">
                                            <label>Category 2</label>
                                            <select class="form-control select2 category_2" name="category_2[]"></select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-4">
                                        <div class="form-group">
                                            <label>Category 3</label>
                                            <select class="form-control select2 category_3" name="category_3[]"></select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-sm-2 mt-2">
                                        <div class="form-group">
                                            <label></label>
                                            <button type="button" class="btn btn-success add-more"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Add Order</button>
                                        <a href="{{ route('order') }}" class="btn btn-default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{ route('saveordercustomer') }}" id="add_customer_form">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Customer</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label>Customer Type*</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="customer_type" value="purchase" id="typePurchase" checked>
                                <label class="form-check-label" for="typePurchase">Purchase</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="customer_type" value="sales" id="typeSales">
                                <label class="form-check-label" for="typeSales">Sales</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Customer Name*</label>
                        <input type="text" class="form-control" name="customer_name" placeholder="Enter Customer Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Location</label>
                        <input type="text" class="form-control" name="location" placeholder="Enter Location">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Country</label>
                        <input type="text" class="form-control" name="country" placeholder="Enter Country">
                    </div>
                    <div class="form-group col-md-6">
                        <label>State</label>
                        <input type="text" class="form-control" name="state" placeholder="Enter State">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Type</label>
                        <input type="text" class="form-control" name="type" placeholder="Enter Type">
                    </div>
                    <div class="form-group col-md-6">
                        <label>GST No</label>
                        <input type="text" class="form-control" name="gst_no" placeholder="Enter GST No">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group" style="">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn" data-dismiss="modal" style="padding: 10px 40px; border-radius: 8px; border: 1px solid black; background: white; color: black;">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('javascript')
<script>
    $(document).on('click', '.add-more', function () {
        let wrapper = $('#item-section-wrapper');
        let clone = wrapper.find('.item-section').first().clone();

        // Clear inputs
        clone.find('input').val('');
        clone.find('select').val('');

        // Remove any existing Select2 containers
        clone.find('select').each(function () {
            if ($(this).hasClass("select2-hidden-accessible")) {
                $(this).select2('destroy');
            }
        });

        // Change '+' to '-' and class
        clone.find('.add-more')
            .removeClass('btn-success add-more')
            .addClass('btn-danger remove-section')
            .html('<i class="fas fa-minus"></i>');

        // Append the clone
        wrapper.append(clone);

        // Initialize Select2 only on the newly appended selects
        clone.find('select.select2').select2();
    });

    $(document).on('click', '.remove-section', function () {
        $(this).closest('.item-section').remove();
    });

    $(document).ready(function () {
        function customMatcher(params, data) {
            if ($.trim(params.term) === '') {
                return data;
            }

            let term = params.term.toLowerCase().replace(/[\s.\-]/g, '');
            let text = (data.text || '').toLowerCase().replace(/[\s.\-]/g, '');

            if (text.indexOf(term) > -1) {
                return data;
            }

            return null;
        }

        // Initialize Customer select2
        $("#customer_id").select2({
            placeholder: "Select a customer",
            allowClear: true,
            minimumResultsForSearch: 0,
            matcher: customMatcher,
            language: {
                noResults: function () {
                    return "No results found";
                }
            }
        }).on('select2:open', function () {
            let input = $('.select2-search__field');
            if (input.length) {
                input[0].focus();
            }
        });

        // Initialize Item select2
        $("#item_id").select2({
            placeholder: "Select an item",
            allowClear: true,
            minimumResultsForSearch: 0,
            matcher: customMatcher,
            language: {
                noResults: function () {
                    return "No results found";
                }
            }
        }).on('select2:open', function () {
            let input = $('.select2-search__field');
            if (input.length) {
                input[0].focus();
            }
        });

        // Auto-fill address when customer changes
        $('#customer_id').change(function () {
            let selectedOption = $(this).find('option:selected');
            let address = selectedOption.data('address');
            $('input[name="address"]').val(address);
        });

        // Fetch categories when item changes
        $(document).on('change', '.item_id', function () {
            let itemId = $(this).val();
            let section = $(this).closest('.item-section');

            let cat1Select = section.find('.category_1');
            let cat2Select = section.find('.category_2');
            let cat3Select = section.find('.category_3');

            cat1Select.empty().append('<option value="">Select Category 1</option>');
            cat2Select.empty().append('<option value="">Select Category 2</option>');
            cat3Select.empty().append('<option value="">Select Category 3</option>');

            if (itemId) {
                $.ajax({
                    url: "{{ route('getitemcategory1') }}",
                    type: "GET",
                    data: { item_id: itemId },
                    success: function (res) {
                        res.category1.forEach(function (cat) {
                            cat1Select.append(`<option value="${cat}">${cat}</option>`);
                        });
                    }
                });
            }
        });

        $(document).on('change', '.category_1', function () {
            let category1 = $(this).val();
            let section = $(this).closest('.item-section');
            let itemId = section.find('.item_id').val();

            let cat2Select = section.find('.category_2');
            let cat3Select = section.find('.category_3');

            cat2Select.empty().append('<option value="">Select Category 2</option>');
            cat3Select.empty().append('<option value="">Select Category 3</option>');

            if (itemId && category1) {
                $.ajax({
                    url: "{{ route('getitemcategory2and3') }}",
                    type: "GET",
                    data: { item_id: itemId, category_1: category1 },
                    success: function (res) {
                        res.category2.forEach(function (cat) {
                            cat2Select.append(`<option value="${cat}">${cat}</option>`);
                        });
                        res.category3.forEach(function (cat) {
                            cat3Select.append(`<option value="${cat}">${cat}</option>`);
                        });
                    }
                });
            }
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
            order_date: {
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
            order_date: {
                required: 'Please select order date',
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.appendTo(element.parent().last());
        }
    });
</script>
<script>
    $(document).on('change', '#customer_id', function () {
        if ($(this).val() === 'add_new') {
            // Reset the form and show modal
            $('#add_customer_form')[0].reset();
            $('#addCustomerModal').modal('show');
            $(this).val(null).trigger('change'); // Reset select2 selection
        } else {
            let selectedOption = $(this).find('option:selected');
            let address = selectedOption.data('address');
            $('input[name="address"]').val(address);
        }
    });

    
    $('#add_customer_form').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('saveordercustomer') }}", // You will create this route
            method: 'POST',
            data: formData + '&_token={{ csrf_token() }}',
            success: function (res) {
                console.log(res);
                if (res.status == 'success') {
                    let newOption = new Option(res.data.customer_name, res.data.id, true, true);
                    $('#customer_id').append(newOption).trigger('change');
                    $('#addCustomerModal').modal('hide');
                    $('#add_customer_form')[0].reset();
                    $('input[name="address"]').val(res.data.location);
                }
            },
            error: function (err) {
//                alert("Error saving customer. Please check required fields.");
            }
        });
    });
</script>
<script>
    jQuery("#add_customer_form").validate({
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
