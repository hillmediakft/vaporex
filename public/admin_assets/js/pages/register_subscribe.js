/**
Előregisztráció oldal
**/
var RegisterSubscribe = function () {

	var registerTable = function() {
        var grid = new Datatable();

        grid.init({
            src: $("#register_subscribe_table"),
            onSuccess: function (grid) {
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            loadingMessage: 'Betöltés...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 
			
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",

			

				// A columnDefs opciót nem kell megadni a datatable működéséhez, de elengedhetetlenül hasznos
				// a php feldolgozónak küld a táblázatról információkat, azért hogy a szever a megfelelő adatokat adhasson vissza pl. szűrésnél
				// (az oszlop nevekenek egyeznie kell az adatbázis tábla oszlop neveivel [a sorbarendezédhez kell])
				"columnDefs": [
					{"name": "chechbox", "searchable": false, "orderable": false, "targets": 0},
					{"name": "user_id", "searchable": true, "orderable": true, "targets": 1},
					{"name": "user_name", "searchable": true, "orderable": true, "targets": 2},
					{"name": "user_email", "searchable": true, "orderable": true, "targets": 3},
					{"name": "user_active", "searchable": true, "orderable": true, "targets": 4},
					{"name": "user_newsletter", "searchable": true, "orderable": true, "targets": 5},
					{"name": "menu", "searchable": false, "orderable": false, "targets": 6}
				],
				
				// ha a php asszociatív tömböt ad vissza (pl.: 'name' => 'László', 'age' => '38', 'haircolor' => 'blonde' ...), akkor meg kell adni az egyes elem nevét!	
				// (ha a php számmal indexelt tömböt ad vissza (pl.: 'László', '38', 'Blonde' ...), akkor nem kell ez a beállítás!)	
				"columns": [
					{ "data": "checkbox" },
					{ "data": "id" },
					{ "data": "name" },
					{ "data": "email" },
					{ "data": "active" },
					{ "data": "newsletter" },
					{ "data": "menu" }
				],		

                "lengthMenu": [
                    [10, 20, 50, 100, 150],
                    [10, 20, 50, 100, 150] // change per page values here 
                ],

                "pageLength": 10, // default record count per page

                "ajax": {
                    "url": "admin/register_subscribe/ajax_get_items", // ajax source
                },
                
				//kikapcsolja mindenhol a sorbarendezés ikont (class="sorting_disable")
				//"ordering": false,
				
				"order": [
                    [1, "desc"]
                ] // set first column as a default sort by asc
            }
        });

         // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
			
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
			
				var confirm_str = '';
				if(action.val() == 'group_delete'){
					confirm_str = "Biztosan törölni akarja a kiválasztott elemeket?";
				}
				
				bootbox.setDefaults({
					locale: "hu", 
				});
				bootbox.confirm(confirm_str, function(result) {
					if (result) {

						grid.setAjaxParam("customActionType", "group_action");
						grid.setAjaxParam("customActionName", action.val());
						grid.setAjaxParam("id", grid.getSelectedRows());
						grid.getDataTable().ajax.reload();
						grid.clearAjaxParams();
				
					}
                }); 			
			
            } else if (action.val() == "") {
                Metronic.alert({
                    type: 'danger',
                    //icon: 'warning',
                    message: 'Please select an action',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                Metronic.alert({
                    type: 'danger',
                    //icon: 'warning',
                    message: 'No record selected',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });
    }   


	/**
	 *	Rekord törlése confirm
	 */
	var deleteConfirm = function () {
		$('#register_subscribe_table').on('click','a.delete_item_class', function(e){
			e.preventDefault();
			var deleteID = $(this).attr('data-id');
			var elem = this;
			
			bootbox.setDefaults({
				locale: "hu", 
			});
			bootbox.confirm("Biztosan törölni akarja a rekordot?", function(result) {
				if (result) {
					delete_items(deleteID, elem); 	
				}
			}); 

		});	
	}
	
	
	/**
	 *	Egy előregisztráció törlése
	 */
	var delete_items = function(deleteID, elem) {
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
			url: "admin/register_subscribe/ajax_delete_items",
			beforeSend: function(){
				//$('#loadingDiv').show();
				Metronic.blockUI({
					boxed: true
				});
			},
			// kész a hívás... utána ez történjen
			complete: function(){
				//$('#loadingDiv').hide();
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
						place: 'prepend'
					});
				}

			},
			error: function(result, status, e){
					alert(e);
			} 
		});		
		
	}	
	

	var hideAlert = function () {
		$('div.alert').delay( 2500 ).slideUp( 750 );						 		
	}

	
	
	var printTable = function () {
		$('#print_register').on('click', function(e){
		e.preventDefault();
		var divToPrint = document.getElementById("register_subscribe_table");
		console.log(divToPrint);
//		divToPrint = $('#jobs tr').find('th:last, td:last').remove();
		newWin= window.open("");
		newWin.document.write(divToPrint.outerHTML);
		newWin.print();
		newWin.close();
		})
	
	}

	
	
    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

            registerTable();
			deleteConfirm();
			hideAlert();
			printTable();
	
        }

    };

}();

$(document).ready(function() {    
	Metronic.init(); // init metronic core componets
	Layout.init(); // init layout
	QuickSidebar.init(); // init quick sidebar
	Demo.init(); // init demo features 
	RegisterSubscribe.init(); // init jobs page

	//másik kép nevet is megadhatunk a töltés jelzésre (kép, plugin elérési utakat is lehet így változtatni)
	//Metronic.setLoaderImage('loader.gif');
	
});