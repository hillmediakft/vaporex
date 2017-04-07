<?php

class Home extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
        require_once "system/libs/logged_in_user.php";
        $this->user = new Logged_in_user();
        $this->check_access("menu_home");
        $this->view->user = $this->user;
		
    }

    public function index() {

        // adatok bevitele a view objektumba
        $this->view->title = 'Admin kezdő oldal';
        $this->view->description = 'Admin kezdő oldal description';

        $this->view->js_link[] = $this->make_link('js', ADMIN_JS, 'pages/common.js');

        $this->view->render('home/tpl_home');
    }

}

?>