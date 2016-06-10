function confirm_for_delete(msg, url) {
    bootbox.confirm(msg, function (result) {
        if (!result) {
        } else {
            window.location.href = url;
            return false;
        }
    });
}


$(document).on("change", ".messageFile", function () {
    var fileNumber = $(".messageFile")[0].files.length;
    if (fileNumber != 0) {
        $(".filename").html(fileNumber + ((fileNumber > 1) ? ' Files' : ' File') + ' Selected');
    } else {
        $(".filename").html('File Selected');
    }
});


jQuery(window).on('load', function () {
    jQuery(document).ready(hideShow);
    jQuery(".dataTables_filter input").keyup(hideShow);
    jQuery(".dataTables_filter input").blur(hideShow);
    // jQuery(".dataTables_length select, .dataTables_filter input").change(hideShow);
});






var hideShow = function () {
    if (($(".dataTables_paginate > span").is(":empty"))) {
        $('.dataTables_paginate').hide();
    } else {
        $('.dataTables_paginate').show();
    }
}

$(document).on('click', '.save-button', function () {
    $('.main-form').submit();
});