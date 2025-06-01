@extends('Layouts.appadmin')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Orders Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Orders Management</li>
                </ol>
            </div>
        </div>
        <div class="text-right">
            <a class="" href="{{route('addorder')}}" >
                <button type="button" class="btn bg-gradient-primary" >Add Orders</button>
            </a>
            <a class="" href="javascript:void(0)" >
                <button type="button" class="btn bg-gradient-primary" data-toggle="modal" data-target="#importCustomersModal">Import Order</button>
            </a>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">                    
                    @php($current_route = Route::currentRouteName())
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="{{ ( $current_route == 'order' ) ? 'active' : '' }}">
                            <a href="{{route('order')}}" class="nav-link active">Current Order</a>
                        </li>
                        <li class="{{ ( $current_route == 'pastorder' ) ? 'active' : '' }}">
                            <a href="{{route('pastorder')}}" class="nav-link">Past Order</a>
                        </li>
                    </ul>
                    <div class="card-body">
                        <table id="email_datatable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Order No.</th>
                                    <th>Customer Name</th>
                                    <th>Item Name</th>
                                    <!--<th>Address</th>-->
                                    <th>Order Type</th>
                                    <th>Category 1</th>
                                    <th>Category 2</th>
                                    <th>Category 3</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Order Date</th>
                                    <th>Delivery Date</th>
                                    <th>Close Date</th>
                                    <th>Remarks</th>
                                    <th>Bill No</th>
                                    <th>Vehicle No</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Delete modal start -->
<div id="changeStatus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="modal_content">
        </div>
    </div>
</div>
<div id="deleteModal" class="modal fade popup-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="delete_modal_content">
        </div>
    </div>
</div>
<!-- Delete Modal End -->
<div id="importCustomersModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Orders</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('importorder') }}" id="orderImportForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Upload File</label>
                        <input type="file" name="order_file" class="form-control">
                    </div>
                    <div class="form-group">
                        <a href="{{ asset('public/Sample/orders_sample.xlsx') }}" download>Download Sample</a>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Import</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Discard</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    var user_path = "{{ env('APP_URL') }}";
    var table;
    $(document).ready(function () {

        alertify.set('notifier', 'position', 'top-right');
        table = jQuery('#email_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": false,
            "scrollX": true,
            "autoWidth": false,
            "order": [[0, "DESC"]],
            "ajax": {
                url: user_path + 'getorder',
                type: "GET",
            },
            "columns": [
                {"taregts": 0, 'data': 'id', "searchable": false, "orderable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"taregts": 1, 'data': 'order_no',
                    "render": function (data, type, row) {
                        var order_no = row.order_no;
                        var id = row.id;
                        if(order_no != null){
                            return `<a title="Edit" href="{{ url('editorder') }}/${id}" class="">${order_no}</a>&nbsp;&nbsp;&nbsp;`;
//                            return order_no;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 2, 'data': 'customer_name',
                    "render": function (data, type, row) {
                        var customer_name = row.customer_name;
                        if(customer_name != null){
                            return customer_name;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 3, 'data': 'item_name',
                    "render": function (data, type, row) {
                        var item_name = row.item_name;
                        if(item_name != null){
                            return item_name;
                        } else {
                            return '-';                            
                        }
                    }
                },
//                {"taregts": 4, 'data': 'address',
//                    "render": function (data, type, row) {
//                        var address = row.address;
//                        if(address != null){
//                            return address;
//                        } else {
//                            return '-';                            
//                        }
//                    }
//                },
                {"taregts": 5, 'data': 'order_type',
                    "render": function (data, type, row) {
                        var order_type = row.order_type;
                        if(order_type != null){
                            return order_type;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 6, 'data': 'category_1',
                    "render": function (data, type, row) {
                        var category_1 = row.category_1;
                        if(category_1 != null){
                            return category_1;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 7, 'data': 'category_2',
                    "render": function (data, type, row) {
                        var category_2 = row.category_2;
                        if(category_2 != null){
                            return category_2;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 8, 'data': 'category_3',
                    "render": function (data, type, row) {
                        var category_3 = row.category_3;
                        if(category_3 != null){
                            return category_3;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 9, 'data': 'quantity',
                    "render": function (data, type, row) {
                        var quantity = row.quantity;
                        if(quantity != null){
                            return quantity;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 10, 'data': 'name',
                    "render": function (data, type, row) {
                        var name = row.name;
                        if(name != null){
                            return name;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 11, 'data': 'order_date',
                    "render": function (data, type, row) {
                        var order_date = row.order_date;
                        if(order_date != null){
                            return order_date;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 12, 'data': 'delivery_date',
                    "render": function (data, type, row) {
                        var delivery_date = row.delivery_date;
                        if(delivery_date != null){
                            return delivery_date;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 13, 'data': 'close_date',
                    "render": function (data, type, row) {
                        var close_date = row.close_date;
                        if(close_date != null){
                            return close_date;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 14, 'data': 'remarks',
                    "render": function (data, type, row) {
                        var remarks = row.remarks;
                        if(remarks != null){
                            return remarks;
                        } else {
                            return '-';                            
                        }
                    }
                },
//                {"taregts": 15, 'data': 'location',
//                    "render": function (data, type, row) {
//                        var location = row.location;
//                        if(location != null){
//                            return location;
//                        } else {
//                            return '-';                            
//                        }
//                    }
//                },
                {"taregts": 16, 'data': 'bill_no',
                    "render": function (data, type, row) {
                        var bill_no = row.bill_no;
                        if(bill_no != null){
                            return bill_no;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 17, 'data': 'vehicle_no',
                    "render": function (data, type, row) {
                        var vehicle_no = row.vehicle_no;
                        if(vehicle_no != null){
                            return vehicle_no;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 18, 'data': 'status',
                    "render": function (data, type, row) {
                        var status = row.status;
                        if(status != null){
                            return status;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 19, 'data': 'created_at'
                },
                {"taregts": 20, "searchable": false, "orderable": false,
                    "render": function (data, type, row) {
                        var id = row.id;
                        var out = '';
                        out += '<a title="Edit " href="{{url("editorder")}}/' + id + '" class="btn btn-primary waves-effect waves-light">Edit</a>&nbsp;&nbsp;&nbsp;';
                        out += '<button title="Delete Order" class="btn btn-danger waves-effect waves-light" onClick="deleteOrder(' + id + ');">Delete</button>';
                        return out;
                    }
                },
                
            ]
        });
        $('#search').on('click', function () {
            table.draw();
        });
        table.on('draw', function () {
            table.columns.adjust().responsive.recalc();
        });
    });
    
    function changeorderStatusModal(id) {
        $.ajax({
            url: user_path + 'changeorderstatus/' + id,
            success: function (response) {
                if (response.status == 'success') {
                    $('#modal_content').html(response.html);
                    $('#changeStatus').modal('show');
                } else {
                    var notification = alertify.notify(response.message, 'error', 6);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var notification = alertify.notify(errorThrown, 'error', 6);
                console.log("Edit Modal AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }
    function deleteOrder(id) {
        $.ajax({
            url: user_path + 'orderdeletemodal/' + id,
            success: function (response) {
                if (response.status == 'success') {
                    $('#delete_modal_content').html(response.html);
                    $('#deleteModal').modal('show');
                } else {
                    var notification = alertify.notify(response.message, 'error', 3);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var notification = alertify.notify(errorThrown, 'error', 3);
                console.log("Delete AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }
   
    jQuery("#orderImportForm").validate({
        ignore: [],
        rules: {
            order_file: {
                required: true,
            },
        },
        messages: {
            order_file: {
                required: 'Please select file',
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.appendTo(element.parent().last());
        }
    });
</script>
@endsection
