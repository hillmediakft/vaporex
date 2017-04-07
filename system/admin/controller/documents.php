<?php

class Documents extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_referenciak");
        $this->view->user = $this->user;
        $this->loadModel('document_model');
    }

    public function index() {

        $this->view->title = 'Admin document oldal';
        $this->view->description = 'Admin document oldal description';



        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/select2/select2.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');

        // az oldalspecifikus javascript linkeket berakjuk a view objektum js_link tulajdonságába (ami egy tömb)
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/select2/select2.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/media/js/jquery.dataTables.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'datatable.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/documents.js');

        $this->view->all_document = $this->document_model->find();

        $this->view->render('documents/tpl_document_list');
    }

    /**
     * Blog bejegyzés hozzáadása
     */
    public function insert() {

        if (!empty($_POST)) {
            $result = $this->document_model->insert();

            if ($result) {
        
                Util::redirect('documents');
            } else {
                Util::redirect('documents/insert');
            }
        }

        $this->view->title = 'Admin document oldal';
        $this->view->description = 'Admin document oldal description';

        $this->view->js_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/kartik-bootstrap-fileinput/css/fileinput.css');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/kartik-bootstrap-fileinput/js/fileinput.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/kartik-bootstrap-fileinput/js/locales/hu.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation/jquery.validate.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation/localization/messages_hu.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/document_insert.js');

        //      $this->view->add_links(array('validation', 'ckeditor', 'vframework', 'kartik-bootstrap-fileinput', 'document_insert'));

        $this->view->category_list = $this->document_model->findCategories();

        $this->view->render('documents/tpl_document_insert');
    }

    /**
     * Blog bejegyzés módosítása
     */
    public function update() {
        if (!empty($_POST)) {

            $result = $this->document_model->update($this->registry->params['id']);
            if ($result) {
                Util::redirect('documents');
            } else {
                Util::redirect('documents/update/' . $this->registry->params['id']);
            }
        }

        $this->view->title = 'Admin document oldal';
        $this->view->description = 'Admin document oldal description';

        $this->view->js_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/kartik-bootstrap-fileinput/css/fileinput.css');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/kartik-bootstrap-fileinput/js/fileinput.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/kartik-bootstrap-fileinput/js/locales/hu.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation/jquery.validate.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation/additional-methods.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/jquery-validation/localization/messages_hu.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/bootbox/bootbox.min.js');

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/document_update.js');

        //      $this->view->add_links(array('bootstrap-fileupload', 'ckeditor', 'vframework', 'document_update'));

         $this->view->category_list = $this->document_model->findCategories();
        $content = $this->document_model->getDocument($this->registry->params['id']);
        $this->view->content = $content[0];

        $this->view->render('documents/tpl_document_update');
    }

    /**
     * 	Blog törlése AJAX-al
     */
    public function delete_document_AJAX() {
        if ($this->request->is_ajax()) {
            if (1) {
                // a POST-ban kapott user_id egy string ami egy szám vagy számok felsorolása pl.: "23" vagy "12,45,76" 
                $id = $this->request->get_post('item_id');
                $respond = $this->document_model->delete_document_AJAX($id);
                echo json_encode($respond);
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Nincs engedélye a művelet végrehajtásához!'
                ));
            }
        }
    }

    /**
     * 	Blog törlése AJAX-al
     */
    public function delete() {
        if (1) {
            $id = $this->registry->params['id'];
            $result = $this->document_model->delete_document($id);
            Util::redirect('documents');
        } else {
            Util::redirect('documents');
        }
    }

    /**
     *  (AJAX) Új lakás adatok bevitele adatbázisba,
     *  Lakás adatok módosítása az adatbázisban
     */
    public function insert_update_data_ajax() {
        if ($this->request->is_ajax()) {
            if ($this->request->has_post()) {
                $result = $this->document_model->insert_update_document_data();
                // válasz a javascriptnek
                echo json_encode($result);
            }
        } else {
            Util::redirect('error');
        }
    }

    /**
     * Blog kategóriák 
     */
    public function category() {
        $this->view = new View();

        $this->view->title = 'Admin document oldal';
        $this->view->description = 'Admin document oldal description';

        $this->view->add_links(array('datatable', 'bootbox', 'vframework', 'document_category'));

        $this->view->all_document_category = $this->document_model->category_query();
        $this->view->category_counter = $this->document_model->category_counter_query();
//$this->view->debug(true);			
        $this->view->set_layout('tpl_layout');
        $this->view->render('document/tpl_document_category');
    }

    /**
     * Kategória hozzáadása és módosítása (AJAX)
     */
    public function category_insert_update() {
        if ($this->request->is_ajax()) {
            $id = $this->request->get_post('id');
            $category_name = $this->request->get_post('data');
            $result = $this->document_model->category_insert_update($id, $category_name);
            echo json_encode($result);
        }
    }

    /**
     * 	Kategória törlése (AJAX)
     */
    public function category_delete() {
        if ($this->request->is_ajax()) {
            if (1) {
                $id = $this->request->get_post('item_id', 'integer');
                $respond = $this->document_model->category_delete($id);
                echo json_encode($respond);
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Nincs engedélye a művelet végrehajtásához!'
                ));
            }
        }
    }

    /**
     * 	(AJAX) Dokumentum feltöltés
     */
    public function doc_upload_ajax() {
        if ($this->request->is_ajax()) {
            //uploadExtraData beállítás küldi
            $id = $this->request->get_post('id', 'integer');
            $doc_names = $this->document_model->upload_doc($_FILES['new_doc'], $id);
            $result = $this->document_model->file_query($doc_names, 'file', $id);

            if ($result !== false) {
                echo json_encode(array('status' => 'success', 'message' => 'File feltöltése sikeres.'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Ismeretlen hiba!'));
            }
        } else {
            Util::redirect('error');
        }
    }

    /**
     * 	(AJAX) File listát jeleníti (frissíti) meg feltöltéskor (képek)
     */
    public function show_file_list() {
        if ($this->request->is_ajax()) {
            // db rekord id-je
            $id = $this->request->get_post('id', 'integer');
            //adatok lekérdezése (a json stringet adja vissza)
            $result = $this->document_model->getDocuments($id);
            // json string átalakítása tömb-bé
            $temp_arr = json_decode($result);

            // lista HTML generálása
            $html = '';
            $counter = 0;

            $file_location = Config::get('documents.upload_path');

            foreach ($temp_arr as $key => $value) {
                $counter = $key + 1;
                $file_path = Util::thumb_path($file_location . $value);
                $html .= '<li id="doc_' . $counter . '" class="list-group-item"><i class="glyphicon glyphicon-file"> </i>&nbsp;' . $value . '<button type="button" class="btn btn-xs btn-default" style="position: absolute; top:8px; right:8px;"><i class="glyphicon glyphicon-trash"></i></button></li>' . "\n\r";
            }

            // lista visszaküldése a javascriptnek
            echo $html;
        } else {
            Util::redirect('error');
        }
    }

    public function download() {
        $file = $this->registry->params['file'];
        $file_path = Config::get('documents.upload_path') . $file;
        Util::outputFile($file_path, $file);
        exit;
    }

}

?>