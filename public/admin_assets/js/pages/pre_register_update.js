var updatePrereg = function () {

	/**
	 *	Form validátor
	 */
    var handleValidation = function() {
		console.log('start handleValidation');
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

		var form1 = $('#update_prereg');
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
				name: {
					required: true,
				},
				mother_name: {
					required: true
				},
				birth_place: {
					required: true
				},
				birth_time: {
					required: true
				},
				nationality: {
					required: true
				},
				student_card_number: {
					required: true
				},
				taj_number: {
					required: true,
					number: true,
					minlength: 9
				},
				tax_id: {
					required: true,
					number: true,
					minlength: 10
				},
				bank_account_number: {
					required: true,
				},
				bank_name: {
					required: true,
				},
				permanent_address: {
					required: true
				},
				email_address: {
					email: true
				},
				school_data: {
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

				//adatok elküldése "normál" küldéssel
				form.submit();
				//alert('form küldése teszt!');
			}
		});
    }


	var hideAlert = function () {
		$('div.alert').delay( 2500 ).slideUp( 750 );						 		
	}

    return {
        //main function to initiate the module
        init: function () {
			handleValidation();
			hideAlert();
        }
    };

	
}();


jQuery(document).ready(function() {    
	Metronic.init(); // init metronic core componets
	Layout.init(); // init layout
	QuickSidebar.init(); // init quick sidebar
	Demo.init(); // init demo features	
	updatePrereg.init();	
});