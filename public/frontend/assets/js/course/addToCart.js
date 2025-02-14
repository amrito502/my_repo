(function ($) {
    "use strict";
    $('.addToCart').on('click', function (){
        var course_id = $(this).data('course_id');
        var product_id = $(this).data('product_id');
        var route = $(this).data('route');

        $.ajax({
            type: "POST",
            url: route,
            data: {'course_id': course_id, 'product_id': product_id,  '_token': $('meta[name="csrf-token"]').attr('content')},
            datatype: "json",
            success: function (response) {
                toastr.options.positionClass = 'toast-bottom-right';
                if (response.status == 402) {
                    toastr.error(response.msg)
                }
                if (response.status == 401 || response.status == 404 || response.status == 409){
                    toastr.error(response.msg)
                } else if(response.status == 200) {
                    $('.cartQuantity').text(response.quantity)
                    toastr.success(response.msg)
                    $('.msgInfoChange').html(response.msgInfoChange)
                }
            },
            error: function (error) {
                toastr.options.positionClass = 'toast-bottom-right';
                if (error.status == 401){
                    toastr.error("You need to login first!")
                }
                if (error.status == 403){
                    toastr.error("You don't have permission to add course or product!")
                }

            },
        });
    })
})(jQuery)
