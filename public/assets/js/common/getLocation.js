//State City Dependent Dropdown With Ajax
$(".city_name").on("change", function() {
    var city_id = this.value;
    var html_class=($(this).hasClass( "parmenent" )) ? '#parmenent_location_name' : '#location_name' ;

    $.ajax({
        url: aurl + "/location/get-location-name",
        type: "POST",
        data: {
            city_id: city_id,
        },
        dataType: "json",
        success: function(result) {
            var html = "<option selected disabled value='0'>Please ";
            html +=
                result.location.length == 0 ?
                state_id == 0 ?
                "First Select City" :
                "First Enter Location" :
                "Select";
            html += "</option>";
            $(html_class).html(html);
            $.each(result.location, function(key, value) {
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

function locationfullAddress(data) {
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

function get_location()
{
    var city_id = ($('.city_name').val() == null)? $('.exit_city').val():$('.city_name').val();
    var exite_location=$('.exit_location').val();
    $.ajax({
        url: aurl + "/location/get-location-name",
        type: "POST",
        data: {
            city_id: city_id,
        },
        dataType: "json",
        success: function(result) {
            var html = "<option selected disabled value='0'>Please ";
            html +=
                result.location.length == 0 ?
                city_id == '' ?
                "First Select City" :
                "First Enter location" :
                "Select";
            html += "</option>";
            
            $(".location_name").html(html);
            $.each(result.location, function(key, value) {
                var selected = (value.id == exite_location)?'selected':'';
                $(".location_name").append(
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

get_location();

function get_parmenent_location()
{
    var city_id = ($('#parmenent_city_name').val() == null)? $('.exit_parmenent_city').val():$('#parmenent_city_name').val();
    var exite_location=$('.exit_parmenent_location').val();
    $.ajax({
        url: aurl + "/location/get-location-name",
        type: "POST",
        data: {
            city_id: city_id,
        },
        dataType: "json",
        success: function(result) {
            var html = "<option selected disabled value='0'>Please ";
            html +=
                result.location.length == 0 ?
                city_id == '' ?
                "First Select City" :
                "First Enter location" :
                "Select";
            html += "</option>";
            
            $("#parmenent_location_name").html(html);
            $.each(result.location, function(key, value) {
                var selected = (value.id == exite_location)?'selected':'';
                $("#parmenent_location_name").append(
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
get_parmenent_location();