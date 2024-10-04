(function ($) {
    "use strict";
    $(function(){
        $('.viewMeetingLink').on('click', function(e){
            e.preventDefault();
            $('.zoomMeetingDiv').removeClass('d-none');
            $('.bbbMeetingDiv').addClass('d-none');
            $('.jitsiMeetingDiv').addClass('d-none');
            const modal = $('.viewMeetingLinkModal');
            modal.find('textarea[name=join_url]').val($(this).data('item').join_url)
            modal.find('input[name=join_url_copy]').val($(this).data('item').join_url)
            let join_url = $(this).data('item').join_url;
            $('.joinNow').attr("href", join_url)
            modal.modal('show')
        })

        $('.viewBBBMeetingLink').on('click', function(e){
            e.preventDefault();
            $('.bbbMeetingDiv').removeClass('d-none');
            $('.zoomMeetingDiv').addClass('d-none');
            $('.jitsiMeetingDiv').addClass('d-none');
            const modal = $('.viewMeetingLinkModal');
            modal.find('input[name=meeting_id]').val($(this).data('item').meeting_id)
            modal.find('input[name=moderator_pw]').val($(this).data('item').moderator_pw)
            modal.find('input[name=attendee_pw]').val($(this).data('item').attendee_pw)
            let route = $(this).data('route');
            $('.joinNow').attr("href", route)
            modal.modal('show')
        })

        $('.viewJitsiMeetingLink').on('click', function(e){
            e.preventDefault();
            $('.bbbMeetingDiv').addClass('d-none');
            $('.zoomMeetingDiv').addClass('d-none');
            $('.jitsiMeetingDiv').removeClass('d-none');
            const modal = $('.viewMeetingLinkModal');
            modal.find('input[name=jitsi_meeting_id]').val($(this).data('item').meeting_id)
            let route = $(this).data('route');
            $('.joinNow').attr("href", route)
            modal.modal('show')
        })
    })

    $(document).on('click', ".copyZoomUrl", function () {
        var copyText = document.getElementById("join_url");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        toastr.options.positionClass = 'toast-bottom-right';
        toastr.success('Copied URL');
    })
})(jQuery)
