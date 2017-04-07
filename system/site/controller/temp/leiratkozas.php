<?php
class Leiratkozas extends Controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('leiratkozas_model');
    }

    public function index() {

        if (isset($this->registry->params['user_id']) && isset($this->registry->params['newsletter_unsubscribe_code'])) {
            $this->leiratkozas_model->leiratkozas($this->registry->params['user_id'], $this->registry->params['newsletter_unsubscribe_code']);

            // adatok bevitele a view objektumba
            $this->view->title = 'Leiratkozás hírlevélről';
            $this->view->description = 'Leiratkozás hírlevélről';
            $this->view->keywords = 'Leiratkozás hírlevélről';

            $this->view->render('leiratkozas/tpl_leiratkozas');
        } else {
            Util::redirect('error');
        }
    }

}
?>