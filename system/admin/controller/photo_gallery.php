<?php

class Photo_gallery extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_photo_gallery");
        $this->view->user = $this->user;
        $this->loadModel('photo_gallery_model');
    }

    public function index() {
        /* 		Auth::handleLogin();

          if (!Acl::create()->userHasAccess('home_menu')) {
          exit('nincs hozzáférése');
          }

         */
        // adatok bevitele a view objektumba
        $this->view->title = 'Fotó galériák oldal';
        $this->view->description = 'Fotó galériák oldal description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/fancybox/source/jquery.fancybox.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_CSS, 'pages/portfolio.css');

        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-mixitup/jquery.mixitup.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/fancybox/source/jquery.fancybox.pack.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/photo_gallery.js');

        $this->view->all_photos = $this->photo_gallery_model->all_photos();
        $this->view->photo_categories = $this->photo_gallery_model->photo_category_query();

        $this->view->render('photo_gallery/tpl_photo_gallery');
    }

    /**
     * Új fotó hozzáadása
     *
     * @return void
     */
    public function new_photo() {

        if (isset($_POST['submit_new_photo'])) {
            $this->photo_gallery_model->save_photo();
            Util::redirect('photo_gallery');
        }

        // adatok bevitele a view objektumba
        $this->view->title = 'Új fotó oldal';
        $this->view->description = 'Új fotó oldal description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');


        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');
        // kategóriák nevének és id-jének lekérdezése az option listához
        $this->view->category_list = $this->photo_gallery_model->photo_category_list_query();

        $this->view->render('photo_gallery/tpl_new_photo');
    }

    /**
     * Kép adatainak szerkesztése (új kép feltöltése, szöveg módosítása, kiemelés, kategória módosítása)
     *
     *
     * @return void
     */
    public function edit() {
         $id = (int) $this->registry->params['id'];

        if (isset($_POST['submit_update_photo'])) {



            $result = $this->photo_gallery_model->update_photo($id);

            Util::redirect('photo-gallery');
        }

        // adatok bevitele a view objektumba
        $this->view->title = 'Fotó szerkesztése oldal';
        $this->view->description = 'Fotó szerkesztése description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');

        $this->view->photo = $this->photo_gallery_model->photo_data_query($id);
        $this->view->category_list = $this->photo_gallery_model->photo_category_list_query();

        $this->view->render('photo_gallery/tpl_edit_photo');
    }

    /**
     * 	Kép törlése a photo_gallery-ből
     *
     */
    public function delete() {
         $id = (int) $this->registry->params['id'];

        $result = $this->photo_gallery_model->delete_photo($id);

        Util::redirect('photo-gallery');
    }

    /**
     * 	Képgaléria kategóriák megjelenítése
     */
    public function category() {
        // adatok bevitele a view objektumba
        $this->view->title = 'Admin képgaléria kategória oldal';
        $this->view->description = 'Admin képgaléria kategória description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');

        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/media/js/jquery.dataTables.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'datatable.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/photo_category.js');

        $this->view->all_photo_category = $this->photo_gallery_model->photo_category_query();


//$this->view->debug(true);			

        $this->view->render('photo_gallery/tpl_photo_category');
    }

    /**
     * 	Új képgaléria kategória hozzáadása
     */
    public function category_insert() {
        // új kategória hozzáadása
        if (isset($_POST['photo_category_name'])) {
            $result = $this->photo_gallery_model->category_insert();

            if ($result) {
                Util::redirect('photo_gallery/category');
            } else {
                Util::redirect('photo_gallery/category_insert');
            }
        }

        $this->view->title = 'Új képgaléria kategória hozzáadása oldal';
        $this->view->description = 'Új képgaléria kategória description';

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');

        // template betöltése
        $this->view->render('photo_gallery/tpl_photo_gallery_category_insert');
    }

    /**
     * 	Képgaléria kategória nevének módosítása
     */
    public function category_update() {
        if (isset($_POST['category_name'])) {
            $result = $this->photo_gallery_model->category_update($this->registry->params['id']);
            if ($result) {
                Util::redirect('photo_gallery/category');
            } else {
                Util::redirect('photo_gallery/category_update/' . $this->registry->params['id']);
            }
        }

        $this->view->title = 'Admin képgaléria kategória módosítása oldal';
        $this->view->description = 'Admin képgaléria kategória módosítása description';

      
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');

        $this->view->category_content = $this->photo_gallery_model->photo_category_query($this->registry->params['id']);

        $this->view->render('photo_gallery/tpl_photo_gallery_category_update');
    }
    
    /**
     * Kategória törlése
     *
     * @return void
     */
    public function delete_category() {

        $this->photo_gallery_model->delete_category();
        Util::redirect('photo_gallery/category');
    }    

}

?>