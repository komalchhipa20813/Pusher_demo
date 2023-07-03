//Country State Dependent Dropdown With Ajax
$(".country_name").on("change", function() {
    var idcountry = this.value;
    var state_class=($(this).hasClass( "parmenent" )) ? '#parmenent_state_name' : '#state_name' ;
    
    $.ajax({
        url: aurl + "/country/get-state-name",
        type: "POST",
        data: {
            country: idcountry,
        },
        dataType: "json",
        success: function(result) {
            var html = "<option selected disabled value='0'>Please ";
            html += result.state.length == 0 ? (idcountry==0?"First Select Country" : "First Enter State"):"Select";
            html += "</option>";
            $(state_class).html(html);
            $.each(result.state, function(key, value) {
                $(state_class).append('<option value="' +value.id +'">' +value.name +"</option>");
            });
        },
        error: function(request) {
            toaster_message('Something Went Wrong! Please Try Again.', 'error');
        },
    });
});
function stateAddress(data){
    $(".country_name option[value="+data.data.city.state.country.id+"]").prop("selected", true);
    var html = "";
    $.each(data.data.states, function(key, value) {
        html +='<option value="'+value.id +'">' +value.name +"</option>";
    });
    $(".state_name").html(html);
    $(".state_name option[value=" +data.data.city.state_id +"]").prop("selected", true);
}

function get_state()
{
    var idcountry = $('#country_name').val();
    var exite_state=$('.exit_state').val();
    $.ajax({
        url: aurl + "/country/get-state-name",
        type: "POST",
        data: {
            country: idcountry,
        },
        dataType: "json",
        success: function(result) {
            var html = "<option selected disabled value='0'>Please ";
            html += result.state.length == 0 ? (idcountry==null?"First Select Country" : "First Enter State"):"Select";
            html += "</option>";
            $(".state_name").html(html);
            $.each(result.state, function(key, value) {
                var selected = (value.id == exite_state)?'selected':'';
                $(".state_name").append('<option value="' +value.id +'" '+selected+'>' +value.name +"</option>");
            });
        },
        error: function(request) {
            toaster_message('Something Went Wrong! Please Try Again.', 'error');
        },
    });
}
get_state();

function get_parmenent_state()
{
    var idcountry = $('#parmenent_country_name').val();
    var exite_state=$('.exit_parmenent_state').val();
    $.ajax({
        url: aurl + "/country/get-state-name",
        type: "POST",
        data: {
            country: idcountry,
        },
        dataType: "json",
        success: function(result) {
            var html = "<option selected disabled value='0'>Please ";
            html += result.state.length == 0 ? (idcountry==null?"First Select Country" : "First Enter State"):"Select";
            html += "</option>";
            $("#parmenent_state_name").html(html);
            $.each(result.state, function(key, value) {
                var selected = (value.id == exite_state)?'selected':'';
                $("#parmenent_state_name").append('<option value="' +value.id +'" '+selected+'>' +value.name +"</option>");
            });
        },
        error: function(request) {
            toaster_message('Something Went Wrong! Please Try Again.', 'error');
        },
    });
}
get_parmenent_state();