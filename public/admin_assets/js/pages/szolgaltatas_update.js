var UpdateSzolgaltatas = function () {

    /**
     *	Form validátor
     */
    var handleValidation = function () {
        console.log('start handleValidation');
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

        var form1 = $('#update_szolgaltatas');
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
                szolgaltatas_title: {
                    minlength: 2,
                    required: true
                },
                szolgaltatas_category_id: {
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

    var hideAlert = function () {
        $('div.alert-success, div.alert-danger').delay(2500).slideUp(750);
    }

    var ckeditorInit = function () {
        CKEDITOR.replace('szolgaltatas_description', {customConfig: 'config_custom3.js'});
        CKEDITOR.replace('szolgaltatas_info', {customConfig: 'config_custom3.js'});
    }

    /**
     *	Fájl feltöltése
     *	(kartik-bootstrap-fileinput)
     */
    var handleFileUpload = function () {
        //console.log('load_fileupload');
        $("#input-4").fileinput({
            uploadUrl: "admin/szolgaltatasok/file_upload_ajax", // server upload action
            uploadAsync: false,
            uploadExtraData: {id: $('#data_update_ajax').attr('data-id')},
            showCaption: false,
            showUpload: true,
            language: "hu",
            maxFileCount: 10,
            maxFileSize: 3000,
            allowedFileExtensions: ["jpg", "jpeg", "gif", "png", "bmp"],
            allowedPreviewTypes: ['image'],
            dropZoneEnabled: false
                    //previewSettings: {image: {width: "auto", height: "90px"}},
                    //dropZoneTitle: '',
                    //showPreview: false,
                    //showUploadedThumbs: true
                    //allowedFileTypes: ["image", "video"]
        });

        $("#input-4").on('fileloaded', function (event, file, previewId, index, reader) {
            //console.log("fileloaded");
            $('.kv-file-upload').hide();
        });
        /*
         
         $("#input-4").on('fileimageloaded', function(event, previewId) {
         console.log("fileimageloaded");
         
         });
         
         $("#input-4").on('filebatchuploadsuccess', function(event, data, previewId, index) {
         //var form = data.form; var files = data.files; var extra = data.extra; var response = data.response; var reader = data.reader;
         console.log('File batch upload success');
         });	
         $("#input-4").on('fileuploaded', function(event, data, previewId, index) {
         $('.file-preview-success').remove();
         });
         */

        $("#input-4").on('filebatchuploadsuccess', function (event, data, previewId, index) {

            var form2 = $('#upload_files_form');
            var success2 = $('.alert-success', form2);
            var success2_span = $('.alert-success > span', form2);
            var error2 = $('.alert-danger', form2);
            var error2_span = $('.alert-danger > span', form2);
            var sortable_ul = $("#photo_list");

            if (data.response.status == 'success') {
                //console.log('A feltöltés sikeres!');
                success2_span.html('Kép feltöltése sikeres.');
                success2.show();
                success2.delay(3000).fadeOut('fast');

                // képek lekérdezése a listás megjelenítéshez
                $.ajax({
                    url: "admin/szolgaltatasok/show_file_list",
                    type: 'POST',
                    //dataType: "json",
                    data: {
                        id: $('#data_update_ajax').attr('data-id'),
                        type: 'kepek'
                    },
                    success: function (result) {
                        // html képek lista
                        sortable_ul.html(result);
                        //újra el kell indítani ezt a metódust
                        delete_photo_trigger();
                    }
                });

            } else {
                //console.log(data.response);
                error2_span.html(data.response[0]);
                error2.show();
                error2.delay(3000).fadeOut('fast');
            }
        });

        $("#input-4").on('filebatchuploadcomplete', function (event, files, extra) {
            //törli a file inputot
            $('#input-4').fileinput('clear');
        });
        /*		
         
         $("#input-4").on('fileclear', function(event) {
         console.log("fileclear");
         });
         
         $("#input-4").on('filecleared', function(event) {
         console.log("filecleared");
         });	
         
         
         $("#input-4").on('filereset', function(event) {
         console.log("filereset");
         });
         */

    }

    /**
     *	Feltöltött képek sorrendjének módosítása
     *	Egy elem helyének módosítása után elküldi a kiszolgálónak a módosított sorrendet
     *	A kiszólgálón módosul a sorrend, és a pozitív válasz után...
     *	a javascript a megváltoztatott sorrendű html lista elemek id-it "visszaindexeli" - 1,2,3,4 ... sorrendbe
     */
    var itemOrder = function () {
        $("#photo_list").sortable({
            items: "li",
            distance: 10,
            cursor: "move",
            axis: "y",
            revert: true,
            opacity: 0.7,
            tolerance: "pointer",
            containment: "parent",
            update: function (event, ui) {
                // a sorok id-it felhasználva képez egy tömböt (id_neve[]=2&id_neve[]=1&id_neve[]=3&id_neve[]=4)
                var $sort_str = $(this).sortable("serialize");
                //console.log($sort_str);
                $.ajax({
                    url: "admin/szolgaltatasok/photo_sort",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        id: $('#data_update_ajax').attr('data-id'),
                        sort: $sort_str
                    },
                    beforeSend: function () {
                        $('#loadingDiv').show();
                    },
                    complete: function () {
                        $('#loadingDiv').hide();
                        //console.log('complete');
                    },
                    success: function (result) {
                        if (result.status == 'success') {
                            //console.log('sorbarendezés sikeres');
                            //újraindexeljük a listaelemek id-it, hogy a php egyszerűen feldolgozhassa a változtatást
                            $("#photo_list li").each(function (index) {
                                index += 1;
                                $(this).attr('id', 'elem_' + index);
                            });
                        } else {
                            console.log('sorbarendezési hiba a szerveren');
                        }
                    }
                });

            }
        });

    }

    /**
     *	Feltöltött kép törlése gomb
     */
    var delete_photo_trigger = function () {

        $("#photo_list li button").on("click", function () {
            var li_element = $(this).closest('li');
            var html_id = li_element.attr('id');
            // kivesszük az id elől az elem_ stringet
            $sort_id = html_id.replace(/elem_/, '');

            //console.log(html_id);	
            //console.log('törlendő elem száma: ' + $sort_id);	

            $.ajax({
                url: "admin/szolgaltatasok/file_delete",
                type: 'POST',
                dataType: "json",
                data: {
                    id: $('#data_update_ajax').attr('data-id'),
                    sort_id: $sort_id,
                    type: "kepek" //a file_delete php metódusnak mondja meg, hogy képet, vagy doc-ot kell törölni
                },
                beforeSend: function () {
                    $('#loadingDiv').show();
                },
                complete: function () {
                    console.log('complete');
                    $('#loadingDiv').hide();
                },
                success: function (result) {
                    if (result.status == 'success') {
                        //töröljük a dom-ból ezt a lista elemet
                        li_element.remove();

                        //újraindexeljük a listaelemek id-it, hogy a php egyszerűen feldolgozhassa a változtatást
                        $("#photo_list li").each(function (index) {
                            index += 1;
                            $(this).attr('id', 'elem_' + index);
                        });
                    } else {
                        console.log('Kép törlési hiba a szerveren');
                    }
                },
                error: function (result, status, e) {
                    alert(e);
                }
            });

        });
    }


    return {
        //main function to initiate the module
        init: function () {
            hideAlert();
            handleValidation();
            ckeditorInit();
            handleFileUpload();
            itemOrder();
            delete_photo_trigger();
        }
    };


}();


jQuery(document).ready(function () {
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features	
    UpdateSzolgaltatas.init();
});