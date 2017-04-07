<?php

class Termekek extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('termekek_model');
    }

    public function index() {

        $this->view->category_menu = $this->termekek_model->get_category_menu();
        /*         * ********************************************* */
// termék részletei oldal - url: termekek/id
        if (isset($this->registry->params['id'])) {
            $id = $this->registry->params['id'];

            $this->view->product_category_id = $this->termekek_model->get_product_category_by_id($id);
            $this->view->product_name = $this->termekek_model->get_product_name_by_id($id);
            $this->view->product = $this->termekek_model->product_details($id);
            $this->view->product_category_path = $this->termekek_model->product_category_path_with_link($this->view->product_category_id);

            $this->view->title = $this->view->product_name['product_title'];
            $this->view->description = $this->view->product_name['product_title'];
            $this->view->keywords = '';

            $this->view->js_link[] = $this->make_link('js', SITE_ASSETS, 'plugins/equalheights/jquery.equalheights.min.js');
            $this->view->css_link[] = $this->make_link('css', SITE_ASSETS, 'plugins/metis-menu/src/metisMenu.css');
            $this->view->css_link[] = $this->make_link('css', SITE_ASSETS, 'plugins/metis-menu/src/metis_demo.css');
            $this->view->js_link[] = $this->make_link('js', SITE_ASSETS, 'plugins/metis-menu/src/metisMenu.js');
            $this->view->js_link[] = $this->make_link('js', SITE_JS, 'pages/termekek.js');
            $this->view->render('termekek/tpl_termek');

            // termék kategória oldal - url: termekek/kategoria/category_name/category_id   
        } elseif (isset($this->registry->params['category_id'])) {
            $id = $this->registry->params['category_id'];
            $this->view->category_name = $this->termekek_model->get_category_name_by_id($id);
            $is_product_in_category = $this->termekek_model->is_products_in_category($id);

            if (empty($is_product_in_category)) {
                $this->view->products_area = $this->termekek_model->product_categories($id);
            } else {
                $this->view->products_area = $this->termekek_model->products_in_category($id);
            }
            $this->view->new_products = $this->termekek_model->get_new_products(3);

            $this->view->product_category_path = '<a href="' . $this->registry->site_url . 'termekek' . '">' . 'termekek' . '</a> / ' . '<a href="' . $this->registry->site_url . 'termekek' . '/' . 'kategoria/' . Util::string_to_slug($this->view->category_name['product_category_name']) . '/' . $id . '">' . $this->view->category_name['product_category_name'] . '</a>';


            $this->view->title = 'kategória' . ': ' . $this->registry->params['category_name'];
            $this->view->description = 'kategória' . ': ' . $this->registry->params['category_name'];
            $this->view->keywords = '';

            $this->view->js_link[] = $this->make_link('js', SITE_ASSETS, 'plugins/equalheights/jquery.equalheights.min.js');
            $this->view->css_link[] = $this->make_link('css', SITE_ASSETS, 'plugins/metis-menu/src/metisMenu.css');
            $this->view->css_link[] = $this->make_link('css', SITE_ASSETS, 'plugins/metis-menu/src/metis_demo.css');
            $this->view->js_link[] = $this->make_link('js', SITE_ASSETS, 'plugins/metis-menu/src/metisMenu.js');
            $this->view->js_link[] = $this->make_link('js', SITE_JS, 'pages/termekek.js');
            $this->view->render('termekek/tpl_termekek');
        } else {
            $this->view->products_area = $this->termekek_model->product_categories();

            $this->view->product_category_path = 'Termékek';
            $data_arr = $this->termekek_model->get_page_data('termekek');

            $this->view->title = $data_arr['page_metatitle'];

            $this->view->description = $data_arr['page_metadescription'];
            $this->view->keywords = $data_arr['page_metakeywords'];

            $this->view->js_link[] = $this->make_link('js', SITE_ASSETS, 'plugins/equalheights/jquery.equalheights.min.js');
            $this->view->css_link[] = $this->make_link('css', SITE_ASSETS, 'plugins/metis-menu/src/metisMenu.css');
            $this->view->css_link[] = $this->make_link('css', SITE_ASSETS, 'plugins/metis-menu/src/metis_demo.css');
            $this->view->js_link[] = $this->make_link('js', SITE_ASSETS, 'plugins/metis-menu/src/metisMenu.js');
            $this->view->js_link[] = $this->make_link('js', SITE_JS, 'pages/termekek.js');

            $this->view->render('termekek/tpl_termekek');
        }


// $this->view->debug(true); 
    }

}

?>