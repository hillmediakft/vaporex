<?php

class Jatszohazak_model extends Site_model {

    function __construct() {
        parent::__construct();
    }

    /**
     * 	A rendezvények táblázathoz kérdezi le az adatokat
     * 	Itt nem kell minden adat egy rendezvényről
     */
    public function get_jatszohazak_query($limit = NULL) {
        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('rendezvenyek'));
        $this->query->set_columns(array(
            'rendezvenyek.rendezveny_id',
            'rendezvenyek.rendezveny_title',
            'rendezvenyek.rendezveny_description',
            'rendezvenyek.rendezveny_status',
            'rendezvenyek.rendezveny_city_id',
            'rendezvenyek.rendezveny_location',
            'rendezvenyek.rendezveny_photo',
            'rendezvenyek.rendezveny_expiry_timestamp',
            'rendezvenyek.rendezveny_start_timestamp',
            'city_list.city_name'
        ));
        $this->query->set_join('left', 'city_list', 'rendezvenyek.rendezveny_city_id', '=', 'city_list.city_id');
        $this->query->set_where('rendezveny_status', '=', 1);
        $this->query->set_where('rendezveny_expiry_timestamp', '>', time());
        $this->query->set_orderby('rendezveny_expiry_timestamp', 'ASC');
        return $this->query->select();
    }

    /**
     * 	A rendezvények táblázathoz kérdezi le az adatokat
     * 	Itt nem kell minden adat egy rendezvényről
     */
    public function get_jatszohaz($id) {
        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('rendezvenyek'));
        $this->query->set_columns(array(
            'rendezvenyek.rendezveny_id',
            'rendezvenyek.rendezveny_title',
            'rendezvenyek.rendezveny_description',
            'rendezvenyek.rendezveny_status',
            'rendezvenyek.rendezveny_city_id',
            'rendezvenyek.rendezveny_location',
            'rendezvenyek.rendezveny_location_lat',
            'rendezvenyek.rendezveny_location_lng',
            'rendezvenyek.rendezveny_directions',
            'rendezvenyek.rendezveny_address',
            'rendezvenyek.rendezveny_photo',
            'rendezvenyek.rendezveny_szolgaltatasok',
            'rendezvenyek.rendezveny_expiry_timestamp',
            'rendezvenyek.rendezveny_start_timestamp',
            'city_list.city_name'
        ));
        $this->query->set_join('left', 'city_list', 'rendezvenyek.rendezveny_city_id', '=', 'city_list.city_id');
        $this->query->set_where('rendezveny_status', '=', 1);
        $this->query->set_where('rendezveny_expiry_timestamp', '>', time());
        $this->query->set_where('rendezveny_id', '=', $id);
        $this->query->set_orderby('rendezveny_expiry_timestamp', 'ASC');
        $result = $this->query->select();
        if (!empty($result)) {
            return $result[0];
        } else {
            return array();
        }
    }

    /**
     * 	Lekérdezi a játékok nevét az id-k alapján, és stringet készít 
     */
    public function get_rendezveny_szolgaltatasok($szolgaltatasok_json_list) {
        $szolgaltatasok_list = json_decode($szolgaltatasok_json_list);

        if (count($szolgaltatasok_list) > 0) {
            foreach ($szolgaltatasok_list as $value) {
                $this->query->reset();
                $this->query->set_table(array('szolgaltatasok'));
                $this->query->set_columns('*');
                $this->query->set_where('szolgaltatas_id', '=', $value);
                $this->query->set_where('szolgaltatas_status', '=', 1);
                $result = $this->query->select();
                $szolgaltatasok_array[] = $result[0];
            }


// Sort the data with attack descending
            usort($szolgaltatasok_array, function($a, $b) {
                if ($a['megtekintes'] == $b['megtekintes'])
                    return 0;
                return ( $a['megtekintes'] > $b['megtekintes'] ) ? -1 : 1;
            });

            return $szolgaltatasok_array;
        } else {
            return array();
        }
    }

    /**
     * 	Egy szolgáltatás minden adatát lekérdezi 
     */
    public function one_szolgaltatas_alldata_query($id = null) {
        $id = (int) $id;

        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('szolgaltatasok'));
        $this->query->set_columns(array(
            'szolgaltatasok.szolgaltatas_id',
            'szolgaltatasok.szolgaltatas_title',
            'szolgaltatasok.szolgaltatas_description',
            'szolgaltatasok.szolgaltatas_photo',
            'szolgaltatasok.szolgaltatas_status',
            'szolgaltatasok.szolgaltatas_category_id',
            'szolgaltatasok_list.szolgaltatas_list_name'
        ));

        $this->query->set_join('left', 'szolgaltatasok_list', 'szolgaltatasok.szolgaltatas_category_id', '=', 'szolgaltatasok_list.szolgaltatas_list_id');
        $this->query->set_where('szolgaltatas_id', '=', $id);
        return $this->query->select();
    }

    /**
     * 	A termékek táblázathoz kérdezi le az adatokat
     * 	@return array
     */
    public function get_products() {
        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('products'));
        $this->query->set_columns(array(
            'products.product_id',
            'products.product_title',
            'products.product_description',
            'products.product_price',
            'products.product_tax',
            'products.product_status',
            'products.product_create_timestamp',
            'products.product_update_timestamp',
            'products.product_category_id',
            'products.product_photo'
        ));
        $this->query->set_where('product_status', '=', 1);

        return $this->query->select();
    }

    /**
     * Növeli az adott játszóház megtekintéseienk számát 1-gyel
     * 	
     * @param   $id     int   jatszóház id
     * @return  void 
     */
    public function increase_no_of_clicks($id) {

        $increase = array('megtekintes' => 'megtekintes+1');

        $this->query->reset();
//        $this->query->debug(true);
        $this->query->set_table(array('rendezvenyek'));
        $this->query->set_columns(array('rendezveny_id', 'megtekintes'));
        $this->query->set_where('rendezveny_id', '=', $id);
        $this->query->update(array(), $increase);
    }

    function __destruct() {
        parent::__destruct();
    }

}

?>