@extends('Layouts.appadmin')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Check Book Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Check Book Management</li>
                </ol>
            </div>
        </div>
        <div class="text-right">
            <a class="" href="{{route('addcheckbook')}}" >
                <button type="button" class="btn bg-gradient-primary" >Add Check Book</button>
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
                        <li class="{{ ( $current_route == 'checkbook' ) ? 'active' : '' }}">
                            <a href="{{route('checkbook')}}" class="nav-link">Current Check Book</a>
                        </li>
                        <li class="{{ ( $current_route == 'pastcheckbook' ) ? 'active' : '' }}">
                            <a href="{{route('pastcheckbook')}}" class="nav-link active">Past Check Book</a>
                        </li>
                    </ul>
                    <div class="card-body">
                        <table id="email_datatable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Payee Name</th>
                                    <th>Checkbook No.</th>
                                    <th>Checkbook Date</th>
                                    <th>Amount</th>
                                    <th>Drop Date</th>
                                    <th>Clearing Date</th>
                                    <th>Return Date</th>
                                    <th>Due Date</th>
                                    <th>Receiver Name</th>
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
                url: user_path + 'getpastcheckbook',
                type: "GET",
            },
            "columns": [
                {"taregts": 0, 'data': 'id', "searchable": false, "orderable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"taregts": 1, 'data': 'payee_name'
                },
                {"taregts": 2, 'data': 'cheque_number'
                },
                {"taregts": 3, 'data': 'cheque_date',
                    "render": function (data, type, row) {
                        var cheque_date = row.cheque_date;
                        if(cheque_date != null){
                            return cheque_date;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 4, 'data': 'amount',
                    "render": function (data, type, row) {
                        var amount = row.amount;
                        if(amount != null){
                            return amount;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 5, 'data': 'drop_date',
                    "render": function (data, type, row) {
                        var drop_date = row.drop_date;
                        if(drop_date != null){
                            return drop_date;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 6, 'data': 'clearing_date',
                    "render": function (data, type, row) {
                        var clearing_date = row.clearing_date;
                        if(clearing_date != null){
                            return clearing_date;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 7, 'data': 'return_date',
                    "render": function (data, type, row) {
                        var return_date = row.return_date;
                        if(return_date != null){
                            return return_date;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 8, 'data': 'due_date',
                    "render": function (data, type, row) {
                        var due_date = row.due_date;
                        if(due_date != null){
                            return due_date;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 9, 'data': 'receiver_name',
                    "render": function (data, type, row) {
                        var receiver_name = row.receiver_name;
                        if(receiver_name != null){
                            return receiver_name;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"taregts": 10, 'data': 'created_at'
                },
                {"taregts": 11, "searchable": false, "orderable": false,
                    "render": function (data, type, row) {
                        var id = row.id;
                        var out = '';
                        out += '<a title="Edit " href="{{url("editcheckbook")}}/' + id + '" class="btn btn-primary waves-effect waves-light">Edit</a>&nbsp;&nbsp;&nbsp;';
                        out += '<button title="Delete CheckBook" class="btn btn-danger waves-effect waves-light" onClick="deleteCheckBook(' + id + ');">Delete</button>';
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
    
    function changecheckbookStatusModal(id) {
        $.ajax({
            url: user_path + 'changecheckbookstatus/' + id,
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
    function deleteCheckBook(id) {
        $.ajax({
            url: user_path + 'checkbookdeletemodal/' + id,
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
   
    
</script>
@endsection
