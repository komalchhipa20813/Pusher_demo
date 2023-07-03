function getAge(date){
    if(date != '')
    {
        var birthDateSplit = date.split('-');
        var birthDate = new Date(birthDateSplit[2],birthDateSplit[1]-1,birthDateSplit[0]);
        var diff_ms = Date.now() - birthDate.getTime();
        var age_dt = new Date(diff_ms); 
        if(date != '')
            {
                $('#age').val(Math.abs(age_dt.getUTCFullYear() - 1970));
            }
        
        return Math.abs(age_dt.getUTCFullYear() - 1970);
    }
    
  }

//Delete Data
$(document).ready(function() {
    feather.replace();
    $("body").on("click", ".delete", function(event) {
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
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
            })
            .then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: aurl + "/" + currentLocation + "/{" + id + "}",
                        success: function(data) {
                            toaster_message(
                                data.message,
                                data.icon,
                                data.redirect_url
                            );
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


    // Delete selected recoreds

    $('body').on("click", ".delete_all", function(event){
        event.preventDefault();
        var ids = new Array();
        $(".checkbox:checked").each(function()
        {
            var id = $(this).attr('id');
            ids.push(id);
        });
        if(ids.length == 0)
        {
            error_toaster_message('Please select records','error',''); 
        }
        else
        {
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger me-2'
            },
            buttonsStyling: false,
            })
      
            swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "post",
                        url: aurl +'/'+currentLocation+"/delete-all",
                        data: {ids: ids},
                        dataType: "JSON",
                        success: function(data) {
                            $('#select_all').each(function() {
                              this.checked = false;
                              $(this).parent().removeClass("checked");
                          });
                            toaster_message(data.message,data.icon);
                        },
                        error: function (error) {
                            toaster_message(error,'error'); 
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel){
                    toaster_message('Cancle deleting','error');
                }
            });
        }
      });

      if($('#dobdatePicker').length){ getAge( $("#dobdatePicker").val()); }  

 $("#dobdatePicker").on("change",function(){
    getAge($(this).val())
});


});

function select_all(obj) {

    if (obj.checked) {
        $(".checkbox").each(function() {
            $(this).prop("checked", "checked");
            $(this).parent().addClass("checked");
        });
    } else {
        $('.checkbox').each(function() {
            this.checked = false;
            $(this).parent().removeClass("checked");
        });
    }
}

function single_unselected(obj)
{
    var i=0;
    var tbl_id= $(obj).parent().parent().parent().parent().attr('id');
    var table = $('#'+tbl_id).dataTable();
    var total_data= table.fnGetData().length;
    var limit=$('select[name="'+ tbl_id+'_length"]').val();
    $(".checkbox:checked").each(function()
    {
    i++;
});



 

if(total_data < limit && i == total_data )
{
    $('#select_all').each(function() {
        $(this).prop("checked", "checked");
        $(this).parent().removeClass("checked");
    });
}
else if(i == limit){
    $('#select_all').each(function() {
        $(this).prop("checked", "checked");
        $(this).parent().removeClass("checked");
    });
}
else
{
    $('#select_all').each(function() {
        this.checked = false;
        $(this).parent().removeClass("checked");
    });
}

}
