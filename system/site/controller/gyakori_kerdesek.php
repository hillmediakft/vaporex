<?php

class Gyakori_kerdesek extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('gyik_model');
    }

    public function index() {

        // oldal tartalmának lekérdezése (paraméter a pages tábla page_id)
        $this->view->content = $this->gyik_model->get_page_data('gyakori-kerdesek');
        $this->view->title = $this->view->content['page_metatitle'];
        $this->view->description = $this->view->content['page_metadescription'];
        $this->view->keywords = $this->view->content['page_metakeywords'];
        $this->view->content = $this->view->content['page_body'];

        $this->view->gyik = $this->gyik_model->all_gyik_query();
        $this->view->gyik_rendezett = $this->gyik_model->arraySort($this->view->gyik, 'gyik_category_name');

        $this->view->render('gyakori_kerdesek/tpl_gyakori_kerdesek');
    }

}

?>