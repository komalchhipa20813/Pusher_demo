//State City Dependent Dropdown With Ajax
$(".state_name").on("change", function() {
    var state_id = this.value;
    var html_class=($(this).hasClass( "parmenent" )) ? '#parmenent_city_name' : '#city_name' ;

    $.ajax({
        url: aurl + "/state/get-city-name",
        type: "POST",
        data: {
            state_id: state_id,
        },
        dataType: "json",
        success: function(result) {
            var html = "<option selected disabled value='0'>Please ";
            html +=
                result.city.length == 0 ?
                state_id == 0 ?
                "First Select State" :
                "First Enter City" :
                "Select";
            html += "</option>";
            $(html_class).html(html);
            $.each(result.city, function(key, value) {
                $(html_class).append(
                    '<option value="' +
                    value.id +
                    '">' +
                    value.name +
                    "</option>"
                );
            });
        },
        error: function(request) {
            toaster_message("Something Went Wrong! Please Try Again.", "error");
        },
    });
});

function fullAddress(data) {
    // stateAddress(data);
    $(".country_name option[value="+data.data.location.city.state.country.id+"]").prop("selected", true);
    var html1 = "";
    $.each(data.data.states, function(key, value) {
        html1 +='<option value="'+value.id +'">' +value.name +"</option>";
    });
    $(".state_name").html(html1);
    $(".state_name option[value=" +data.data.location.city.state_id +"]").prop("selected", true);


    var html = "";
    $.each(data.data.cities, function(key, value) {
        html += '<option value="' + value.id + '">' + value.name + "</option>";
    });
    $(".city_name").html(html);
    $(".city_name option[value=" + data.data.city_id + "]").prop(
        "selected",
        true
    );
    modal_dropdown();
}

function get_city()
{
    var state_id = ($('.state_name').val() == null)? $('.exit_state').val():$('.state_name').val();
    var exite_city=$('.exit_city').val();
    console.log(state_id);
    $.ajax({
        url: aurl + "/state/get-city-name",
        type: "POST",
        data: {
            state_id: state_id,
        },
        dataType: "json",
        success: function(result) {
            var html = "<option selected disabled value='0'>Please ";
            html +=
                result.city.length == 0 ?
                state_id == '' ?
                "First Select State" :
                "First Enter City" :
                "Select";
            html += "</option>";
            
            $(".city_name").html(html);
            $.each(result.city, function(key, value) {
                var selected = (value.id == exite_city)?'selected':'d';
                $(".city_name").append(
                    '<option value="' +
                    value.id +
                    '" '+selected+'>' +
                    value.name +
                    "</option>"
                );
            });
        },
        error: function(request) {
            toaster_message("Something Went Wrong! Please Try Again.", "error");
        },
    }); 
}
get_city();

function get_parmenent_city()
{
    var state_id = ($('#parmenent_state_name').val() == null)? $('.exit_parmenent_state').val():$('#parmenent_state_name').val();
    var exite_city=$('.exit_parmenent_city').val();
    console.log(state_id);
    $.ajax({
        url: aurl + "/state/get-city-name",
        type: "POST",
        data: {
            state_id: state_id,
        },
        dataType: "json",
        success: function(result) {
            var html = "<option selected disabled value='0'>Please ";
            html +=
                result.city.length == 0 ?
                state_id == '' ?
                "First Select State" :
                "First Enter City" :
                "Select";
            html += "</option>";
            
            $("#parmenent_city_name").html(html);
            $.each(result.city, function(key, value) {
                var selected = (value.id == exite_city)?'selected':'';
                $("#parmenent_city_name").append(
                    '<option value="' +
                    value.id +
                    '" '+selected+'>' +
                    value.name +
                    "</option>"
                );
            });
        },
        error: function(request) {
            toaster_message("Something Went Wrong! Please Try Again.", "error");
        },
    }); 
}

get_parmenent_city();