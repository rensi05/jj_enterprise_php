@extends('Layouts.appadmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-6">
                <h1 class="m-0 text-dark"><a href="{{route('checkbook')}}"><img class="back-ic" src="{{ asset('public/admin/images/back-arrow.svg')}}"></a> Edit CheckBook</h1>
            </div>
            <div class="col-lg-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('checkbook')}}">CheckBook Management</a></li>
                    <li class="breadcrumb-item active">Edit CheckBook</li>
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
                    <form method="post" id="edit_checkbook" name="edit_checkbook" action="{{route('updatecheckbook')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="checkbook_id" value="{{base64_encode($checkbook->id)}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Cheque Number *</label>
                                        <input type="text" class="form-control" name="cheque_number" value="{{$checkbook->cheque_number}}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Amount *</label>
                                        <input type="text" class="form-control" name="amount" id="amount" value="{{$checkbook->amount}}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Payee Name *</label>
                                        <input type="text" class="form-control" name="payee_name" value="{{$checkbook->payee_name}}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Receiver Name *</label>
                                        <input type="text" class="form-control" name="receiver_name" value="{{$checkbook->receiver_name}}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Cheque Date *</label>
                                        <input type="date" class="form-control" name="cheque_date" value="{{$checkbook->cheque_date}}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Drop Date *</label>
                                        <input type="date" class="form-control" name="drop_date" value="{{$checkbook->drop_date}}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Clearing Date *</label>
                                        <input type="date" class="form-control" name="clearing_date" value="{{$checkbook->clearing_date}}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Return Date *</label>
                                        <input type="date" class="form-control" name="return_date" value="{{$checkbook->return_date}}" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light"> Update </button>
                                        <a href="{{route('checkbook')}}" class="btn btn-default waves-effect m-l-5"> Cancel </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

@section('javascript')
<script>
    $(document).ready(function () {
        $("#amount").on("keyup", function () {
            let val = $(this).val();
            $(this).val(val.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1'));
        });

        $("#edit_checkbook").validate({
            rules: {
                payee_name: {required: true},
                cheque_number: {required: true},
                cheque_date: {required: true},
                amount: {required: true, number: true},
                drop_date: {required: true},
                clearing_date: {required: true},
                return_date: {required: true},
                receiver_name: {required: true}
            },
            messages: {
                payee_name: {required: 'Please enter payee name'},
                cheque_number: {required: 'Please enter cheque number'},
                cheque_date: {required: 'Please enter cheque date'},
                amount: {required: 'Please enter amount', number: 'Only numbers are allowed'},
                drop_date: {required: 'Please enter drop date'},
                clearing_date: {required: 'Please enter clearing date'},
                return_date: {required: 'Please enter return date'},
                receiver_name: {required: 'Please enter receiver name'}
            }
        });
    });
</script>
@endsection
