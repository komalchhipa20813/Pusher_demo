function modelopen(){
    Webcam.set({
        width: 490,
        height: 350,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    
    Webcam.attach( '#my_camera' );
    $('#webcammodel').modal('show');
  }
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
          $("#filename_customer").attr('disabled','disabled');
            $(".image-tag").val(data_uri);
            $('.image').attr('src',data_uri);
        } );
    }

    function gold_modelopen(){
    Webcam.set({
        width: 490,
        height: 350,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    
    Webcam.attach( '#gold_my_camera' );
    $('#goldcammodel').modal('show');
  }
  function gold_take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".gold-image-tag").val(data_uri);
            $('.gold_image').attr('src',data_uri);
            $('#gold_image_div').css('display','flex');
        } );
    }

    function loan_signingOff_from()
    {
        Webcam.set({
            width: 490,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        
        Webcam.attach( '#loanSigningfrom_my_camera' );
        $('#loancammodel').modal('show');
    }

    function loanfrom_take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".loan-from-image-tag").val(data_uri);
            $('.loanSignfrom_image').attr('src',data_uri);
            $('#loanfrom_image_div').css('display','flex');
        } );
    }

    function gold_release_photo_webcam()
    {
        Webcam.set({
            width: 490,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        
        Webcam.attach( '#goldRelease_my_camera' );
        $('#goldReleasecammodel').modal('show');
    }

    function goldRelease_take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".goldRelease-image-tag").val(data_uri);
            $('.goldRelease_image').attr('src',data_uri);
            $('#goldRelease_image_div').css('display','flex');
        } );
    }