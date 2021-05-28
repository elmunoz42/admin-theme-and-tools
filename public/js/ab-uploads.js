jQuery(document).ready(function ($) {
    alert("Hello");
    $('#upload_button').click(function () {
        tb_show('Upload a logo', 'media-upload.php?type=image&TB_iframe=true&post_id=0', false);
        return false;
    });

    // Display the Image link in TEXT Field
    window.send_to_editor = function (html) {
        var image_url = $('img', html).attr('src');
        $('#logo_url').val(image_url);
        tb_remove();
    }
});