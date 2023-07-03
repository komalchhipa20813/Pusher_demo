/* datatable */
if($('#employee_tbl').length){
    $('#employee_tbl').DataTable({
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
            url: aurl + "/employee/listing", 
        },
        'columns': [
            { data: '0' },
            { data: '1' },
            { data: '2' },
            { data: '3' },
            { data: '4' },
            { data: '5' }
        ]
    });
}
  
$(document).ready(function(){

    $('#filename_employee').change(function(events){
        var tmppath=URL.createObjectURL(events.target.files[0]);
        $(".empimage").fadeIn("fast").attr('src',URL.createObjectURL(events.target.files[0]));
  });

  

    //Datatable
    if($("#employee_form").length){
        $("#employee_form").validate({
            rules: {
                image:{
                    required: window.location.href.split("/")[4] == 'create',
                    extension: "png|jpg|jpeg",
                    maxfilesize:true,
                    
                    
                  },
                branch_id:{
                  required: true,
                },
                  first_name: {
                      required: true,
                  },
                  last_name: {
                      required: true,
                  },
                  phone:
                  {
                    required:true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                  },
                  email:
                  {
                      required: true,
                      email:true,
                      emailcheck:true,
                  },
                  address:{
                    maxlength: 255,
                  },
                  role_id: {
                    required : true
                  },
                 
                             
              },
            highlight: function(element) {
                $(element).removeClass("error");
            },
            messages: {
                image:{
                    required: 'Please upload Profile Photo.',
                    
                    
                  },
                branch_id:{
                    required:"Please Select Branch.",
        
                  },
                  role_id: {
                    required : "Please Select Role.",
                  },
                 
                  first_name:{
                    required:"Please Enter First Name.",
        
                  },
                  last_name:{
                    required:"Please Enter Last Name.",
        
                  },
                  phone:
                  {
                      required:"Please Enter Contact Number.",
                      number:'Only number allow.',
                      minlength:'Minimum 10 digite required.',
                      maxlength:'Maximum 10 digite required.'
        
                  }, 
                  
                  email:{
                     required:"Please Enter Employee Email",
                     emailcheck:"Email Already Exists",
                    },
            },
            errorPlacement: function (label, element) {
                if(element.attr("type") == "checkbox"){
                    label.insertAfter(element.closest(".check")); 
                }else if(element.hasClass("select2-hidden-accessible")) {
                    label.appendTo(element.parent());
                }
                else if ( element.hasClass("dobdatePicker")) {
                    label.appendTo(element.parent().parent());
                }
                else if (
                    element.parents("div").hasClass("uploader") 
                ) {
                    label.appendTo(element.parent().parent());
                }
                else{
                    label.insertAfter(element);
                }
            },
        });
        $.validator.addMethod(
            "emailcheck",
            function(value) {
                var x = 0;
                var id = $(".employee_id").val();
                var x = $.ajax({
                    url: aurl + "/employee/email-check",
                    type: "POST",
                    async: false,
                    data: { email: value, id: id},
                }).responseText;
                if (x != 0) {
                    return false;
                } else return true;
            },
        );

        $.validator.addMethod(
            "maxfilesize",
            function (value, element) {
              if (this.optional(element) || ! element.files || ! element.files[0]) {
                return true;
              } else {
                return element.files[0].size <= 2097152;
              }
            },
            'The file size can not exceed 2MiB.'
          );
    }

    /* adding and updating role data */    
    $(".submit_employee").on("click", function(event){
        event.preventDefault();
        var form = $('#employee_form')[0];
        var formData = new FormData(form);
        if($("#employee_form").valid()){   
            $.ajax({
                url: aurl + "/employee",
                type: 'POST',
                dataType: "JSON",
                data:formData,
                beforeSend: function(){
                    $(".submit_employee").prop('disabled', true);
                    $(".cancel_btn").addClass('disable-link');
                  },
                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $(".submit_employee").prop('disabled', false);
                    $(".cancel_btn").removeClass('disable-link');
                    toaster_message(data.message,data.icon,data.redirect_url);
                },
                error: function(request) {
                    $(".submit_employee").prop('disabled', false);
                    $(".cancel_btn").removeClass('disable-link');
                    toaster_message('Something Went Wrong! Please Try Again.', 'error');
                },
            });
        }
    });

   

    
    
});

$(function() {
	var switchess = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
    switchess.forEach(function(html) {
      var switchery = new Switchery(html);
    });

    

});