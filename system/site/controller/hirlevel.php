<?php

class Hirlevel extends Controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('hirlevel_model');
    }

    public function index() {

        if (isset($this->registry->params['user_id']) && isset($this->registry->params['user_activation_verification_code'])) {

            // új hírlevélre feliratkozás ellenőrzése
            $result = $this->hirlevel_model->verifyNewUser($this->registry->params['user_id'], $this->registry->params['user_activation_verification_code']);

            if ($result) {
                $this->view->message = Message::send('account_activation_successful');
            } else {
                $this->view->message = Message::send('account_activation_failed');
            }

            $this->view->settings = $this->hirlevel_model->get_settings();

            $this->view->render('hirlevel/tpl_hirlevel', true);
        } else {
            Util::redirect('error');
        }
    }

    /**
     * 	(AJAX) Felhasználó regisztráció
     */
    public function ajax_hirlevel() {
        if (Util::is_ajax()) {

           $respond = $this->hirlevel_model->save_subscriber();

            echo $respond;
            exit();
        } else {
            Util::redirect('error');
        }
    }

}

?>