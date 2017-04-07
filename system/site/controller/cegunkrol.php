<?php

class Cegunkrol extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('cegunkrol_model');
    }

    public function index() {

        // oldal tartalmának lekérdezése (paraméter a pages tábla page_id)
        $this->view->content = $this->cegunkrol_model->get_page_data('cegunkrol');
        $this->view->title = $this->view->content['page_metatitle'];
        $this->view->description = $this->view->content['page_metadescription'];
        $this->view->keywords = $this->view->content['page_metakeywords'];
        $this->view->content = $this->view->content['page_body'];

// $this->view->debug(true); 

        $this->view->render('cegunkrol/tpl_cegunkrol');
    }
    
    public function miert_pont_vaporex() {
        // oldal tartalmának lekérdezése (paraméter a pages tábla page_id)
        $this->view->content = $this->cegunkrol_model->get_page_data('miert-pont-vaporex');
        $this->view->title = $this->view->content['page_metatitle'];
        $this->view->description = $this->view->content['page_metadescription'];
        $this->view->keywords = $this->view->content['page_metakeywords'];
        $this->view->content = $this->view->content['page_body'];

// $this->view->debug(true); 

        $this->view->render('cegunkrol/tpl_miert_pont_vaporex');
    }  
    
    public function mennyibe_kerul() {

        // oldal tartalmának lekérdezése (paraméter a pages tábla page_id)
        $this->view->content = $this->cegunkrol_model->get_page_data('mennyibe-kerul');
        $this->view->title = $this->view->content['page_metatitle'];
        $this->view->description = $this->view->content['page_metadescription'];
        $this->view->keywords = $this->view->content['page_metakeywords'];
        $this->view->content = $this->view->content['page_body'];

// $this->view->debug(true); 

        $this->view->render('cegunkrol/tpl_mennyibe_kerul');
    }    

}

?>