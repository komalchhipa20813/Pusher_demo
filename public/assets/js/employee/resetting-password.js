$(document).ready(function() {

    $.validator.addMethod("pwcheck",function(value, element) {
        return (value.match(/[a-z]/) && value.match(/[A-Z]/) && value.match(/[0-9]/) && value.match(/[_!#@$%^&*]/));
      }, 'Please enter a valid password');

     /* Validation Of City Form */
     $("#resetPassword_form").validate({
        rules: {
            password:
            {
                required: true,
                minlength : 8,
                pwcheck : true,
            },
            confirmpassword:
            {
                required: true,
                minlength : 8,
                equalTo : "#password"
            },
        },
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long",
                pwcheck: "please enter atleast one uppercase, number and special character!"
            },
            confirmpassword:{
                required:"This value should not be blank.",
            },
           
        },
        errorPlacement: function(error, element) {
            if (
                element.parents("div").hasClass("has-feedback") ||
                element.hasClass("select2-hidden-accessible")
            ) {
                error.appendTo(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).removeClass("error");
        },
    });


     /* Display Add Resetting Password Modal */
     $("body").on("click", ".reset_password", function() {
        $("#resetPassword_form").validate().resetForm();
        $("#resetPassword_form").trigger('reset');
        $('#resetPassword_modal').modal('show');
        $('.employee_id').val($(this).data('id'));
        $('.submit_resetPassword').text("Save");
       
        $("#resetPassword_form").trigger("reset");
    });

    /* Adding And Updating Employee Password Data */
    $(".submit_resetPassword").on("click", function(event) {
        event.preventDefault();
        var form = $("#resetPassword_form")[0];
        var formData = new FormData(form);
        if ($("#resetPassword_form").valid()) {
            $.ajax({
                url: aurl + "/employee/reset-password",
                type: "POST",
                dataType: "JSON",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#resetPassword_modal").modal("hide");
                    toaster_message(data.message, data.icon);
                },
                error: function(request) {
                    toaster_message('Something Went Wrong! Please Try Again.', 'error');
                },
            });
        }
    });


});