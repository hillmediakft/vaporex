<?php

class Referenciak extends Site_Controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('referenciak_model');
    }

    public function index() {

        $this->view->data_arr = $this->referenciak_model->page_data_query('referenciak');
        $this->view->category_list = $this->referenciak_model->project_category_list();

        $this->view->title = $this->view->data_arr[0]['page_metatitle'];
        $this->view->description = $this->view->data_arr[0]['page_metadescription'];
        $this->view->keywords = $this->view->data_arr[0]['page_metakeywords'];
        $this->view->content = $this->view->data_arr[0]['page_body'];

        $this->view->referenciak = $this->referenciak_model->all_projects_query();
        $this->view->referencia_kategoriak = $this->referenciak_model->referencia_kategoriak();

        $this->view->render('referenciak/tpl_referenciak');
    }
    
    public function referencia() {
        $id = $this->registry->params['id'];

   //     $this->view->data_arr = $this->referenciak_model->page_data_query('referenciak');
        $this->view->referencia = $this->referenciak_model->get_project($id);

        $this->view->title = $this->view->referencia['project_title'];
        $this->view->description = Util::substr_word($this->view->referencia['project_description'], 150);
        $this->view->keywords = $this->view->referencia['project_title'];

        $this->view->render('referenciak/tpl_referencia');
    }    

}

?>