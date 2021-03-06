<?php

class Register_subscribe extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_register_subscribe");
        $this->view->user = $this->user;
        $this->loadModel('register_subscribe_model');
    }

    public function index() {

        $this->view->title = 'Admin regisztráltak és feliratkozottak listája oldal';
        $this->view->description = 'Admin regisztráltak és feliratkozottak listája oldal description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');

        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/media/js/jquery.dataTables.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'datatable.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/register_subscribe.js');

//$this->view->debug(true);

        $this->view->render('register_subscribe/tpl_register_subscribe');
    }

    /**
     * 	Rekord törlése a site_users táblából
     */
    public function ajax_delete_items() {
        if (Util::is_ajax()) {
            if (isset($_POST['delete_id'])) {
                // ez a metódus true-val tér vissza (false esetén kivételt dob!)
                $result = $this->register_subscribe_model->delete(array($_POST['delete_id']));

                // visszatérés üzenetekkel
                if ($result['success'] == 1) {
                    $message = Message::send('A felhasználó törlése sikerült.');
                    echo json_encode(array(
                      "status" => 'success',
                      "message" => $message
                    ));
                } else {
                    $message = Message::send('A felhasználó törlése nem sikerült!');
                    echo json_encode(array(
                      "status" => 'error',
                      "message" => $message
                    ));
                }
            } else {
                throw new Exception('HIBA az ajax_delete_item metódusban: Nem létezik $_POST["delete_id"]');
            }
        } else {
            Util::redirect('error');
        }
    }

    /**
     * 	A site_users tábla listáját adja vissza és kezeli a csoportos művelteket is
     */
    public function ajax_get_items() {
        if (Util::is_ajax()) {
            $request_data = $_REQUEST;
            $json_data = $this->register_subscribe_model->get_items($request_data);
            // adatok visszaküldése a javascriptnek
            echo json_encode($json_data);
        } else {
            Util::redirect('error');
        }
    }

}

?>