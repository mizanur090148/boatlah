$(document).on('click', '.verify-by-admin', function () {
    $this = $(this);
    var todo = $(this).attr('todo');
    if (todo == '') {
        return false;
    }
    var customerId = $(this).closest('div').attr('customer-id');
    var table = $(this).closest('div').attr('type');
    var data = new Object();
    data._token = csrfToken;
    data.todo = todo;
    data.field = table;
    data.customerId = customerId;
    var url = baseUrl + '/admin-dashboard/verify-by-admin';
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (res) {
            if (res.response) {
                 if(todo == 'no'){
                     $this.closest('div').find('.verify-txt').html('Not Verified');
                     $this.closest('div').find('.verify-txt').removeClass('text-success');
                     $this.closest('div').find('.verify-txt').addClass('text-danger');
                     $this.attr('todo', 'yes');
                     $this.html('Verify Now!');
                 }else{
                     $this.closest('div').find('.verify-txt').html('Verified');
                     $this.closest('div').find('.verify-txt').addClass('text-success');
                     $this.closest('div').find('.verify-txt').removeClass('text-danger');
                     $this.attr('todo', 'no');
                     $this.html('Unverify!');
                 }
            } else {
                bootbox.alert(res.msg);
            }
        },
        error: function (res) {

        }

    });

});