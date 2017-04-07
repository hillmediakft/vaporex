<?php 
class Kapcsolat_model extends Site_model {

	function __construct()
	{
		parent::__construct();
	}
	
	function __destruct()
	{
		parent::__destruct();
	}
	
/**
     * 	A rendezvények táblázathoz kérdezi le a legközelebbi játszóház adatait
     * 	Itt nem kell minden adat egy rendezvényről
     */
    public function get_kovetkezo_jatszohaz() {
        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('rendezvenyek'));
        $this->query->set_columns(array(
          'rendezvenyek.rendezveny_id',
          'rendezvenyek.rendezveny_city_id',
          'rendezvenyek.rendezveny_location',
          'rendezvenyek.rendezveny_start_timestamp',
          'city_list.city_name'
        ));
        $this->query->set_join('left', 'city_list', 'rendezvenyek.rendezveny_city_id', '=', 'city_list.city_id');
        $this->query->set_where('rendezveny_status', '=', 1);
        $this->query->set_where('rendezveny_expiry_timestamp', '>', time());
        $this->query->set_orderby('rendezveny_start_timestamp', 'ASC');
        $this->query->set_limit(1);
        return $this->query->select();
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

}
?>