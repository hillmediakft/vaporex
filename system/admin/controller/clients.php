<?php

class Clients extends Controller {

    function __construct() {
                parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_modules");
        $this->view->user = $this->user;
        $this->loadModel('clients_model');
    }

    public function index() {
        $this->view->title = 'Partnereink oldal';
        $this->view->description = 'Partnereink description';

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

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/clients.js');

        $this->view->all_client = $this->clients_model->all_client_query();

//$this->view->debug(true);

        $this->view->render('clients/tpl_clients');
    }

    /**
     * 	Munka minden adatának megjelenítése
     */
    public function view_client() {
        $this->view->title = 'Admin munka részletek oldal';
        $this->view->description = 'Admin munka részletek oldal description';
        // az oldalspecifikus css linkeket berakjuk a view objektum css_link tulajdonságába (ami egy tömb)
        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');

        $this->view->content = $this->clients_model->one_client_alldata_query($this->registry->params['id']);

//$this->view->debug(true);

        $this->view->render('clients/tpl_client_view');
    }

    /**
     * 	Munka minden adatának megjelenítése
     */
    public function view_client_ajax() {
        if (Util::is_ajax()) {
            $this->view->content = $this->clients_model->one_client_alldata_query_ajax();

            $this->view->location = $this->view->content['county_name'] . $this->view->content['city_name'] . $this->view->content['district_name'];
            $this->view->render('clients/tpl_client_view_modal', true);
        } else {
            Util::redirect('error');
        }
    }

    /**
     * 	Új munka hozzáadása
     */
    public function new_client() {
        // új munka hozzáadása
        if (!empty($_POST)) {
            $result = $this->clients_model->insert_client();
            if ($result) {
                Util::redirect('clients');
            } else {
                Util::redirect('clients/new_client');
            }
        }

        // HTML oldal megjelenítése
        // adatok bevitele a view objektumba
        $this->view->title = 'Új kolléga oldal';
        $this->view->description = 'Új kolléga description';
// css linkek generálása
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/croppic/croppic.css');

        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        // js linkek generálása
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/croppic/croppic.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');



        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/new_client.js');

        // ck_editor bekapcsolása
        $this->view->ckeditor = true;

        // munkaterület kategóriák lekérdezése az option listához
//$this->view->debug(true);
        // template betöltése
        $this->view->render('clients/tpl_new_client');
    }

    /**
     * 	Munkák törlése
     *
     */
    public function delete_client() {
        // ez a metódus true-val tér vissza (false esetén kivételt dob!)
        $this->clients_model->delete_client();
        Util::redirect('clients');
    }

    /**
     * 	Crew member módosítása
     *
     */
    public function update_client() {
        if (!empty($_POST)) {
            $result = $this->clients_model->update_client($this->registry->params['id']);

            if ($result) {
                Util::redirect('clients');
            } else {
                Util::redirect('clients/update_client/' . $this->registry->params['id']);
            }
        }

        // HTML oldal megjelenítése
        // adatok bevitele a view objektumba
        $this->view->title = 'Crew member módosítása oldal';
        $this->view->description = 'Crew member módosítása description';
        // css linkek generálása
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/croppic/croppic.css');


        // js linkek generálása
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/croppic/croppic.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootstrap-fileupload/bootstrap-fileupload.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/edit_client.js');


        // a módosítandó kolléga adatai
        $this->view->actual_client = $this->clients_model->one_client_query($this->registry->params['id']);


        // template betöltése
        $this->view->render('clients/tpl_client_update');
    }

    /**
     * 	A felhasználó képét tölti fel a szerverre, és készít egy kisebb méretű képet is.
     *
     * 	Ez a metódus kettő XHR kérést dolgoz fel.
     * 	Meghívásakor kap egy id nevű paramétert melynek értékei upload vagy crop
     * 		upload paraméterrel meghívva: feltölti a kiválasztott képet
     * 		crop paraméterrel meghívva: megvágja az eredeti képet és feltölti	
     * 	(a paraméterek megadása a new_user.js fájlban található: admin/users/user_img_upload/upload vagy admin/user_img_upload/crop)
     *
     * 	Az user_img_upload() model metódus JSON adatot ad vissza (ezt "echo-za" vissza ez a metódus a kérelmező javascriptnek). 
     */
    public function client_img_upload() {
        if (Util::is_ajax()) {
            echo $this->clients_model->client_img_upload();
        }
    }

}

?>