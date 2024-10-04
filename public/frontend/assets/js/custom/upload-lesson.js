(function () {
    'use strict'
    var lecture_type = $('.lecture_type').val()
    if (lecture_type == 'youtube') {
        $('#fileDuration').removeClass('d-none');
    }
    $('.add-more-section-btn').on('click', function () {
        $('.add-more-section-wrap').removeClass('d-none');
        $('.add-more-lesson-box').addClass('d-none');
    })

    $('.cancel-add-more-section').on('click', function () {
        $('.add-more-section-wrap').addClass('d-none');
        $('.add-more-lesson-box').removeClass('d-none');
    })

    $('.lecture-type').on('click', function () {

       var type =  $(this).val();

       if (type === 'video')
       {
           $('#video').removeClass('d-none');
           $('#youtube').addClass('d-none');
           $('#vimeo').addClass('d-none');

           $('#fileDuration').addClass('d-none');
           $('.customFileDuration').removeAttr("required");
           $('#vimeo_url_path').removeAttr("required");
           $('#youtube_url_path').removeAttr("required");
           $('#video_file').attr("required", true);
       } else if (type === 'youtube') {
           $('#video').addClass('d-none');
           $('#youtube').removeClass('d-none');
           $('#vimeo').addClass('d-none');

           $('#fileDuration').removeClass('d-none');
           $('.customFileDuration').attr("required", true);
           $('#youtube_url_path').attr("required", true);
           $('#vimeo_url_path').removeAttr("required");
           $('#video_file').removeAttr("required");
       } else {
           $('#video').addClass('d-none');
           $('#youtube').addClass('d-none');
           $('#vimeo').removeClass('d-none');
           $('#vimeo_url_path').attr("required", true);
           $('#youtube_url_path').removeAttr("required");
           $('#fileDuration').addClass('d-none');
           $('.customFileDuration').removeAttr("required");
           $('#video_file').removeAttr("required");
       }
    })

    /*** =========== Youtube validation check ===============**/
    $(function(){
        var typeYoutube = $('.oldTypeYoutube').val();
        if ( typeYoutube === 'youtube')
        {
            $('#video').addClass('d-none');
            $('#youtube').removeClass('d-none');
            $('#vimeo').addClass('d-none');

            $('#fileDuration').removeClass('d-none');
            $('.customFileDuration').attr("required", true);
            $('#youtube_url_path').attr("required", true);
            $('#vimeo_url_path').removeAttr("required");
            $('#video_file').removeAttr("required");
            $('#lectureTypeYoutube').attr( 'checked', true )
        }
    });

    /*** =========== video duration ===============**/
    var myVideos = [];
    window.URL = window.URL || window.webkitURL;
    document.getElementById('video_file').onchange = setFileInfo;
    function setFileInfo() {
        var files = this.files;
        myVideos.push(files[0]);
        var video = document.createElement('video');
        video.preload = 'metadata';

        video.onloadedmetadata = function() {
            window.URL.revokeObjectURL(video.src);
            var duration = video.duration;
            $('#file_duration').val(duration);
        };
        video.src = URL.createObjectURL(files[0]);
    }

    /*** =========== end video duration ===============**/

    /*** =========== video duration ===============**/
    var myVideos = [];
    window.URL = window.URL || window.webkitURL;
    document.getElementById('vimeo_url_path').onchange = setFileInfo;
    function setFileInfo() {
        var files = this.files;
        myVideos.push(files[0]);
        var video = document.createElement('video');
        video.preload = 'metadata';

        video.onloadedmetadata = function() {
            window.URL.revokeObjectURL(video.src);
            var duration = video.duration;
            $('#file_duration').val(duration);
        };
        video.src = URL.createObjectURL(files[0]);
    }

    /*** =========== end video duration ===============**/

})()


