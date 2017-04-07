/**
Employer oldal
**/
var Employer = function () {

    var employerTable = function () {

        var table = $('#employer');
		// begin first table
        
	
		table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "_START_ - _END_ elem _TOTAL_ elemből",
                "infoEmpty": "Nincs megjeleníthető adat!",
                "infoFiltered": "(Szűrve _MAX_ elemből)",
                "lengthMenu": "Show _MENU_ entries",
                "search": "Search:",
                "zeroRecords": "Nincs egyező elem"
            },

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            // "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "columns": [{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": false
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": false
            }],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 20,            
            "pagingType": "bootstrap_full_number",
            "language": {
                "search": "Keresés: ",
                "lengthMenu": "  _MENU_ elem/oldal",
                "paginate": {
                    "previous": "Előző",
                    "next": "Következő",
                    "last": "Utolsó",
                    "first": "Első"
                }
            },
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [2, "asc"]
            ] // set column as a default sort by asc
			
		
        });

        var tableWrapper = jQuery('#employer_wrapper');

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                    $(this).parents('tr').addClass("active");
                } else {
                    $(this).attr("checked", false);
                    $(this).parents('tr').removeClass("active");
                }
            });
            jQuery.uniform.update(set);
        });

        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });

        tableWrapper.find('.dataTables_length select').addClass("form-control input-sm input-inline"); // modify table per page dropdown
    }
	
	var deleteOneEmployerConfirm = function () {
	 		$('[id*=delete_employer]').on('click', function(e){
               	e.preventDefault();
				var deleteLink = $(this).attr('href');
				//var employerName = $(this).closest("tr").find('td:nth-child(3)').text();
				
				bootbox.setDefaults({
					locale: "hu", 
				});
				bootbox.confirm("Biztosan törölni akarja a munkaadót?", function(result) {
					if (result) {
						window.location.href = deleteLink; 	
					}
                }); 
            });	
	 
	}

	var hideAlert = function () {
		$('div.alert').delay( 2500 ).slideUp( 750 );						 		
	}

    var makeActiveConfirm = function () {
			$('[id*=make_active], [id*=make_inactive]').on('click', function(e){
                e.preventDefault();
				
				var action = $(this).attr('data-action');
				var employerId = $(this).attr('rel');
				var elem = this;
				var url = $(this).attr('href');
				//var employerName = $(this).closest("tr").find('td:nth-child(2)').text();
				
				bootbox.setDefaults({
					locale: "hu", 
				});
				bootbox.confirm("Biztosan módosítani akarja a munkaadó státuszát?", function(result) {
					if (result) {
						makeActive(employerId, action, url, elem);
					}
                }); 
            });	 		
	}
	
	var makeActive = function (employerId, action, url, elem) {
		$.ajax({
			type: "POST",
			data: {
				id: employerId,
				action: action
			},
			url: url,
			dataType: "json",
			beforeSend: function() {
				$('#loadingDiv').html('<img src="public/admin_assets/img/loader.gif">');
				$('#loadingDiv').show();
			},
			complete: function(){
				$('#loadingDiv').hide();
			},
			success: function (result) {
				if(result.status == 'success') {
				
					if(action == 'make_inactive') {
						$(elem).html('<i class="fa fa-check"></i> Aktivál');
						$(elem).attr('data-action', 'make_active');
						//$(elem).attr('href', 'admin/employer/make_active');
						$(elem).closest('td').prev().html('<span class="label label-sm label-danger">Inaktív</span>');
						$("#ajax_message").html('<div class="alert alert-success">A munkaadó inaktív státuszba került!</div>');
						hideAlert();
					}
					else if(action == 'make_active') {
						$(elem).html('<i class="fa fa-ban"></i> Blokkol');
						$(elem).attr('data-action', 'make_inactive');
						//$(elem).attr('href', 'admin/employer/make_inactive');
						$(elem).closest('td').prev().html('<span class="label label-sm label-success">Aktív</span>');
						$("#ajax_message").html('<div class="alert alert-success">A munkaadó aktív státuszba került!</div>');
						hideAlert();
					}
					
				} else {
					console.log('Hiba: az adatbázis művelet nem történt meg!');
					$("#ajax_message").html('<div class="alert alert-success">Adatbázis hiba! A státusz nem változott meg!</div>');
					hideAlert();
				}
			},
			error: function(result, status, e){
					alert(e);
				} 
		});

	}
	
	
	var printTable = function () {
		$('#print_employer').on('click', function(e){
		e.preventDefault();
		var divToPrint = document.getElementById("employer");
		console.log(divToPrint);
//		divToPrint = $('#employer tr').find('th:last, td:last').remove();
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
            employerTable();
			deleteOneEmployerConfirm();
			hideAlert();
			makeActiveConfirm();
			printTable();
        }

    };

}();

$(document).ready(function() {    
	Metronic.init(); // init metronic core componets
	Layout.init(); // init layout
	QuickSidebar.init(); // init quick sidebar
	Demo.init(); // init demo features 
	Employer.init(); // init Employer page
});