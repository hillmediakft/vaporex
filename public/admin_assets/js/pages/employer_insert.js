var employerInsert = function () {

	/**
	 *	Form validátor
	 */
    var handleValidation = function() {
		console.log('start handleValidation');
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

		var form1 = $('#employer_insert');
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
				employer_name: {
					minlength: 2,
					required: true
				},
				employer_address: {
					required: true
				},
				employer_contact_person: {
					required: true
				},
				employer_contact_tel: {
					required: true
				},
				employer_contact_email: {
					email: true
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
		$('div.alert').delay( 3000 ).slideUp( 750 );						 		
	}

	
    var ckeditorInit = function () {
		//CKEDITOR.replace( 'employer_remark');							
		CKEDITOR.replace( 'employer_remark', {customConfig: 'config_minimal1.js'});	
	}    
    
    return {

        //main function to initiate the module
        init: function () {


			handleValidation();
			hideAlert();
            ckeditorInit();    
			
        }

    };

}();

$(document).ready(function() {    
	Metronic.init(); // init metronic core componets
	Layout.init(); // init layout
	QuickSidebar.init(); // init quick sidebar
	Demo.init(); // init demo features 
	employerInsert.init();
});