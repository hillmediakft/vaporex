<?php

class Letoltesek extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('letoltesek_model');
    }

    public function index() {

        $this->view->settings = $this->letoltesek_model->get_settings();
        $this->view->data_arr = $this->letoltesek_model->page_data_query('letoltesek');
        
        $this->view->category_list = $this->letoltesek_model->findCategories();
        $this->view->letoltesek = Util::group_array_by_field($this->letoltesek_model->getDocuments(), 'name');
        
        $this->view->title = $this->view->data_arr[0]['page_metatitle'];
        $this->view->description = $this->view->data_arr[0]['page_metadescription'];
        $this->view->keywords = $this->view->data_arr[0]['page_metakeywords'];
        $this->view->content = $this->view->data_arr[0]['page_body'];

        $this->view->render('letoltesek/tpl_letoltesek');
    }
    
    public function category() {
        $id = $this->registry->params['id'];

        $this->view->referencia = $this->letoltesek_model->get_project($id);

        $this->view->title = $this->view->referencia['project_title'];
        $this->view->description = Util::substr_word($this->view->referencia['project_description'], 150);
        $this->view->keywords = $this->view->referencia['project_title'];

        $this->view->render('letoltesek/tpl_referencia');
    }    

}

?>