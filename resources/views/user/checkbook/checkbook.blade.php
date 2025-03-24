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
                    <!--<div class="card-header">-->
                        <!--<h3 class="card-title">DataTable with minimal features & hover style</h3>-->
                    <!--</div>-->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="email_datatable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Payee Name</th>
                                    <th>Checkbook No.</th>
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
            "responsive": true,
            "order": [[0, "DESC"]],
            "ajax": {
                url: user_path + 'getcheckbook',
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
                {"taregts": 3, 'data': 'created_at'
                },
                {"taregts": 4, "searchable": false, "orderable": false,
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
