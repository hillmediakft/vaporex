<?php

class Jatekaink_model extends Site_model {

    function __construct() {
        parent::__construct();
    }

    function __destruct() {
        parent::__destruct();
    }
    
    /**
     * 	A services táblázathoz kérdezi le az adatokat
     * 	Itt nem kell minden adat egy szolgáltatásról/játékról
     */
    public function all_szolgaltatasok_query() {
        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('szolgaltatasok'));
        $this->query->set_columns(array(
          'szolgaltatasok.szolgaltatas_id',
          'szolgaltatasok.szolgaltatas_title',
          'szolgaltatasok.szolgaltatas_description',
          'szolgaltatasok.szolgaltatas_info',
          'szolgaltatasok.szolgaltatas_photo',
          'szolgaltatasok.szolgaltatas_status'
        ));
		$this->query->set_where('szolgaltatas_status', '=', 1);
		$this->query->set_orderby('megtekintes', 'DESC');
        return $this->query->select();
    }
    
/**
     * 	Egy szolgáltatás minden adatát lekérdezi a részletek megjelenítéséhez
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
          'szolgaltatasok.szolgaltatas_info',
          'szolgaltatasok.szolgaltatas_photo',
          'szolgaltatasok.szolgaltatas_extra_photos',
          'szolgaltatasok.szolgaltatas_status',
          'szolgaltatasok.szolgaltatas_category_id',
          'szolgaltatasok_list.szolgaltatas_list_name'
        ));

        $this->query->set_join('left', 'szolgaltatasok_list', 'szolgaltatasok.szolgaltatas_category_id', '=', 'szolgaltatasok_list.szolgaltatas_list_id');
        $this->query->set_where('szolgaltatas_id', '=', $id);
        $result = $this->query->select();
        return $result[0];
       
    }   
    
    /**
     * Növeli az adott játék megtekintéseienk számát 1-gyel
     * 	
     * @param   $id     int    játék id
     * @return  void 
     */
    public function increase_no_of_clicks($id) {

        $increase = array('megtekintes' => 'megtekintes+1');

        $this->query->reset();
//        $this->query->debug(true);
        $this->query->set_table(array('szolgaltatasok'));
        $this->query->set_columns(array('szolgaltatas_id', 'megtekintes'));
        $this->query->set_where('szolgaltatas_id', '=', $id);
        $this->query->update(array(), $increase);
    }    

}

?>