var updateRendezveny = function () {

    /**
     *	Form validátor
     */
    var handleValidation = function () {
        console.log('start handleValidation');
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

        var form1 = $('#update_rendezveny');
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
                rendezveny_title: {
                    minlength: 2,
                    required: true
                },
                rendezveny_county_id: {
                    required: true
                },
                rendezveny_city_id: {
                    required: true
                },
                rendezveny_start_timestamp: {
                    required: true
                },
                rendezveny_expiry_timestamp: {
                    required: true
                }
            },
            // az invalidHandler akkor aktiválódik, ha elküldjük a formot és hiba van
            invalidHandler: function (event, validator) { //display error alert on form submit              

                //success1.hide();
                var errors = validator.numberOfInvalids();
                error1_span.html(errors + ' mezőt nem megfelelően töltött ki!');
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
                console.log('success');
                //label.closest('.form-group').removeClass('has-error').addClass("has-success"); // set success class to the control group
                label.closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function (form) {
                //console.log('submitHandler');
                error1.hide();
                //success1.show();
                Metronic.blockUI({
                    boxed: true,
                    message: 'Feldolgozás...'
                });
                window.setTimeout(function () {
                    form.submit();
                }, 2000);
            }
        });
    }

    var handleMultiSelect = function () {
        $('#rendezveny_szolgaltatasok').multiSelect();

    }


    var hideAlert = function () {
        $('div.alert.alert-success, div.alert.alert-danger').delay(2500).slideUp(750);
    }

    var handleDateTimePickers = function () {
        $('.datetimepicker').datetimepicker({
            locale: 'hu',
            minDate: 'moment'
        });
    }

    /*
     var handleDatePickers = function () {
     
     if (jQuery().datepicker) {
     $('.date-picker').datepicker({
     rtl: Metronic.isRTL(),
     orientation: "left",
     autoclose: true,
     format: "yyyy-mm-dd",
     language: "hu-HU",
     startDate: '0d'
     });
     //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
     }
     
     }
     */

    var locationsInput = function () {
        //$("#city_div").hide();
        //$("#district_div").hide();

        //kerület és városrész option lista megjelenítése, ha a kiválasztott megye Budapest
        $("#county_select").change(function () {
            var str = "";
            //option listaelem tartalom
            str = $("select#county_select option:selected").text();
            // option listaelem value
            option_value = $("select#county_select option:selected").val();

            // az érték üres lesz, ha a válassz elemet választjuk ki az option listából
            if (option_value !== '') {

                if (str == "Budapest") {
                    $("#city_div").hide();
                    //$("#district_div").show();
                    $("#district_div").fadeIn(1000);
                }
                if (str != "Budapest") {
                    $("#district_div").hide();
                    //$("#city_div").show();
                    $("#city_div").fadeIn(1000);

                    var county_id = $("#county_select").val();

                    $.ajax({
                        type: "post",
                        url: "admin/rendezvenyek/county_city_list",
                        data: "county_id=" + county_id,
                        beforeSent: function () {
                            $("#loading").show();
                        },
                        complete: function () {
                            $("#loading").hide();
                        },
                        success: function (data) {
                            //console.log(data);
                            $("#city_div > select").html(data);
                        }
                    });
                }

            } else {
                $("#city_div").hide();
                $("#district_div").hide();
            }

        })


    }

    var ckeditorInit = function () {
        CKEDITOR.replace('rendezveny_description', {customConfig: 'config_custom3.js'});
        CKEDITOR.replace('rendezveny_directions', {customConfig: 'config_custom3.js'});
    }

    return {
        //main function to initiate the module
        init: function () {
            handleValidation();
            hideAlert();
            //     handleDatePickers();
            locationsInput();
            ckeditorInit();
            handleMultiSelect();
            handleDateTimePickers();
        }
    };


}();


jQuery(document).ready(function () {
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features	
    updateRendezveny.init();
});