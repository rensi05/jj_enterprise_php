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
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="air_bubble_filter">Select Item</label>
                                <select id="air_bubble_filter" class="form-control">
                                    <option value="AIR BUBBLE ROLL 1 MTR" selected>AIR BUBBLE ROLL 1 MTR</option>
                                    <option value="AIR BUBBLE ROLL 1.5 MTR">AIR BUBBLE ROLL 1.5 MTR</option>
                                    <option value="AIR BUBBLE ROLL 2 MTR">AIR BUBBLE ROLL 2 MTR</option>
                                    <!-- Add other similar item names -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="email_datatable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Category 1</th>
                                    <th>Category 2</th>
                                    <th>Category 3</th>
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
                                    <th>Category 1</th>
                                    <th>Category 2</th>
                                    <th>Category 3</th>
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
                                    <th>Category 1</th>
                                    <th>Category 2</th>
                                    <th>Category 3</th>
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
                                    <th>Category 1</th>
                                    <th>Category 2</th>
                                    <th>Category 3</th>
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
                        <!--<h3 class="card-title">Other Item</h3>-->
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title">Other Item</h3>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group float-right">
                                    <label for="other_item_filter">Select Item</label>
                                    <select id="other_item_filter" class="form-control">
                                        <option value="">All</option>
                                        @foreach($otherItems as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="other_datatable" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Item Name</th>
                                    <th>Category 1</th>
                                    <th>Category 2</th>
                                    <th>Category 3</th>
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
    </div>
</section>
@endsection

@section('javascript')
<script>
    var getFirstItemBaseUrl = "{{ url('getfirstitem') }}";
</script>
<script>
    var user_path = "{{ env('APP_URL') }}";
    let table;
    $(document).ready(function () {

    alertify.set('notifier', 'position', 'top-right');
    function loadTable(selectedItem) {
        if (table) {
            table.ajax.url(getFirstItemBaseUrl + "/" + encodeURIComponent(selectedItem)).load();
        } else {
            table = $('#email_datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                scrollX: true,
                autoWidth: false,
                order: [[0, "DESC"]],
                ajax: {
                    url: getFirstItemBaseUrl + "/" + encodeURIComponent(selectedItem),
                    type: "GET",
                },
                columns: [
                    {
                        targets: 0,
                        data: 'id',
                        searchable: false,
                        orderable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { targets: 1, data: 'category_1' },
                    { targets: 2, data: 'category_2' },
                    { targets: 3, data: 'category_3' },
                    { targets: 4, data: 'pending_order' },
                    { targets: 5, data: 'completed_order' },
                    { targets: 6, data: 'total_order' }
                ]
            });
            table.on('draw', function () {
                table.columns.adjust().responsive.recalc();
            });
        }
    }

    $(document).ready(function () {
        let selectedItem = $('#air_bubble_filter').val();
        loadTable(selectedItem);

        $('#air_bubble_filter').on('change', function () {
            let newItem = $(this).val();
            loadTable(newItem);
        });

        $('#search').on('click', function () {
            let selectedItem = $('#air_bubble_filter').val();
            loadTable(selectedItem);
        });
    });
        
        table2 = jQuery('#second_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": false,
            "scrollX": true,
            "autoWidth": false,
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
                {"taregts": 3, 'data': 'category_3'
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
            table2.draw();
        });
        
        table3 = jQuery('#third_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": false,
            "scrollX": true,
            "autoWidth": false,
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
                {"taregts": 3, 'data': 'category_3'
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
            table3.draw();
        });
        
        table4 = jQuery('#fourth_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": false,
            "scrollX": true,
            "autoWidth": false,
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
                {"taregts": 3, 'data': 'category_3'
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
            table4.draw();
        });
        
        table5 = jQuery('#other_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": false,
            "scrollX": true,
            "autoWidth": false,
            "order": [[0, "DESC"]],     
            "ajax": {
                url: "{{ route('getotheritem') }}",
                type: "GET",
                data: function (d) {
                    d.item_name = $('#other_item_filter').val();
                }
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
                {"taregts": 4, 'data': 'category_3'
                },
                {"taregts": 5, 'data': 'pending_order'
                },
                {"taregts": 6, 'data': 'completed_order'
                },
                {"taregts": 7, 'data': 'total_order'
                },
            ]
        });
        $('#other_item_filter').on('change', function () {
            table5.draw();
        });
        $('#search').on('click', function () {
            table5.draw();
        });
        table5.on('draw', function () {
            table5.columns.adjust().responsive.recalc();
        });
    });    
</script>
@endsection
