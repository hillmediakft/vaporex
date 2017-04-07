<?php

class User_manual extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_user_manual");
        $this->view->user = $this->user;
    }

    public function index() {
        Auth::handleLogin();

        // adatok bevitele a view objektumba
        $this->view->title = 'Admin dokumentáció oldal';
        $this->view->description = 'Admin dookumentáció description';


        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');
//		$this->view->css = '';
//		$this->view->js = '';


        $this->view->render('user_manual/tpl_user_manual');
    }

}

?>