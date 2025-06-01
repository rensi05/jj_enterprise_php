@extends('Layouts.appadmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-6">
                <h1 class="m-0 text-dark"><a href="{{route('item')}}"><img class="back-ic" src="{{ asset('public/admin/images/back-arrow.svg')}}"></a> Add Item</h1>
            </div>
            <div class="col-lg-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('item')}}">Item Management</a></li>
                    <li class="breadcrumb-item active">Add Items</li>
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
                    <form method="post" id="add_item" name="add_item" action="{{route('saveitem')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Item Name*</label>
                                        <input type="text" class="form-control" name="item_name" placeholder="Enter Item Name" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Quantity 1</label>
                                        <input type="number" class="form-control" name="quantity" placeholder="Enter Quantity" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Unit 1</label>
                                        <input type="text" class="form-control" name="unit" placeholder="Enter Unit" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Quantity 2</label>
                                        <input type="number" class="form-control" name="quantity_1" placeholder="Enter Quantity" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Unit 2</label>
                                        <input type="text" class="form-control" name="unit_1" placeholder="Enter Unit" />
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="location" placeholder="Enter Location" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label>Categories</label>
                                    <div id="category-wrapper">
                                        <div class="row category-row mb-2">
                                            <div class="col-md-4">
                                                <input type="text" name="category_1[]" class="form-control" placeholder="Enter Category 1" />
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="category_2[]" class="form-control" placeholder="Enter Category 2" />
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="category_3[]" class="form-control" placeholder="Enter Category 3" />
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-success btn-sm add-category"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
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
                                        <button type="submit" class="btn btn-primary">Add</button>
                                        <a href="{{route('item')}}" class="btn btn-default">Cancel</a>
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
<!--<script>
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
</script>-->
<script>
$(document).ready(function () {
    $('#category-wrapper').on('click', '.add-category', function () {
        let row = `<div class="row category-row mb-2">
            <div class="col-md-4">
                <input type="text" name="category_1[]" class="form-control" placeholder="Enter Category 1" />
            </div>
            <div class="col-md-4">
                <input type="text" name="category_2[]" class="form-control" placeholder="Enter Category 2" />
            </div>
            <div class="col-md-3">
                <input type="text" name="category_3[]" class="form-control" placeholder="Enter Category 3" />
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-category"><i class="fas fa-minus"></i></button>
            </div>
        </div>`;
        $('#category-wrapper').append(row);
    });

    $('#category-wrapper').on('click', '.remove-category', function () {
        $(this).closest('.category-row').remove();
    });
});
</script>

<script>
    jQuery("#add_item").validate({
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
