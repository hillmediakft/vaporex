<?php

class Offices extends Controller {

    public function __construct() {
        parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_offices");
        $this->view->user = $this->user;
        $this->loadModel('offices_model');
    }

    public function index() {
        // adatok bevitele a view objektumba
        $this->view->title = 'Admin irodák oldal';
        $this->view->description = 'Admin irodák oldal description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/media/js/jquery.dataTables.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'datatable.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/offices.js');

        // az összes iroda adatainak lekérdezése
        $this->view->offices = $this->offices_model->offices_data_query();

        $this->view->render('offices/tpl_offices');
    }

    public function insert() {
        if (!empty($_POST)) {
            $result = $this->offices_model->insert_office();

            if ($result) {
                Util::redirect('offices');
            } else {
                Util::redirect('offices/insert');
            }
        }

        // adatok bevitele a view objektumba
        $this->view->title = 'Admin irodák oldal';
        $this->view->description = 'Admin irodák oldal description';

        //form validator	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/jquery.validate.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/localization/messages_hu.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/offices_insert_update.js');

        $this->view->render('offices/tpl_insert_office');
    }

    public function update() {
        $id = (int) $this->registry->params['id'];

        //var_dump($id); die();

        if (!empty($_POST)) {
            $result = $this->offices_model->update_office($id);

            if ($result) {
                Util::redirect('offices');
            }
            /*
              else {
              Util::redirect('offices/update/' . $id);
              }
             */
        }

        // adatok bevitele a view objektumba
        $this->view->title = 'Admin irodák oldal';
        $this->view->description = 'Admin irodák oldal description';

        //form validator	
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/jquery.validate.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation-new/localization/messages_hu.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/offices_insert_update.js');

        // egy iroda adatainak lekérdezése
        $this->view->office = $this->offices_model->offices_data_query($id);

        $this->view->render('offices/tpl_update_office');
    }

    /* -------------------------- */

    /**
     * 	Iroda törlése
     */
    public function ajax_delete_office() {
        if (isset($_POST['delete_id'])) {

            $id = (int) $_POST['delete_id'];

            // ez a metódus true-val tér vissza (false esetén kivételt dob!)
            $result = $this->offices_model->delete_office($id);

            // visszatérés üzenetekkel
            if ($result['success'] == 1) {
                $message = Message::send('Az iroda törlése sikerült.');
                echo json_encode(array(
                  "status" => 'success',
                  "message" => $message
                ));
            } else {
                $message = Message::send('Az iroda törlése nem sikerült!');
                echo json_encode(array(
                  "status" => 'error',
                  "message" => $message
                ));
            }
        } else {
            throw new Exception('HIBA az ajax_delete_office metódusban: Nem létezik $_POST["delete_id"]');
        }
    }

}

?>