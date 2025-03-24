<div class="modal-main mb-2">
    <h4 class="modal-title" id="myModalLabel">Delete Order</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

    <div class="alert alert-danger" style="display:none"></div>
    <form id="edit_setting_form" name="edit_setting_form">
        @csrf
        <input type="hidden" name="id" id="serviceId" value="{{ base64_encode($edit_data->id) }}">
        <h4 class="deleteFAQs">
            <p>Are you sure you want to delete this Order?</p>
        </h4>
        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        <button type="button" onClick="deteleSetting()" class="btn btn-danger waves-effect waves-light">Delete</button>
    </form>
</div>
<script>
    alertify.set('notifier', 'position', 'top-right');
    function deteleSetting() {
        var admin_path = "{{ env('APP_URL') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: admin_path + 'deleteorder',
            method: 'post',
            data: {
                serviceId: $('#serviceId').val()
            },
            success: function (data) {
                $('#deleteModal').modal('hide');
                table.draw();
                if (data.status === 'success') {
                    var notification = alertify.notify(data.message, 'success', 3);
                } else {
                    var notification = alertify.notify(data.message, 'error', 3);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var notification = alertify.notify(errorThrown, 'error', 3);
                console.log("Edit Modal AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }
</script>
