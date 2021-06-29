$(document).ready(function(){

    $image_crop = $('#upload-image').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
        },
        boundary: {
            width: 300,
            height: 300
        }
    });
    $('#images').on('change', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            $image_crop.croppie('bind', {
                url: e.target.result
            }).then(function(){
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });
    $('.cropped_image').on('click', function (ev) {
        // var image_response = '';
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {

            // alert(response);

            // var image_response = response;

            $('#student_image').val(response);

            // $.ajax({
            //     // url: "model/upload.php",
            //     url: "../model/upload.php",
            //     type: "POST",
            //     // data: {"image":response , "id":rid},
            //     data: {"image":response},
            //     success: function (data) {
            //
            //         // alert(data);
            //
            //         var response1 = JSON.parse(data);
            //
            //
            //
            //         html = '<img src="' + response + '" />';
            //         $("#upload-image-i").html(html);
            //
            //         $("#setval").val(response1.image);
            //
            //     }
            // });
        });
    });
});
