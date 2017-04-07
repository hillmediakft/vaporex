/**
Irodák oldal
**/
var Offices = function () {
    
	var hideAlert = function () {
		$('div.alert').delay( 2500 ).slideUp( 750 );						 		
	};

 	/**
	 *	Iroda törlése confirm
	 */
	var deleteOfficeConfirm = function () {
		$('a.delete_office_class').on('click', function(e){
			e.preventDefault();
			var elem = $(this);
			var deleteID = elem.attr('data-id');
			
			bootbox.setDefaults({
				locale: "hu", 
			});
			bootbox.confirm("Biztosan törölni akarja az irodát?", function(result) {
				if (result) {
					delete_office(deleteID, elem); 	
				}
			}); 

		});	
	};
		
	/**
	 *	Egy iroda törlése
	 */
	var delete_office = function(deleteID, elem) {
		// a del_tr változóhoz rendeljük a html táblázat törlendő sorát
		var del_tr = elem.closest("tr");

		//végrehajtjuk az AJAX hívást
		$.ajax({
			type: "POST",
			//contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
			data: {
				delete_id: deleteID
			},
			dataType: "json",
			// a feldolgozó url-je
			url: "admin/offices/ajax_delete_office",
			beforeSend: function(){
				Metronic.blockUI({
					boxed: true
				});
			},
			complete: function(){
				Metronic.unblockUI();
			},
			// itt kapjuk meg (és dolgozzuk fel) a feldolgozó php által visszadott adatot 
			success: function(response){
				console.log(response);
				if(response.status == 'success'){
					Metronic.alert({
						type: 'success',
						//icon: 'warning',
						message: response.message,
						container: $('#ajax_message'),
                        closeInSeconds: 3,
						place: 'prepend'
					});
					
					// törlölt sor html törlése
					del_tr.remove();
				}

				if(response.status == 'error'){
					Metronic.alert({
						type: 'danger',
						//icon: 'warning',
						message: response.message,
						container: $('#ajax_message'),
                        closeInSeconds: 3,
						place: 'prepend'
					});
				}

			},
			error: function(result, status, e){
					alert(e);
			} 
		});		
		
	};	    
    
    return {

        //main function to initiate the module
        init: function () {
            deleteOfficeConfirm();
			hideAlert();
        }

    };

}();

$(document).ready(function() {    
    Metronic.init(); // init metronic core componets
	Layout.init(); // init layout
	QuickSidebar.init(); // init quick sidebar
	Demo.init(); // init demo features 
	Offices.init(); // init Irodak page
});