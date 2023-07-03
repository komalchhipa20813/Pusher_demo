$(document).ready(function() {
    feather.replace();
    $("body").on("click", ".reset_password", function(event) {
        event.preventDefault();
        var id = $(this).data("id");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger me-2",
            },
            buttonsStyling: false,
        });

        swalWithBootstrapButtons
            .fire({
                title: "Are you sure to reset the password?",
                text: "Your password will be changed!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Reset it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
            })
            .then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "GET",
                        url: aurl + "/employee/reset-password/{" + id + "}",
                        beforeSend: function(){
                            $('#loading').addClass('loading');
                            // $('.main-wrapper').addClass('loading');
                            $('#loading-content').addClass('loading-content');
                          },
                        success: function(data) {
                            $('#loading').removeClass('loading');
                            $('#loading-content').removeClass('loading-content');
                                // $("body").removeClass("loading"); 
                                toaster_message(data.message, data.icon);
                        },
                        error: function(request) {
                            toaster_message(
                                "Something Went Wrong! Please Try Again.",
                                "error"
                            );
                        },
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        "Cancelled",
                        "Your Data Is Safe",
                        "info"
                    );
                }
            });
    
    });
});