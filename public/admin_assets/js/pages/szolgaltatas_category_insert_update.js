var szolgaltatasCategory_insert_update = function () {

    /**
     *	Form validátor
     */
    var handleValidation = function () {
        console.log('start handleValidation');
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

        var form1 = $('#szolgaltatas_category_form');
        var error1 = $('.alert-danger', form1);
        var error1_span = $('.alert-danger > span', form1);
        var success1 = $('.alert-success', form1);
        //var success1_span = $('.alert-success > span', form1);

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            //ignore: "input[name='img']",
            rules: {
                szolgaltatas_list_name: {
                    minlength: 2,
                    required: true
                }
            },
            // az invalidHandler akkor aktiválódik, ha elküldjük a formot és hiba van
            invalidHandler: function (event, validator) { //display error alert on form submit              
                //success1.hide();
                //var errors = validator.numberOfInvalids();
                error1_span.html('Nem adta meg a kategória nevét!');
                error1.show();
                error1.delay(3000).slideUp(750);
            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group                   
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group                   
            },
            success: function (label) {
                //label.closest('.form-group').removeClass('has-error').addClass("has-success"); // set success class to the control group
                label.closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function (form) {
                error1.hide();
                //success1.show();
                console.log('blockui');
                $.blockUI({
                    boxed: true,
                    message: '<div class="loading-message loading-message-boxed"><img style="width:22px;" src="public/site_assets/image/loading-spinner-grey.gif"><span> Feldolgozás...</span>',
                    baseZ: 5000,
                    css: {
                        left: '35%',
                        width: '30%',
                        border: 'none',
                        backgroundColor: 'none'
                    },
                    overlayCSS: {
                        backgroundColor: '#000',
                        opacity: 0.2
                    }
                });
                //adatok elküldése "normál" küldéssel
                form.submit();
                //alert('form küldése teszt!');
            }
        });
    }


    var hideAlert = function () {
        $('div.alert').delay(2500).slideUp(750);
    }


    return {
        //main function to initiate the module
        init: function () {
            hideAlert();
            handleValidation();
        }
    };

}();

jQuery(document).ready(function () {
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features	
    szolgaltatasCategory_insert_update.init();
});