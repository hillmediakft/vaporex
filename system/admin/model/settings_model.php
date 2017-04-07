<?php

class Settings_model extends Model {

    /**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Oldal szintű beállítások lekérdezése a settings táblából
     *
     * @return array a beállítások tömbje
     */
    public function get_settings() {
        $this->query->set_table(array('settings'));
        $this->query->set_columns('*');
        $result = $this->query->select();
        return $result[0];
    }

    /**
     * Oldal szintű beállítások módosításának elmentése
     *
     * @return true/false
     */
    public function update_settings() {
        $data['ceg'] = $_POST['setting_ceg'];
        $data['cim'] = $_POST['setting_cim'];
        $data['email'] = $_POST['setting_email'];
        $data['tel'] = $_POST['setting_tel'];
        $data['facebook_link'] = $_POST['setting_facebook_link'];
        if (isset($_POST['setting_home_city_filter'])) {
            $data['home_city_filter'] = (int) $_POST['setting_home_city_filter'];
        } else {
            $data['home_city_filter'] = 0;
        }

        // új adatok beírása az adatbázisba (update) a $data tömb tartalmazza a frissítendő adatokat 
        $this->query->reset();
        //    $this->query->debug(true);
        $this->query->set_table(array('settings'));
        $this->query->set_where('id', '=', 1);
        $result = $this->query->update($data);

        if ($result > 0) {
            Message::set('success', 'settings_update_success');
            return true;
        } elseif ($result == 0) {
            Message::set('success', 'Nem módosította az adatokat');
            return true;
        } else {
            Message::set('error', 'unknown_error');
            return false;
        }
    }

}

?>