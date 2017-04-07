<?php 
class Pre_register_model extends Model {

	function __construct()
	{
		parent::__construct();
	}

	/**
	 *	Lekérdezi egy rekord minden adatát a pre_register_user táblából
	 */
	public function alldata_query($id)
	{
		$this->query->reset();
		$this->query->set_table(array('pre_register_user'));
		$this->query->set_columns('*');
		$this->query->set_where('user_id', '=', $id);
		$result = $this->query->select();
		return $result[0];
	}
	
	/**
	 *	Előregisztrációk törlése
	 *
	 *	@param	array	$id_arr		a törlendő rekordok id-it tartalmazó tömb
	 *	@return	array
	 */
	public function delete_prereg($id_arr)
	{
		// a sikeres törlések számát tárolja
		$success_counter = 0;
		// a sikertelen törlések számát tárolja
		$error_counter = 0;

		// bejárjuk a $id_arr tömböt és minden elemen végrehajtjuk a törlést
		foreach($id_arr as $id) {
			//átalakítjuk a integer-ré a kapott adatot
			$id = (int)$id;
				
			//felhasználó törlése	
			$this->query->reset();
			$this->query->set_table(array('pre_register_user'));
			//a delete() metódus integert (lehet 0 is) vagy false-ot ad vissza
			$result = $this->query->delete('user_id', '=', $id);
			
			if($result !== false) {
				// ha a törlési sql parancsban nincs hiba
				if($result > 0){
					//sikeres törlés
					$success_counter += $result;
				}
				else {
					//sikertelen törlés
					$fail_counter += 1;
				}
			}
			else {
				// ha a törlési sql parancsban hiba van
				throw new Exception('Hibas sql parancs: nem sikerult a DELETE lekerdezes az adatbazisbol!');
				return false;
			}
		}
		
		return array("success" => $success_counter, "error" => $error_counter);	
	}	
	
	
	public function get_prereg($request_data)
	{
		// ebbe a tömbbe kerülnek a csoportos műveletek üzenetei
		$messages = array();

		if(isset($request_data['customActionType']) && isset($request_data['customActionName'])) {
		
			switch ($request_data['customActionName']) {
			
				case 'group_delete':
					// az id-ket tartalmazó tömböt kapja paraméterként
					$result = $this->delete_prereg($request_data['id']);
					
					if($result['success'] > 0) {
						$messages['success'] = $result['success'] . ' ' . Message::send('Előregisztráció sikeresen törölve.');	
					}
					if($result['error'] > 0){
						$messages['error'] = $result['error'] . ' ' . Message::send('Előregisztráció törlése nem sikerült!');	
					}					
					break;
			}
		
		}
	
		
		//összes sor számának lekérdezése
		$total_records = $this->query->count('pre_register_user');
	
		$display_length = intval($request_data['length']);
		$display_length = ($display_length < 0) ? $total_records : $display_length;
		$display_start = intval($request_data['start']);
		$display_draw = intval($request_data['draw']);
		
		$this->query->reset();	
		// a query tulajdonság ($this->query) tartalmazza a query objektumot
		$this->query->set_table(array('pre_register_user')); 
		$this->query->set_columns('SQL_CALC_FOUND_ROWS 
			`user_id`,
			`name`,
			`mother_name`,
			`birth_place`,
			`student_card_number`'
		); 		
		
		$this->query->set_offset($display_start); 
		$this->query->set_limit($display_length); 
		
		//szűrés beállítások
		if(isset($request_data['action']) && $request_data['action'] == 'filter') {
			if(!empty($request_data['search_user_id'])){
				$this->query->set_where('user_id', '=', $request_data['search_user_id']);
			}
			if(!empty($request_data['search_name'])){
				$this->query->set_where('name', 'LIKE', '%' . $request_data['search_name'] . '%');
			}
			if(!empty($request_data['search_mother_name'])){
				$this->query->set_where('mother_name', 'LIKE', '%' . $request_data['search_mother_name'] . '%');
			}
			if(!empty($request_data['search_birth_place'])){
				$this->query->set_where('birth_place', 'LIKE', '%' . $request_data['search_birth_place'] . '%');
			}
			if(!empty($request_data['search_student_card_number'])){
				$this->query->set_where('student_card_number', '=', $request_data['search_student_card_number']);
			}
		}
		
		//rendezés
		if(isset($request_data['order'][0]['column']) && isset($request_data['order'][0]['dir'])){
			$num = $request_data['order'][0]['column']; //ez az oszlop száma
			$dir = $request_data['order'][0]['dir']; // asc vagy desc
			$order = $request_data['columns'][$num]['name']; // az oszlopokat az adatbázis mezői szerint kell elnevezni (a javascript datattables columnDefs beállításában)
			
			$this->query->set_orderby(array($order), $dir); 
		}

		// lekérdezés
		$result = $this->query->select();
		// szűrés utáni visszaadott eredmények száma
		$filtered_records = $this->query->found_rows(); 
		
		// ebbe a tömbbe kerülnek az elküldendő adatok
		$data = array();
		
        $loggedin_user_role = Session::get('user_role_id');
        $loggedin_user_id = Session::get('user_id');
        
		foreach($result as $value) {

			// id attribútum hozzáadása egy sorhoz 
				//$temp['DT_RowId'] = 'ez_az_id_' . $value['job_id'];
			// class attribútum hozzáadása egy sorhoz 
				//$temp['DT_RowClass'] = 'proba_osztaly';
			// csak a datatables 1.10.5 verzió felett
				//$temp['DT_RowAttr'] = array('data-proba' => 'ertek_proba');
		
		
			$temp['checkbox'] = '<input type="checkbox" class="checkboxes" name="user_id_' . $value['user_id'] . '" value="' . $value['user_id'] . '"/>'; 
			$temp['id'] = '#' . $value['user_id'];
			$temp['name'] = $value['name'];
			$temp['mother_name'] = $value['mother_name'];
			$temp['birth_place'] = $value['birth_place'];
			$temp['student_card_number'] = $value['student_card_number'];

			$temp['menu'] = '						
			<div class="actions">
				<div class="btn-group">';
				
				$temp['menu'] .= '<a class="btn btn-sm grey-steel" title="Műveletek" href="#" data-toggle="dropdown">
						<i class="fa fa-cogs"></i>
					</a>					
					<ul class="dropdown-menu pull-right">
						<li><a data-toggle="modal" data-target="#ajax_modal" href="' . $this->registry->site_url . 'pre_register/ajax_view_prereg/' . $value['user_id'] . '"><i class="fa fa-eye"></i> Részletek</a></li>';
						
				$temp['menu'] .= '<li><a href="javascript:;" id="szerzodes_print_2" data-id="' . $value['user_id'] . '"><i class="fa fa-print"></i> Szerződés nyomtatása</a></li>'; 		
				$temp['menu'] .= '<li><a href="' . $this->registry->site_url . 'pre_register/update/' . $value['user_id'] . '"><i class="fa fa-pencil"></i> Szerkeszt</a></li>'; 		
				$temp['menu'] .= '<li><a href="javascript:;" class="delete_prereg_class" data-id="' . $value['user_id'] . '"> <i class="fa fa-trash"></i> Töröl</a></li>';		

				$temp['menu'] .= '</ul></div></div>';

			// adatok berakása a data tömbbe
			$data[] = $temp;
		} 
		
		$json_data = array(
			"draw"            => $display_draw,
			"recordsTotal"    => $total_records,
			"recordsFiltered" => $filtered_records,
			"data"            => $data,
			"customActionStatus" => 'OK',
			"customActionMessage" => $messages
		);
		
		return $json_data;
	}
	
	/**
	 *	Előregisztrációs adatok módosítása
	 *
	 *	@param	Integer	  $id
	 *	@return	boolean
	 */
	public function update_prereg($id)
	{
		$data = $_POST;
		
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
			'school_data' => 'A jelenlegi oktatási intézmény adatai'
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
			
		// adatbázis műveletek
			$this->query->reset();
			$this->query->set_table(array('pre_register_user'));
			$this->query->set_where('user_id', '=', $id);
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
?>