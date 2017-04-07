<?php

class Application {

    public $registry;

    public function __construct() {
        // Registry objektum hozzárendelése egy tulajdonsághoz
        $this->registry = Registry::get_instance();

        // url elemzése és elemeinek bevitele a registrybe
        $this->uri_parser();

        // Beállítjuk, hogy az üzenetek melyik modulra vonatkozzanak (message_site vagy message_admin)
        Message::set_area($this->registry->area);
        // Betöltjük az aktuális nyelvnek megfelelő üzenet fájlt
        Message::load('messages_' . $this->registry->area, $this->registry->lang);
        // router betöltése (controller, action és paraméterek megadása)
        $this->load_router();
        //var_dump($this->registry);
        //die('');
        // hook objektum létrehozása, a rendszer elindítása előtti hook-ok futtatása
        $this->hooks = new Hooks();
        $this->hooks->_call_hook($this->registry->area . '_pre_system');

        // controller file betöltése és a megfelelő action behívása
        $this->load_controller();
    }

    /**
     * 	Létrehozzuk az uri (elemző) objektumát
     *
     * 	@return		A Registry objektumba teszi a visszadott értékeket
     */
    private function uri_parser() {
        $parse_uri = new Uri();

        $this->registry->uri = $parse_uri->uri; //URI a query string-gel együtt 
        $this->registry->current_url = $parse_uri->current_url; // Jelenlegi url (a címsorban lévő teljes url-t tartalmazza, néhány tisztító művelet után)
        $this->registry->site_url = $parse_uri->site_url; // base url + modul +lang
        $this->registry->uri_path = $parse_uri->uri_path; // URI a query string nélkül
        $this->registry->query_string = $parse_uri->query_string; // query string
        $this->registry->query_string_arr = $parse_uri->query_string_arr; // query string elemei asszociatív tömbben
        $this->registry->area = $parse_uri->area; // admin vagy site
        $this->registry->lang = $parse_uri->lang; // nyelvi kód
    }

    /**
     * 	Router elindítása
     */
    private function load_router() {
        $router = new Router();
        $router->find($this->registry->uri_path, $this->registry->area);

        $this->registry->controller = $router->controller;
        $this->registry->action = $router->action;
        $this->registry->params = $router->params;
    }

    /**
     * Controller betöltése
     */
    private function load_controller() {
        // Először is betölti a megfelelő controller fájlt (ha betölthető), az url első paramétere alapján.
        $file = 'system/' . $this->registry->area . '/controller/' . $this->registry->controller . '.php';

        if (!file_exists($file)) {
            require_once ('system/' . $this->registry->area . '/controller/error.php');
            $error = new Error();
            $error->index();
        } else {
            require_once($file);
            // Példányosítjuk a controllert
            $controller = new $this->registry->controller();
            /*
             * ------------------------------------------------------
             *  Ha van "post_controller_constructor" hook, akkor meghívjuk
             * ------------------------------------------------------
             */
            $this->hooks->_call_hook($this->registry->area . '_post_controller_constructor');


            // meghívjuk az action metódust, ha nincs, akkor az index metódust hívjuk meg
            if (method_exists($controller, $this->registry->action)) {
                $controller->{$this->registry->action}();
            } else {
                $controller->index();
            }
        }
    }

}

// osztály vége
?>