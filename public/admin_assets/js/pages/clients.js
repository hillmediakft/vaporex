/**
 Crew_members oldal
 **/
var Clients = function () {

    var clientsTable = function () {

        var table = $('#clients');
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
                    "orderable": false
                }, {
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": false
                }],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "Összes"] // change per page values here
            ],
            // set the initial value
            "pageLength": 15,
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
            "columnDefs": [{// set default column settings
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

        var tableWrapper = jQuery('#clients_wrapper');

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

    var deleteOneClientConfirm = function () {
        $('[id*=delete_client]').on('click', function (e) {
            e.preventDefault();
            var deleteLink = $(this).attr('href');
            //var jobName = $(this).closest("tr").find('td:nth-child(3)').text();

            bootbox.setDefaults({
                locale: "hu",
            });

            bootbox.confirm("Biztosan törölni akarja a kollégát?", function (result) {
                if (result) {
                    window.location.href = deleteLink;
                }
            });

        });
    }

    var deleteClientsConfirm = function () {
        $('#del_client_form').submit(function (e) {
            e.preventDefault();
            currentForm = this;
            bootbox.setDefaults({
                locale: "hu",
            });
            bootbox.confirm("Biztosan törölni akarja a kijelölt kollégákat?", function (result) {
                if (result) {
                    // a submit() nem küldi el a gomb name értékét, ezért be kell rakni egy hidden elemet
                    //$('#del_job_form').append($("<input>").attr("type", "hidden").attr("name", "delete_job_submit").val("submit"));
                    currentForm.submit();
                }
            });
        });
    }

    var enableDisableButtons = function () {

        var deleteCrew_memberSubmit = $('button[name="delete_job_submit"]');
        var checkAll = $('input.group-checkable');
        var checkboxes = $('input.checkboxes');

        deleteCrew_memberSubmit.attr('disabled', true);

        checkboxes.change(function () {
            $(this).closest("tr").find('.btn-group a').attr('disabled', $(this).is(':checked'));
            deleteCrew_memberSubmit.attr('disabled', !checkboxes.is(':checked'));
        });
        checkAll.change(function () {
            checkboxes.closest("tr").find('.btn-group a').attr('disabled', $(this).is(':checked'));
            deleteCrew_memberSubmit.attr('disabled', !checkboxes.is(':checked'));
        });

    }

    var resetSearchForm = function () {
        $('#reset_search_form').on('click', function () {
            $(':input', '#job_search_form')
                    .not(':button, :submit, :reset, :hidden')
                    .val('')
                    .removeAttr('checked')
                    .removeAttr('selected');
        });
    }

    var hideAlert = function () {
        $('div.alert').delay(2500).slideUp(750);
    }


    var makeActiveConfirm = function () {
        $('[id*=make_active], [id*=make_inactive]').on('click', function (e) {
            e.preventDefault();

            var action = $(this).attr('data-action');
            var jobId = $(this).attr('rel');
            var url = $(this).attr('href');
            var elem = this;
            //var jobName = $(this).closest("tr").find('td:nth-child(2)').text();

            bootbox.setDefaults({
                locale: "hu",
            });
            bootbox.confirm("Biztosan módosítani akarja a kolléga státuszát?", function (result) {
                if (result) {
                    makeActive(jobId, action, url, elem);
                }
            });
        });
    }

    var makeActive = function (jobId, action, url, elem) {
        //console.log(elem);
        $.ajax({
            type: "POST",
            data: {
                id: jobId,
                action: action
            },
            url: url,
            dataType: "json",
            beforeSend: function () {
                $('#loadingDiv').html('<img src="public/admin_assets/img/loader.gif">');
                $('#loadingDiv').show();
            },
            complete: function () {
                $('#loadingDiv').hide();
            },
            success: function (result) {
                if (result.status == 'success') {

                    if (action == 'make_inactive') {
                        $(elem).html('<i class="fa fa-check"></i> Aktivál');
                        $(elem).attr('data-action', 'make_active');
                        //$(elem).attr('href', 'admin/clients/make_active');
                        $(elem).closest('td').prev().html('<span class="label label-sm label-danger">Inaktív</span>');
                        $("#ajax_message").html('<div class="alert alert-success">A kolléga inaktív státuszba került!</div>');
                        hideAlert();
                    }
                    else if (action == 'make_active') {
                        $(elem).html('<i class="fa fa-ban"></i> Blokkol');
                        $(elem).attr('data-action', 'make_inactive');
                        //$(elem).attr('href', 'admin/clients/make_inactive');
                        $(elem).closest('td').prev().html('<span class="label label-sm label-success">Aktív</span>');
                        $("#ajax_message").html('<div class="alert alert-success">A kolléga aktív státuszba került!</div>');
                        hideAlert();
                    }

                } else {
                    console.log('Hiba: az adatbázis művelet nem történt meg!');
                    $("#ajax_message").html('<div class="alert alert-success">Adatbázis hiba! A kolléga státusza nem változott meg!</div>');
                    hideAlert();
                }
            },
            error: function (result, status, e) {
                alert(e);
            }
        });

    }



    /*----------------------------------------------------------*/


    var add_html = function (label, data) {
        html = '<dt style="font-size:100%; color:grey;">' + label + '</dt>' +
                '<dd>' + data + '</dd>' +
                '<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>';
        return html;
    };
    var add_html_last = function (label, data) {
        html = '<dt style="font-size:100%; color:grey;">' + label + '</dt>' +
                '<dd>' + data + '</dd>';
        return html;
    };

    var viewClientDialog = function () {

        $('[id*=details_]').on('click', function (e) {
            e.preventDefault();
            currentElem = this;
            var id = $(currentElem).attr('data-id');
            console.log(id);

            $.ajax({
                type: "POST",
                data: {id: id},
                url: "admin/clients/view_job_ajax",
                dataType: "json",
                beforeSend: function () {
                    $('#loadingDiv').html('<img src="public/admin_assets/img/loader.gif">');
                    $('#loadingDiv').show();
                },
                complete: function () {
                    $('#loadingDiv').hide();
                },
                success: function (result) {

                    var data = result[0];

                    var county_name = '';
                    if (data.county_name == 'Budapest') {
                        county_name = 'Budapest, ';
                    }

                    var city_name = '';
                    if (data.city_name != null) {
                        city_name = data.city_name;
                    }

                    var district_name = '';
                    if (data.district_name != null) {
                        district_name = data.district_name + ' kerület';
                    }

                    var munka_helye = county_name + city_name + district_name;

                    var update_date = '';
                    if (data.job_update_timestamp != null) {
                        update_date = data.job_update_timestamp;
                    }
                    var expiry_date = '';
                    if (data.job_expiry_timestamp != null) {
                        expiry_date = data.job_expiry_timestamp;
                    }

                    var job_status = '';
                    if (data.job_status == '0') {
                        job_status = 'Inaktív';
                    } else {
                        job_status = 'Aktív';
                    }

                    content = '<dl class="dl-horizontal">';
                    content += add_html('Azonosító szám', '#' + data.job_id);
                    content += add_html('Megnevezés:', data.job_title);
                    content += add_html('Munkaadó:', data.employer_name);
                    content += add_html('Típus:', data.job_list_name);
                    content += add_html('Leírás:', data.job_description);
                    content += add_html('Feltételek:', data.job_conditions);
                    content += add_html('Munkavégzés helye:', munka_helye);
                    content += add_html('Munkaidő:', data.job_working_hours);
                    content += add_html('Fizetés:', data.job_pay);
                    content += add_html('Lejárati idő:', expiry_date);
                    content += add_html('Létrehozás dátuma:', data.job_create_timestamp);
                    content += add_html('Módosítás dátuma:', update_date);
                    content += add_html_last('Státusz:', job_status);
                    content += '</dl>';

                    // bootbox dialog doboz megjelenítése
                    bootbox.dialog({
                        size: "large",
                        message: content,
                        title: "Munka részletei",
                        animate: true,
                        buttons: {
                            success: {
                                label: "Adatok módosítása",
                                className: "btn-success",
                                callback: function () {
                                    window.location.href = 'admin/clients/update_job/' + data.job_id;
                                }
                            },
                            cancel: {
                                label: "vissza",
                                className: "btn-default"
                            }
                        }
                    });

                },
                error: function (result, status, e) {
                    alert(e);
                }
            });

        });
    }


    /*----------------------------------------------------------*/


    var printTable = function () {
        $('#print_clients').on('click', function (e) {
            e.preventDefault();
            var divToPrint = document.getElementById("clients");
            console.log(divToPrint);
//		divToPrint = $('#clients tr').find('th:last, td:last').remove();
            newWin = window.open("");
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

            clientsTable();
            deleteOneClientConfirm();
            deleteClientsConfirm();
            enableDisableButtons();
            resetSearchForm();
            hideAlert();
            makeActiveConfirm();
            printTable();
            viewClientDialog();
        }

    };

}();

$(document).ready(function () {
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features 
    Clients.init(); // init clients page
});