<?php 
class Admin_model extends Model {

	function __construct()
	{
		parent::__construct();
	}

	function __destruct()
	{
		parent::__destruct();
	}
	
    /**
     * 	Lekérdezi a megyék nevét és id-jét a county_list táblából (az option listához)
     */
    public function county_list_query() {
        $this->query->reset();
        $this->query->set_table(array('county_list'));
        $this->query->set_columns(array('county_id', 'county_name'));
        $result = $this->query->select();
        return $result;
    }         
        
}
?>