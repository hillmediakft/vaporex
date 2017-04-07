<?php 
class Leiratkozas_model extends Model {

	/**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
	function __construct()
	{
		parent::__construct();
	}
	
	public function leiratkozas($user_id, $unsubscribe_code)
	{
		// lekérdezzük, hogy helyes-e a user_id és a unsubscribe_code (tehát van-e ilyen aktív user)
		$this->query->set_table(array('site_users'));
		$this->query->set_columns('user_id');
		$this->query->set_where('user_id', '=', $user_id, 'and');
		$this->query->set_where('user_active', '=', 1, 'and');
		$this->query->set_where('user_unsubscribe_code', '=', $unsubscribe_code);
		$result = $this->query->select();

		//ha a találatok száma 1, akkor töröljük az adott user_id-jü rekordot
		if(count($result) == 1){
			//töröljük az adatbázisból
			$delete_user = $result[0]['user_id'];
			
			$this->query->reset();
			$this->query->set_table(array('site_users'));
			$this->query->set_where('user_id', '=', $delete_user);
			$result = $this->query->delete();
		
			if(count($result == 1)){
				//pozitív üzenet
				Message::set('success','Sikeresen leiratkozott a hírlevelünkről.');
			} else {
				//negatív üzenet
				Message::set('error','A leiratkozás nem sikerült!');
			}
		} else {
			//HIBA: 0 vagy több találat - nem torolheto az adatbazisbol;
			Message::set('error','Adatbázis hiba. A leiratkozás nem sikerült!');
		}	
	}
}
?>