<?php

class File_manager extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_file_manager");
        $this->view->user = $this->user;
    }

    public function index() {
        /* 		Auth::handleLogin();

          if (!Acl::create()->userHasAccess('home_menu')) {
          exit('nincs hozzáférése');
          }

         */
        // adatok bevitele a view objektumba
        $this->view->title = 'Fájlkezelő oldal';
        $this->view->description = 'Fájlkezelő oldal description';
        $this->view->css_link[] = $this->make_link('css', '', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/elfinder/css/elfinder.min.css');
        $this->view->css_link[] = $this->make_link('css', ADMIN_ASSETS, 'plugins/elfinder/css/theme.css');


        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/elfinder/js/elfinder.min.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_ASSETS, 'plugins/elfinder/js/i18n/elfinder.hu.js');
        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/file_manager.js');



        $this->view->render('file_manager/tpl_file_manager');
    }

}

?>