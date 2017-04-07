<?php

class Error extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('error_model');
    }

    public function index() {

        $this->view->content = $this->error_model->get_page_data('error');
        $this->view->title = $this->view->content['page_metatitle'];
        $this->view->description = $this->view->content['page_metadescription'];
        $this->view->keywords = $this->view->content['page_metakeywords'];
        header('HTTP/1.0 404 Not Found');
        $this->view->render('error/404');
    }

}

?>