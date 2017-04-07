<?php

class Aktualis extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('aktualis_model');
    }

    public function index() {
        
        // oldal tartalmának lekérdezése (paraméter a pages tábla page_id)
        $this->view->content = $this->aktualis_model->get_page_data(16);
        $this->view->title = $this->view->content['page_metatitle'];
        $this->view->description = $this->view->content['page_metadescription'];
        $this->view->keywords = $this->view->content['page_metakeywords'];
        

//$this->view->debug(true); 	

        $this->view->render('aktualis/tpl_aktualis');
    }

}

?>