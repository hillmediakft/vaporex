<?php 
class Offices_model extends Model {

	/**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
	function __construct()
	{
		parent::__construct();
	}


    /*
     * Irodák (vagy 1 iroda) adatainak lekérdezése
     *
     *  @param  $Integer    $id     opcionális paraméter (ha csak egy iroda adatait akarjuk lekérdezni, akkor meg kell adni az id-t)
     */
    public function offices_data_query($id = NULL)
    {
        $this->query->reset();
        $this->query->set_table(array('offices'));
        $this->query->set_columns('*');
        
        if(!is_null($id)){
            $this->query->set_where('office_id', '=', $id);
            $result = $this->query->select();
            return $result[0];
        } 

        return $this->query->select();
    }
    
	/**
	 *	Iroda törlése
	 *
	 *	@param	array	$id_arr		a törlendő rekordok id-it tartalmazó tömb
	 *	@return	array
	 */
	public function delete_office($id)
	{
        $success_counter = 0;
        $error_counter = 0;

        //iroda törlése	
        $this->query->reset();
        $this->query->set_table(array('offices'));
        //a delete() metódus integert (lehet 0 is) vagy false-ot ad vissza
        $result = $this->query->delete('office_id', '=', $id);

        if($result !== false) {
            // ha a törlési sql parancsban nincs hiba
            if($result > 0){
                //sikeres törlés
                $success_counter += $result;
            }
            else {
                //sikertelen törlés
                $error_counter += 1;
            }
        }
        else {
            // ha a törlési sql parancsban hiba van
            throw new Exception('Hibas sql parancs: nem sikerult a DELETE lekerdezes az adatbazisbol!');
            return false;
        }

		return array("success" => $success_counter, "error" => $error_counter);	
	}
    
    /**
     * Új iroda hozzáadása 
     */
    public function insert_office()
    {
        //var_dump($_POST); die();
        
        $data = array();
        
        foreach($_POST as $key => $value){
            if($value == ''){
                $data[$key] = NULL;
            } else {
                $data[$key] = $value;
            }
        }
                
        $this->query->reset();
        $this->query->set_table(array('offices'));
        $result = $this->query->insert($data);
    
        if($result){
            Message::set('success', 'Új iroda hozzáadva.');
            return true;
        } else {
            Message::set('error', 'Az iroda hozzáadása nem sikerült!');
            return false;
        }
        
    }
    
    /**
     * Iroda adatok módosítása
     *  
     *  @param  Integer $id
     *  @return bool
     */
    public function update_office($id)
    {
        //var_dump($_POST); die();
        
        $data = array();
        
        foreach($_POST as $key => $value){
            if($value == ''){
                $data[$key] = NULL;
            } else {
                $data[$key] = $value;
            }
        }
                
        $this->query->reset();
        $this->query->set_table(array('offices'));
        $this->query->set_where('office_id', '=', $id);
        $result = $this->query->update($data);
    
        if($result){
            Message::set('success', 'Iroda adatok módosítva.');
            return true;
        } else {
            Message::set('error', 'Az iroda adatok módosítása nem sikerült!');
            return false;
        }
        
    }
    
}
?>