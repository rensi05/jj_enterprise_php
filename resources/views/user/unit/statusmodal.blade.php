<div class="modal-main">
    <h4 class="modal-title" id="myModalLabel">Change Status</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <div class="alert alert-danger" style="display:none"></div>
    <form id="edit_setting_form" name="edit_setting_form">
        @csrf
        <input type="hidden" name="unit_id" id="unit_id" value="{{ base64_encode($edit_data->id) }}">
        <br>

        <h4 class="deleteFAQs">
            <p>Are you sure you want to <?php if ($edit_data->status == 'active') {
                                            echo 'Inactive';
                                        } else echo 'Active'; ?> this Service?</p>
        </h4>

        <button type="button" onClick="changeStatusModal()" class="btn btn-danger waves-effect waves-light">Yes</button>
        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">No</button>

    </form>
</div>
<script>
    alertify.set('notifier', 'position', 'top-right');

    function changeStatusModal() {
        var admin_path = "{{ env('APP_URL') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: admin_path + 'updateunitstatus',
            method: 'post',
            data: {
                unit_id: $('#unit_id').val()
            },
            success: function(data) {
                $('#changeStatus').modal('hide');
                table.draw();
                if (data.status === 'success') {
                    var notification = alertify.notify(data.message, 'success', 6);
                } else {
                    var notification = alertify.notify(data.message, 'error', 6);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var notification = alertify.notify(errorThrown, 'error', 6);
                console.log("Delete Modal AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }
</script>