/**
 Szolgaltatasok oldal
 **/
var Szolgaltatasok = function () {

    var szolgaltatasokTable = function () {
        var grid = new Datatable();

        grid.init({
            src: $("#szolgaltatasok"),
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
                "columnDefs": [
                    {"name": "chechbox", "searchable": false, "orderable": false, "targets": 0},
                    {"name": "szolgaltatas_id", "searchable": false, "orderable": true, "targets": 1},
                    {"name": "szolgaltatas_photo", "searchable": true, "orderable": true, "targets": 2},
                    {"name": "szolgaltatas_title", "searchable": true, "orderable": true, "targets": 3},
                    {"name": "szolgaltatas_list_name", "searchable": true, "orderable": true, "targets": 4},
                    {"name": "szolgaltatas_description", "searchable": false, "orderable": false, "targets": 5},
                    {"name": "megtekintes", "searchable": false, "orderable": true, "targets": 6},
                    {"name": "szolgaltatas_status", "searchable": true, "orderable": true, "targets": 7},
                    {"name": "menu", "searchable": false, "orderable": false, "targets": 8}

                ],
                // ha a php asszociatív tömböt ad vissza (pl.: 'name' => 'László', 'age' => '38', 'haircolor' => 'blonde' ...), akkor meg kell adni az egyes elem nevét!	
                // (ha a php számmal indexelt tömböt ad vissza (pl.: 'László', '38', 'Blonde' ...), akkor nem kell ez a beállítás!)	
                "columns": [
                    {"data": "checkbox"},
                    {"data": "id"},
                    {"data": "foto"},
                    {"data": "nev"},
                    {"data": "kategoria"},
                    {"data": "leiras"},
                    {"data": "megtekintes"},
                    {"data": "status"},
                    {"data": "menu"}
                ],
                "lengthMenu": [
                    [10, 20, 50, 100, 150],
                    [10, 20, 50, 100, 150] // change per page values here 
                ],
                "pageLength": 100, // default record count per page

                "ajax": {
                    "url": "admin/szolgaltatasok/ajax_get_szolgaltatasok", // ajax source
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
                    confirm_str = "Biztosan végre akarja hajtani a szolgáltatások aktiválását?";
                }
                else if (action.val() == 'group_make_inactive') {
                    confirm_str = "Biztosan végre akarja hajtani a szolgáltatások inaktiválását?";
                }
                else if (action.val() == 'group_delete') {
                    confirm_str = "Biztosan törölni akarja a szolgáltatást?";
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
                    icon: 'warning',
                    message: 'Válasszon csoportműveletet!',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                Metronic.alert({
                    type: 'danger',
                    icon: 'warning',
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
    var deleteOneSzolgaltatasConfirm = function () {
        $('#szolgaltatasok').on('click', 'a.delete_szolgaltatas_class', function (e) {
            e.preventDefault();
            var elem = $(this);
            var deleteID = elem.attr('data-id');
            //var szolgaltatasName = $(this).closest("tr").find('td:nth-child(3)').text();

            bootbox.setDefaults({
                locale: "hu",
            });
            bootbox.confirm("Biztosan törölni akarja a szolgáltatást?", function (result) {
                if (result) {
                    delete_szolgaltatas(deleteID, elem);
                }
            });

        });
    };


    /**
     *	Egy munka törlése
     */
    var delete_szolgaltatas = function (deleteID, elem) {
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
            url: "admin/szolgaltatasok/ajax_delete_szolgaltatas",
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
     
     var deleteJobSubmit = $('button[name="delete_szolgaltatas_submit"]');
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
     $(':input', '#szolgaltatas_search_form')
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
    var cloneRendezvenyConfirm = function () {
        $('#szolgaltatasok').on('click', 'a.clone_szolgaltatas', function (e) {
            e.preventDefault();

            var elem = $(this);
            var cloneID = elem.attr('data-id');
            //var szolgaltatasName = $(this).closest("tr").find('td:nth-child(3)').text();

            bootbox.setDefaults({
                locale: "hu",
            });
            bootbox.confirm("Biztosan klónozni akarja a szolgáltatást?", function (result) {
                if (result) {
                    clone_szolgaltatas(cloneID, elem);
                }
            });

        });
    };

    /**
     *	Egy munka klónozása
     */
    var clone_szolgaltatas = function (cloneID, elem) {

        //végrehajtjuk az AJAX hívást
        $.ajax({
            type: "POST",
            //contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            data: {
                clone_id: cloneID
            },
            dataType: "json",
            // a feldolgozó url-je
            url: "admin/szolgaltatasok/ajax_clone_szolgaltatas",
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
                $('#szolgaltatasok').DataTable().ajax.reload();

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
        $('#szolgaltatasok').on('click', '.change_status', function (e) {
            e.preventDefault();

            var action = $(this).attr('data-action');
            var szolgaltatasId = $(this).attr('data-id');
            var elem = this;
            //var szolgaltatasName = $(this).closest("tr").find('td:nth-child(2)').text();

            bootbox.setDefaults({
                locale: "hu",
            });
            bootbox.confirm("Biztosan módosítani akarja a szolgáltatás státuszát?", function (result) {
                if (result) {
                    makeActive(szolgaltatasId, action, elem);
                }
            });
        });
    };

    /**
     *	Egy munka státusz módosítását kezeli
     *
     */
    var makeActive = function (szolgaltatasId, action, elem) {
        //console.log(elem);
        $.ajax({
            type: "POST",
            data: {
                id: szolgaltatasId,
                action: action
            },
            url: 'admin/szolgaltatasok/ajax_change_status',
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
        $('#print_szolgaltatasok').on('click', function (e) {
            e.preventDefault();
            var divToPrint = $('#szolgaltatasok');
            console.log(divToPrint.html());

            //        console.log(divToPrint.html());
            newWin = window.open("");
            newWin.document.write('\
<html>\n\
<head>\n\
<title>Szolgáltatások / játékok</title>\n\
<link href="public/admin_assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>\n\
<link href="public/admin_assets/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>\n\
<link href="public/admin_assets/css/print.css?v2" rel="stylesheet" type="text/css"/>\n\
</head>\n\
<body>\n\
<div class="container">\n\
<div class="row">\n\
<h3>Szolgáltatások / játékok</h3\n\
><table class="table table-striped table-bordered">');
            newWin.document.write(divToPrint.html());
            newWin.document.write('\
</table>\n\
</div>\n\
</div>\n\
</body></html>');
     //       newWin.print();
     //       newWin.close();
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

            szolgaltatasokTable();
            deleteOneSzolgaltatasConfirm();
            cloneRendezvenyConfirm();
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
    Szolgaltatasok.init(); // init szolgaltatasok page

    //másik kép nevet is megadhatunk a töltés jelzésre (kép, plugin elérési utakat is lehet így változtatni)
    //Metronic.setLoaderImage('loader.gif');
});