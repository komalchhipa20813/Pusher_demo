/* datatable */
$('#notification_tbl').DataTable({
    "aLengthMenu": [
        [10, 30, 50, -1],
        [10, 30, 50, "All"]
    ],
    "iDisplayLength": 10,
    "language": {
        search: ""
    },
    'ajax': {
        type:'POST',
        url: aurl + "/notification/listing",
    },
    'columns': [
        { data: '0' },
        { data: '1' },
        { data: '2' },
        {data: '3' },
    ],
    fnDrawCallback: function(oSettings) {
        var elems = Array.prototype.slice.call(
            document.querySelectorAll(".switchery")
        );

        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });
    },
});

$(document).ready(function() {
    /* Validation Of Permission */
    $("#notification_form").validate({
        rules: {
            title: {
                required: true,
                maxlength: 35,
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            message: {
                required: true,
                maxlength: 255,
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
        },
        highlight: function(element) {
            $(element).removeClass("error");
        },
        messages: {
            name: {
                required: "Please Enter Country Name",
                countryCheck: "Country Name Already Exists",
            },
        },
    });
    $.validator.addMethod("countryCheck", function(value) {
        var id = $(".country_id").val();
        var x = $.ajax({
            url: aurl + "/country/country-check",
            type: "POST",
            async: false,
            data: { name: value, id: id },
        }).responseText;
        if (x != 0) {
            return false;
        } else return true;
    });

    /* Display Add country Modal */
    $("body").on("click", ".add_notification", function() {
        $("#notification_form").validate().resetForm();
        $("#notification_form").trigger('reset');
        $('#notification_modal').modal('show');
        $('.country_id').val($(this).data('id'));
        $('#title_notification_modal').text("Add Notification");
        $('.submit_notification').text("Save ");
        $("#notification_form").trigger("reset");
    });

    /* Adding And Updating Permission Data */
    $(".submit_notification").on("click", function(event) {
        event.preventDefault();
        var form = $("#notification_form")[0];
        var formData = new FormData(form);
        if ($("#notification_form").valid()) {
            $.ajax({
                url: aurl + "/notification",
                type: "POST",
                dataType: "JSON",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#notification_modal").modal("hide");
                    // toaster_message(data.message, data.icon);
                },
                error: function(request) {
                    // toaster_message('Something Went Wrong! Please Try Again.', 'error');
                },
            });
        }
    });

    /* Display Update Permission Modal */
    $("body").on("click", ".country_edit", function(event) {
        var id = $(this).data("id");
        $(".country_id").val(id);
        event.preventDefault();
        $.ajax({
            url: aurl + "/country/{" + id + "}",
            type: "GET",
            data: { id: id },
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $("#notification_form").validate().resetForm();
                    $("#notification_form").trigger('reset');
                    $('#title_notification_modal').text("Update Country");
                    $('#notification_modal').modal('show');
                    $('.submit_country').text("Update Country");
                    $('.name').val(data.name);
                    console.log(data.country_status);

                    checked = data.country_status == 1 ? "checked" : "";
                    $(".editcountry").html(
                        '<input class="switcherye" type="checkbox" ' +
                        checked +
                        ' id="editstatus" name="status"  >'
                    );
                    var elems = Array.prototype.slice.call(
                        document.querySelectorAll(".switcherye")
                    );
                    elems.forEach(function(html) {
                        var switchery = new Switchery(html);
                    });
                }else{
                    toaster_message(data.message,data.icon,data.redirect_url);
                }
            },
            error: function(request) {
                toaster_message('Something Went Wrong! Please Try Again.', 'error');
            },
        });
    });
});