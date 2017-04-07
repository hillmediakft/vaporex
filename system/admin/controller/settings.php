<?php

class Settings extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_settings");
        $this->view->user = $this->user;
        $this->loadModel('settings_model');
    }

    public function index() {

        if (isset($_POST['submit_settings'])) {

            $result = $this->settings_model->update_settings();

            Util::redirect('settings');
        }

        $this->view->settings = $this->settings_model->get_settings();

        // adatok bevitele a view objektumba
        $this->view->title = 'Beállítások oldal';
        $this->view->description = 'Beállítások oldal description';
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/settings.js');
        $this->view->render('settings/tpl_settings');
    }

}

?>