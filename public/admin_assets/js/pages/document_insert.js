var Document_insert = function () {

    var fileUploadInit = function () {
        $('#fileinput').fileinput({
            language: 'hu',
            showUpload: false,
            mainClass: "input-group",
            allowedFileExtensions: ['docx', 'doc', 'pdf', 'txt'],
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });
    }

    /**
     *	Form validátor
     *	(ha minden rendben indítja a send_data() metódust ami ajax-al küldi az adatokat)
     */
    var handleValidation = function () {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        console.log('validation start');
        var form1 = $('#upload_document_form');
        var error1 = $('.alert-danger', form1);
        var error1_span = $('.alert-danger > span', form1);
        //var success1 = $('.alert-success', form1);

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: ":disabled", // validate all fields including form hidden input
            rules: {
                title: {
                    required: true
                },
                category_id: {
                    required: true
                }
            },
            // az invalidHandler akkor aktiválódik, ha elküldjük a formot és hiba van
            invalidHandler: function (event, validator) { //display error alert on form submit              
                //success1.hide();
                var errors = validator.numberOfInvalids();
                error1_span.html(errors + ' mezőt nem megfelelően töltött ki!');
                error1.show();
                error1.delay(4000).fadeOut('slow');

                //console.log(event);	
                //console.log(validator);	
            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group                   
                /*	
                 //menü cím színének megvátoztatása
                 var tab_id = $(element).closest('.tab-pane').attr('id');                  
                 $(".nav-tabs li a[href='#" + tab_id + "']").css('color', '#a94442');
                 //$(".nav-tabs li a[href='#" + tab_id + "']").addClass('has-error');
                 */
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group                   
                /*
                 //menü cím színének megvátoztatása
                 var tab_id = $(element).closest('.tab-pane').attr('id');                  
                 $(".nav-tabs li a[href='#" + tab_id + "']").css('color', '');			
                 */


            },
            success: function (label) {
                //label.closest('.form-group').removeClass('has-error').addClass("has-success"); // set success class to the control group
                label.closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function (form1) {
                error1.hide();
                Metronic.blockUI({
                    boxed: true,
                    message: 'Feldolgozás...'
                });

                setTimeout(function () {
                    form1.submit();
                }, 300);



            }
        });
    };



    /**
     *	Form adatok INSERT elküldése gomb
     */
    var sendForm = function () {
        $("#data_upload_ajax").on("click", function () {
            console.log("hello");
            $('#upload_document_form').submit();
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            console.log('init');
            fileUploadInit();
            sendForm();
            //        handleDocUpload_start();
            handleValidation();
            //          send_form_trigger();
            //          send_form_trigger_update();
        }
    };

}();

jQuery(document).ready(function () {
    Document_insert.init();
});