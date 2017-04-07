<?php

class Kereses extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('kereses_model');
    }

    public function index() {

        $this->view->search_results = $this->kereses_model->search($this->registry->query_string_arr['search']);
        $this->view->result_list = $this->view->search_results[0];
        $this->view->keyword = $this->view->search_results[1];
//var_dump($this->view->search_results);die;

        // oldal tartalmának lekérdezése (paraméter a pages tábla page_id)
        $this->view->content = $this->kereses_model->get_page_data('kereses');
        $this->view->title = $this->view->content['page_metatitle'];
        $this->view->description = $this->view->content['page_metadescription'];
        $this->view->keywords = $this->view->content['page_metakeywords'];

        $this->view->render('kereses/tpl_kereses_lista');
    }

}

?>