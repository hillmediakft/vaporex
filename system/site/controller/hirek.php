<?php

class Hirek extends Site_controller {

    function __construct() {
        parent::__construct();

        parent::__construct();
        $this->loadModel('hirek_model');
         $this->view->hirek_categories = $this->hirek_model->get_blog_categories();
        $this->view->hirek_per_page = 6;
    }

    public function index() {

        $pagine = new Paginator('page', $this->view->hirek_per_page);
        // adatok lekérdezése limittel
        $this->view->hirek_list = $this->hirek_model->blog_pagination_query($pagine->get_limit(), $pagine->get_offset());

        // szűrési feltételeknek megfelelő összes rekord száma
        $hirek_count = $this->hirek_model->blog_pagination_count_query();

        $pagine->set_total($hirek_count);
        $language_code = ($this->registry->lang == 'hu') ? '' : $this->registry->lang;
        // lapozó linkek
        $this->view->pagine_links = $pagine->page_links($language_code . '/' . $this->registry->uri_path);


        // oldal tartalmának lekérdezése (paraméter a pages tábla page_id)
        $this->view->content = $this->hirek_model->get_page_data('hirek');
        $this->view->title = $this->view->content['page_metatitle'];
        $this->view->description = $this->view->content['page_metadescription'];
        $this->view->keywords = $this->view->content['page_metakeywords'];
        $this->view->content = $this->view->content['page_body'];

        $this->view->render('hirek/tpl_hirek');
    }

    public function reszletek() {
        $id = $this->registry->params['id'];

        $content = $this->hirek_model->blog_query($id);

        if (empty($content)) {
            Util::redirect('error');
        }
        $this->view->title = $content['blog_title'] . ' | Vaporex';
        $this->view->description = $content['blog_title'];
        $this->view->blog = $content;

        $this->view->keywords = $this->view->title;

        $this->view->render('hirek/tpl_hir');
    }

    public function kategoria() {
        $category_id = (int) $this->registry->params['id'];

        $category_data = $this->hirek_model->blog_category_query($category_id);
        $this->view->category_name = $category_data['category_name'];
        $this->view->content = $this->hirek_model->blog_query_by_category($category_id);

        $pagine = new Paginator('page', $this->view->hirek_per_page);
        // adatok lekérdezése limittel
        $this->view->blog_list = $this->hirek_model->blog_query_by_category_pagination($category_id, $pagine->get_limit(), $pagine->get_offset());

        // szűrési feltételeknek megfelelő összes rekord száma
        $blog_count = $this->hirek_model->blog_pagination_count_query();

        $pagine->set_total($blog_count);
        // lapozó linkek
        $language_code = ($this->registry->lang == 'hu') ? '' : $this->registry->lang;
        $this->view->pagine_links = $pagine->page_links($language_code . '/' . $this->registry->uri_path);

        $this->view->title = $this->view->category_name;
        $this->view->description = $this->view->category_name;
        $this->view->keywords = 'blog: ' . $this->view->category_name;

        $this->view->render('hirek/tpl_hirek_category');
    }

}

?>