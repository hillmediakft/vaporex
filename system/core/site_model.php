<?php 
class Site_model extends Model {

	function __construct()
	{
		parent::__construct();
	}

	function __destruct()
	{
		parent::__destruct();
	}

	
	/**
	 * Oldal szintű beállítások lekérdezése a settings táblából
	 *
	 * @return array a beállítások tömbje
	 */
	public function get_settings()
	{
		$this->query->reset();
		$this->query->set_table(array('settings')); 
		$this->query->set_columns('*'); 
		$result = $this->query->select(); 
		return $result[0];
	}	
	
	/**
	 *	Oldal tartalmak lekérdezése
	 *
	 *	@param	integer	$id 	(page_id az oldal id-je a pages táblában)
	 *	@return array
	 */
	public function get_page_data($page_name)
	{
		$this->query->reset();		
		$this->query->set_table(array('pages'));		
		$this->query->set_columns('*');
		$this->query->set_where('page_friendlyurl', '=', $page_name);
		$result = $this->query->select();
                return $result[0];
	}
        
	/**
	 *	Oldal tartalmak lekérdezése
	 *
	 *	@param	integer	$id 	(page_id az oldal id-je a pages táblában)
	 *	@return array
	 */
	public function get_content_data($content_name)
	{
		$this->query->reset();		
		$this->query->set_table(array('content'));		
		$this->query->set_columns('content_body');
		$this->query->set_where('content_name', '=', $content_name);
		$result = $this->query->select();
		return $result[0]['content_body'];
	}        
	
    
    /**
     * E-mail küldés
	 *
     * @param string 	$from_name 				küldő neve
     * @param string	$from_email 			küldő email cim
     * @param string 	$message 				üzenet
     * @param string 	$to_email              	címzett email
     * @param string 	$to_name              	címzett neve
     * @param string 	$subject              	levél tárgya
     *
     * @return boolean
     */
    public function send_email($from_email, $from_name, $subject, $message, $to_email, $to_name)
    {
		// Email kezelő osztály behívása
		include(LIBS . '/simple_mail_class.php');
		
        // Létrehozzuk a SimpleMail objektumot
		$mail = new SimpleMail();
		$mail->setTo($to_email, $to_name)
			 ->setSubject($subject)
			 ->setFrom($from_email, $from_name)
			 ->addMailHeader('Reply-To', $from_email, $from_name)
			 ->addGenericHeader('MIME-Version', '1.0')
			 ->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
			 ->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
			 ->setMessage($message)
			 ->setWrap(78);
  
        // final sending and check
        if($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
   
 
    /**
     * Partnerek (clients) lekérdezése a testimonials táblából
     *
     * @return array $result a vélemények adatai tömbben
     */
    public function get_clients() {

        $this->query->reset();
        $this->query->set_table(array('clients'));
        $this->query->set_columns('*');
        $this->query->set_orderby(array('client_id'), 'DESC');
        $result = $this->query->select();

        return $result;
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
    
     public function slider_query() {
        $this->query->reset();
        $this->query->set_table(array('slider'));
        $this->query->set_columns('*');
        $this->query->set_where('active', '=', 1);
        $this->query->set_orderby(array('slider_order'), 'ASC');
        return $this->query->select();
    }
    
    /**
     * A vélemények lekérdezése a testimonials táblából
     *
     * @return array $result a vélemények adatai tömbben
     */
    public function get_testimonials() {

        $this->query->reset();
        $this->query->set_table(array('testimonials'));
        $this->query->set_columns();
        $this->query->set_orderby(array('id'), 'DESC');
        $result = $this->query->select();

        return $result;
    }   
	
}
?>