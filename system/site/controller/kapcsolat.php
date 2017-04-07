<?php

class Kapcsolat extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('kapcsolat_model');
    }

    public function index() {

        if (isset($_POST['name'])) {
            if (isset($_POST['mezes_bodon']) && $_POST['mezes_bodon'] == '') {
                Util::send_mail($this->view->settings['email'], "Üzenet a Vaporex weboldaltól");
                exit();
            }
        }
        $this->view->js_link[] = $this->make_link('js', 'http://maps.google.com/maps/api/js?key=AIzaSyDoU5BWhXCTpaRJPgZq-ILXqW8A-CNZjeg', '');
        $this->view->js_link[] = $this->make_link('js', SITE_ASSETS, 'plugins/gmaps/gmaps.js');
        $this->view->js_link[] = $this->make_link('js', SITE_ASSETS, 'plugins/bootstrap.validator/bootstrapValidator.min.js');
        $this->view->js_link[] = $this->make_link('js', SITE_JS, 'pages/kapcsolat.js');

        // oldal tartalmának lekérdezése (paraméter a pages tábla page_id)
        $this->view->content = $this->kapcsolat_model->get_page_data('kapcsolat');
        $this->view->title = $this->view->content['page_metatitle'];
        $this->view->description = $this->view->content['page_metadescription'];
        $this->view->keywords = $this->view->content['page_metakeywords'];
        $this->view->content = $this->view->content['page_body'];
        $this->view->footer_social = $this->kapcsolat_model->get_content_data('footer_social');
        $this->view->footer_online_fizetes = $this->kapcsolat_model->get_content_data('footer_online_fizetes');


//$this->view->debug(true); 	

        $this->view->render('kapcsolat/tpl_kapcsolat');
    }

}

?>