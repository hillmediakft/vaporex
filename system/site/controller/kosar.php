<?php

class Kosar extends Site_controller {

    function __construct() {
        parent::__construct();
        Auth::handleExpire();
        $this->loadModel('kosar_model');
    }

    public function index() {
        $this->view->js_link[] = $this->make_link('js', '', Util::auto_version(SITE_JS . 'pages/kosar.js'));

        // oldal tartalmának lekérdezése (paraméter a pages tábla page_id)
        $this->view->content = $this->kosar_model->get_page_data('kosar');
        $this->view->title = $this->view->content['page_metatitle'];
        $this->view->description = $this->view->content['page_metadescription'];
        $this->view->keywords = $this->view->content['page_metakeywords'];
        $this->view->content = $this->view->content['page_body'];
       
        $cart = new Cart();      
        $this->view->items = $cart->getItems();
//        var_dump($this->view->items);die;

        $this->view->render('kosar/tpl_kosar');
    }

    public function ajax() {
        $data = $_POST;


    }
}
?>