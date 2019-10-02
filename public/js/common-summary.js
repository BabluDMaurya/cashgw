$('.modal').on('hidden.bs.modal', function (e) {
    var modalId = $(this).attr('id');
    if (modalId == "add-phone") {
        $(this)
        .find("#phonenumber")
        .val('')
        .end()
        .find('.invalid-feedback').removeClass('error').text('')
        .end()
        .find("#phonenumbervalue, input[type=radio]")
        .prop("checked", "")
        .end()
        .find('.invalid-feedback').removeClass('error').text('')
        .end();
    }
});

$.fn.datepicker.defaults.format = "dd/mm/yyyy";
$('.datepicker').datepicker({
    todayHighlight: true,
    startDate: '-0m',
    autoclose: true
}).on("show", function () {
    $('.datepicker').addClass('summarydate');
});
$(document).on("change", ".upload_pro_image", function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var id = $(this).attr("img_id");
    $(".crop_image2").attr("input_id", id);
    var width = $(this).attr("img_width");
    var height = $(this).attr("img_height");
    var b_width = +width + 70;
    var b_height = +height + 70;
    $image_crop = $('.image_demo').croppie({
        enableExif: true,
        viewport: {
            width: width,
            height: height,
            type: 'square' //circle
        },
        boundary: {
            width: b_width,
            height: b_height
        }
    });

    var reader = new FileReader();
    reader.onload = function (event) {
        $image_crop.croppie('bind', {
            url: event.target.result
        }).then(function () {
            console.log('jQuery bind complete');
        });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal2').modal('show');


});
$('#uploadimageModal2').on('hidden.bs.modal', function () {
    $image_crop.croppie('destroy');
});

$(document).on('change', '#myphoto', function () {
    $('#myphotohtml').html('<input type="submit" class="btn round-btn" value="Save">');
});
$(document).ready(function () {
    jQuery.validator.addMethod("alpha", function (value, element) {
        return this.optional(element) || /^[a-zA-Z ]+$/i.test(value);
    }, "Letters only please");

    //    $.validator.addMethod('filesize', function (value, element, param) {
    //        return this.optional(element) || (element.files[0].size <= param)
    //    }, 'File size must be less than {0}');  

    $('.myform').each(function () {
        $(this).validate({
            errorElement: 'span',
            errorClass: 'invalid-feedback',
            rules: {
                myphoto: {
                    required: true,
                    extension: "jpg,png,jpeg",
                    //                filesize: 50000,
                },
                balance: {
                    required: true,
                },
                phonenumber: {
                    required: true,
                    phoneUS: true
                },
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            messages: {
                myphoto: {
                    required: "Image Required",
                    extension: "Only image type jpg/png/jpeg is allowed",
                    //                filesize:"File size must be less than {0}",
                },
                balance: {
                    required: "Amount Required",
                },
                phonenumber: {
                    required: "Phone Number Required",
                    phoneUS: "Only 11 Digit Numbers",
                },
            }
        });
    });
});