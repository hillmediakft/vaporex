<?php

class Jobs_model extends Model {

    /**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Userek lekérdezése
     */
    public function user_list_query() {
        $this->query->reset();
        $this->query->set_table(array('users'));
        $this->query->set_columns(array('user_id', 'user_name', 'user_first_name', 'user_last_name'));
        return $this->query->select();
    }

    /**
     * 	Egy munka minden adatát lekérdezi a részletek megjelenítéséhez
     */
    public function one_job_alldata_query($id = null) {
        $id = (int) $id;

        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('jobs'));
        $this->query->set_columns(array(
          'jobs.job_id',
          'jobs.job_title',
          'jobs.job_description',
          'jobs.job_pay',
          'jobs.job_working_hours',
          'jobs.job_conditions',
          'jobs.job_status',
          'jobs.job_create_timestamp',
          'jobs.job_update_timestamp',
          'jobs.job_expiry_timestamp',
          'employer.employer_name',
          'jobs_list.job_list_name',
          'county_list.county_name',
          'district_list.district_name',
          'city_list.city_name'
        ));
        $this->query->set_join('left', 'employer', 'jobs.job_employer_id', '=', 'employer.employer_id');
        $this->query->set_join('left', 'jobs_list', 'jobs.job_category_id', '=', 'jobs_list.job_list_id');
        $this->query->set_join('left', 'county_list', 'jobs.job_county_id', '=', 'county_list.county_id');
        $this->query->set_join('left', 'city_list', 'jobs.job_city_id', '=', 'city_list.city_id');
        $this->query->set_join('left', 'district_list', 'jobs.job_district_id', '=', 'district_list.district_id');
        $this->query->set_where('job_id', '=', $id);
        return $this->query->select();
    }

    /**
     * 	Egy munka minden adatát lekérdezi a részletek megjelenítéséhez
     */
    public function one_job_alldata_query_ajax() {
        //$id = (int)$_POST['id'];
        $id = (int) $this->registry->params['id'];

        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('jobs'));
        $this->query->set_columns(array(
          'jobs.job_id',
          'jobs.job_title',
          'jobs.job_description',
          'jobs.job_pay',
          'jobs.job_working_hours',
          'jobs.job_conditions',
          'jobs.job_status',
          'jobs.job_create_timestamp',
          'jobs.job_update_timestamp',
          'jobs.job_expiry_timestamp',
          'employer.employer_name',
          'jobs_list.job_list_name',
          'county_list.county_name',
          'district_list.district_name',
          'city_list.city_name',
          //'users.user_name',
          'users.user_first_name',
          'users.user_last_name'
        ));
        $this->query->set_join('left', 'employer', 'jobs.job_employer_id', '=', 'employer.employer_id');
        $this->query->set_join('left', 'jobs_list', 'jobs.job_category_id', '=', 'jobs_list.job_list_id');
        $this->query->set_join('left', 'county_list', 'jobs.job_county_id', '=', 'county_list.county_id');
        $this->query->set_join('left', 'city_list', 'jobs.job_city_id', '=', 'city_list.city_id');
        $this->query->set_join('left', 'district_list', 'jobs.job_district_id', '=', 'district_list.district_id');
        $this->query->set_join('left', 'users', 'jobs.job_ref_id', '=', 'users.user_id');
        $this->query->set_where('job_id', '=', $id);
        $result = $this->query->select();

        $result[0]['job_create_timestamp'] = date('Y-m-d H:i', $result[0]['job_create_timestamp']);
        $result[0]['job_update_timestamp'] = (!empty($result[0]['job_update_timestamp'])) ? date('Y-m-d H:i', $result[0]['job_update_timestamp']) : $result[0]['job_update_timestamp'];
        $result[0]['job_expiry_timestamp'] = (!empty($result[0]['job_expiry_timestamp'])) ? date('Y-m-d H:i', $result[0]['job_expiry_timestamp']) : $result[0]['job_expiry_timestamp'];

        $result[0]['county_name'] = ($result[0]['county_name'] == 'Budapest') ? 'Budapest, ' : '';
        $result[0]['city_name'] = (!empty($result[0]['city_name'])) ? $result[0]['city_name'] : '';
        $result[0]['district_name'] = (!empty($result[0]['district_name'])) ? $result[0]['district_name'] . ' kerület' : '';

        //return json_encode($result);
        return $result[0];
    }

    /**
     * 	Egy munka minden "nyers" adatát lekérdezi
     * 	A munka módosításához kell (itt az id-kre van szükség, és nem a hozzájuk tartozó névre)	
     */
    public function one_job_query($id) {
        $id = (int) $id;
        $this->query->reset();
        $this->query->set_table(array('jobs'));
        $this->query->set_columns('*');
        $this->query->set_where('job_id', '=', $id);
        return $this->query->select();
    }

    /**
     * 	A munkák táblázathoz kérdezi le az adatokat
     * 	Itt nem kell minden adat egy munkáról
     */
    public function all_jobs_query() {
        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('jobs'));
        $this->query->set_columns(array(
          'jobs.job_id',
          'jobs.job_title',
          'jobs.job_status',
          'jobs.job_create_timestamp',
          'jobs.job_update_timestamp',
          'employer.employer_name',
          'jobs_list.job_list_name'
        ));
        $this->query->set_join('left', 'employer', 'jobs.job_employer_id', '=', 'employer.employer_id');
        $this->query->set_join('left', 'jobs_list', 'jobs.job_category_id', '=', 'jobs_list.job_list_id');
        return $this->query->select();
    }

    /**
     * 	Lekérdezi a munka típusokat a jobs_list táblából (és az id-ket)
     * 	@param	integer	$id  (ha csak egy elemet akarunk lekérdezni, pl.: munka kategória módosításhoz)
     * 	@return	array	
     */
    public function job_list_query($id = null) {
        $this->query->reset();
        $this->query->set_table(array('jobs_list'));
        $this->query->set_columns('*');
        if (!is_null($id)) {
            $id = (int) $id;
            $this->query->set_where('job_list_id', '=', $id);
        }
        return $this->query->select();
    }

    /**
     * 	Lekérdezi a munkadók nevét és id-jét employer táblából (az option listához)
     */
    public function employer_list_query() {
        $this->query->reset();
        $this->query->set_table(array('employer'));
        $this->query->set_columns(array('employer_id', 'employer_name'));
        $this->query->set_orderby('employer_name', 'ASC');
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

    /**
     * 	Lekérdezi a városok nevét és id-jét a city_list táblából (az option listához)
     * 	A paraméter megadja, hogy melyik megyében lévő városokat adja vissza 		
     * 	@param integer	$id 	egy megye id-je (county_id)
     */
    public function city_list_query($id = null) {
        $this->query->reset();
        $this->query->set_table(array('city_list'));
        $this->query->set_columns(array('city_id', 'city_name'));
        if (!is_null($id)) {
            $this->query->set_where('county_id', '=', $id);
        }
        $this->query->set_orderby('city_name', 'ASC');
        $result = $this->query->select();
        return $result;
    }

    /**
     * 	Lekérdezi a kerületek nevét és id-jét a district_list táblából (az option listához)
     */
    public function district_list_query() {
        $this->query->reset();
        $this->query->set_table(array('district_list'));
        $this->query->set_columns(array('district_id', 'district_name'));
        $result = $this->query->select();
        return $result;
    }

    /**
     * 	Munka hozzáadása
     */
    public function insert_job() {
        $data = $_POST;
        $error_counter = 0;
        //megnevezés ellenőrzése	
        if (empty($data['job_title'])) {
            $error_counter++;
            Message::set('error', 'A munka megnevezése nem lehet üres!');
        }
        if (empty($data['job_description'])) {
            $error_counter++;
            Message::set('error', 'A munka leírása nem lehet üres!');
        }
        if (empty($data['job_county_id'])) {
            $error_counter++;
            Message::set('error', 'Választani kell egy megyét!');
        } else {
            if ($data['job_county_id'] == '5') {
                $data['job_city_id'] = 88;
            } else {
                $data['job_district_id'] = NULL;
            }
        }

        if ($error_counter == 0) {

            // ha nincs lejárat NULL, ha van átalakítja timestamp-re
            $data['job_expiry_timestamp'] = (empty($data['job_expiry_timestamp'])) ? time() + (14 * 24 * 60 * 60) : strtotime($data['job_expiry_timestamp']);
            // munkaadó azonosító megadása
            $data['job_employer_id'] = ($data['job_employer_id'] == '') ? NULL : (int) $data['job_employer_id'];
            // referens id megadása
            $data['job_ref_id'] = (!isset($data['job_ref_id'])) ? (int) Session::get('user_id') : (int) $data['job_ref_id'];

            //létrehozás dátuma timestamp
            $data['job_create_timestamp'] = time();

            // új adatok az adatbázisba
            $this->query->reset();
            $this->query->set_table(array('jobs'));
            $this->query->insert($data);

            Message::set('success', 'Munka sikeresen hozzáadva.');
            return true;
        } else {
            // ha valamilyen hiba volt a form adataiban
            return false;
        }
    }

    /**
     * 	Munka módosítása
     *
     * 	@param integer	$id
     */
    public function update_job($id) {
        $data = $_POST;
        $id = (int) $id;

        $error_counter = 0;
        //megnevezés ellenőrzése	
        if (empty($data['job_title'])) {
            $error_counter++;
            Message::set('error', 'A munka megnevezése nem lehet üres!');
        }
        if (empty($data['job_description'])) {
            $error_counter++;
            Message::set('error', 'A munka leírása nem lehet üres!');
        }
        if (empty($data['job_county_id'])) {
            $error_counter++;
            Message::set('error', 'Választani kell egy megyét!');
        } else {
            // ha Budapest van kiválasztva
            if ($data['job_county_id'] == '5') {
                $data['job_city_id'] = 88;
            } else {
                $data['job_district_id'] = NULL;
            }
        }

        if ($error_counter == 0) {

            // lejárat átalakítása timestamp-re
            $data['job_expiry_timestamp'] = strtotime($data['job_expiry_timestamp']);
            // munkaadó azonosító megadása
            $data['job_employer_id'] = ($data['job_employer_id'] == '') ? NULL : (int) $data['job_employer_id'];
            // referens id megadása
            $data['job_ref_id'] = (!isset($data['job_ref_id'])) ? (int) Session::get('user_id') : (int) $data['job_ref_id'];

            // módosítás dátuma timestamp formátumban
            $data['job_update_timestamp'] = time();

            // új adatok az adatbázisba
            $this->query->reset();
            $this->query->set_table(array('jobs'));
            $this->query->set_where('job_id', '=', $id);
            $this->query->update($data);

            Message::set('success', 'Munka adatai sikeresen módosítva.');
            return true;
        } else {
            // ha valamilyen hiba volt a form adataiban
            return false;
        }
    }

    /**
     * 	Munka (illetve munkák) törlése
     *
     * 	@param	array	$id_arr		a törlendő rekordok id-it tartalmazó tömb
     * 	@return	array
     */
    public function delete_job($id_arr) {
        // a sikeres törlések számát tárolja
        $success_counter = 0;
        // a sikertelen törlések számát tárolja
        $error_counter = 0;

        // bejárjuk a $id_arr tömböt és minden elemen végrehajtjuk a törlést
        foreach ($id_arr as $id) {
            //átalakítjuk a integer-ré a kapott adatot
            $id = (int) $id;

            //felhasználó törlése	
            $this->query->reset();
            $this->query->set_table(array('jobs'));
            //a delete() metódus integert (lehet 0 is) vagy false-ot ad vissza
            $result = $this->query->delete('job_id', '=', $id);

            if ($result !== false) {
                // ha a törlési sql parancsban nincs hiba
                if ($result > 0) {
                    //sikeres törlés
                    $success_counter += $result;
                } else {
                    //sikertelen törlés
                    $error_counter += 1;
                }
            } else {
                // ha a törlési sql parancsban hiba van
                throw new Exception('Hibas sql parancs: nem sikerult a DELETE lekerdezes az adatbazisbol!');
                return false;
            }
        }

        return array("success" => $success_counter, "error" => $error_counter);
    }
    
    
    /**
     * 	Munka klónozása
     *
     * 	@param	array	$id_arr		a törlendő rekordok id-it tartalmazó tömb
     * 	@return	array
     */
    public function clone_job($id) {

        $success_counter = 0;
        $error_counter = 0;
       
            //átalakítjuk a integer-ré az id-t
            $id = (int) $id;

            $data = $this->one_job_query($id);
            $data = $data[0];
 
            //létrehozás dátuma timestamp
            $data['job_create_timestamp'] = time();
            $data['job_status'] = 0;
            
            unset($data['job_id']);
            $this->query->reset();
            $this->query->set_table(array('jobs'));
            $result = $this->query->insert($data);
            
            
            if ($result !== false) {
                // ha az insert sql parancsban nincs hiba
                if ($result > 0) {
                    //sikeres klónozás
                    $success_counter = 1;
                } else {
                    //sikertelen klónozás
                    $error_counter = 1;
                }
            } else {
                // ha a törlési sql parancsban hiba van
                throw new Exception('Hibas sql parancs: nem sikerult a klónozás!');
                return false;
            }
      

        return array("success" => $success_counter, "error" => $error_counter);
    }    
    
    

    /**
     * 	Munka kategória hozzáadása
     */
    public function category_insert() {
        //ha üresen küldték el a formot
        if (empty($_POST['job_list_name'])) {
            Message::set('error', 'Meg kell adni a kategória nevét!');
            return false;
        }

        $data['job_list_name'] = trim($_POST['job_list_name']);

        // kategóriák lekérdezése (annak ellenőrzéséhez, hogy már létezik-e ilyen kategória)
        $existing_categorys = $this->job_list_query();
        // bejárjuk a kategória neveket és összehasonlítjuk az új névvel (kisbetűssé alakítjuk, hogy ne számítson a nagybetű-kisbetű eltérés)
        foreach ($existing_categorys as $value) {
            $data['job_list_name'] = trim($data['job_list_name']);
            if (strtolower($data['job_list_name']) == strtolower($value['job_list_name'])) {
                Message::set('error', 'category_already_exists');
                return false;
            }
        }

        if (isset($_FILES['upload_job_category_photo']) && $_FILES['upload_job_category_photo']['error'] != 4) {
            // kép feltöltése, upload_job_category_picture() metódussal (visszatér a feltöltött kép elérési útjával, vagy false-al)
            $image_name = $this->upload_job_category_photo($_FILES['upload_job_category_photo']);

            if ($image_name === false) {
                return false;
            }
        }

        //kép elérési útja	
        $data['job_list_photo'] = (isset($image_name)) ? $image_name : Config::get('jobphoto.default_photo');

        // adatbázis lekérdezés	
        $this->query->reset();
        $this->query->set_table(array('jobs_list'));
        $result = $this->query->insert($data);

        // ha sikeres az insert visszatérési érték egy id
        if ($result) {
            Message::set('success', 'category_created');
            return true;
        } else {
            Message::set('error', 'unknown_error');
            return false;
        }
    }

    public function category_update($id) {
        $data['job_list_name'] = trim($_POST['job_list_name']);
        // régi képek elérési útjának változókhoz rendelése (ezt használjuk a régi kép törléséhez, ha új kép lett feltöltve)
        $old_img_name = $_POST['old_img'];
        $old_category = $_POST['old_category'];
        $id = (int) $id;

        //ha módosított a kategória nevén
        if ($old_category != $data['job_list_name']) {
            // kategóriák lekérdezése (annak ellenőrzéséhez, hogy már létezik-e ilyen kategória)
            $existing_categorys = $this->job_list_query();
            // bejárjuk a kategória neveket és összehasonlítjuk az új névvel (kisbetűssé alakítjuk, hogy ne számítson a nagybetű-kisbetű eltérés)
            foreach ($existing_categorys as $value) {
                if ((strtolower($data['job_list_name']) == strtolower($value['job_list_name'])) && $id != $value['job_list_id']) {
                    Message::set('error', 'category_already_exists');
                    return false;
                }
            }
        }

        if (isset($_FILES['upload_job_category_photo']) && $_FILES['upload_job_category_photo']['error'] != 4) {
            // kép feltöltése, upload_job_category_picture() metódussal (visszatér a feltöltött kép elérési útjával, vagy false-al)
            $image_name = $this->upload_job_category_photo($_FILES['upload_job_category_photo']);

            if ($image_name === false) {
                return false;
            }
        }

        if (isset($image_name)) {
            $data['job_list_photo'] = $image_name;

            //megnézzük, hogy a régi kép a default-e, mert azt majd nem akarjuk törölni
            if ($old_img_name == Config::get('jobphoto.default_photo')) {
                $default_photo = true;
            } else {
                $default_photo = false;
                $old_thumb_name = Util::thumb_path($old_img_name);
            }
        }

        // módosítjuk az adatbázisban a kategória nevét	és kép elérési utat ha kell
        $this->query->reset();
        $this->query->set_table(array('jobs_list'));
        $this->query->set_where('job_list_id', '=', $id);
        $result = $this->query->update($data);

        // ha sikeres az insert visszatérési érték true
        if ($result) {
            // megvizsgáljuk, hogy létezik-e új feltöltött kép és a régi kép, nem a default
            if (isset($image_name) && $default_photo === false) {
                //régi képek törlése
                if (!Util::del_file(Config::get('jobphoto.upload_path') . $old_img_name)) {
                    Message::set('error', 'unknown_error');
                };
                if (!Util::del_file(Config::get('jobphoto.upload_path') . $old_thumb_name)) {
                    Message::set('error', 'unknown_error');
                };
            }
            Message::set('success', 'category_updated');
            return true;
        } else {
            Message::set('error', 'unknown_error');
            return false;
        }
    }

    /**
     * 	Visszaadja a jobs tábla job_category_id oszlop tartalmát
     * 	Egy kategóriához tertozó munkák számának meghatározásához kell
     */
    public function job_category_counter_query() {
        $this->query->reset();
        $this->query->set_table(array('jobs'));
        $this->query->set_columns('job_category_id');
        return $this->query->select();
    }

    /**
     * 	(AJAX) A jobs tábla job_status mezőjének ad értéket
     * 	siker vagy hiba esetén megy vissza az üzenet a javascriptnek 	
     *
     * 	@param	array	$id_arr		id-ket tartalmazó tömb	
     * 	@param	integer	$data (0 vagy 1)	
     * 	@return 
     */
    public function change_status_query($id_arr, $data) {
        $success_counter = 0;
        $error_counter = 0;

        foreach ($id_arr as $id) {
            $this->query->reset();
            $this->query->set_table(array('jobs'));
            $this->query->set_where('job_id', '=', $id);
            $result = $this->query->update(array('job_status' => $data));

            if ($result !== false) {
                // ha az update sql parancsban nincs hiba
                if ($result > 0) {
                    //sikeres update
                    $success_counter += $result;
                } else {
                    //sikertelen update
                    $error_counter++;
                }
            } else {
                // ha az update sql parancsban hiba van
                throw new Exception('Hibas sql parancs: nem sikerult az UPDATE lekerdezes az adatbazisbol!');
                exit();
            }
        }
        // visszatér a sikeres és sikertelen update-ek számával
        return array("success" => $success_counter, "error" => $error_counter);
    }

    /**
     * 	Munka kategória képet méretezi és tölti fel a szerverre (thumb képet is)
     * 	(ez a metódus a category_insert() metódusban hívódik meg!)
     *
     * 	@param	$files_array	Array ($_FILES['valami'])
     * 	@return	String (kép elérési útja) or false
     */
    private function upload_job_category_photo($files_array) {
        include(LIBS . "/upload_class.php");
        // feltöltés helye
        $imagePath = Config::get('jobphoto.upload_path');
        //képkezelő objektum létrehozása (a kép a szerveren a tmp könyvtárba kerül)	
        $handle = new Upload($files_array);
        // fájlneve utáni random karakterlánc
        $suffix = md5(uniqid());

        //file átméretezése, vágása, végleges helyre mozgatása
        if ($handle->uploaded) {
            // kép paramétereinek módosítása
            $handle->file_auto_rename = true;
            $handle->file_safe_name = true;
            $handle->allowed = array('image/*');
            $handle->file_new_name_body = "jobcategory_" . $suffix;
            $handle->image_resize = true;
            $handle->image_x = Config::get('jobphoto.width', 300); //jobphoto kép szélessége
            $handle->image_y = Config::get('jobphoto.height', 200); //jobphoto kép magassága
            //$handle->image_ratio_y           = true;
            //képarány meghatározása a nézőképhez
            $ratio = ($handle->image_x / $handle->image_y);

            // Slide kép készítése
            $handle->Process($imagePath);
            if ($handle->processed) {
                //kép elérési útja és új neve (ezzel tér vissza a metódus, ha nincs hiba!)
                //$dest_imagePath = $imagePath . $handle->file_dst_name;
                //a kép neve (ezzel tér vissza a metódus, ha nincs hiba!)
                $image_name = $handle->file_dst_name;
            } else {
                Message::set('error', $handle->error);
                return false;
            }

            // Nézőkép készítése
            //nézőkép nevének megadása (kép új neve utána _thumb)	
            $handle->file_new_name_body = $handle->file_dst_name_body;
            $handle->file_name_body_add = '_thumb';

            $handle->image_resize = true;
            $handle->image_x = Config::get('jobphoto.thumb_width', 80); //jobphoto nézőkép szélessége
            $handle->image_y = round($handle->image_x / $ratio);
            //$handle->image_ratio_y           = true;

            $handle->Process($imagePath);
            if ($handle->processed) {
                //temp file törlése a szerverről
                $handle->clean();
            } else {
                Message::set('error', $handle->error);
                return false;
            }
        } else {
            // Message::set('error', $handle->error);
            return false;
        }
        // ha nincs hiba visszadja a feltöltött kép elérési útját
        return $image_name;
    }

    public function ajax_get_jobs($request_data) {
        // ebbe a tömbbe kerülnek a csoportos műveletek üzenetei
        $messages = array();

        $user_role = Session::get('user_role_id');

        if (isset($request_data['customActionType']) && isset($request_data['customActionName'])) {

            switch ($request_data['customActionName']) {

                case 'group_delete':
                    // az id-ket tartalmazó tömböt kapja paraméterként
                    $result = $this->delete_job($request_data['id']);

                    if ($result['success'] > 0) {
                        $messages['success'] = $result['success'] . ' ' . Message::send('munka sikeresen törölve.');
                    }
                    if ($result['error'] > 0) {
                        $messages['error'] = $result['error'] . ' ' . Message::send('munka törlése nem sikerült!');
                    }
                    break;

                case 'group_make_active':
                    $result = $this->change_status_query($request_data['id'], 1);

                    if ($result['success'] > 0) {
                        $messages['success'] = $result['success'] . Message::send(' munka státusza aktívra változott.');
                    }
                    if ($result['error'] > 0) {
                        $messages['error'] = $result['error'] . Message::send(' munka státusza nem változott meg!');
                    }
                    break;

                case 'group_make_inactive':
                    $result = $this->change_status_query($request_data['id'], 0);

                    if ($result['success'] > 0) {
                        $messages['success'] = $result['success'] . Message::send(' munka státusza inaktívra változott.');
                    }
                    if ($result['error'] > 0) {
                        $messages['error'] = $result['error'] . Message::send(' munka státusza nem változott meg!');
                    }
                    break;
            }
        }


        //összes sor számának lekérdezése
        $total_records = $this->query->count('jobs');

        $display_length = intval($request_data['length']);
        $display_length = ($display_length < 0) ? $total_records : $display_length;
        $display_start = intval($request_data['start']);
        $display_draw = intval($request_data['draw']);

        $this->query->reset();
        $this->query->set_table(array('jobs'));
        $this->query->set_columns('SQL_CALC_FOUND_ROWS 
			`jobs`.`job_id`,
                        `jobs`.`job_city_id`,
			`jobs`.`job_title`,
			`jobs`.`job_status`,
			`jobs`.`job_create_timestamp`,
			`jobs`.`job_update_timestamp`,
                        `jobs`.`job_expiry_timestamp`,
			`employer`.`employer_name`,
			`jobs_list`.`job_list_name`,
            `users`.`user_id`,
            `users`.`user_first_name`,
            `users`.`user_last_name`,
            `city_list`.`city_name`'    
        );

        $this->query->set_join('left', 'employer', 'jobs.job_employer_id', '=', 'employer.employer_id');
        $this->query->set_join('left', 'jobs_list', 'jobs.job_category_id', '=', 'jobs_list.job_list_id');
        $this->query->set_join('left', 'users', 'jobs.job_ref_id', '=', 'users.user_id');
        $this->query->set_join('left', 'city_list', 'jobs.job_city_id', '=', 'city_list.city_id');

        $this->query->set_offset($display_start);
        $this->query->set_limit($display_length);
        
        // Ha a felhasználó user jogosultsággal rendelkezik (user_role_id = 3), akkor
        // csak a hozzá tartozó munkákat listázhatja
        if (Session::get('user_role_id') == 3) {
                $this->query->set_where('job_ref_id', '=', Session::get('user_id'));
            }

        //szűrés beállítások
        if (isset($request_data['action']) && $request_data['action'] == 'filter') {
            if (!empty($request_data['search_employer'])) {
                $this->query->set_where('job_employer_id', 'LIKE', '%' . $request_data['search_employer'] . '%');
            }
            if (!empty($request_data['search_job_category'])) {
                $this->query->set_where('job_category_id', 'LIKE', '%' . $request_data['search_job_category'] . '%');
            }
            if (!empty($request_data['search_job_id'])) {
                $this->query->set_where('job_id', '=', (int) $request_data['search_job_id']);
            }
            if (!empty($request_data['search_city_id'])) {
                $this->query->set_where('job_city_id', '=', (int) $request_data['search_city_id']);
            }
            if (!empty($request_data['search_referens'])) {
                $this->query->set_where('job_ref_id', '=', (int) $request_data['search_referens']);
            }
            if (!empty($request_data['search_job_title'])) {
                $this->query->set_where('job_title', 'LIKE', '%' . $request_data['search_job_title'] . '%');
            }
            if ($request_data['search_status'] !== '') {
                $this->query->set_where('job_status', '=', (int) $request_data['search_status']);
            }
        }

        //rendezés
        if (isset($request_data['order'][0]['column']) && isset($request_data['order'][0]['dir'])) {
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

        foreach ($result as $value) {

            // id attribútum hozzáadása egy sorhoz 
            //$temp['DT_RowId'] = 'ez_az_id_' . $value['job_id'];
            // class attribútum hozzáadása egy sorhoz 
            //$temp['DT_RowClass'] = 'proba_osztaly';
            // csak a datatables 1.10.5 verzió felett
            //$temp['DT_RowAttr'] = array('data-proba' => 'ertek_proba');


            $temp['checkbox'] = ($user_role < 3) ? '<input type="checkbox" class="checkboxes" name="job_id_' . $value['job_id'] . '" value="' . $value['job_id'] . '"/>' : '';
            $temp['id'] = '#' . $value['job_id'];
            $temp['varos'] = $value['city_name'];
            $temp['megnevezes'] = $value['job_title'];
            $temp['kategoria'] = $value['job_list_name'];
            $temp['ceg_neve'] = $value['employer_name'];
            $temp['letrehozva'] = date('Y-m-d', $value['job_create_timestamp']) . ' / ' . date('Y-m-d', $value['job_expiry_timestamp']);

            $temp['modositva'] = (empty($value['job_update_timestamp'])) ? '' : date('Y-m-d H:i', $value['job_update_timestamp']);
            $temp['referens'] = $value['user_first_name'] . ' ' . $value['user_last_name'];

            $temp['status'] = ($value['job_status'] == 1) ? '<span class="label label-sm label-success">Aktív</span>' : '<span class="label label-sm label-danger">Inaktív</span>';
            if ($value['job_expiry_timestamp'] < time()) {
                $temp['status'] .= '<span class="label label-sm label-warning">Lejárt</span>';
            }
            $temp['menu'] = '						
			<div class="actions">
				<div class="btn-group">';

            $temp['menu'] .= '<a class="btn btn-sm grey-steel" title="Műveletek" href="#" data-toggle="dropdown">
						<i class="fa fa-cogs"></i>
					</a>					
					<ul class="dropdown-menu pull-right">
						<li><a data-toggle="modal" data-target="#ajax_modal" href="' . $this->registry->site_url . 'jobs/view_job_ajax/' . $value['job_id'] . '"><i class="fa fa-eye"></i> Részletek</a></li>';

            // update
            $temp['menu'] .= ($user_role < 3) ? '<li><a href="' . $this->registry->site_url . 'jobs/update_job/' . $value['job_id'] . '"><i class="fa fa-pencil"></i> Szerkeszt</a></li>' : '';

            // törlés
            if ($user_role == 1) {
                $temp['menu'] .= '<li><a href="javascript:;" class="delete_job_class" data-id="' . $value['job_id'] . '"> <i class="fa fa-trash"></i> Töröl</a></li>';
            } else {
                $temp['menu'] .= '<li class="disabled-link"><a href="javascript:;" title="Nincs jogosultsága törölni" class="disable-target"><i class="fa fa-trash"></i> Töröl</a></li>';
            }
            
            $temp['menu'] .= '<li><a href="javascript:;" class="clone_job" data-id="' . $value['job_id'] . '"> <i class="fa fa-copy"></i> Klónozás</a></li>';

            // status
            if ($value['job_status'] == 0) {
                $temp['menu'] .= '<li><a data-id="' . $value['job_id'] . '" href="javascript:;" class="change_status" data-action="make_active"><i class="fa fa-check"></i> Aktivál</a></li>';
            } else {
                $temp['menu'] .= '<li><a data-id="' . $value['job_id'] . '" href="javascript:;" class="change_status" data-action="make_inactive"><i class="fa fa-ban"></i> Blokkol</a></li>';
            }

            $temp['menu'] .= '</ul></div></div>';

            // adatok berakása a data tömbbe
            $data[] = $temp;
        }

        $json_data = array(
          "draw" => $display_draw,
          "recordsTotal" => $total_records,
          "recordsFiltered" => $filtered_records,
          "data" => $data,
          "customActionStatus" => 'OK',
          "customActionMessage" => $messages
        );

        return $json_data;
    }

}

?>