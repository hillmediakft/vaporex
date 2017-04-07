<?php 
class Eloregisztracio_model extends Site_model {

	/**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
	function __construct()
	{
		parent::__construct();
	}

	function __destruct()
	{
		parent::__destruct();
	}

	/**
	 *	Visszadja, hogy előregisztrált-e már a bejelentkezett user
	 *
	 *	@return	bool
	 */
	public function check_preregister()
	{
		$this->query->reset();
		$this->query->set_table(array('pre_register_user'));
		$this->query->set_columns(array('user_id'));
		$this->query->set_where('user_id', '=', (int)Session::get('user_site_id'));
		$result = $this->query->select();
		return (count($result) == 1) ? true : false;
	}


	/**
	 *	Előregisztráció insert és update 
	 *
	 *	@param	string	$mode		(insert|update)
	 */	
	public function pre_register($mode)
	{
		$data = $_POST;
		
		// insert-nél a submit gomb adat törlése
		if($mode == 'insert'){
			unset($data['pre_register_submit']);
		}
		// update-nél a submit gomb adat törlése
		if($mode == 'update'){
			unset($data['pre_register_update']);
		}
		
	// üres stringek konvertálása null-ra
		foreach($data as $key => $value) {
			if($data[$key] == ''){
				$data[$key] = null;				
			}
		} 

		$error_count = 0;
		
	//validálás	
		// üzenet elem első része
		$message_first_part = array(
			'name' => 'A név mező',
			'mother_name' => 'Az anyja leánykori neve',
			'birth_place' => 'A születési hely',
			'birth_time' => 'A születési idő',
			'nationality' => 'Az állampolgárság',
			'student_card_number' => 'A diákigazolvány szám',
			'taj_number' => 'A TAJ szám',
			'tax_id' => 'Az adóazonosító jel',
			'bank_account_number' => 'A bankszámla száma',
			'bank_name' => 'A számlavezető bank neve',
			'permanent_address' => 'Az állandó lakcím',
			'email_address' => 'Az e-mail cím',
			'school_data' => 'Az iskola adatai'
		);
		// üzenetek második része
		$message_second_part = array(
			'field_empty' => ' nem lehet üres.',
			'illegal_char' => ' nem megengedett karaktert tartalmaz.'
		);
		
		// hibák keresése
		foreach($message_first_part as $key => $value) {
			if(is_null($data[$key])){
				$error_count++;
				Message::set('error', $value . $message_second_part['field_empty']);
			}
			if(preg_match('~[\"\']+~', $data[$key])){
				$error_count++;
				Message::set('error', $value . $message_second_part['illegal_char']);
			}
		} 	

		// ha van hiba
		if($error_count > 0){
			return false;		
		} else {
		// ha nincs hiba	
		
		// adatok feldolgozása	
			$data['school_type'] = (int)$data['school_type'];
			$data['user_id'] = (int)Session::get('user_site_id');	

			
		// adatbázis műveletek
			if($mode == 'insert'){
				$this->query->reset();
				$this->query->set_table(array('pre_register_user'));
				$result = $this->query->insert($data);
				
				if($result) {
					Message::set('success', 'Az előregisztráció megtörtént.');
					return true;				
				} else {
					Message::set('error', 'A regisztráció nem sikerült, próbálja újra!');
					return false;
				}
			}
			if($mode == 'update'){
				$this->query->reset();
				$this->query->set_table(array('pre_register_user'));
				$this->query->set_where('user_id', '=', $data['user_id']);
				$result = $this->query->update($data);			

				if($result == 1) {
					Message::set('success', 'Az előregisztráció adatainak módosítása megtörtént.');
					return true;				
				} else {
					Message::set('error', 'Az adatok módosítása nem sikerült, próbálja újra!');
					return false;
				}
			}
		}
		
	}
	
	public function get_prereg_data()
	{
		$this->query->reset();
		$this->query->set_table(array('pre_register_user'));
		$this->query->set_columns('*');
		$this->query->set_where('user_id', '=', (int)Session::get('user_site_id'));
		$result = $this->query->select();
		return $result[0];
	}
	

}
?>