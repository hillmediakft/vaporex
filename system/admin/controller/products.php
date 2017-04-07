<?php

/**
 * Class products
 *
 * @author Várnagy Attila
 * 
 */
class Products extends Controller {

    function __construct() {
        parent::__construct();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_products");
        $this->view->user = $this->user;
        $this->loadModel('products_model');
        $this->loadClass('category');
    }

    /**
     * index metódus
     *
     * 
     */
    public function index() {
        $this->view->title = 'Termékek oldal';
        $this->view->description = 'Termékek oldal description';

        // az oldalspecifikus css linkeket berakjuk a view objektum css_link tulajdonságába (ami egy tömb)
        // a make_link() metódus az anyakontroller metódusa (így egyszerűen meghívható bármelyik kontrollerben)
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');

        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/media/js/jquery.dataTables.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'datatable.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/products.js');

        $this->view->all_products = $this->products_model->all_products_query();

        $this->view->render('products/tpl_products');
    }

    /**
     * 	Termék minden adatának megjelenítése
     */
    public function view_product() {
        $this->view->title = 'Admin termék részletek oldal';
        $this->view->description = 'Admin termék részletek oldal description';
        // az oldalspecifikus css linkeket berakjuk a view objektum css_link tulajdonságába (ami egy tömb)
        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');

        $this->view->content = $this->products_model->one_product_alldata_query($this->registry->params['id']);

        $this->view->render('products/tpl_product_view');
    }

    /**
     * 	Termék minden adatának megjelenítése Ajax-szal
     */
    public function view_product_ajax() {
        if (Util::is_ajax()) {
            $this->view->content = $this->products_model->one_product_alldata_query_ajax();


            $this->view->render('products/tpl_product_view_modal', true);
        } else {
            Util::redirect('error');
        }
    }

    /**
     * 	Új termék hozzáadása
     */
    public function new_product() {
        // új termék hozzáadása
        if (!empty($_POST)) {
            $result = $this->products_model->insert_product();
            if ($result) {
                Util::redirect('products');
            } else {
                Util::redirect('products/new_product');
            }
        }

        $this->view->title = 'Új termék oldal';
        $this->view->description = 'Új termék description';
        
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/croppic/croppic.css');
        // js linkek generálása
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/croppic/croppic.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/new_product.js');

        // ck_editor bekapcsolása
        $this->view->ckeditor = true;

// termék kategóriák lekérdezése az option listához
        $this->view->product_category_list = $this->category->product_categories_query();
       
        
        
        $this->view->product_category_list_with_path = $this->category->product_categories_with_path($this->view->product_category_list);


        // template betöltése
        $this->view->render('products/tpl_new_product');
    }

    /**
     * 	Termék törlése
     *
     */
    public function delete_product() {
        // ez a metódus true-val tér vissza (false esetén kivételt dob!)
        $this->products_model->delete_product();
        Util::redirect('products');
    }

    /**
     * 	Termék módosítása
     *
     */
    public function update_product() {
        if (!empty($_POST)) {
            $result = $this->products_model->update_product($this->registry->params['id']);

            if ($result) {
                Util::redirect('products');
            } else {
                Util::redirect('products/update_product/' . $this->registry->params['id']);
            }
        }

        // HTML oldal megjelenítése
        // adatok bevitele a view objektumba
        $this->view->title = 'Termék módosítása oldal';
        $this->view->description = 'Termék módosítása description';
 $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/croppic/croppic.css');
        // js linkek generálása
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/croppic/croppic.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/edit_product.js');

        // ck_editor bekapcsolása
        $this->view->ckeditor = true;

        // a módosítandó termék adatai
        $this->view->actual_product = $this->products_model->one_product_query($this->registry->params['id']);
        // munka kategóriák lekérdezése az option listához
        $this->view->product_category_list = $this->category->product_categories_query();
        $this->view->product_category_list_with_path = $this->category->product_categories_with_path($this->view->product_category_list);

        $this->view->render('products/tpl_product_update');
    }

    /**
     * 	Termék kategóriák megjelenítése
     */
    public function category() {
        // adatok bevitele a view objektumba
        $this->view->title = 'Termékek kategória oldal';
        $this->view->description = 'termékek kategória description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/jstree/dist/themes/default/style.min.css');

        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/media/js/jquery.dataTables.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'datatable.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jstree/dist/jstree.min.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/product_category.js');

        $this->view->all_product_category = $this->products_model->product_categories_query();

        $this->view->category_counter = $this->products_model->product_category_counter_query();
        $this->view->category_tree = $this->products_model->get_category_tree();

        $this->view->render('products/tpl_product_category');
    }

    /**
     * 	Új termék kategória hozzáadása
     */
    public function category_insert() {

        if (isset($_POST['product_category_name'])) {

            $result = $this->products_model->category_insert();

            if ($result) {
                Util::redirect('products/category');
            } else {
                Util::redirect('products/category_insert');
            }
        }

        $this->view->title = 'Új munka kategória hozzáadása oldal';
        $this->view->description = 'Új munka kategória description';

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/croppic/croppic.css');
        // js linkek generálása
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/croppic/croppic.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/new_product_category.js');
        //$this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');	
        // termék kategóriák lekérdezése az option listához
        $this->view->product_category_list = $this->category->product_categories_query();
        $this->view->product_category_list_with_path = $this->category->product_categories_with_path($this->view->product_category_list);

        // template betöltése
        $this->view->render('products/tpl_product_category_insert');
    }

    /**
     * 	Termék kategória módosítása
     */
    public function category_update() {
        if (isset($_POST['product_category_name'])) {
            $result = $this->products_model->category_update($this->registry->params['id']);
            if ($result) {
                Util::redirect('products/category');
            } else {
                Util::redirect('products/category_update/' . $this->registry->params['id']);
            }
        }

        $this->view->title = 'Admin termék kategória módosítása oldal';
        $this->view->description = 'Admin termék kategória módosítása description';

       $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/croppic/croppic.css');
        // js linkek generálása
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/croppic/croppic.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/edit_product_category.js');


        //$this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');	   
        $this->view->product_category_list = $this->category->product_categories_query();
        $this->view->product_category_list_with_path = $this->category->product_categories_with_path($this->view->product_category_list);
        $this->view->category_content = $this->products_model->one_product_category($this->registry->params['id']);

        $this->view->render('products/tpl_product_category_update');
    }

    /**
     * Kategória törlése
     *
     * @return void
     */
    public function category_delete() {

        $this->products_model->delete_category();
        Util::redirect('products/category');
    }

    /**
     * (AJAX) A products táblában módosítja az product_status mező értékét
     *
     * @return void
     */
    public function change_status() {
        if (Util::is_ajax()) {
            if (isset($_POST['action']) && isset($_POST['id'])) {

                $id = (int) $_POST['id'];

                if ($_POST['action'] == 'make_active') {
                    $this->products_model->change_status_query($id, 1);
                }
                if ($_POST['action'] == 'make_inactive') {
                    $this->products_model->change_status_query($id, 0);
                }
            }
        } else {
            Util::redirect('error');
        }
    }

    /**
     * 	A termék képét tölti fel a szerverre, és készít egy kisebb méretű képet is.
     *
     * 	Ez a metódus kettő XHR kérést dolgoz fel.
     * 	Meghívásakor kap egy id nevű paramétert melynek értékei upload vagy crop
     * 		upload paraméterrel meghívva: feltölti a kiválasztott képet
     * 		crop paraméterrel meghívva: megvágja az eredeti képet és feltölti	
     * 	(a paraméterek megadása a new_user.js fájlban található: admin/users/user_img_upload/upload vagy admin/user_img_upload/crop)
     *
     * 	Az user_img_upload() model metódus JSON adatot ad vissza (ezt "echo-za" vissza ez a metódus a kérelmező javascriptnek). 
     */
    public function product_crop_img_upload() {
        if (Util::is_ajax()) {
            echo $this->products_model->product_crop_img_upload();
        }
    }
    
    /**
     * 	A termék kategória képét tölti fel a szerverre, és készít egy kisebb méretű képet is.
     *
     * 	Ez a metódus kettő XHR kérést dolgoz fel.
     * 	Meghívásakor kap egy id nevű paramétert melynek értékei upload vagy crop
     * 		upload paraméterrel meghívva: feltölti a kiválasztott képet
     * 		crop paraméterrel meghívva: megvágja az eredeti képet és feltölti	
     * 	(a paraméterek megadása a new_user.js fájlban található: admin/users/user_img_upload/upload vagy admin/user_img_upload/crop)
     *
     * 	Az user_img_upload() model metódus JSON adatot ad vissza (ezt "echo-za" vissza ez a metódus a kérelmező javascriptnek). 
     */
    public function product_category_crop_img_upload() {
        if (Util::is_ajax()) {
            echo $this->products_model->product_category_crop_img_upload();
        }
    }    
    
    

}

?>