/**
 Jobs oldal
 **/
var Jobs = function () {

    var jobsTable = function () {
        var grid = new Datatable();

        grid.init({
            src: $("#jobs"),
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


                /*				
                 // A columnDefs opciót nem kell megadni, de hasznos lehet
                 // a php feldolgozónak küld a táblázatról információkat, azért hogy a szever a megfelelő adatokat adhassa vissza pl. szűrésnél
                 "columnDefs": [
                 //oszlopok elnevezése (a targets elem elhagyható)
                 
                 { "name": "chechbox",   "targets": 0 },
                 { "name": "id",  "targets": 1 },
                 { "name": "megnevezes", "targets": 2 },
                 { "name": "kategoria",  "targets": 3 },
                 { "name": "ceg_neve",    "targets": 4 },
                 { "name": "letrehozva",    "targets": 5 },
                 { "name": "modositva",    "targets": 6 },
                 { "name": "status",    "targets": 7 },
                 { "name": "menu",    "targets": 8 },
                 
                 //oszlopok searchable beállítása (a targets elem elhagyható)
                 { "searchable": false,   "targets": 0 },
                 { "searchable": false,  "targets": 1 },
                 { "searchable": false, "targets": 2 },
                 { "searchable": false,  "targets": 3 },
                 { "searchable": false,    "targets": 4 },
                 { "searchable": false,    "targets": 5 },
                 { "searchable": false,    "targets": 6 },
                 { "searchable": false,    "targets": 7 },
                 { "searchable": false,    "targets": 8 },
                 
                 //oszlopok adatok sorrendbe rendezését kapcsolja (a targets elem elhagyható)
                 { "orderable": false,    "targets": 0 },
                 { "orderable": true,     "targets": 1 },
                 { "orderable": false,    "targets": 2 },
                 { "orderable": false,	   "targets": 3 },
                 { "orderable": false, "targets": 4 },
                 { "orderable": false,    "targets": 5 },
                 { "orderable": false,    "targets": 6 },
                 { "orderable": false,    "targets": 7 },
                 { "orderable": false,    "targets": 8 }
                 
                 ],
                 */





                // A columnDefs opciót nem kell megadni a datatable működéséhez, de elengedhetetlenül hasznos
                // a php feldolgozónak küld a táblázatról információkat, azért hogy a szever a megfelelő adatokat adhasson vissza pl. szűrésnél
                "columnDefs": [
                    {"name": "chechbox", "searchable": false, "orderable": false, "targets": 0},
                    {"name": "job_id", "searchable": false, "orderable": true, "targets": 1},
                    {"name": "job_city_id", "searchable": true, "orderable": true, "targets": 2},
                    {"name": "job_title", "searchable": true, "orderable": true, "targets": 3},
                    {"name": "job_category_id", "searchable": true, "orderable": false, "targets": 4},
                    {"name": "job_employer_id", "searchable": true, "orderable": false, "targets": 5},
                    {"name": "job_create_timestamp", "searchable": false, "orderable": true, "targets": 6},
                    {"name": "job_ref_id", "searchable": true, "orderable": true, "targets": 7},
                    {"name": "job_status", "searchable": true, "orderable": true, "targets": 8},
                    {"name": "menu", "searchable": false, "orderable": false, "targets": 9}

                ],
                // ha a php asszociatív tömböt ad vissza (pl.: 'name' => 'László', 'age' => '38', 'haircolor' => 'blonde' ...), akkor meg kell adni az egyes elem nevét!	
                // (ha a php számmal indexelt tömböt ad vissza (pl.: 'László', '38', 'Blonde' ...), akkor nem kell ez a beállítás!)	
                "columns": [
                    {"data": "checkbox"},
                    {"data": "id"},
                    {"data": "varos"},
                    {"data": "megnevezes"},
                    {"data": "kategoria"},
                    {"data": "ceg_neve"},
                    {"data": "letrehozva"},
                    {"data": "referens"},
                    {"data": "status"},
                    {"data": "menu"}
                ],
                "lengthMenu": [
                    [10, 20, 50, 100, 150],
                    [10, 20, 50, 100, 150] // change per page values here 
                ],
                "pageLength": 20, // default record count per page

                "ajax": {
                    "url": "admin/jobs/ajax_get_jobs", // ajax source
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
                if (action.val() == 'group_make_active') {
                    confirm_str = "Biztosan végre akarja hajtani a munkák aktiválását?";
                }
                else if (action.val() == 'group_make_inactive') {
                    confirm_str = "Biztosan végre akarja hajtani a munkák inaktiválását?";
                }
                else if (action.val() == 'group_delete') {
                    confirm_str = "Biztosan törölni akarja a munkákat?";
                }

                bootbox.setDefaults({
                    locale: "hu",
                });
                bootbox.confirm(confirm_str, function (result) {
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
                    message: 'Válasszon csoportműveletet!',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                Metronic.alert({
                    type: 'danger',
                    //icon: 'warning',
                    message: 'Nem jelölt ki semmit!',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });
    };


    /**
     *	Munka törlése confirm
     */
    var deleteOneJobConfirm = function () {
        $('#jobs').on('click', 'a.delete_job_class', function (e) {
            e.preventDefault();
            var elem = $(this);
            var deleteID = elem.attr('data-id');
            //var jobName = $(this).closest("tr").find('td:nth-child(3)').text();

            bootbox.setDefaults({
                locale: "hu",
            });
            bootbox.confirm("Biztosan törölni akarja a munkát?", function (result) {
                if (result) {
                    delete_job(deleteID, elem);
                }
            });

        });
    };


    /**
     *	Egy munka törlése
     */
    var delete_job = function (deleteID, elem) {
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
            url: "admin/jobs/ajax_delete_job",
            beforeSend: function () {
                //$('#loadingDiv').show();
                Metronic.blockUI({
                    boxed: true
                });
            },
            // kész a hívás... utána ez történjen
            complete: function () {
                //$('#loadingDiv').hide();
                Metronic.unblockUI();
            },
            // itt kapjuk meg (és dolgozzuk fel) a feldolgozó php által visszadott adatot 
            success: function (response) {
                console.log(response);
                if (response.status == 'success') {
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

                if (response.status == 'error') {
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
            error: function (result, status, e) {
                alert(e);
            }
        });

    };

    /*	
     var enableDisableButtons = function () {
     
     var deleteJobSubmit = $('button[name="delete_job_submit"]');
     var checkAll = $('input.group-checkable');
     var checkboxes = $('input.checkboxes');
     
     deleteJobSubmit.attr('disabled', true);
     
     checkboxes.change(function(){
     $(this).closest("tr").find('.btn-group a').attr('disabled', $(this).is(':checked'));
     deleteJobSubmit.attr('disabled', !checkboxes.is(':checked'));
     });		
     checkAll.change(function(){
     checkboxes.closest("tr").find('.btn-group a').attr('disabled', $(this).is(':checked'));
     deleteJobSubmit.attr('disabled', !checkboxes.is(':checked'));
     });	
     
     }
     
     var resetSearchForm = function () {
     $('#reset_search_form').on('click', function(){
     $(':input', '#job_search_form')
     .not(':button, :submit, :reset, :hidden')
     .val('')
     .removeAttr('checked')
     .removeAttr('selected');
     }); 								 		
     }
     */

    /**
     *	Munka klónozása confirm
     */
    var cloneJobConfirm = function () {
        $('#jobs').on('click', 'a.clone_job', function (e) {
            e.preventDefault();
           
            var elem = $(this);
            var cloneID = elem.attr('data-id');
            //var jobName = $(this).closest("tr").find('td:nth-child(3)').text();

            bootbox.setDefaults({
                locale: "hu",
            });
            bootbox.confirm("Biztosan klónozni akarja a munkát?", function (result) {
                if (result) {
                    clone_job(cloneID, elem);
                }
            });

        });
    };

    /**
     *	Egy munka klónozása
     */
    var clone_job = function (cloneID, elem) {

        //végrehajtjuk az AJAX hívást
        $.ajax({
            type: "POST",
            //contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            data: {
                clone_id: cloneID
            },
            dataType: "json",
            // a feldolgozó url-je
            url: "admin/jobs/ajax_clone_job",
            beforeSend: function () {
                //$('#loadingDiv').show();
                Metronic.blockUI({
                    boxed: true
                });
            },
            // kész a hívás... utána ez történjen
            complete: function () {
                //$('#loadingDiv').hide();
                
                Metronic.unblockUI();
$('#jobs').DataTable().ajax.reload();
                
            },
            // itt kapjuk meg (és dolgozzuk fel) a feldolgozó php által visszadott adatot 
            success: function (response) {
                console.log(response);
                if (response.status == 'success') {
                    Metronic.alert({
                        type: 'success',
                        //icon: 'warning',
                        message: response.message,
                        container: $('#ajax_message'),
                        closeInSeconds: 3,
                        place: 'prepend'
                    });

                }

                if (response.status == 'error') {
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
            error: function (result, status, e) {
                alert(e);
            }
        });

    };


    var hideAlert = function () {
        $('div.alert').delay(2500).slideUp(750);
    };

    var makeActiveConfirm = function () {
        $('#jobs').on('click', '.change_status', function (e) {
            e.preventDefault();

            var action = $(this).attr('data-action');
            var jobId = $(this).attr('data-id');
            var elem = this;
            //var jobName = $(this).closest("tr").find('td:nth-child(2)').text();

            bootbox.setDefaults({
                locale: "hu",
            });
            bootbox.confirm("Biztosan módosítani akarja a munka státuszát?", function (result) {
                if (result) {
                    makeActive(jobId, action, elem);
                }
            });
        });
    };

    /**
     *	Egy munka státusz módosítását kezeli
     *
     */
    var makeActive = function (jobId, action, elem) {
        //console.log(elem);
        $.ajax({
            type: "POST",
            data: {
                id: jobId,
                action: action
            },
            url: 'admin/jobs/ajax_change_status',
            dataType: "json",
            beforeSend: function () {
                //$('#loadingDiv').show();
                Metronic.blockUI({
                    //message: 'Betöltés...',
                    boxed: true
                });
            },
            complete: function () {
                //$('#loadingDiv').hide();
                Metronic.unblockUI();
            },
            success: function (result) {
                if (result.status == 'success') {

                    if (action == 'make_inactive') {
                        $(elem).html('<i class="fa fa-check"></i> Aktivál');
                        $(elem).attr('data-action', 'make_active');
                        $(elem).closest('td').prev().html('<span class="label label-sm label-danger">Inaktív</span>');

                        Metronic.alert({
                            type: 'success',
                            //icon: 'warning',
                            message: result.message,
                            container: $('#ajax_message'),
                            place: 'prepend',
                            closeInSeconds: 3
                        });
                    }
                    else if (action == 'make_active') {
                        $(elem).html('<i class="fa fa-ban"></i> Blokkol');
                        $(elem).attr('data-action', 'make_inactive');
                        $(elem).closest('td').prev().html('<span class="label label-sm label-success">Aktív</span>');

                        Metronic.alert({
                            type: 'success',
                            //icon: 'warning',
                            message: result.message,
                            container: $('#ajax_message'),
                            place: 'prepend',
                            closeInSeconds: 3
                        });
                    }

                } else {
                    //console.log('Hiba: az adatbázis művelet nem történt meg!');
                    Metronic.alert({
                        type: 'danger',
                        //icon: 'warning',
                        message: result.message,
                        container: $('#ajax_message'),
                        place: 'prepend',
                        closeInSeconds: 3
                    });
                }
            },
            error: function (result, status, e) {
                alert(e);
            }
        });

    };

    var printTable = function () {
        $('#print_jobs').on('click', function (e) {
            e.preventDefault();
            var divToPrint = document.getElementById("jobs");
            console.log(divToPrint);
//		divToPrint = $('#jobs tr').find('th:last, td:last').remove();
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        })

    };

    var handle_modal = function () {
        // amikor megjelenik a modal
        $('#ajax_modal').on('show.bs.modal', function () {
            $('body').addClass('modal-open-noscroll');
        });
        // amikor eltűnik a modal
        $('#ajax_modal').on('hidden.bs.modal', function () {
            $('#modal_container').html('');
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

            jobsTable();
            deleteOneJobConfirm();
            cloneJobConfirm();
            //enableDisableButtons();
            //resetSearchForm();
            hideAlert();
            makeActiveConfirm();
            printTable();
            handle_modal();

        }
    };

}();

$(document).ready(function () {
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features 
    Jobs.init(); // init jobs page

    //másik kép nevet is megadhatunk a töltés jelzésre (kép, plugin elérési utakat is lehet így változtatni)
    //Metronic.setLoaderImage('loader.gif');
});