var updateJob = function () {

    /**
     *	Form validátor
     */
    var handleValidation = function () {
        console.log('start handleValidation');
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

        var form1 = $('#update_job');
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
                job_title: {
                    minlength: 2,
                    required: true
                },
                job_category_id: {
                    required: true
                },
                job_county_id: {
                    required: true
                },
                job_city_id: {
                    required: true
                },
                job_employer_id: {
                    required: true
                },
                job_pay: {
                    required: true,
                    maxlength: 18
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

                //adatok elküldése "normál" küldéssel
                form.submit();
                //alert('form küldése teszt!');
            }
        });
    }


    var hideAlert = function () {
        $('div.alert').delay(2500).slideUp(750);
    }


    var handleDatePickers = function () {

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: Metronic.isRTL(),
                orientation: "left",
                autoclose: true,
                format: "yyyy-mm-dd",
                language: "hu-HU",
                startDate: '0d',
                endDate: '+2m'
            });
            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }

        /* Workaround to restrict daterange past date select: http://stackoverflow.com/questions/11933173/how-to-restrict-the-selectable-date-ranges-in-bootstrap-datepicker */
    }

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
                        url: "admin/jobs/county_city_list",
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
        CKEDITOR.replace('job_description', {customConfig: 'config_minimal1.js'});
        CKEDITOR.replace('job_conditions', {customConfig: 'config_minimal1.js'});
    }

    return {
        //main function to initiate the module
        init: function () {
            handleValidation();
            hideAlert();
            handleDatePickers();
            locationsInput();
            ckeditorInit();
        }
    };


}();


jQuery(document).ready(function () {
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features	
    updateJob.init();
});