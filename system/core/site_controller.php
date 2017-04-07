<?php

class Site_controller extends Controller {

    public function __construct() {
        parent::__construct();

        if (!Util::is_ajax()) {

            // settings betöltése
            $this->loadModel('settings_model');
            $this->view->settings = $this->settings_model->get_settings();

            $this->loadModel('termekek_model');
            $this->view->new_products = $this->termekek_model->get_new_products(3);
            $this->view->logged_in = Session::get('user_site_logged_in');

// var_dump($this->settings);
// var_dump($this->blogs);
// die();
        }
    }

}

?>