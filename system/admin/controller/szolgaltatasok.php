<?php

class Szolgaltatasok extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_szolgaltatasok");
        $this->view->user = $this->user;
        $this->loadModel('szolgaltatasok_model');
    }

    public function index() {

        $this->view->title = 'Admin szolgáltatások oldal';
        $this->view->description = 'Admin szolgáltatások oldal description';

        // az oldalspecifikus css linkeket berakjuk a view objektum css_link tulajdonságába (ami egy tömb)
        // a make_link() metódus az anyakontroller metódusa (így egyszerűen meghívható bármelyik kontrollerben)
        //$this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');

        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        //$this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/media/js/jquery.dataTables.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'datatable.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/szolgaltatasok.js');

        $this->view->category_list = $this->szolgaltatasok_model->category_list_query();

        $this->view->render('szolgaltatasok/tpl_szolgaltatasok');
    }

    /**
     * 	Munka minden adatának megjelenítése
     */
    public function view_szolgaltatas() {
        $this->view->title = 'Admin munka részletek oldal';
        $this->view->description = 'Admin munka részletek oldal description';
        // az oldalspecifikus css linkeket berakjuk a view objektum css_link tulajdonságába (ami egy tömb)
        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');

        $this->view->content = $this->szolgaltatasok_model->one_szolgaltatas_alldata_query($this->registry->params['id']);

//$this->view->debug(true);

        $this->view->render('szolgaltatasok/tpl_szolgaltatasok_view');
    }

    /**
     * 	Munka minden adatának megjelenítése
     */
    public function view_szolgaltatas_ajax() {
        if (Util::is_ajax()) {
            $this->view->content = $this->szolgaltatasok_model->one_szolgaltatas_alldata_query_ajax();
            
            $this->view->services = $this->szolgaltatasok_model->get_szolgaltatas_services($this->view->content['szolgaltatas_services']);
            $this->view->location = $this->view->content['city_name'] . ' ' . $this->view->content['district_name'];
            $this->view->render('szolgaltatasok/tpl_szolgaltatas_view_modal', true);
        } else {
            Util::redirect('error');
        }
    }

    /**
     * 	Új szolgaltatas hozzáadása
     */
    public function uj_szolgaltatas() {
        // új munka hozzáadása
        if (!empty($_POST)) {

            $result = $this->szolgaltatasok_model->insert_szolgaltatas();
            if ($result) {
                Util::redirect('szolgaltatasok');
            } else {
                Util::redirect('szolgaltatasok/uj_szolgaltatas');
            }
        }

        // HTML oldal megjelenítése
        // adatok bevitele a view objektumba
        $this->view->title = 'Új munka oldal';
        $this->view->description = 'Új munka description';
        // css linkek generálása
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
      //  $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/jquery-multi-select/css/multi-select.css');

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/css/datepicker.css');
    //    $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-multi-select/js/jquery.multi-select.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/ckeditor/ckeditor.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');
        //datepicker	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.hu.js');
        //form validator	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/jquery.validate.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/localization/messages_hu.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/uj_szolgaltatas.js');
        
        $this->view->category_list = $this->szolgaltatasok_model->category_list_query();

//$this->view->debug(true);
        // template betöltése
        $this->view->render('szolgaltatasok/tpl_uj_szolgaltatas');
    }

    /**
     * 	Munka módosítása
     *
     */
    public function update_szolgaltatas() {
        $id = (int) $this->registry->params['id'];

        if (!empty($_POST)) {
            $result = $this->szolgaltatasok_model->update_szolgaltatas($id);

            if ($result) {
                Util::redirect('szolgaltatasok');
            } else {
                Util::redirect('szolgaltatasok/update_szolgaltatas/' . $id);
            }
        }

        // HTML oldal megjelenítése
        // adatok bevitele a view objektumba
        $this->view->title = 'Szolgáltatás módosítása oldal';
        $this->view->description = 'Szolgáltatás módosítása description';
        // css linkek generálása
                $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
      //  $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/jquery-multi-select/css/multi-select.css');
        // css linkek generálása
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/kartik-bootstrap-fileinput/css/fileinput.css');

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/css/datepicker.css');
    //    $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-multi-select/js/jquery.multi-select.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/ckeditor/ckeditor.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');
        //datepicker	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.hu.js');
        //form validator	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/jquery.validate.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/localization/messages_hu.js');
        
        // js linkek generálása
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2_locale_hu.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/kartik-bootstrap-fileinput/js/fileinput.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/kartik-bootstrap-fileinput/js/fileinput_locale_hu.js');
 $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/szolgaltatas_update.js');

        // a módosítandó munka adatai
        $this->view->actual_szolgaltatas = $this->szolgaltatasok_model->one_szolgaltatas_query($id);
         $this->view->category_list = $this->szolgaltatasok_model->category_list_query();

//$this->view->debug(true);
        // template betöltése
        $this->view->render('szolgaltatasok/tpl_update_szolgaltatas');
    }


    /* --------------------------------------------------------------------------------- */

    /**
     * 	1 munka törlése
     */
    public function ajax_delete_szolgaltatas() {
        if (isset($_POST['delete_id'])) {
            // ez a metódus true-val tér vissza (false esetén kivételt dob!)
            $result = $this->szolgaltatasok_model->delete_szolgaltatas(array($_POST['delete_id']));

            // visszatérés üzenetekkel
            if ($result['success'] == 1) {
                $message = Message::send('A szolgáltatás törlése sikerült!');
                echo json_encode(array(
                  "status" => 'success',
                  "message" => $message
                ));
            } else {
                $message = Message::send('A szolgáltatás nem törölhető!');
                echo json_encode(array(
                  "status" => 'error',
                  "message" => $message
                ));
            }
        } else {
            throw new Exception('HIBA az ajax_delete_szolgaltatasok metódusban: Nem létezik $_POST["delete_id"]');
        }
    }

  

    /**
     * 	Munkák listáját adja vissza és kezeli a csoportos művelteket is
     */
    public function ajax_get_szolgaltatasok() {
        if (Util::is_ajax()) {
            $request_data = $_REQUEST;
            $json_data = $this->szolgaltatasok_model->ajax_get_szolgaltatasok($request_data);

// adatok visszaküldése a javascriptnek
            $json_data = Util::convert_array_to_utf8($json_data);

            if (json_encode($json_data)) {
                echo json_encode($json_data);
            } else {
                echo json_last_error_msg();
            }
        } else {
            Util::redirect('error');
        }
    }
    
/**
     * 	Munka kategóriák megjelenítése
     */
    public function category() {
        $this->check_access("menu_szolgaltatasok_category");
        // adatok bevitele a view objektumba
        $this->view->title = 'Admin szolgáltatások kategória oldal';
        $this->view->description = 'Admin munka szolgáltatások description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');

        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/media/js/jquery.dataTables.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'datatable.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/szolgaltatasok_category.js');

        $this->view->all_szolgaltatasok_category = $this->szolgaltatasok_model->szolgaltatas_list_query();
        $this->view->category_counter = $this->szolgaltatasok_model->szolgaltatasok_category_counter_query();

//$this->view->debug(true);			

        $this->view->render('szolgaltatasok/tpl_szolgaltatasok_category');
    }
    
    /**
     * 	Új munka kategória hozzáadása
     */
    public function category_insert() {
      

        // új munka kategória hozzáadása
        if (isset($_POST['szolgaltatas_list_name'])) {
            $result = $this->szolgaltatasok_model->category_insert();

            if ($result) {
                Util::redirect('szolgaltatasok/category');
            } else {
                Util::redirect('szolgaltatasok/category_insert');
            }
        }

        $this->view->title = 'Új munka kategória hozzáadása oldal';
        $this->view->description = 'Új munka kategória description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');

        //form validator	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/jquery.validate.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/localization/messages_hu.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/szolgaltatas_category_insert_update.js');
        //$this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');	
        // template betöltése
        $this->view->render('szolgaltatasok/tpl_szolgaltatas_category_insert');
    }

    /**
     * 	Munka kategória nevének módosítása
     */
    public function category_update() {
     
   
        $id = (int) $this->registry->params['id'];

        if (isset($_POST['szolgaltatas_list_name'])) {
            $result = $this->szolgaltatasok_model->category_update($id);
            if ($result) {
                Util::redirect('szolgaltatasok/category');
            } else {
                Util::redirect('szolgaltatasok/category_update/' . $id);
            }
        }

        $this->view->title = 'Admin munka kategória módosítása oldal';
        $this->view->description = 'Admin munka kategória módosítása description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');
        //form validator	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/jquery.validate.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/localization/messages_hu.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/szolgaltatas_category_insert_update.js');


        //$this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');	   

        $this->view->category_content = $this->szolgaltatasok_model->szolgaltatas_list_query($id);

        $this->view->render('szolgaltatasok/tpl_szolgaltatas_category_update');
    }    
    

    /**
     * (AJAX) A szolgaltatasok táblában módosítja az szolgaltatasok_status mező értékét
     * 1 munka státuszát módosítja
     *
     * @return void
     */
    public function ajax_change_status() {
        if (Util::is_ajax()) {
            if (isset($_POST['action']) && isset($_POST['id'])) {

                $id = (int) $_POST['id'];
                $action = $_POST['action'];

                if ($action == 'make_active') {
                    $result = $this->szolgaltatasok_model->change_status_query(array($id), 1);
                    if ($result['success'] == 1) {
                        $message = Message::send('A munka aktív státuszba került!');
                        echo json_encode(array(
                          "status" => 'success',
                          "message" => $message
                        ));
                    } else {
                        $message = Message::send();
                        echo json_encode(array(
                          "status" => 'error',
                          "message" => $message
                        ));
                    }
                }
                if ($action == 'make_inactive') {
                    $result = $this->szolgaltatasok_model->change_status_query(array($id), 0);
                    if ($result['success'] == 1) {
                        $message = Message::send('A munka inaktív státuszba került!');
                        echo json_encode(array(
                          "status" => 'success',
                          "message" => $message
                        ));
                    } else {
                        $message = Message::send('A munka státusza nem változott meg!');
                        echo json_encode(array(
                          "status" => 'error',
                          "message" => $message
                        ));
                    }
                }
            } else {
                throw new Exception('Nincs $_POST["action"] es $_POST["id"]!!!');
            }
        } else {
            Util::redirect('error');
        }
    }

    /**
     * 	(AJAX) - Visszadja a kiválasztott megye városainak option listáját  
     */
    public function county_city_list() {
        if (Util::is_ajax()) {
            if (isset($_POST["county_id"])) {
                $id = (int) $_POST["county_id"];
                $result = $this->szolgaltatasok_model->city_list_query($id);

                $string = '<option value="">Válasszon</option>' . "\r\n";
                foreach ($result as $value) {
                    $string .= '<option value="' . $value['city_id'] . '">' . $value['city_name'] . '</option>' . "\r\n";
                }
                //válasz a javascriptnek (option lista)
                echo $string;
            }
        } else {
            Util::redirect('error');
        }
    }
    
     /**
     * Kategória törlése
     *
     * @return void
     */
    public function category_delete() {

        $this->szolgaltatasok_model->delete_category();
        Util::redirect('szolgaltatasok/category');
    } 
    
   /**
     * 	(AJAX) File listát jeleníti (frissíti) meg feltöltéskor (képek)
     */
    public function show_file_list() {
        if (Util::is_ajax()) {
            // db rekord id-je
            $id = (int) $_POST['id'];
            // típus: kepek vagy docs
            $type = $_POST['type'];

            //adatok lekérdezése (a json stringet adja vissza)
            $result = $this->szolgaltatasok_model->file_data_query($id);
            // json string átalakítása tömb-bé
            $temp_arr = json_decode($result);

            // lista HTML generálása
            $html = '';
            $counter = 0;


                $file_location = Config::get('szolgaltatasphoto.upload_path');

                foreach ($temp_arr as $key => $value) {
                    $counter = $key + 1;
                    $file_path = Util::thumb_path($file_location . $value);
                    $html .= '<li id="elem_' . $counter . '" class="ui-state-default"><img style="width:100px" class="img-thumbnail" src="' . $file_path . '" alt="" /><button style="position:absolute; top:20px; right:20px; z-index:2;" class="btn btn-xs btn-default" type="button" title="Kép törlése"><i class="fa fa-trash"></i></button></li>' . "\n\r";
                }
      


            // lista visszaküldése a javascriptnek
            echo $html;
        } else {
            Util::redirect('error');
        }
    }

    /**
     * 	Képek sorbarendezése (AJAX)
     * 	
     */
    public function photo_sort() {
        if (Util::is_ajax()) {
            $id = (int) $_POST['id'];
            $sort_json = $_POST['sort'];

            $result = $this->szolgaltatasok_model->photo_sort($id, $sort_json);

            if ($result) {
                echo json_encode(array('status' => 'success'));
            } else {
                echo json_encode(array('status' => 'error'));
            }
        } else {
            Util::redirect('error');
        }
    }

    /**
     * 	(AJAX) Kép vagy dokumentum törlése a feltöltöttek listából
     */
    public function file_delete() {
        if (Util::is_ajax()) {
            $id = (int) $_POST['id'];
            // a kapott szorszámból kivonunk egyet, mert a képeket tartalamzó tömbben 0-tól indul a számozás
            $sort_id = ((int) $_POST['sort_id']) - 1;

            $result = $this->szolgaltatasok_model->file_delete($id, $sort_id);

            if ($result) {
                $message = Message::send('A file törölve!');
                echo json_encode(array(
                  'status' => 'success',
                  'message' => $message
                ));
            } else {
                echo json_encode(array('status' => 'error'));
            }
        } else {
            Util::redirect('error');
        }
    }

    /**
     * 	(AJAX) File feltöltés (képek)
     */
    public function file_upload_ajax() {
        if (Util::is_ajax()) {
            //uploadExtraData beállítás küldi
            $id = (int) $_POST['id'];
            $photo_names = $this->szolgaltatasok_model->upload_szolgaltatas_extra_photos($_FILES['new_file']);
            $result = $this->szolgaltatasok_model->szolgaltatas_file_query($photo_names, $id);

            if ($result) {
                echo json_encode(array('status' => 'success'));
            } else {
                echo json_encode(array('status' => 'error'));
            }
        } else {
            Util::redirect('error');
        }
    }
    




   

}

?>