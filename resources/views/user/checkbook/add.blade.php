@extends('Layouts.appadmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-6">
                <h1 class="m-0 text-dark"><a href="{{route('checkbook')}}"><img class="back-ic" src="{{ asset('public/admin/images/back-arrow.svg')}}"></a> Add CheckBook</h1>
            </div>
            <div class="col-lg-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('checkbook')}}">CheckBook Management</a></li>
                    <li class="breadcrumb-item active">Add CheckBook</li>
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
                    <form method="post" id="add_checkbook" name="add_checkbook" action="{{route('savecheckbook')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Cheque Number *</label>
                                        <input type="text" class="form-control" name="cheque_number" placeholder="Enter Cheque Number">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Amount *</label>
                                        <input type="string" step="0.01" id="amount" class="form-control" name="amount" placeholder="Enter Amount">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Payee Name *</label>
                                        <input type="text" class="form-control" name="payee_name" placeholder="Enter Payee Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Receiver Name *</label>
                                        <input type="text" class="form-control" name="receiver_name" placeholder="Enter Receiver Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Cheque Date *</label>
                                        <input type="date" class="form-control" name="cheque_date">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Drop Date *</label>
                                        <input type="date" class="form-control" name="drop_date">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Clearing Date *</label>
                                        <input type="date" class="form-control" name="clearing_date">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Return Date *</label>
                                        <input type="date" class="form-control" name="return_date">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                        <a href="{{route('checkbook')}}" class="btn btn-default">Cancel</a>
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
<script>
    $(document).ready(function() {
        $("#amount").on("keyup", function() {
            let val = $(this).val();
            $(this).val(val.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1'));
        });
    });
    $(document).ready(function () {
        $("#add_checkbook").validate({
            rules: {
                payee_name: {required: true, maxlength: 255},
                cheque_number: {required: true, maxlength: 50},
                cheque_date: {required: true, date: true},
                amount: {required: true, number: true, min: 0},
                drop_date: {required: true, date: true},
                clearing_date: {required: true, date: true},
                return_date: {required: true, date: true},
                receiver_name: {required: true, maxlength: 255},
            },
            messages: {
                payee_name: {required: "Payee Name is required", maxlength: "Maximum 255 characters"},
                cheque_number: {required: "Cheque Number is required", maxlength: "Maximum 50 characters"},
                cheque_date: {required: "Cheque Date is required"},
                amount: {required: "Amount is required", number: "Enter a valid amount", min: "Amount cannot be negative"},
                drop_date: {required: "Drop Date is required"},
                clearing_date: {required: "Clearing Date is required"},
                return_date: {required: "Return Date is required"},
                receiver_name: {required: "Receiver Name is required", maxlength: "Maximum 255 characters"},
            },
            errorElement: "span",
            errorPlacement: function (error, element) {
                error.appendTo(element.parent().last());
            }
        });
    });
</script>
@endsection
