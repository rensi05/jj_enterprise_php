@extends('Layouts.appadmin')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Customers Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Customers Management</li>
                </ol>
            </div>
        </div>
        <div class="text-right">
            <a class="" href="{{route('addcustomer')}}" >
                <button type="button" class="btn bg-gradient-primary" >Add Customers</button>
            </a>
            <a class="" href="javascript:void(0)" >
                <button type="button" class="btn bg-gradient-primary" data-toggle="modal" data-target="#importCustomersModal">Import Customers</button>
            </a>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!--<div class="card-header">-->
                        <!--<h3 class="card-title">DataTable with minimal features & hover style</h3>-->
                    <!--</div>-->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="email_datatable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Customer Type</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>Type</th>
                                    <th>GST No</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
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

<!-- Import Customers Modal -->
<div id="importCustomersModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Customers</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('importcustomer') }}" id="customerImportForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Upload File</label>
                        <input type="file" name="customer_file" class="form-control">
                    </div>
                    <div class="form-group">
                        <a href="{{ asset('public/Sample/customers_sample.xlsx') }}" download>Download Sample</a>
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
                url: user_path + 'getcustomer',
                type: "GET",
            },
            "columns": [
                {"taregts": 0, 'data': 'id', "searchable": false, "orderable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"taregts": 1, 'data': 'customer_type'
                },
                {"taregts": 2, 'data': 'customer_name',
                    "render": function (data, type, row) {
                        var customer_name = row.customer_name;
                        var id = row.id;
                        if(customer_name != null){
                            return `<a title="Edit" href="{{ url('editcustomer') }}/${id}" class="">${customer_name}</a>&nbsp;&nbsp;&nbsp;`;
//                            return customer_name;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 3, 'data': 'location',
                    "render": function (data, type, row) {
                        var location = row.location;
                        if(location != null){
                            return location;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 4, 'data': 'country',
                    "render": function (data, type, row) {
                        var country = row.country;
                        if(country != null){
                            return country;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 5, 'data': 'state',
                    "render": function (data, type, row) {
                        var state = row.state;
                        if(state != null){
                            return state;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 6, 'data': 'type',
                    "render": function (data, type, row) {
                        var type = row.type;
                        if(type != null){
                            return type;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 7, 'data': 'gst_no',
                    "render": function (data, type, row) {
                        var gst_no = row.gst_no;
                        if(gst_no != null){
                            return gst_no;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 8, 'data': 'created_at'
                },
                {"taregts": 9, 'data': 'status', "searchable": false, "orderable": false,
                    "render": function (data, type, row) {
                        var status = row.status;
                        var id = row.id;
                        var out = '';
                        if (status == "active") {
                            out += '<button title="Active" class="btn btn-success waves-effect waves-light" onClick="changecustomerStatusModal(' + id + ')">Active</button>&nbsp;&nbsp;&nbsp;';
                        } else {
                            out += '<button title="Inactive" class="btn btn-danger waves-effect waves-light" onClick="changecustomerStatusModal(' + id + ')">Inactive</button>';
                        }
                        return out;
                    }
                },
                {"taregts": 10, "searchable": false, "orderable": false,
                    "render": function (data, type, row) {
                        var id = row.id;
                        var out = '';
                        out += '<a title="Edit " href="{{url("editcustomer")}}/' + id + '" class="btn btn-primary waves-effect waves-light">Edit</a>&nbsp;&nbsp;&nbsp;';
                        out += '<button title="Delete Customer" class="btn btn-danger waves-effect waves-light" onClick="deleteCustomer(' + id + ');">Delete</button>';
                        return out;
                    }
                },
                
            ]
        });
        table.on('draw', function () {
            table.columns.adjust().responsive.recalc();
        });
        $('#search').on('click', function () {
            table.draw();
        });
    });
    
    function changecustomerStatusModal(id) {
        $.ajax({
            url: user_path + 'changecustomerstatus/' + id,
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
    function deleteCustomer(id) {
        $.ajax({
            url: user_path + 'customerdeletemodal/' + id,
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
   
    jQuery("#customerImportForm").validate({
        ignore: [],
        rules: {
            customer_file: {
                required: true,
            },
        },
        messages: {
            customer_file: {
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
