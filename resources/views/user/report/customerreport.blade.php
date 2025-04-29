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
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="email_datatable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Customer Name</th>
                                    <th>Total Orders</th>
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
                url: user_path + 'getcustomerreport',
                type: "GET",
            },
            "columns": [
                {"taregts": 0, 'data': 'id', "searchable": false, "orderable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"taregts": 1, 'data': 'customer_name',
                    "render": function (data, type, row) {
                        var customer_name = row.customer_name;
                        if(customer_name != null){
                            return customer_name;
                        } else {
                            return '-';                            
                        }
                    }
                },
                {"targets": 2, 'data': 'total_orders',
                    "render": function (data, type, row) {
                        return row.total_orders ? row.total_orders : 0;
                    }
                },
                {"taregts": 3, "searchable": false, "orderable": false,
                    "render": function (data, type, row) {
                        var id = row.id;
                        var out = '';
                        out += '<a title="View Customer Report" href="{{url("viewcustomerreport")}}/' + id + '" class="btn btn-success waves-effect waves-light">View</a>&nbsp;&nbsp;&nbsp;';
                        return out;
                    }
                },
                
            ]
        });
        $('#search').on('click', function () {
            table.draw();
        });
    });
   
    
</script>
@endsection
