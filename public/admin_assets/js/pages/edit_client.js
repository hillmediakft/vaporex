var editClient = function () {

    var cropClientPhoto = function () {
        var userPhoto = $('#client_image');
        userPhoto.css("width", '214px').css("height", '124px');
        var cropperOptions = {
            //kérés a user_img_upload metódusnak "upload" paraméterrel
            uploadUrl: 'admin/clients/client_img_upload/upload',
            //kérés a user_img_upload metódusnak "crop" paraméterrel
            cropUrl: 'admin/clients/client_img_upload/crop',
            outputUrlId: 'OutputId',
            modal: false,
            doubleZoomControls: false,
            rotateControls: false,
            loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
        }
        var cropperHeader = new Croppic('client_image', cropperOptions);
    }

    var oldImg = $('#old_img').val();
    $('#client_image').css('background-image', 'url(' + oldImg + ')');

    var hideAlert = function () {
        $('div.alert-success').delay(3000).slideUp(750);
    }


    return {
//main method to initiate page
        init: function () {

            cropClientPhoto();
            hideAlert();
        },
    };
}();
$(document).ready(function () {
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features 
    editClient.init(); // init users page
});