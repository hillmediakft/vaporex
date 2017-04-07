<?php

class Hirlevel_model extends Site_model {

    /**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
    function __construct() {
        parent::__construct();
    }

    function __destruct() {
        parent::__destruct();
    }

    /**
     * 	Ellenőrzi a felhasználótól kapott adatokat
     * 	
     * 	@param	array	$data
     * 	@return	bool
     */
    private function verify_user_data($data) {
        $messages = array();

        // User név ellenőrzés
        if (empty($data['name'])) {
            $messages[] = Message::send('username_field_empty');
        } else {
            if (strlen($data['name']) > 64 OR strlen($data['name']) < 2) {
                $messages[] = Message::send('username_too_short_or_too_long');
            }
            if (!preg_match('/^[\_\sa-záöőüűóúéíÁÖŐÜŰÓÚÉÍ\d]{2,64}$/i', $data['name'])) {
                $messages[] = Message::send('username_does_not_fit_pattern');
            }
        }
        // E-mail ellenőrzés
        if (empty($data['email'])) {
            $messages[] = Message::send('email_field_empty');
        } else {
            if (strlen($data['email']) > 64) {
                $messages[] = Message::send('email_too_long');
            }
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $messages[] = Message::send('email_does_not_fit_pattern');
            }
        }


        if (empty($messages)) {

            // lekérdezzük, hogy létezik-e már ilyen e-mail cím
            $this->query->reset();
            $this->query->set_table(array('newsletter_subscribers'));
            $this->query->set_columns('id');
            $this->query->set_where('email', '=', $data['email']);
            $result = $this->query->select();
            if (count($result) == 1) {
                $messages[] = Message::send('user_email_already_taken');
            }

            if (empty($messages)) {
                // ha nincs semmilyen hiba
                return true;
            } else {
                //hibaüzeneteket tartalmazó tömb
                return $messages;
            }
        } else {
            //hibaüzeneteket tartalmazó tömb
            return $messages;
        }
    }

    /**
     * 	Felhasználó regisztrálása a site_users táblába
     * 	(Normál regisztráció)
     */
    public function save_subscriber() {
        // ellenőrzi a usertől kapott adatokat
        $verify_result = $this->verify_user_data($_POST);

        // ha a verify_user_data() metódus TRUE-t ad vissza	nincs hiba
        if ($verify_result === true) {

            $data = $_POST;

            $success_messages = array();
            $error_messages = array();

            // Ha egy robot töltötte ki a formot
            /*
              if($data['security_name'] != ''){
              return false;
              }
              unset($data['security_name']);
             */


            // generálunk egy kódot ami majd a hírlevélről leiratkozáshoz kell (40 char string)
            $data['unsubscribe_code'] = sha1(uniqid(mt_rand(), true));
            // generálunk egy ellenőrző kódot a regisztráció email-es ellenőrzéshez (40 char string)
            $data['activation_hash'] = sha1(uniqid(mt_rand(), true));
            $data['active'] = 0;
            // generate integer-timestamp for saving of account-creating date
            $data['creation_timestamp'] = time();



            $this->query->reset();
            $this->query->set_table(array('newsletter_subscribers'));
            $user_id = $this->query->insert($data);

            if (!$user_id) {
                $message = Message::send('account_creation_failed');
                return json_encode(array(
                  "status" => 'error',
                  "message" => $message
                ));
            }


            // ellenőrző email küldése, (ha az ellenőrző email küldése sikertelen: töröljük a user adatait az adatbázisból)
            if ($this->sendVerificationEmail($data['name'], $user_id, $data['email'], $data['activation_hash'])) {

                $messages[] = Message::send('account_successfully_created');
                $messages[] = Message::send('verification_mail_sending_successful');
                $messages[] = Message::send('click_verification_link');

                return json_encode(array(
                  "status" => 'success',
                  "message" => $messages
                ));
            } else {
                $this->query->reset();
                $this->query->set_table(array('newsletter_subscribers'));
                $this->query->delete('id', '=', $user_id);
                $message[] = Message::send('verification_mail_sending_failed');

                return json_encode(array(
                  "status" => 'error',
                  "message" => $message
                ));
            }
        } else {
            // ha valamilyen hiba volt a form adataiban
            return json_encode(array(
              "status" => 'error',
              "message" => $verify_result
            ));
        }
    }

    /**
     * sends an email to the provided email address
     *
     * @param string 	$user_name 					felhasznalo neve
     * @param int 		$user_id 					user's id
     * @param string 	$user_email 				user's email
     * @param string 	$user_activation_hash 		user's mail verification hash string

     * @return boolean
     */
    private function sendVerificationEmail($name, $user_id, $email, $activation_hash) {
        // Email kezelő osztály behívása
        include(LIBS . '/simple_mail_class.php');

        $subject = Config::get('email.verification_newsletter.subject');
        $link = Config::get('email.verification_newsletter.link');
        $html = '<html><body><h3>Kedves ' . $name . '!</h3><p>A ' . $email . ' e-mail címmel feliratkoztál a Megajátszóház hírlevelére. A feliratkozás megtörtént, de jelenleg passzív.</p><a href="' . BASE_URL . 'hirlevel/' . $user_id . '/' . $activation_hash . '">' . $link . '</a><p>Üdvözlettel:<br>A Megajátszóház csapata</p></body></html>';

        $from_email = Config::get('email.from_email');
        $from_name = Config::get('email.from_name');

        // Létrehozzuk a SimpleMail objektumot
        $mail = new SimpleMail();
        $mail->setTo($email, $name)
                ->setSubject($subject)
                ->setFrom($from_email, $from_name)
                ->addMailHeader('Reply-To', 'noreply@gmail.com', 'Mail Bot')
                ->addGenericHeader('MIME-Version', '1.0')
                ->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
                ->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
                ->setMessage($html)
                ->setWrap(78);

        // final sending and check
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * checks the email/verification code combination and set the user's activation status to true in the database
     * @param int $user_id user id
     * @param string $user_activation_verification_code verification token
     * @return bool success status
     */
    public function verifyNewUser($user_id, $user_activation_verification_code) {
        // megnézzük, hogy már sikerült-e a regisztráció (ha frissíti az oldalt)
        $this->query->reset();
        $this->query->set_table(array('newsletter_subscribers'));
        $this->query->set_columns(array('id'));
        $this->query->set_where('id', '=', $user_id);
        $this->query->set_where('active', '=', 1, 'and');
        $this->query->set_where('activation_hash', '=', null, 'and');

        $result = $this->query->select();
        if ($result) {
            return true;
        }


        $data['active'] = 1;
        $data['activation_hash'] = null;

        $this->query->reset();
        $this->query->set_table(array('newsletter_subscribers'));
        $this->query->set_where('id', '=', $user_id);
        $this->query->set_where('activation_hash', '=', $user_activation_verification_code, 'and');
        $result = $this->query->update($data);

        if ($result == 1) {
            return true;
        } else {
            return false;
        }
    }

}

?>