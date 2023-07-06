$(document).ready(function() {
    var pusher = new Pusher('439bf8694fcf0159d431', {
        cluster: 'ap2',
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('user-notification', function(data) {
        if(data.text != '')
        {
            var id=1;

            $.ajax({
                url: aurl + "/notification/pusher-notification",
                type: "POST",
                dataType: "JSON",
                data:{id:id},
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('.bell-notify').html('<div class="indicator"><div class="circle">1</div> </div>');
                    $('.main-pusher-data').html(data.data.notifictions);
                    
                },
                error: function(request) {
                    toaster_message('Something Went Wrong! Please Try Again.', 'error');
                },
            });
        }
       
    });

    
});
function notificationClear(id){
        $.ajax({
            url: aurl + "/notification/read-notification",
            type: "POST",
            dataType: "JSON",
            data:{id:id},
            success: function(data) {
                if(data.status)
                {
                    if(data.data.count != 0)
                    {
                        $('.bell-notify').html('<div class="indicator"><div class="circle">1</div> </div>');
                    }
                    else{
                        $('.bell-notify').html(' ');
                    }
                    
                    $('.main-pusher-data').html(data.data.notifictions);
                }
               
                
            },
            error: function(request) {
                toaster_message('Something Went Wrong! Please Try Again.', 'error');
            },
        });
}