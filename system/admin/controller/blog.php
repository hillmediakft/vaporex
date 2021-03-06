<?php

class Blog extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_hirek");
        $this->view->user = $this->user;
        $this->loadModel('blog_model');
    }

    public function index() {

        // adatok bevitele a view objektumba
        $this->view->title = 'Admin blog oldal';
        $this->view->description = 'Admin blog oldal description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');

        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/media/js/jquery.dataTables.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'datatable.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/blog.js');


        $this->view->all_blog = $this->blog_model->blog_query2();

//$this->view->debug(true);		

        $this->view->render('blog/tpl_blog');
    }

    public function insert() {
        if (isset($_POST['submit_add_blog'])) {
            $result = $this->blog_model->insert();
            if ($result) {
                Util::redirect('blog');
            } else {
                Util::redirect('blog/insert');
            }
        }

        $this->view->title = 'Admin blog oldal';
        $this->view->description = 'Admin blog oldal description';
        $this->view->ckeditor = true;
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');

        $this->view->category_list = $this->blog_model->blog_category_query();

        $this->view->render('blog/tpl_blog_insert');
    }

    public function update() {
        if (isset($_POST['submit_update_blog'])) {
            $result = $this->blog_model->update($this->registry->params['id']);
            if ($result) {
                Util::redirect('blog');
            } else {
                Util::redirect('blog/update/' . $this->registry->params['id']);
            }
        }


        $this->view->title = 'Admin blog oldal';
        $this->view->description = 'Admin blog oldal description';
        $this->view->ckeditor = true;

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');

        $this->view->category_list = $this->blog_model->blog_category_query();
        $content = $this->blog_model->blog_query2($this->registry->params['id']);
        $this->view->content = $content[0];

// $this->view->debug(true);		


        $this->view->render('blog/tpl_blog_update');
    }

    public function delete() {
        $result = $this->blog_model->delete_blog();
        if ($result) {
            Util::redirect('blog');
        }
    }

    public function category() {
        // adatok bevitele a view objektumba
        $this->view->title = 'Admin blog oldal';
        $this->view->description = 'Admin blog oldal description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');

        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/media/js/jquery.dataTables.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'datatable.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/blog_category.js');


        $this->view->all_blog_category = $this->blog_model->blog_category_query();
        $this->view->category_counter = $this->blog_model->blog_category_counter_query();

//$this->view->debug(true);			

        $this->view->render('blog/tpl_blog_category');
    }

    public function category_insert() {
        if (isset($_POST['submit_category_insert'])) {
            $result = $this->blog_model->category_insert();
            if ($result) {
                Util::redirect('blog/category');
            } else {
                Util::redirect('blog/category_insert');
            }
        }

        $this->view->title = 'Admin blog oldal';
        $this->view->description = 'Admin blog oldal description';

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');

        $this->view->render('blog/tpl_category_insert');
    }

    public function category_update() {
        if (isset($_POST['submit_category_update'])) {
            $result = $this->blog_model->category_update($this->registry->params['id']);
            if ($result) {
                Util::redirect('blog/category');
            } else {
                Util::redirect('blog/category_update/' . $this->registry->params['id']);
            }
        }

        $this->view->title = 'Admin blog oldal';
        $this->view->description = 'Admin blog oldal description';

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');

        $this->view->content = $this->blog_model->blog_category_query($this->registry->params['id']);

        $this->view->render('blog/tpl_category_update');
    }
    
    /**
     * 	Kategória törlése a photo_gallery-ből
     *
     */
    public function delete_category() {
        $id = $this->registry->params['id'];

        $result = $this->blog_model->delete_category($id);

        Util::redirect('blog/category');
    }     

}

?>