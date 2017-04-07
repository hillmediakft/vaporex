<?php 
class Ajax_request_model Extends Site_model {

	function __construct()
	{
		parent::__construct();
	}

	function __destruct()
	{
		parent::__destruct();
	}
	
	
	/**
	 *	Lekérdezi a megyék nevét és id-jét a county_list táblából (az option listához)
	 */
	public function county_list_query()
	{
		$this->query->reset(); 
		$this->query->set_table(array('county_list')); 
		$this->query->set_columns(array('county_id','county_name')); 
		$result = $this->query->select();
		return $result;
	}
	
	/**
	 *	Lekérdezi a városok nevét és id-jét a city_list táblából (az option listához)
	 *	A paraméter megadja, hogy melyik megyében lévő városokat adja vissza 		
	 *	@param integer	$id 	egy megye id-je (county_id)
	 */
	public function city_list_query($id = null)
	{
		$this->query->reset(); 
		$this->query->set_table(array('city_list')); 
		$this->query->set_columns(array('city_id','city_name')); 
			if(!is_null($id)) {
				$this->query->set_where('county_id', '=', $id);
			}
		$result = $this->query->select();
		return $result;
	}

	/**
	 *	Lekérdezi a kerületek nevét és id-jét a district_list táblából (az option listához)
	 */
	public function district_list_query()
	{
		$this->query->reset(); 
		$this->query->set_table(array('district_list')); 
		$this->query->set_columns(array('district_id','district_name')); 
		$result = $this->query->select();
		return $result;
	}

	/**
	 *	Lekérdezi a kerületek nevét és id-jét a district_list táblából (az option listához)
	 */
	public function job_category_list_query()
	{
		$this->query->reset(); 
		$this->query->set_table(array('jobs_list')); 
		$this->query->set_columns(array('job_list_id','job_list_name')); 
		$result = $this->query->select();
		return $result;
	}		
	

}
?>