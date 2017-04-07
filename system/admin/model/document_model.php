<?php

class Document_model extends Admin_model {

    protected $table = 'documents';

    function __construct() {
        parent::__construct();
    }

    /**
     * 	Visszaadja a document tábla tartalmát
     * 	Ha kap egy id paramétert (integer), akkor csak egy sort ad vissza a táblából
     *
     * 	@param $id Integer 
     */
    public function getDocument($id = null) {
        if (!is_null($id)) {
            $id = (int) $id;
            $this->query->debug(false);
            $this->query->set_table(array('documents'));
            $this->query->set_columns(array('*'));
            $this->query->set_where('id', '=', $id);
        }
        return $this->query->select();
    }

    /**
     * 	Visszaadja a document tábla egy kategóriájának elemeit
     * 	Ha kap egy id paramétert (integer), akkor csak egy sort ad vissza a táblából
     *
     * 	@param $id Integer 
     */
    public function find($id = null) {
        $this->query->debug(false);
        $this->query->set_table(array('documents'));
        $this->query->set_columns(array('documents.id', 'documents.title', 'documents.description', 'documents.file', 'documents.created', 'document_category.name'));
        $this->query->set_join('left', 'document_category', 'documents.category_id', '=', 'document_category.id');
        if (!is_null($id)) {
            $id = (int) $id;
            $this->query->set_where('documents.id', '=', $id);
        }
        $this->query->set_orderby('documents.created', 'DESC');
        return $this->query->select();
    }

    /**
     * 	Visszaadja a document_category tábla tartalmát
     * 	Ha kap egy id paramétert (integer), akkor csak egy sort ad vissza a táblából
     *
     * 	@param $id Integer 
     */
    public function findCategories($id = null) {
        $this->query->set_table(array('document_category'));
        $this->query->set_columns('*');
        if (!is_null($id)) {
            $id = (int) $id;
            $this->query->set_where('id', '=', $id);
        }
        return $this->query->select();
    }

    /**
     * 	Visszaadja a document táblából a document_category oszlopot
     */
    public function category_counter_query() {
        $this->query->set_columns('document_category');
        return $this->query->select();
    }

    /**
     * Document törlése AJAX-al
     *
     * @param string $id     ez lehet egy szám, vagy felsorolás pl: 23 vagy 12,14,36
     */
    public function delete_document($id) {


        //átalakítjuk a integer-ré a kapott adatot
        $id = (int) $id;

        //lekérdezzük a törlendő document képének a nevét, hogy törölhessük a szerverről
        $this->query->reset();
        $this->query->debug(false);
        $this->query->set_table(array('documents'));
        $this->query->set_columns(array('file'));
        $this->query->set_where('id', '=', $id);
        $file = $this->query->select();
        $document_to_delete = $file[0]['file'];
        //document törlése	
        //a delete() metódus integert (lehet 0 is) vagy false-ot ad vissza
        $this->query->reset();
        $this->query->set_table(array('documents'));
        //a delete() metódus integert (lehet 0 is) vagy false-ot ad vissza
        $result = $this->query->delete('id', '=', $id);

        if ($result !== false) {
            // ha a törlési sql parancsban nincs hiba
            if ($result > 0) {

                if ($document_to_delete) {

                    $file_path = Config::get('documents.upload_path') . $document_to_delete;
                    //fájl file törlése a szerverről (ha az Util::del_file() falsot ad vissza nem tudtuk törölni a képet... hibaüzenet)
                    if (!Util::del_file($file_path)) {
                        Message::set('error', 'A dokumentum nem létezik, vagy nem törölhető! - ' . $document_to_delete);
                        return false;
                    } else {
                        Message::set('success', 'A dokumentum törölve!');
                        return true;
                    }
                }
            } else {
                Message::set('error', 'Sql lekérdezési hiba!');
                return false;
            }
        }
    }

    /**
     * Document törlése AJAX-al
     *
     * @param string $id     ez lehet egy szám, vagy felsorolás pl: 23 vagy 12,14,36
     */
    public function delete_document_AJAX($id) {
        // a sikeres törlések számát tárolja
        $success_counter = 0;
        // a sikeresen törölt id-ket tartalmazó tömb
        $success_id = array();
        // a sikertelen törlések számát tárolja
        $fail_counter = 0;

        // a paraméterként kapott stringből tömböt csinálunk a , karakter mentén
        $data_arr = explode(',', $id);

        // bejárjuk a $data_arr tömböt és minden elemen végrehajtjuk a törlést
        foreach ($data_arr as $value) {
            //átalakítjuk a integer-ré a kapott adatot
            $value = (int) $value;

            //lekérdezzük a törlendő document képének a nevét, hogy törölhessük a szerverről
            $this->query->set_columns(array('file'));
            $this->query->set_where('id', '=', $value);
            $files = $this->query->select();
            $files_json = $files[0]['file'];
            $documents_to_delete = json_decode($files_json);
            //document törlése	
            //a delete() metódus integert (lehet 0 is) vagy false-ot ad vissza
            $result = $this->query->delete('id', '=', $value);

            if ($result !== false) {
                // ha a törlési sql parancsban nincs hiba
                if ($result > 0) {

                    if ($documents_to_delete) {
                        foreach ($documents_to_delete as $file_name) {
                            $file_path = Config::get('documents.upload_path') . $file_name;
                            //fájl file törlése a szerverről (ha az Util::del_file() falsot ad vissza nem tudtuk törölni a képet... hibaüzenet)
                            if (!Util::del_file($file_path)) {
                                Message::log('A dokumentum nem létezik, vagy nem törölhető! - ' . $file_path);
                            }
                        }
                    }
                    //sikeres törlés
                    $success_counter += $result;
                    $success_id[] = $value;
                } else {
                    //sikertelen törlés
                    $fail_counter += 1;
                }
            } else {
                // ha a törlési sql parancsban hiba van
                return array(
                    'status' => 'error',
                    'message_error' => 'Hibas sql parancs: nem sikerult a DELETE lekerdezes az adatbazisbol!',
                );
            }
        }

        // üzenetek visszaadása
        $respond = array();
        $respond['status'] = 'success';

        if ($success_counter > 0) {
            $respond['message_success'] = $success_counter . ' dokumentum törölve.';
        }
        if ($fail_counter > 0) {
            $respond['message_error'] = $fail_counter . ' dokumentot már töröltek!';
        }

        // respond tömb visszaadása
        return $respond;
    }

    /* ------------ KATEGÓRIÁK --------------- */

    /**
     * Kategória hozzáadása és módosítása
     *
     * @param integer||null $id
     * @param string $new_name
     * @return array
     */
    public function category_insert_update($id, $new_name) {
        $new_name = trim($new_name);

        if ($new_name == '') {
            return array(
                'status' => 'error',
                'message' => 'Nem lehet üres a kategória név mező!'
            );
        }

        // kategóriák lekérdezése (annak ellenőrzéséhez, hogy már létezik-e ilyen kategória)
        $existing_categorys = $this->category_query();
        // bejárjuk a kategória neveket és összehasonlítjuk az új névvel (kisbetűssé alakítjuk, hogy ne számítson a nagybetű-kisbetű eltérés)
        foreach ($existing_categorys as $value) {
            if (strtolower($new_name) == strtolower($value['category_name'])) {
                return array(
                    'status' => 'error',
                    'message' => 'Már létezik ' . $value['category_name'] . ' kategória!'
                );
            }
        }

        //insert (ha az $id értéke null)
        if ($id == null) {

            $this->query->set_table(array('document_category'));
            $result = $this->query->insert(array('category_name' => $new_name));

            if ($result) {
                return array(
                    'status' => 'success',
                    'message' => 'Kategória hozzáadva.',
                    'inserted_id' => $result
                );
            }
            if ($result === false) {
                return array(
                    'status' => 'error',
                    'message' => 'Adatbázis lekérdezési hiba!'
                );
            }
        }
        // update
        else {
            $id = (int) $id;
            $this->query->set_table(array('document_category'));
            $this->query->set_where('category_id', '=', $id);
            $result = $this->query->update(array('category_name' => $new_name));

            if ($result >= 0) {
                return array(
                    'status' => 'success',
                    'message' => 'Kategória módosítva.'
                );
            }
            if ($result === false) {
                return array(
                    'status' => 'error',
                    'message' => 'Adatbázis lekérdezési hiba!'
                );
            }
        }
    }

    /**
     * Document kategória törlése
     *
     * @param string $id     ez egy szám
     */
    public function category_delete($id) {
        // a sikeres törlések számát tárolja
        $success_counter = 0;
        // a sikertelen törlések számát tárolja
        $fail_counter = 0;

        // lekérdezzük a törlendő képek nevét
        $this->query->set_columns(array('document_picture'));
        $this->query->set_where('document_category', '=', $id);
        $photo_names_temp = $this->query->select();

        $photo_names = array();
        foreach ($photo_names_temp as $key => $value) {
            $photo_names[] = $value['document_picture'];
        }
        unset($photo_names_temp);

        // képekhez tartozó rekordok törlése
        $result = $this->query->delete('document_category', '=', $id);

        // képek törlése
        if ($result !== false) {
            if ($result > 0) {

                foreach ($photo_names as $value) {

                    $picture_path = Config::get('documentphoto.upload_path') . $value;
                    $thumb_picture_path = Util::thumb_path($picture_path);

                    $del_result = Util::del_file($picture_path);
                    $del_thumb_result = Util::del_file($thumb_picture_path);

                    //kép file törlése a szerverről (ha az Util::del_file() falsot ad vissza nem tudtuk törölni a képet... hibaüzenet)
                    if (!$del_result) {
                        Message::log('A kép nem létezik, vagy nem törölhető! - ' . $picture_path);
                    }
                    //kép file törlése a szerverről (ha az Util::del_file() falsot ad vissza nem tudtuk törölni a képet... hibaüzenet)
                    if (!$del_thumb_result) {
                        Message::log('A nézőkép nem létezik, vagy nem törölhető! - ' . $thumb_picture_path);
                    }
                }
            }
        }

        // kategória törlése
        $this->query->set_table(array('document_category'));
        //a delete() metódus integert (lehet 0 is) vagy false-ot ad vissza
        $result = $this->query->delete('category_id', '=', $id);

        if ($result !== false) {
            // ha a törlési sql parancsban nincs hiba
            if ($result > 0) {
                $success_counter += $result;
            } else {
                //sikertelen törlés
                $fail_counter++;
            }
        } else {
            // ha a törlési sql parancsban hiba van
            return array(
                'status' => 'error',
                'message_error' => 'Hibas sql parancs: nem sikerult a DELETE lekerdezes az adatbazisbol!',
            );
        }

        // üzenetek visszaadása
        $respond = array();
        $respond['status'] = 'success';

        if ($success_counter > 0) {
            $respond['message_success'] = 'Kategória törölve.';
        }
        if ($fail_counter > 0) {
            $respond['message_error'] = 'A kategóriát már törölték!';
        }

        // respond tömb visszaadása
        return $respond;
    }

// delete END

    /**
     * 	Dokumentumokat tölti fel a szerverre
     *
     * 	@param	$files_array	Array ($_FILES['valami'])
     * 	@return	String (kép elérési útja) or echo errors (json)
     */
    public function upload_doc($file, $id = '') {
//hibaüzenetek tömbje
        $errors = array();

        include(LIBS . "/upload_class.php");
// feltöltés helye
        $filePath = Config::get('documents.upload_path');

// több file feltöltése
//képkezelő objektum létrehozása (a kép a szerveren a tmp könyvtárba kerül)	
        $handle = new Upload($file);
// fájlneve utáni random karakterlánc
//$suffix = md5(uniqid());
//documentum végleges helyre mozgatása
        if ($handle->uploaded) {
// file paramétereinek módosítása
            $handle->file_name_body_pre = ($id != '') ? $id . '_' : '';
//$handle->file_auto_rename 	 = true;
            $handle->file_safe_name = true;

            $handle->allowed = array('application/*', 'text/*', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            /*
              $handle->allowed = array(
              'image/jpeg', 'image/pjpeg',
              'image/png',  'image/x-png',
              'image/bmp', 'image/x-bmp', 'image/x-bitmap', 'image/x-xbitmap', 'image/x-win-bitmap', 'image/x-windows-bmp', 'image/ms-bmp', 'image/x-ms-bmp', 'application/bmp', 'application/x-bmp', 'application/x-win-bitmap',
              'text/plain', 'text/richtext', 'text/rtf', 'text/xml',
              'application/xml',
              'application/pdf',
              'application/json',
              'application/excel',
              'application/msexcel',
              'application/vnd.ms-excel',
              'application/x-msexcel',
              'application/x-ms-excel',
              'application/x-excel',
              'application/x-dos_ms_excel',
              'application/xls',
              'application/x-xls',
              'application/msword',
              'application/vnd.ms-office',
              'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
              'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
              'application/powerpoint', 'application/vnd.ms-powerpoint',
              'application/vnd.openxmlformats-officedocument.presentationml.presentation'
              );
             */

//$handle->file_new_name_body   	 = "doc_" . $suffix;
// File véglegesítése
            $handle->Process($filePath);
            if ($handle->processed) {
                $doc_name = $handle->file_dst_name;
            } else {
                $errors = Message::set('error', $handle->error);

//return false;
            }
        } else {
            $errors = Message::set('error', $handle->error);

//return false;	
        }


        unset($handle);


        if (!empty($errors)) {
//visszaküldi a hibákat a javascriptnek és megállítja a php script futását
            echo json_encode($errors);
            exit();
        } else {
//ha nincs hiba visszaadja a fájlok neveit tartalmazó tömböt
            return $doc_name;
        }
    }

    /**
     * 	A képek és dokumentumok neveit teszi be az ingatlanok táblába
     *
     * 	@param	array	$new_file_names		fájlok nevei tömbben	
     * 	@param	string	$column				db oszlop neve
     * 	@param	integer	$id					rekord id-je
     * 	@return	bool	true || false	
     */
    public function file_query($new_file_names, $column, $id) {
// lekérdezzük a képek vagy docs mező értékét
        $result = $this->getDocuments($id);

        $temp_arr = array();

// ha már tartalmaz adatot a mező
        if (!empty($result)) {
// átalakítjuk tömbbé a json-t
            $temp_arr = json_decode($result);

            $temp_arr = array_merge($temp_arr, $new_file_names);
        } else {
//ha először kerül a mezőbe adat
            $temp_arr = $new_file_names;
        }
        if ($column == 'kepek') {
            $data['kepek_szama'] = count($temp_arr);
        }

// visszaalakítjuk json-ra
        $data[$column] = json_encode($temp_arr);

// beírjuk az adatbázisba
        $this->query->reset();
        $this->query->set_table(array('documents'));
        $this->query->set_where('id', '=', $id);
        return $this->query->update($data);
    }

    /* ------------------------------------ */

    /**
     * 	Kép vagy dokumentum fájlok json adatainak lekérdezése
     *
     * 	@param	integer $id  		rekord id-je
     * 	@param	string  $column  	oszlop neve (kepek, docs)
     * 	@return	string				json string (kép vagy dokumentum fájlok neveit tartalmazó json)
     */
    public function getDocuments($id) {
        $this->query->set_table(array('documents'));
        $this->query->set_columns(array('file'));
        $this->query->set_where('id', '=', $id);
        $result = $this->query->select();
        return $result[0]['file'];
    }

    /**
     * 	ingatlan adatok adatbázisba (INSERT is, és UPDATE is)
     * 	
     * 	@return	array   üzenetek a javascriptnek
     */
    public function insert_update_document_data() {
        //megadja, hogy update, vagy insert lesz
        $update_marker = false;
        //megadja, hogy insert utáni update, normál update lesz (modositas_datum megadása miatt)
        $update_real = false;

        $data = $this->request->get_post(null, 'strip_danger_tags');


//echo json_encode($data);
        // megvizsgáljuk, hogy a post adatok között van-e update_id
        // update-nél a javasriptel hozzáadunk a post adatokhoz egy update_id elemet
        if (isset($data['update_id'])) {
            //beállítjuk, hogy update-elni kell az adatbázist
            $update_marker = true;
            $id = (int) $data['update_id'];
            unset($data['update_id']);

            //megvizsgáljuk, hogy adatbevitelkori update, vagy "rendes" update
            // "rendes" update-nél a javasriptel hozzáadunk a post adatokhoz egy update_status elemet is
            if (isset($data['update_status'])) {
                $update_real = true;
                unset($data['update_status']);
            }
        }

        $error_messages = array();
        $error_counter = 0;



        if (empty($data['title'])) {
            $error_messages[] = Message::show('Nem adta meg az elnevezést!');
            $error_counter += 1;
        }

        if ($error_counter == 0) {

            // üres stringet tartalmazó elemek esetén az adatbázisba null érték kerül
            foreach ($data as $key => $value) {
                if (isset($value) && $value == '') {
//unset($data[$key]);
                    $data[$key] = null;
                }
            }

            if ($update_marker) {
// UPDATE
                // az update-nél már nem kell a referens id-jét módosítani
                unset($data['ref_id']);

                $this->query->set_table(array('documents'));
                $this->query->set_where('id', '=', $id);
                $result = $this->query->update($data);

                if ($result === 0 || $result === 1) {

                    if ($update_real) {
                        Message::set('success', 'A módosítások sikeresen elmentve!');
                    } else {
                        Message::set('success', 'Sikeres mentés!');
                    }

                    return array(
                        "status" => 'success',
                        "message" => ''
                    );
                } else {
                    Message::set('error', 'A módosítások mentése nem sikerült, próbálja újra!');

                    return array(
                        "status" => 'error',
                        "message" => ''
                    );
                }
            } else {
// INSERT
                $data['created'] = time();

// $this->query->debug(true);
                $this->query->set_table(array('documents'));
                // a last insert id-t adja vissza
                $last_id = $this->query->insert($data);

                return array(
                    "status" => 'success',
                    "last_insert_id" => $last_id,
                    "message" => 'Az adatok bekerültek az adatbázisba.'
                );
            }
        } else {
            // visszaadja a hibaüzeneteket tartalmazó tömböt
            return array(
                "status" => 'error',
                "error_messages" => $error_messages
            );
        }
    }

    public function insert() {
        $error = false;

        $data = $_POST;

        unset($data['upload_data']);
        if (empty($data['title'])) {
            $error_messages[] = Message::set('error', 'Nem adta meg az elnevezést!');
            $error = true;
        }

        if (!$error) {
            $data['created'] = time();
            $data['file'] = $this->upload_doc($_FILES['new_doc']);
// $this->query->debug(true);
            $this->query->set_table(array('documents'));
            // a last insert id-t adja vissza
            $last_id = $this->query->insert($data);

            return true;
        } else {
            // visszaadja a hibaüzeneteket tartalmazó tömböt
            return false;
        }
    }

    public function update($id) {
        $error = false;
        
        $data = $_POST;
        $file_path = Config::get('documents.upload_path') . $data['old_document'];
        if (empty($data['title'])) {
            $error_messages[] = Message::set('error', 'Nem adta meg az elnevezést!');
            $error = true;
        }

        if (!$error) {
            if (isset($_FILES['new_doc']) && $_FILES['new_doc']['error'] == 0) {
                $data['file'] = $this->upload_doc($_FILES['new_doc']);
                
// $this->query->debug(true);
            }
            unset($data['old_document']);
            $this->query->reset();
            $this->query->set_table(array('documents'));
            $this->query->set_where('id', '=', $id);
            $last_id = $this->query->update($data);

           
            //fájl file törlése a szerverről (ha az Util::del_file() falsot ad vissza nem tudtuk törölni a képet... hibaüzenet)
            Util::del_file($file_path);
            Message::set('success', 'A módosítás megtörtént');
            return true;
        } else {
            return false;
        }
    }

}

?>