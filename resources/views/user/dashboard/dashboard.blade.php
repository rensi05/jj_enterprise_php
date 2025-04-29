@extends('Layouts.appadmin')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">AIR BUBBLE ROLL 1 MTR</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="email_datatable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Gauge</th>
                                    <th>Weight</th>
                                    <th>Pending Order</th>
                                    <th>Completed Order</th>
                                    <th>Total Order</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">BOPP TAP</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="second_datatable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Gauge</th>
                                    <th>Weight</th>
                                    <th>Pending Order</th>
                                    <th>Completed Order</th>
                                    <th>Total Order</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">STRETCH FILM ROLL</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="third_datatable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Gauge</th>
                                    <th>Weight</th>
                                    <th>Pending Order</th>
                                    <th>Completed Order</th>
                                    <th>Total Order</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">EPE FOAM ROLL</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="fourth_datatable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Gauge</th>
                                    <th>Weight</th>
                                    <th>Pending Order</th>
                                    <th>Completed Order</th>
                                    <th>Total Order</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Other Item</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="other_datatable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Item Name</th>
                                    <th>Gauge</th>
                                    <th>Weight</th>
                                    <th>Pending Order</th>
                                    <th>Completed Order</th>
                                    <th>Total Order</th>
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
                url: "{{ route('getfirstitem', ['item_name' => 'AIR BUBBLE ROLL 1 MTR']) }}",
                type: "GET",
            },
            "columns": [
                {"taregts": 0, 'data': 'id', "searchable": false, "orderable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"taregts": 1, 'data': 'category_1'
                },
                {"taregts": 2, 'data': 'category_2'
                },
                {"taregts": 3, 'data': 'pending_order'
                },
                {"taregts": 4, 'data': 'completed_order'
                },
                {"taregts": 5, 'data': 'total_order'
                },
            ]
        });
        $('#search').on('click', function () {
            table.draw();
        });
        
        table2 = jQuery('#second_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [[0, "DESC"]],
            "ajax": {
                url: "{{ route('getfirstitem', ['item_name' => 'BOPP TAP']) }}",
                type: "GET",
            },
            "columns": [
                {"taregts": 0, 'data': 'id', "searchable": false, "orderable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"taregts": 1, 'data': 'category_1'
                },
                {"taregts": 2, 'data': 'category_2'
                },
                {"taregts": 3, 'data': 'pending_order'
                },
                {"taregts": 4, 'data': 'completed_order'
                },
                {"taregts": 5, 'data': 'total_order'
                },
            ]
        });
        $('#search').on('click', function () {
            table2.draw();
        });
        
        table3 = jQuery('#third_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [[0, "DESC"]],
            "ajax": {
                url: "{{ route('getfirstitem', ['item_name' => 'STRETCH FILM ROLL']) }}",
                type: "GET",
            },
            "columns": [
                {"taregts": 0, 'data': 'id', "searchable": false, "orderable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"taregts": 1, 'data': 'category_1'
                },
                {"taregts": 2, 'data': 'category_2'
                },
                {"taregts": 3, 'data': 'pending_order'
                },
                {"taregts": 4, 'data': 'completed_order'
                },
                {"taregts": 5, 'data': 'total_order'
                },
            ]
        });
        $('#search').on('click', function () {
            table3.draw();
        });
        
        table4 = jQuery('#fourth_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [[0, "DESC"]],
            "ajax": {
                url: "{{ route('getfirstitem', ['item_name' => 'EPE FOAM ROLL']) }}",
                type: "GET",
            },
            "columns": [
                {"taregts": 0, 'data': 'id', "searchable": false, "orderable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"taregts": 1, 'data': 'category_1'
                },
                {"taregts": 2, 'data': 'category_2'
                },
                {"taregts": 3, 'data': 'pending_order'
                },
                {"taregts": 4, 'data': 'completed_order'
                },
                {"taregts": 5, 'data': 'total_order'
                },
            ]
        });
        $('#search').on('click', function () {
            table4.draw();
        });
        
        table5 = jQuery('#other_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [[0, "DESC"]],
            "ajax": {
                url: "{{ route('getotheritem') }}",
                type: "GET",
            },
            "columns": [
                {"taregts": 0, 'data': 'id', "searchable": false, "orderable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"taregts": 1, 'data': 'item_name'
                },
                {"taregts": 2, 'data': 'category_1'
                },
                {"taregts": 3, 'data': 'category_2'
                },
                {"taregts": 4, 'data': 'pending_order'
                },
                {"taregts": 5, 'data': 'completed_order'
                },
                {"taregts": 6, 'data': 'total_order'
                },
            ]
        });
        $('#search').on('click', function () {
            table5.draw();
        });
    });    
</script>
@endsection
