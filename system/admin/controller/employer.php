<?php

class Employer extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_employer");
        $this->view->user = $this->user;
        $this->loadModel('employer_model');
    }

    public function index() {
        $this->view->title = 'Admin munkaadó hozzáadása oldal';
        $this->view->description = 'Admin munkaadó hozzáadása oldal description';

        // az oldalspecifikus css linkeket berakjuk a view objektum css_link tulajdonságába (ami egy tömb)
        // a make_link() metódus az anyakontroller metódusa (így egyszerűen meghívható bármelyik kontrollerben)
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');

        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/media/js/jquery.dataTables.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'datatable.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/employer_list.js');

        $this->view->all_employer = $this->employer_model->all_employer_query();
        // Lekérdezés az egyes munkaadókhoz tartozó munkák számának meghatározásához
        $this->view->job_counter = $this->employer_model->job_counter_query();

        $this->view->render('employer/tpl_employer_list');
    }

    public function insert() {
         $this->check_access("action_insert_employer", 'employer');
        // új munka hozzáadása
        if (!empty($_POST)) {
            $result = $this->employer_model->insert_employer();
            if ($result) {
                Util::redirect('employer');
            } else {
                Util::redirect('employer/insert');
            }
        }

        // HTML oldal megjelenítése
        // adatok bevitele a view objektumba
        $this->view->title = 'Új munkaadó oldal';
        $this->view->description = 'Új munkaadó description';
        // css linkek generálása
        // js linkek generálása
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/jquery.validate.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/localization/messages_hu.js');
        //ckEditor
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/ckeditor/ckeditor.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/employer_insert.js');

//$this->view->debug(true);
        // template betöltése
        $this->view->render('employer/tpl_employer_insert');
    }

    public function update() {
        $this->check_access("action_update_employer", 'employer');
        $id = (int) $this->registry->params['id'];

        // új munka hozzáadása
        if (!empty($_POST)) {
            $result = $this->employer_model->update_employer($id);
            if ($result) {
                Util::redirect('employer');
            } else {
                Util::redirect('employer/update/' . $id);
            }
        }

        // HTML oldal megjelenítése
        // adatok bevitele a view objektumba
        $this->view->title = 'Munkaadó módosítása oldal';
        $this->view->description = 'Munkaadó módosítása description';
        // css linkek generálása
        //$this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        //$this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/croppic/croppic.css');
        // js linkek generálása
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/jquery.validate.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/localization/messages_hu.js');
        //ckEditor
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/ckeditor/ckeditor.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/employer_update.js');

        $this->view->employer_data = $this->employer_model->all_employer_query($id);

//$this->view->debug(true);
        // template betöltése
        $this->view->render('employer/tpl_employer_update');
    }

    public function delete() {
        $this->check_access("action_delete_employer", 'employer');
        // ez a metódus true-val tér vissza (false esetén kivételt dob!)
        $this->employer_model->delete_employer();
        Util::redirect('employer');
    }

    /* ---------------------------------------------------------------------------- */

    /**
     * (AJAX) Az employer táblában módosítja az employer_status mező értékét
     *
     * @return void
     */
    public function change_status() {
        if (Util::is_ajax()) {
            if (isset($_POST['action']) && isset($_POST['id'])) {

                $id = (int) $_POST['id'];

                if ($_POST['action'] == 'make_active') {
                    $this->employer_model->change_status_query($id, 1);
                }
                if ($_POST['action'] == 'make_inactive') {
                    $this->employer_model->change_status_query($id, 0);
                }
            }
        } else {
            Util::redirect('error');
        }
    }

}

?>