@extends('Layouts.appadmin')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>JJ Reports</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('customerreport')}}">Customer Report</a></li>
                    <li class="breadcrumb-item active">View Customer Orders</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">  
                    <div class="card-body">
                        <div class="pro-main-info border-bottom pb-4">
                            @if(!empty($customer_detail))
                            <div class="pro-info-txt">
                                <b>Customer Name: </b> {{ $customer_detail['customer_name'] }}<br>
                            </div>
                            @endif
                        </div>
                        <div class="pro-ext-info mt-4">
                            <h3 class="mb-3">Customer Order(s)</h3>
                            <div class="row">
                                <div class="col-lg-12"> 
                                    <table id="email_datatable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sr No</th>
                                                <th>Order No.</th>
                                                <th>Item Name</th>
                                                <th>Address</th>
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
                                                <th>Location</th>
                                                <th>Bill No</th>
                                                <th>Vehicle No</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
            "responsive": true,
            "order": [[0, "DESC"]],
            "ajax": {
                url: "<?php echo route('getcustomerorder', !empty($customer_detail->id) ? $customer_detail->id : 0); ?>",
                type: "GET",
            },
            "columns": [
                {"taregts": 0, 'data': 'id', "searchable": false, "orderable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"taregts": 1, 'data': 'order_no'
                },
                {"taregts": 2, 'data': 'item_name',
                    "render": function (data, type, row) {
                        var item_name = row.item_name;
                        if (item_name != null) {
                            return item_name;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 3, 'data': 'address',
                    "render": function (data, type, row) {
                        var address = row.address;
                        if (address != null) {
                            return address;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 4, 'data': 'order_type',
                    "render": function (data, type, row) {
                        var order_type = row.order_type;
                        if (order_type != null) {
                            return order_type;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 5, 'data': 'category_1',
                    "render": function (data, type, row) {
                        var category_1 = row.category_1;
                        if (category_1 != null) {
                            return category_1;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 6, 'data': 'category_2',
                    "render": function (data, type, row) {
                        var category_2 = row.category_2;
                        if (category_2 != null) {
                            return category_2;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 7, 'data': 'category_3',
                    "render": function (data, type, row) {
                        var category_3 = row.category_3;
                        if (category_3 != null) {
                            return category_3;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 8, 'data': 'quantity',
                    "render": function (data, type, row) {
                        var quantity = row.quantity;
                        if (quantity != null) {
                            return quantity;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 9, 'data': 'name',
                    "render": function (data, type, row) {
                        var name = row.name;
                        if (name != null) {
                            return name;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 10, 'data': 'order_date',
                    "render": function (data, type, row) {
                        var order_date = row.order_date;
                        if (order_date != null) {
                            return order_date;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 11, 'data': 'delivery_date',
                    "render": function (data, type, row) {
                        var delivery_date = row.delivery_date;
                        if (delivery_date != null) {
                            return delivery_date;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 12, 'data': 'close_date',
                    "render": function (data, type, row) {
                        var close_date = row.close_date;
                        if (close_date != null) {
                            return close_date;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 13, 'data': 'remarks',
                    "render": function (data, type, row) {
                        var remarks = row.remarks;
                        if (remarks != null) {
                            return remarks;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 14, 'data': 'location',
                    "render": function (data, type, row) {
                        var location = row.location;
                        if (location != null) {
                            return location;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 15, 'data': 'bill_no',
                    "render": function (data, type, row) {
                        var bill_no = row.bill_no;
                        if (bill_no != null) {
                            return bill_no;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 16, 'data': 'vehicle_no',
                    "render": function (data, type, row) {
                        var vehicle_no = row.vehicle_no;
                        if (vehicle_no != null) {
                            return vehicle_no;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 17, 'data': 'status',
                    "render": function (data, type, row) {
                        var status = row.status;
                        if (status != null) {
                            return status;
                        } else {
                            return '-';
                        }
                    }
                },
                {"taregts": 18, 'data': 'created_at'
                },
            ]
        });
        $('#search').on('click', function () {
            table.draw();
        });
    });
</script>
@endsection
