<?php

class Home extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('home_model');
    }

    public function index() {
        $this->view->js_link[] = $this->make_link('js', SITE_ASSETS, 'plugins/iview/js/iview.js');
        $this->view->js_link[] = $this->make_link('js', SITE_ASSETS, 'plugins/equalheights/jquery.equalheights.min.js');
        $this->view->js_link[] = $this->make_link('js', SITE_ASSETS, 'pages/home.js');

        $this->view->slider = $this->home_model->slider_query();
        // oldal tartalmának lekérdezése (paraméter a pages tábla page_id)
        $this->view->content = $this->home_model->get_page_data('home');
        $this->view->title = $this->view->content['page_metatitle'];
        $this->view->description = $this->view->content['page_metadescription'];
        $this->view->keywords = $this->view->content['page_metakeywords'];
        $this->view->content = $this->view->content['page_body'];
        $this->view->footer_social = $this->home_model->get_content_data('footer_social');
        $this->view->footer_online_fizetes = $this->home_model->get_content_data('footer_online_fizetes');

        $this->view->termekek = $this->termekek_model->all_products_query();
        $this->view->testimonials = $this->home_model->get_testimonials();
// $this->view->debug(true); 

        $this->view->render('home/tpl_home');
    }

}

?>