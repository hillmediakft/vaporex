<?php

class Kepgaleria extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('kepgaleria_model');
    }

    public function index() {


        $this->view->css_link[] = $this->make_link('css', SITE_ASSETS, 'pages/portfolio.css');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-mixitup/jquery.mixitup.min.js');
        //     $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/fancybox/source/jquery.fancybox.pack.js');

        $this->view->js_link[] = $this->make_link('js', SITE_ASSETS, 'pages/photo_gallery.js');


        // oldal tartalmának lekérdezése (paraméter a pages tábla page_id)
        $this->view->content = $this->kepgaleria_model->get_page_data('kepgaleria');
        $this->view->title = $this->view->content['page_metatitle'];
        $this->view->description = $this->view->content['page_metadescription'];
        $this->view->keywords = $this->view->content['page_metakeywords'];
        $this->view->content = $this->view->content['page_body'];
        $this->view->footer_social = $this->kepgaleria_model->get_content_data('footer_social');
        $this->view->footer_online_fizetes = $this->kepgaleria_model->get_content_data('footer_online_fizetes');

        $this->view->jatszohazak = $this->kepgaleria_model->get_jatszohazak_query();

        if (count($this->view->jatszohazak) > 0) {
            $this->view->kovetkezo_jatszohaz = $this->view->jatszohazak[0];
        } else {
            $this->view->kovetkezo_jatszohaz = array();
        }

        $this->view->photo_gallery = $this->kepgaleria_model->get_all_photo();
        $this->view->category_list = $this->kepgaleria_model->photo_category_list_query();



        $this->view->render('kepgaleria/tpl_kepgaleria');
    }

}

?>