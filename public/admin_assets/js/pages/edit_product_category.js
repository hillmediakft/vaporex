var EditProductCategory = function () {

    var hideAlert = function () {
        $('div.alert-success').delay(2500).slideUp(750);
    }

    var cropProductCategoryPhoto = function () {
        var userPhoto = $('#product_category_image');
        userPhoto.css("width", '402px').css("height", '302px');
        var cropperOptions = {
            //kérés a user_img_upload metódusnak "upload" paraméterrel
            uploadUrl: 'admin/products/product_category_crop_img_upload/upload',
            //kérés a user_img_upload metódusnak "crop" paraméterrel
            cropUrl: 'admin/products/product_category_crop_img_upload/crop',
            outputUrlId: 'OutputId',
            modal: false,
            doubleZoomControls: false,
            rotateControls: false,
            loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
        }
        var cropperHeader = new Croppic('product_category_image', cropperOptions);
    }

    var oldImg = $('#old_img').val();
    $('#product_category_image').css('background-image', 'url(' + oldImg + ')');

    return {
        //main function to initiate the module
        init: function () {
            hideAlert();
            cropProductCategoryPhoto();
        }
    };


}();


jQuery(document).ready(function () {
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features	
    EditProductCategory.init();
});