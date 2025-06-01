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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Order Type</label>
                                        <input type="text" class="form-control" name="order_type" value="{{ $order_detail->order_type }}" placeholder="Enter Order Type" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Address</label>
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ $order_detail->address }}" placeholder="Enter Address" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Order Date*</label>
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
                            </div>
                            <div id="item-section-wrapper">
                                @if(!$order_detail->items->isEmpty())
                                    @foreach($order_detail->items as $key => $orderItem)
                                    <div class="item-section row p-3 mb-3 border rounded bg-light">
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="form-group">
                                                <label>Item*</label>
                                                <select class="form-control select2 item_id" name="item_id[]">
                                                    <option value="">Select Item</option>
                                                    @foreach($items as $item)
                                                    <option value="{{ $item->id }}"
                                                            data-category1="{{ $item->category_1 }}"
                                                            data-category2="{{ $item->category_2 }}"
                                                            data-category3="{{ $item->category_3 }}"
                                                            {{ $item->id == $orderItem->item_id ? 'selected' : '' }}>
                                                        {{ $item->item_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="form-group">
                                                <label>Total Qty</label>
                                                <input type="text" class="form-control qty-field total-qty" name="quantity[]" value="{{ $orderItem->quantity }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="form-group">
                                                <label>Used Qty</label>
                                                <input type="text" class="form-control qty-field used-qty" name="used_qty[]" value="{{ $orderItem->used_qty }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="form-group">
                                                <label>Remaining Qty</label>
                                                <input type="text" class="form-control qty-field remaining-qty" name="remaining_qty[]" value="{{ $orderItem->remaining_qty }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="form-group">
                                                <label>Unit</label>
                                                <select class="form-control select2" name="unit_id[]">
                                                    <option value="">Select Unit</option>
                                                    @foreach($units as $unit)
                                                    <option value="{{ $unit->id }}" {{ $unit->id == $orderItem->unit_id ? 'selected' : '' }}>
                                                        {{ $unit->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="form-group">
                                                <label>Category 1</label>
                                                <select class="form-control select2 category_1" name="category_1[]">
                                                    @if($orderItem->category_1)
                                                    <option selected value="{{ $orderItem->category_1 }}">{{ $orderItem->category_1 }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="form-group">
                                                <label>Category 2</label>
                                                <select class="form-control select2 category_2" name="category_2[]">
                                                    @if($orderItem->category_2)
                                                    <option selected value="{{ $orderItem->category_2 }}">{{ $orderItem->category_2 }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="form-group">
                                                <label>Category 3</label>
                                                <select class="form-control select2 category_3" name="category_3[]">
                                                    @if($orderItem->category_3)
                                                    <option selected value="{{ $orderItem->category_3 }}">{{ $orderItem->category_3 }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-sm-2">
                                            <div class="form-group">
                                                @if($key == 0)
                                                    <button type="button" class="btn btn-success add-more"><i class="fas fa-plus"></i></button>
                                                @else
                                                    <button type="button" class="btn btn-danger remove-section"><i class="fas fa-minus"></i></button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
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
                                @endif
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
    $(document).on('input', '.qty-field', function () {
        let val = $(this).val();
        val = val.replace(/[^0-9]/g, '');
        $(this).val(val);

//        let section = $(this).closest('.row');
        let section = $(this).closest('.item-section');

        let total = parseFloat(section.find('.total-qty').val()) || 0;
        let used = parseFloat(section.find('.used-qty').val()) || 0;
        let remaining = parseFloat(section.find('.remaining-qty').val()) || 0;

        let changedField = $(this).hasClass('total-qty') ? 'total' :
                           $(this).hasClass('used-qty') ? 'used' : 'remaining';

        if (changedField === 'total') {
            // Adjust remaining based on current used
            section.find('.remaining-qty').val((total - used));
        } else if (changedField === 'used') {
            section.find('.remaining-qty').val((total - used));
        } else if (changedField === 'remaining') {
            section.find('.used-qty').val((total - remaining));
        }
    });
</script>
<script>    
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

    // Initialize Item select2
    function initializeSelect2($element) {
        $element.select2({
            placeholder: "Select an item",
            allowClear: true,
            width: '100%',
            minimumResultsForSearch: 0,
            matcher: function(params, data) {
                if ($.trim(params.term) === '') return data;
                let term = params.term.toLowerCase().replace(/[\s.\-]/g, '');
                let text = (data.text || '').toLowerCase().replace(/[\s.\-]/g, '');
                return text.indexOf(term) > -1 ? data : null;
            },
            language: {
                noResults: () => "No results found"
            }
        }).on('select2:open', function () {
            let input = $('.select2-search__field');
            if (input.length) input[0].focus();
        });
    }

    initializeSelect2($('.item_id'));
    initializeSelect2($('.category_1'));
    initializeSelect2($('.category_2'));
    initializeSelect2($('.category_3'));
    initializeSelect2($('.unit_id'));
    
    $(document).on('click', '.add-more', function () {
        let wrapper = $('#item-section-wrapper');
        let firstSection = wrapper.find('.item-section').first();
        let clone = firstSection.clone();

        // Clear inputs
        clone.find('input').val('');
        clone.find('select').val('').trigger('change');

        // Remove previous Select2 DOM wrappers
        clone.find('.select2-container').remove();

        // Remove select2 from cloned selects to reapply later
        clone.find('select').removeClass('select2-hidden-accessible').removeAttr('data-select2-id').show();

        // Change '+' to '-' and class
        clone.find('.add-more')
            .removeClass('btn-success add-more')
            .addClass('btn-danger remove-section')
            .html('<i class="fas fa-minus"></i>');

        // Append the clone
        wrapper.append(clone);

        // Reinitialize Select2 on new selects
        initializeSelect2(clone.find('.item_id'));
        initializeSelect2(clone.find('.category_1'));
        initializeSelect2(clone.find('.category_2'));
        initializeSelect2(clone.find('.category_3'));
        initializeSelect2(clone.find('.unit_id'));
    });

    $(document).on('click', '.remove-section', function () {
        $(this).closest('.item-section').remove();
    });

    $(document).ready(function () {
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
    jQuery("#edit_order").validate({
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
@endsection
