<?php

class Jobs extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_jobs");
        $this->view->user = $this->user;
        $this->loadModel('jobs_model');
    }

    public function index() {

        $this->view->title = 'Admin munka hozzáadása oldal';
        $this->view->description = 'Admin munka hozzáadása oldal description';

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

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/jobs.js');

        $this->view->job_list = $this->jobs_model->job_list_query();
        $this->view->employer_list = $this->jobs_model->employer_list_query();
        $this->view->user_list = $this->jobs_model->user_list_query();
        $this->view->city_list = $this->jobs_model->city_list_query();

//$this->view->debug(true);

        $this->view->render('jobs/tpl_jobs');
    }

    /**
     * 	Munka minden adatának megjelenítése
     */
    public function view_job() {
        $this->view->title = 'Admin munka részletek oldal';
        $this->view->description = 'Admin munka részletek oldal description';
        // az oldalspecifikus css linkeket berakjuk a view objektum css_link tulajdonságába (ami egy tömb)
        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');

        $this->view->content = $this->jobs_model->one_job_alldata_query($this->registry->params['id']);

//$this->view->debug(true);

        $this->view->render('jobs/tpl_job_view');
    }

    /**
     * 	Munka minden adatának megjelenítése
     */
    public function view_job_ajax() {
        if (Util::is_ajax()) {
            $this->view->content = $this->jobs_model->one_job_alldata_query_ajax();

            $this->view->location = $this->view->content['city_name'] . ' ' . $this->view->content['district_name'];
            $this->view->render('jobs/tpl_job_view_modal', true);
        } else {
            Util::redirect('error');
        }
    }

    /**
     * 	Új munka hozzáadása
     */
    public function new_job() {
        // új munka hozzáadása
        if (!empty($_POST)) {
            $result = $this->jobs_model->insert_job();
            if ($result) {
                Util::redirect('jobs');
            } else {
                Util::redirect('jobs/new_job');
            }
        }

        // HTML oldal megjelenítése
        // adatok bevitele a view objektumba
        $this->view->title = 'Új munka oldal';
        $this->view->description = 'Új munka description';
        // css linkek generálása
        //$this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        //$this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/croppic/croppic.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/css/datepicker.css');
        // js linkek generálása
        //$this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/croppic/croppic.min.js');
        //$this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');
        //$this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation/dist/jquery.validate.js');
        //$this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation/dist/additional-methods.min.js');
        //$this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'form-validation.js');
        //$this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');
        //ckEditor
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/ckeditor/ckeditor.js');

        //datepicker	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.hu.js');
        //form validator	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/jquery.validate.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/localization/messages_hu.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/new_job.js?2015102202');

        // ck_editor bekapcsolása
        //$this->view->ckeditor = true;
        // munka kategóriák lekérdezése az option listához
        $this->view->jobs_list = $this->jobs_model->job_list_query();
        // Megyék adatainak lekérdezése az option listához
        $this->view->county_list = $this->jobs_model->county_list_query();
        // munkaadók nevének és id-jének lekérdezése az option listához
        $this->view->employer_list = $this->jobs_model->employer_list_query();

        // kerületek nevének és id-jének lekérdezése az option listához
        $this->view->district_list = $this->jobs_model->district_list_query();

        // userek lekérdezése
        if (Session::get('user_role_id') == 1) {
            $this->view->user_list = $this->jobs_model->user_list_query();
        }
//$this->view->debug(true);
        // template betöltése
        $this->view->render('jobs/tpl_new_job');
    }

    /**
     * 	Munka módosítása
     *
     */
    public function update_job() {
        $id = (int) $this->registry->params['id'];

        if (!empty($_POST)) {
            $result = $this->jobs_model->update_job($id);

            if ($result) {
                Util::redirect('jobs');
            } else {
                Util::redirect('jobs/update_job/' . $id);
            }
        }

        // HTML oldal megjelenítése
        // adatok bevitele a view objektumba
        $this->view->title = 'Munka módosítása oldal';
        $this->view->description = 'Munka módosítása description';
        // css linkek generálása
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/css/datepicker.css');
        // js linkek generálása
        //datepicker	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.hu.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/job_update.js?2015102202');
        //form validator	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/jquery.validate.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/localization/messages_hu.js');

        //ckEditor
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/ckeditor/ckeditor.js');


        // a módosítandó munka adatai
        $this->view->actual_job = $this->jobs_model->one_job_query($id);
        // a város vagy kerület beviteli mező megjelenjenítéséhez vagy eltüntetéséhez használjuk
        $this->view->budapest = ($this->view->actual_job[0]['job_county_id'] == 5) ? true : false;
        // városok nevének és id-jének lekérdezése egy megyéből (a paraméter adja meg, hogy melyik megye)
        $this->view->city_list = $this->jobs_model->city_list_query($this->view->actual_job[0]['job_county_id']);
        // munka kategóriák lekérdezése az option listához
        $this->view->jobs_list = $this->jobs_model->job_list_query();
        // munkaadók nevének és id-jének lekérdezése az option listához
        $this->view->employer_list = $this->jobs_model->employer_list_query();
        // Megyék adatainak lekérdezése az option listához
        $this->view->county_list = $this->jobs_model->county_list_query();
        // kerületek nevének és id-jének lekérdezése az option listához
        $this->view->district_list = $this->jobs_model->district_list_query();
        // userek lekérdezése
        if (Session::get('user_role_id') == 1) {
            $this->view->user_list = $this->jobs_model->user_list_query();
        }

//$this->view->debug(true);
        // template betöltése
        $this->view->render('jobs/tpl_job_update');
    }

    /**
     * 	Munka kategóriák megjelenítése
     */
    public function category() {
        $this->check_access("menu_job_category");
        // adatok bevitele a view objektumba
        $this->view->title = 'Admin munka kategória oldal';
        $this->view->description = 'Admin munka kategória description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');

        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/media/js/jquery.dataTables.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'datatable.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/job_category.js');

        $this->view->all_job_category = $this->jobs_model->job_list_query();
        $this->view->category_counter = $this->jobs_model->job_category_counter_query();

//$this->view->debug(true);			

        $this->view->render('jobs/tpl_job_category');
    }

    /**
     * 	Új munka kategória hozzáadása
     */
    public function category_insert() {
        $this->check_access("menu_insert_job_category");

        // új munka kategória hozzáadása
        if (isset($_POST['job_list_name'])) {
            $result = $this->jobs_model->category_insert();

            if ($result) {
                Util::redirect('jobs/category');
            } else {
                Util::redirect('jobs/category_insert');
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

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/job_category_insert_update.js');
        //$this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');	
        // template betöltése
        $this->view->render('jobs/tpl_job_category_insert');
    }

    /**
     * 	Munka kategória nevének módosítása
     */
    public function category_update() {
        $this->check_access("action_update_job_category");
   
        $id = (int) $this->registry->params['id'];

        if (isset($_POST['job_list_name'])) {
            $result = $this->jobs_model->category_update($id);
            if ($result) {
                Util::redirect('jobs/category');
            } else {
                Util::redirect('jobs/category_update/' . $id);
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

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/job_category_insert_update.js');


        //$this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');	   

        $this->view->category_content = $this->jobs_model->job_list_query($id);

        $this->view->render('jobs/tpl_job_category_update');
    }

    /* --------------------------------------------------------------------------------- */

    /**
     * 	1 munka törlése
     */
    public function ajax_delete_job() {
        if (isset($_POST['delete_id'])) {
            // ez a metódus true-val tér vissza (false esetén kivételt dob!)
            $result = $this->jobs_model->delete_job(array($_POST['delete_id']));

            // visszatérés üzenetekkel
            if ($result['success'] == 1) {
                $message = Message::send('A munka törlése sikerült.');
                echo json_encode(array(
                  "status" => 'success',
                  "message" => $message
                ));
            } else {
                $message = Message::send('A munka törlése nem sikerült!');
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
     * 	1 munka törlése
     */
    public function ajax_clone_job() {
        if (isset($_POST['clone_id'])) {
            // ez a metódus true-val tér vissza (false esetén kivételt dob!)
            $result = $this->jobs_model->clone_job($_POST['clone_id']);

            // visszatérés üzenetekkel
            if ($result['success'] == 1) {
                $message = Message::send('A munka másolása sikerült.');
                echo json_encode(array(
                  "status" => 'success',
                  "message" => $message
                ));
            } else {
                $message = Message::send('A munka másolása nem sikerült!');
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
    public function ajax_get_jobs() {
        if (Util::is_ajax()) {
            $request_data = $_REQUEST;
            $json_data = $this->jobs_model->ajax_get_jobs($request_data);
            // adatok visszaküldése a javascriptnek
            echo json_encode($json_data);
        } else {
            Util::redirect('error');
        }
    }

    /**
     * (AJAX) A jobs táblában módosítja az job_status mező értékét
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
                    $result = $this->jobs_model->change_status_query(array($id), 1);
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
                    $result = $this->jobs_model->change_status_query(array($id), 0);
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
                $result = $this->jobs_model->city_list_query($id);

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