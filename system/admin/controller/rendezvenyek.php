<?php

class Rendezvenyek extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_rendezvenyek");
        $this->view->user = $this->user;
        $this->loadModel('rendezvenyek_model');
    }

    public function index() {

        $this->view->title = 'Admin rendezvények oldal';
        $this->view->description = 'Admin rendezvények oldal description';

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

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/rendezvenyek.js');


        $this->view->city_list = $this->rendezvenyek_model->city_list_query();

//$this->view->debug(true);

        $this->view->render('rendezvenyek/tpl_rendezvenyek');
    }

    /**
     * 	Munka minden adatának megjelenítése
     */
    public function view_rendezveny() {
        $this->view->title = 'Admin munka részletek oldal';
        $this->view->description = 'Admin munka részletek oldal description';
        // az oldalspecifikus css linkeket berakjuk a view objektum css_link tulajdonságába (ami egy tömb)
        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');

        $this->view->content = $this->rendezvenyek_model->one_job_alldata_query($this->registry->params['id']);

//$this->view->debug(true);

        $this->view->render('rendezvenyek/tpl_job_view');
    }

    /**
     * 	Munka minden adatának megjelenítése
     */
    public function view_rendezveny_ajax() {
        if (Util::is_ajax()) {
            $this->view->content = $this->rendezvenyek_model->one_rendezveny_alldata_query_ajax();
            
            $this->view->szolgaltatasok = $this->rendezvenyek_model->get_rendezveny_szolgaltatasok($this->view->content['rendezveny_szolgaltatasok']);
            $this->view->location = $this->view->content['city_name'] . ' ' . $this->view->content['district_name'];
            $this->view->render('rendezvenyek/tpl_rendezveny_view_modal', true);
        } else {
            Util::redirect('error');
        }
    }

    /**
     * 	Új munka hozzáadása
     */
    public function uj_rendezveny() {
        // új munka hozzáadása
        if (!empty($_POST)) {

            $result = $this->rendezvenyek_model->insert_rendezveny();
            if ($result) {
                Util::redirect('rendezvenyek');
            } else {
                Util::redirect('rendezvenyek/uj_rendezveny');
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
        
        
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
        
        

  //      $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/css/datepicker.css');
    //    $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-multi-select/js/jquery.multi-select.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/ckeditor/ckeditor.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');
  $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/moment/moment.js');   $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/moment/locale/hu.js');    

//datepicker	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js');
        
        
  //      $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
 //       $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.hu.js');
        //form validator	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/jquery.validate.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/localization/messages_hu.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/uj_rendezveny.js');

        // ck_editor bekapcsolása
        //$this->view->ckeditor = true;
        // Megyék adatainak lekérdezése az option listához
        $this->view->county_list = $this->rendezvenyek_model->county_list_query();
                // kerületek nevének és id-jének lekérdezése az option listához
        $this->view->city_list = $this->rendezvenyek_model->city_list_query();
        // munkaadók nevének és id-jének lekérdezése az option listához
        $this->view->facebook_site_list = $this->rendezvenyek_model->facebook_site_list_query();

        // játékok nevének és id-jének lekérdezése az option listához
        $this->view->szolgaltatasok_list = $this->rendezvenyek_model->szolgaltatasok_list_query();
        
        // kerületek nevének és id-jének lekérdezése az option listához
        $this->view->district_list = $this->rendezvenyek_model->district_list_query();

        // userek lekérdezése
        if (Session::get('user_role_id') == 1) {
            $this->view->user_list = $this->rendezvenyek_model->user_list_query();
        }
//$this->view->debug(true);
        // template betöltése
        $this->view->render('rendezvenyek/tpl_uj_rendezveny');
    }

    /**
     * 	Munka módosítása
     *
     */
    public function update_rendezveny() {
        $id = (int) $this->registry->params['id'];

        if (!empty($_POST)) {
            $result = $this->rendezvenyek_model->update_rendezveny($id);

            if ($result) {
                Util::redirect('rendezvenyek');
            } else {
                Util::redirect('rendezvenyek/update_rendezveny/' . $id);
            }
        }

        // HTML oldal megjelenítése
        // adatok bevitele a view objektumba
        $this->view->title = 'Rendezvény módosítása oldal';
        $this->view->description = 'Rendezvény módosítása description';
        // css linkek generálása
                $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
      //  $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/jquery-multi-select/css/multi-select.css');
 $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
   //     $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/css/datepicker.css');
    //    $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-multi-select/js/jquery.multi-select.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/ckeditor/ckeditor.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');
        //datepicker
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/moment/moment.js');   $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/moment/locale/hu.js');    

//datepicker	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js');	
  //      $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
  //      $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.hu.js');
        //form validator	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/jquery.validate.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/localization/messages_hu.js');
 $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/rendezveny_update.js');

        // a módosítandó munka adatai
        $this->view->actual_rendezveny = $this->rendezvenyek_model->one_rendezveny_query($id);
		

        
        // a város vagy kerület beviteli mező megjelenjenítéséhez vagy eltüntetéséhez használjuk
        $this->view->budapest = ($this->view->actual_rendezveny[0]['rendezveny_county_id'] == 5) ? true : false;
        // városok nevének és id-jének lekérdezése egy megyéből (a paraméter adja meg, hogy melyik megye)
        $this->view->city_list = $this->rendezvenyek_model->city_list_query($this->view->actual_rendezveny[0]['rendezveny_county_id']);

        // munkaadók nevének és id-jének lekérdezése az option listához
        $this->view->facebook_site_list = $this->rendezvenyek_model->facebook_site_list_query();
                // játékok nevének és id-jének lekérdezése az option listához
        $this->view->szolgaltatasok_list = $this->rendezvenyek_model->szolgaltatasok_list_query();


        // Megyék adatainak lekérdezése az option listához
        $this->view->county_list = $this->rendezvenyek_model->county_list_query();
        // kerületek nevének és id-jének lekérdezése az option listához
        $this->view->district_list = $this->rendezvenyek_model->district_list_query();
        // userek lekérdezése
        if (Session::get('user_role_id') == 1) {
            $this->view->user_list = $this->rendezvenyek_model->user_list_query();
        }

// $this->view->debug(true);
        // template betöltése
        $this->view->render('rendezvenyek/tpl_update_rendezveny');
    }


    /* --------------------------------------------------------------------------------- */

    /**
     * 	1 munka törlése
     */
    public function ajax_delete_rendezveny() {
        if (isset($_POST['delete_id'])) {
            // ez a metódus true-val tér vissza (false esetén kivételt dob!)
            $result = $this->rendezvenyek_model->delete_rendezveny(array($_POST['delete_id']));

            // visszatérés üzenetekkel
            if ($result['success'] == 1) {
                $message = Message::send('A rendezvény törlése sikerült.');
                echo json_encode(array(
                  "status" => 'success',
                  "message" => $message
                ));
            } else {
                $message = Message::send('A rendezvény törlése nem sikerült!');
                echo json_encode(array(
                  "status" => 'error',
                  "message" => $message
                ));
            }
        } else {
            throw new Exception('HIBA az ajax_delete_job metódusban: Nem létezik $_POST["delete_id"]');
        }
    }

    /* --------------------------------------------------------------------------------- */

    /**
     * 	rendezvébny klónozása
     */
    public function ajax_clone_rendezveny() {
        if (isset($_POST['clone_id'])) {
            // ez a metódus true-val tér vissza (false esetén kivételt dob!)
            $result = $this->rendezvenyek_model->clone_rendezveny($_POST['clone_id']);

            // visszatérés üzenetekkel
            if ($result['success'] == 1) {
                $message = Message::send('A rendezvény másolása sikerült.');
                echo json_encode(array(
                  "status" => 'success',
                  "message" => $message
                ));
            } else {
                $message = Message::send('A rendezvény másolása nem sikerült!');
                echo json_encode(array(
                  "status" => 'error',
                  "message" => $message
                ));
            }
        } else {
            throw new Exception('HIBA az ajax_clone_job metódusban: Nem létezik $_POST["clone_id"]');
        }
    }

    /**
     * 	Munkák listáját adja vissza és kezeli a csoportos művelteket is
     */
    public function ajax_get_rendezvenyek() {
        if (Util::is_ajax()) {
            $request_data = $_REQUEST;
            $json_data = $this->rendezvenyek_model->ajax_get_rendezvenyek($request_data);
            // adatok visszaküldése a javascriptnek
            echo json_encode($json_data);
        } else {
            Util::redirect('error');
        }
    }

    /**
     * (AJAX) A rendezvenyek táblában módosítja az job_status mező értékét
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
                    $result = $this->rendezvenyek_model->change_status_query(array($id), 1);
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
                    $result = $this->rendezvenyek_model->change_status_query(array($id), 0);
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
                $result = $this->rendezvenyek_model->city_list_query($id);

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

}

?>