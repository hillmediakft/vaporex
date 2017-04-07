<?php

class Szolgaltatasok_model extends Model {

    /**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * 	Egy szolgáltatás minden adatát lekérdezi a részletek megjelenítéséhez
     */
    public function one_szolgaltatas_alldata_query($id = null) {
        $id = (int) $id;

        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('szolgaltatasok'));
        $this->query->set_columns(array(
          'szolgaltatasok.szolgaltatas_id',
          'szolgaltatasok.szolgaltatas_title',
          'szolgaltatasok.szolgaltatas_description',
          'szolgaltatasok.szolgaltatas_info',
          'szolgaltatasok.szolgaltatas_photo',
          'szolgaltatasok.szolgaltatas_status',
          'szolgaltatasok.szolgaltatas_category_id',
          'szolgaltatasok_list.szolgaltatas_list_name'
        ));

        $this->query->set_join('left', 'szolgaltatasok_list', 'szolgaltatasok.szolgaltatas_category_id', '=', 'szolgaltatasok_list.szolgaltatas_list_id');
        $this->query->set_where('szolgaltatas_id', '=', $id);
        return $this->query->select();
    }

    /**
     * 	Egy szolgáltatás minden adatát lekérdezi a részletek megjelenítéséhez
     */
    public function one_szolgaltatas_alldata_query_ajax() {
        //$id = (int)$_POST['id'];
        $id = (int) $this->registry->params['id'];

        $this->query->reset();
        //   $this->query->debug(true);
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('szolgaltatasok'));
        $this->query->set_columns(array(
          'szolgaltatasok.szolgaltatas_id',
          'szolgaltatasok.szolgaltatas_title',
          'szolgaltatasok.szolgaltatas_description',
          'szolgaltatasok.szolgaltatas_info',
          'szolgaltatasok.szolgaltatas_photo',
          'szolgaltatasok.szolgaltatas_status'
        ));
        $this->query->set_where('szolgaltatas_id', '=', $id);
        $result = $this->query->select();

        return $result[0];
    }

    /**
     * 	Egy szolgáltatás minden "nyers" adatát lekérdezi
     * 	A szolgáltatás módosításához kell (itt az id-kre van szükség, és nem a hozzájuk tartozó névre)	
     */
    public function one_szolgaltatas_query($id) {
        $id = (int) $id;
        $this->query->reset();
        $this->query->set_table(array('szolgaltatasok'));
        $this->query->set_columns('*');
        $this->query->set_where('szolgaltatas_id', '=', $id);
        return $this->query->select();
    }

    /**
     * 	A munkák táblázathoz kérdezi le az adatokat
     * 	Itt nem kell minden adat egy munkáról
     */
    public function all_szolgaltatasok_query() {
        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('szolgaltatasok'));
        $this->query->set_columns(array(
          'szolgaltatasok.szolgaltatas_id',
          'szolgaltatasok.szolgaltatas_title',
          'szolgaltatasok.szolgaltatas_description',
          'szolgaltatasok.szolgaltatas_photo',
          'szolgaltatasok.szolgaltatas_status'
        ));

        return $this->query->select();
    }

    /**
     * 	Lekérdezi a szolgaltatasok típusokat a szolgaltatasok_list táblából (és az id-ket)
     * 	@param	integer	$id  (ha csak egy elemet akarunk lekérdezni, pl.: munka kategória módosításhoz)
     * 	@return	array	
     */
    public function szolgaltatas_list_query($id = null) {
        $this->query->reset();
        $this->query->set_table(array('szolgaltatasok_list'));
        $this->query->set_columns('*');
        if (!is_null($id)) {
            $id = (int) $id;
            $this->query->set_where('szolgaltatas_list_id', '=', $id);
        }
        
        return $this->query->select();
    }

    /**
     * 	Visszaadja a szolgaltatasok tábla szolgaltatas_category_id oszlop tartalmát
     * 	Egy kategóriához tertozó munkák számának meghatározásához kell
     */
    public function szolgaltatasok_category_counter_query() {
        $this->query->reset();
        $this->query->set_table(array('szolgaltatasok'));
        $this->query->set_columns('szolgaltatas_category_id');
        return $this->query->select();
    }

    /**
     * 	Szolgáltatás hozzáadása
     */
    public function insert_szolgaltatas() {
        $data = $_POST;

        $error_counter = 0;
        //megnevezés ellenőrzése	
        if (empty($data['szolgaltatas_title'])) {
            $error_counter++;
            Message::set('error', 'A szolgáltatás megnevezése nem lehet üres!');
        }
        if (empty($data['szolgaltatas_description'])) {
            $error_counter++;
            Message::set('error', 'A szolgáltatás leírása nem lehet üres!');
        }
        if (empty($data['szolgaltatas_category_id'])) {
            $error_counter++;
            Message::set('error', 'A szolgáltatás kategória nem lehet üres!');
        }

        if ($error_counter == 0) {

            if (isset($_FILES['upload_szolgaltatas_photo']) && $_FILES['upload_szolgaltatas_photo']['error'] != 4) {
                // kép feltöltése, upload_szolgaltatas_photo() metódussal (visszatér a feltöltött kép elérési útjával, vagy false-al)
                $image_name = $this->upload_szolgaltatas_photo($_FILES['upload_szolgaltatas_photo']);

                if ($image_name === false) {
                    return false;
                }
            }

            //kép elérési útja	
            $data['szolgaltatas_photo'] = (isset($image_name)) ? $image_name : Config::get('szolgaltatasphoto.default_photo');

            // új adatok az adatbázisba
            $this->query->reset();
            $this->query->set_table(array('szolgaltatasok'));
            $this->query->insert($data);

            Message::set('success', 'Szolgáltatás sikeresen hozzáadva.');
            return true;
        } else {
            // ha valamilyen hiba volt a form adataiban
            Message::set('error', 'Hiba történt');
            return false;
        }
    }

    /**
     * 	Munka módosítása
     *
     * 	@param integer	$id
     */
    public function update_szolgaltatas($id) {
        $old_img_name = $_POST['old_img'];
        $data = $_POST;
        unset($data['old_img']);
        $id = (int) $id;

        $error_counter = 0;
        //megnevezés ellenőrzése	
        if (empty($data['szolgaltatas_title'])) {
            $error_counter++;
            Message::set('error', 'A szolgáltatás megnevezése nem lehet üres!');
        }
        if (empty($data['szolgaltatas_description'])) {
            $error_counter++;
            Message::set('error', 'A szolgáltatás leírása nem lehet üres!');
        }


        if ($error_counter == 0) {

            if (isset($_FILES['upload_szolgaltatas_photo']) && $_FILES['upload_szolgaltatas_photo']['error'] != 4) {
                // kép feltöltése, upload_szolgaltatas_photo() metódussal (visszatér a feltöltött kép elérési útjával, vagy false-al)
                $image_name = $this->upload_szolgaltatas_photo($_FILES['upload_szolgaltatas_photo']);

                if ($image_name === false) {
                    return false;
                }
            }

            if (isset($image_name)) {
                $data['szolgaltatas_photo'] = $image_name;

                //megnézzük, hogy a régi kép a default-e, mert azt majd nem akarjuk törölni
                if ($old_img_name == Config::get('szolgaltatasphoto.default_photo')) {
                    $default_photo = true;
                } else {
                    $default_photo = false;
                    $old_thumb_name = Util::thumb_path($old_img_name);
                }
            }

            // új adatok az adatbázisba
            $this->query->reset();
            //       $this->query->debug(true);
            $this->query->set_table(array('szolgaltatasok'));
            $this->query->set_where('szolgaltatas_id', '=', $id);
            $this->query->update($data);

            if (isset($image_name) && $default_photo === false) {
                //régi képek törlése
                if (!Util::del_file(Config::get('szolgaltatasphoto.upload_path') . $old_img_name)) {
                    Message::set('error', 'unknown_error');
                };
                if (!Util::del_file(Config::get('szolgaltatasphoto.upload_path') . $old_thumb_name)) {
                    Message::set('error', 'unknown_error');
                };
            }
            Message::set('success', 'Szolgáltatás adatai sikeresen módosítva.');
            return true;
        } else {
            Message::set('error', 'unknown_error');
            return false;
        }
    }

    /**
     * 	Szolgáltatás (illetve szolgáltatásek) törlése
     *
     * 	@param	array	$id_arr a törlendő rekordok id-it tartalmazó tömb
     * 	@return	array
     */
    public function delete_szolgaltatas($id_arr) {
        // a sikeres törlések számát tárolja
        $success_counter = 0;
        // a sikertelen törlések számát tárolja
        $error_counter = 0;

        // bejárjuk a $id_arr tömböt és minden elemen végrehajtjuk a törlést
        foreach ($id_arr as $id) {
            //átalakítjuk a integer-ré a kapott adatot
            $id = (int) $id;

            $is_deletable = $this->is_szolgaltatas_deletable($id);

            //ha nem false a visszadott érték, akkor nem törölhető
            if (!$is_deletable) {
                $error_counter += 1;
				continue;
            }



            $this->query->reset();
            $this->query->set_table(array('szolgaltatasok'));
            $this->query->set_columns(array('szolgaltatas_photo'));
            $this->query->set_where('szolgaltatas_id', '=', $id);
            $result = $this->query->select();

            $image_to_delete = Config::get('szolgaltatasphoto.upload_path') . $result[0]['szolgaltatas_photo'];



            //szolgáltatás törlése	
            $this->query->reset();
            $this->query->set_table(array('szolgaltatasok'));
            //a delete() metódus integert (lehet 0 is) vagy false-ot ad vissza
            $result = $this->query->delete('szolgaltatas_id', '=', $id);

            if ($result !== false) {
                // ha a törlési sql parancsban nincs hiba
                if ($result > 0) {
                    //sikeres törlés
                    Util::del_file($image_to_delete);
                    Util::del_file(Util::thumb_path($image_to_delete));
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
     * 	(AJAX) A szolgaltatasok tábla szolgaltatas_status mezőjének ad értéket
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
            $this->query->set_table(array('szolgaltatasok'));
            $this->query->set_where('szolgaltatas_id', '=', $id);
            $result = $this->query->update(array('szolgaltatas_status' => $data));

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
    private function upload_szolgaltatas_photo($files_array) {
        include(LIBS . "/upload_class.php");
        // feltöltés helye
        $imagePath = Config::get('szolgaltatasphoto.upload_path');
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
            $handle->file_new_name_body = "szolgaltatas_" . $suffix;
            $handle->image_resize = true;
            $handle->image_x = Config::get('szolgaltatasphoto.width', 400); //szolgaltatasphoto kép szélessége
            $handle->image_y = Config::get('szolgaltatasphoto.height', 300); //szolgaltatasphoto kép magassága
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
            $handle->image_x = Config::get('szolgaltatasphoto.thumb_width', 80); //szolgaltatasphoto nézőkép szélessége
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
            Message::set('error', $handle->error);
            return false;
        }
        // ha nincs hiba visszadja a feltöltött kép elérési útját
        return $image_name;
    }

    /**
     * 	Munka kategória képet méretezi és tölti fel a szerverre (thumb képet is)
     * 	(ez a metódus a category_insert() metódusban hívódik meg!)
     *
     * 	@param	$files_array	Array ($_FILES['valami'])
     * 	@return	String (kép elérési útja) or false
     */
    private function upload_szolgaltatas_category_photo($files_array) {
        include(LIBS . "/upload_class.php");
        // feltöltés helye
        $imagePath = Config::get('szolgaltatascategoryphoto.upload_path');
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
            $handle->file_new_name_body = "szolgaltatascategory_" . $suffix;
            $handle->image_resize = true;
            $handle->image_x = Config::get('szolgaltatascategoryphoto.width', 400); //szolgaltatasphoto kép szélessége
            $handle->image_y = Config::get('szolgaltatascategoryphoto.height', 300); //szolgaltatasphoto kép magassága
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
            $handle->image_x = Config::get('szolgaltatascategoryphoto.thumb_width', 80); //szolgaltatasphoto nézőkép szélessége
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

    public function ajax_get_szolgaltatasok($request_data) {
        // ebbe a tömbbe kerülnek a csoportos műveletek üzenetei
        $messages = array();

        $user_role = Session::get('user_role_id');

        if (isset($request_data['customActionType']) && isset($request_data['customActionName'])) {

            switch ($request_data['customActionName']) {

                case 'group_delete':
                    // az id-ket tartalmazó tömböt kapja paraméterként
                    $result = $this->delete_szolgaltatas($request_data['id']);

                    if ($result['success'] > 0) {
                        $messages['success'] = $result['success'] . ' ' . Message::send('szolgáltatás sikeresen törölve.');
                    }
                    if ($result['error'] > 0) {
                        $messages['error'] = $result['error'] . ' ' . Message::send('szolgáltatás törlése nem sikerült, vagy nem törölhetők!');
                    }
                                        if ($result['success'] > 0) {
                        $messages['success'] = $result['success'] . ' ' . Message::send('szolgáltatás sikeresen törölve.');
                    }
                    break;

                case 'group_make_active':
                    $result = $this->change_status_query($request_data['id'], 1);

                    if ($result['success'] > 0) {
                        $messages['success'] = $result['success'] . Message::send(' szolgáltatás státusza aktívra változott.');
                    }
                    if ($result['error'] > 0) {
                        $messages['error'] = $result['error'] . Message::send(' szolgáltatás státusza nem változott meg!');
                    }
                    break;

                case 'group_make_inactive':
                    $result = $this->change_status_query($request_data['id'], 0);

                    if ($result['success'] > 0) {
                        $messages['success'] = $result['success'] . Message::send(' szolgáltatás státusza inaktívra változott.');
                    }
                    if ($result['error'] > 0) {
                        $messages['error'] = $result['error'] . Message::send(' szolgáltatás státusza nem változott meg!');
                    }
                    break;
            }
        }


        //összes sor számának lekérdezése
        $total_records = $this->query->count('szolgaltatasok');

        $display_length = intval($request_data['length']);
        $display_length = ($display_length < 0) ? $total_records : $display_length;
        $display_start = intval($request_data['start']);
        $display_draw = intval($request_data['draw']);

        $this->query->reset();
        $this->query->debug(false);
        $this->query->set_table(array('szolgaltatasok'));
        $this->query->set_columns('SQL_CALC_FOUND_ROWS 
			`szolgaltatasok`.`szolgaltatas_id`,
			`szolgaltatasok`.`szolgaltatas_title`,
                        `szolgaltatasok`.`szolgaltatas_description`,
			`szolgaltatasok`.`szolgaltatas_status`,
                        `szolgaltatasok`.`szolgaltatas_photo`,
                        `szolgaltatasok`.`szolgaltatas_category_id`,
                        `szolgaltatasok_list`.`szolgaltatas_list_name`'
        );

        $this->query->set_join('left', 'szolgaltatasok_list', 'szolgaltatasok.szolgaltatas_category_id', '=', 'szolgaltatasok_list.szolgaltatas_list_id');
        $this->query->set_offset($display_start);
        $this->query->set_limit($display_length);

        //szűrés beállítások
        if (isset($request_data['action']) && $request_data['action'] == 'filter') {

            if (!empty($request_data['search_szolgaltatas_id'])) {
                $this->query->set_where('szolgaltatas_id', '=', (int) $request_data['search_szolgaltatas_id']);
            }
            if ($request_data['search_status'] !== '') {
                $this->query->set_where('szolgaltatas_status', '=', (int) $request_data['search_status']);
            }
            if ($request_data['search_category'] !== '') {
                $this->query->set_where('szolgaltatas_category_id', '=', (int) $request_data['search_category']);
            }
            if ($request_data['search_title'] !== '') {
                $like_string = '%' . $request_data['search_title'] . '%';
                $this->query->set_where('szolgaltatas_title', 'LIKE', $like_string);
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
            //$temp['DT_RowId'] = 'ez_az_id_' . $value['szolgaltatas_id'];
            // class attribútum hozzáadása egy sorhoz 
            //$temp['DT_RowClass'] = 'proba_osztaly';
            // csak a datatables 1.10.5 verzió felett
            //$temp['DT_RowAttr'] = array('data-proba' => 'ertek_proba');


            $temp['checkbox'] = ($user_role < 3) ? '<input type="checkbox" class="checkboxes" name="szolgaltatas_id_' . $value['szolgaltatas_id'] . '" value="' . $value['szolgaltatas_id'] . '"/>' : '';
            $temp['id'] = '#' . $value['szolgaltatas_id'];
            $temp['foto'] = '<img class="img-responsive" src="' . Config::get('szolgaltatasphoto.upload_path') . Util::thumb_path($value['szolgaltatas_photo']) . '">';
            $temp['nev'] = $value['szolgaltatas_title'];
            $temp['kategoria'] = $value['szolgaltatas_list_name'];
            $temp['leiras'] = substr($value['szolgaltatas_description'], 0, 100) . '...';
            $temp['status'] = ($value['szolgaltatas_status'] == 1) ? '<span class="label label-sm label-success">Aktív</span>' : '<span class="label label-sm label-danger">Inaktív</span>';
            $temp['menu'] = '						
			<div class="actions">
				<div class="btn-group">';

            $temp['menu'] .= '<a class="btn btn-sm grey-steel" title="Műveletek" href="#" data-toggle="dropdown">
						<i class="fa fa-cogs"></i>
					</a>					
					<ul class="dropdown-menu pull-right">
						<li><a href="' . $this->registry->site_url . 'szolgaltatasok/view_szolgaltatas/' . $value['szolgaltatas_id'] . '"><i class="fa fa-eye"></i> Részletek</a></li>';

            // update
            $temp['menu'] .= ($user_role < 3) ? '<li><a href="' . $this->registry->site_url . 'szolgaltatasok/update_szolgaltatas/' . $value['szolgaltatas_id'] . '"><i class="fa fa-pencil"></i> Szerkeszt</a></li>' : '';

            // törlés
            if ($user_role == 1) {
                $temp['menu'] .= '<li><a href="javascript:;" class="delete_szolgaltatas_class" data-id="' . $value['szolgaltatas_id'] . '"> <i class="fa fa-trash"></i> Töröl</a></li>';
            } else {
                $temp['menu'] .= '<li class="disabled-link"><a href="javascript:;" title="Nincs jogosultsága törölni" class="disable-target"><i class="fa fa-trash"></i> Töröl</a></li>';
            }

            // status
            if ($value['szolgaltatas_status'] == 0) {
                $temp['menu'] .= '<li><a data-id="' . $value['szolgaltatas_id'] . '" href="javascript:;" class="change_status" data-action="make_active"><i class="fa fa-check"></i> Aktivál</a></li>';
            } else {
                $temp['menu'] .= '<li><a data-id="' . $value['szolgaltatas_id'] . '" href="javascript:;" class="change_status" data-action="make_inactive"><i class="fa fa-ban"></i> Blokkol</a></li>';
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

    /**
     * Ellenőrizzük, hogy a szolgáltatás törölhető-e: volt-e rendezvényhez rendelve 	
     *
     * @param   integer $id
     * @return  boolean 
     */
    public function is_szolgaltatas_deletable($id) {
        $id = (string) $id;
        $this->query->reset();
        //   $this->query->debug(true);
        $this->query->set_table('rendezvenyek');
        $this->query->set_columns('rendezveny_id');
        $this->query->set_where('rendezveny_szolgaltatasok', 'LIKE', '%' . $id . '%');
        $result = $this->query->select();

        if (!empty($result)) {
            return false;
        }
        return true;
    }

    /**
     * 	Munka kategória hozzáadása
     */
    public function category_insert() {
        //ha üresen küldték el a formot
        if (empty($_POST['szolgaltatas_list_name'])) {
            Message::set('error', 'Meg kell adni a kategória nevét!');
            return false;
        }

        $data['szolgaltatas_list_name'] = trim($_POST['szolgaltatas_list_name']);

        // kategóriák lekérdezése (annak ellenőrzéséhez, hogy már létezik-e ilyen kategória)
        $existing_categorys = $this->szolgaltatas_list_query();
        // bejárjuk a kategória neveket és összehasonlítjuk az új névvel (kisbetűssé alakítjuk, hogy ne számítson a nagybetű-kisbetű eltérés)
        foreach ($existing_categorys as $value) {
            $data['szolgaltatas_list_name'] = trim($data['szolgaltatas_list_name']);
            if (strtolower($data['szolgaltatas_list_name']) == strtolower($value['szolgaltatas_list_name'])) {
                Message::set('error', 'category_already_exists');
                return false;
            }
        }

        if (isset($_FILES['upload_szolgaltatas_category_photo']) && $_FILES['upload_szolgaltatas_category_photo']['error'] != 4) {
            // kép feltöltése, upload_szolgaltatas_category_picture() metódussal (visszatér a feltöltött kép elérési útjával, vagy false-al)
            $image_name = $this->upload_szolgaltatas_category_photo($_FILES['upload_szolgaltatas_category_photo']);

            if ($image_name === false) {
                return false;
            }
        }

        //kép elérési útja	
        $data['szolgaltatas_list_photo'] = (isset($image_name)) ? $image_name : Config::get('szolgaltatascategoryphoto.default_photo');

        // adatbázis lekérdezés	
        $this->query->reset();
        $this->query->set_table(array('szolgaltatasok_list'));
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

    /**
     * 	Szolgáltatás kategória törlése
     */
    public function delete_category() {

        if (!isset($this->registry->params['id'])) {
            throw new Exception('Nincs id-t tartalmazo parameter az url-ben (ezert nem tudunk torolni id alapjan)!');
            return false;
        }
        //berakjuk a $data_arr tömbbe a törlendő felhasználó id-jét
        $id = (int) $this->registry->params['id'];

        $is_deletable = $this->is_category_deletable($id);

        if (!$is_deletable) {
            Message::set('error', 'A kategória nem törölhető! A kategória szolgáltatást tartalmaz!');
            return;
        }

        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('szolgaltatasok_list'));
        $this->query->set_columns('szolgaltatas_list_photo');
        $this->query->set_where('szolgaltatas_list_id', '=', $id);
        $result = $this->query->select();
        $category_photo = $result[0]['szolgaltatas_list_photo'];
        $category_photo_thumb = Util::thumb_path($category_photo);

        $this->query->reset();
        $this->query->set_table(array('szolgaltatasok_list'));
        //a delete() metódus integert (lehet 0 is) vagy false-ot ad vissza
        $result = $this->query->delete('szolgaltatas_list_id', '=', $id);

        if ($result !== false) {
            // ha a törlési sql parancsban nincs hiba
            if ($result > 0) {
                //sikeres törlés
                if (isset($category_photo)) {
                    //régi képek törlése
                    if (!Util::del_file(Config::get('szolgaltatascategoryphoto.upload_path') . $category_photo)) {
                        Message::set('error', 'unknown_error');
                    };
                    if (!Util::del_file(Config::get('szolgaltatascategoryphoto.upload_path') . $category_photo_thumb)) {
                        Message::set('error', 'unknown_error');
                    };
                }
                Message::set('success', 'A kategória törlése sikerült.');
                return true;
            } else {
                //sikertelen törlés
                Message::set('error', 'A kategória törlése nem sikerült!');
                return false;
            }
        } else {
            // ha a törlési sql parancsban hiba van
            throw new Exception('Hibas sql parancs: nem sikerult a DELETE lekerdezes az adatbazisbol!');
            return false;
        }


        // default visszatérési érték (akkor tér vissza false-al ha hibás az sql parancs)	
        return true;
    }

    /**
     * Ellenőrizzük, hogy a kategória törölhető-e: tartalmaz-e terméket 	
     *
     * @param integer $id
     * @return boolean $result
     */
    public function is_category_deletable($id) {

        $this->query->reset();
//        $this->query->debug(true);
        $this->query->set_table('szolgaltatasok');
        $this->query->set_columns('szolgaltatas_id');
        $this->query->set_where('szolgaltatas_category_id', '=', $id);
        $result = $this->query->select();

        if (!empty($result)) {
            return false;
        }

        return true;
    }

    public function category_update($id) {
        $data['szolgaltatas_list_name'] = trim($_POST['szolgaltatas_list_name']);
        // régi képek elérési útjának változókhoz rendelése (ezt használjuk a régi kép törléséhez, ha új kép lett feltöltve)
        $old_img_name = $_POST['old_img'];
        $old_category = $_POST['old_category'];
        $id = (int) $id;

        //ha módosított a kategória nevén
        if ($old_category != $data['szolgaltatas_list_name']) {
            // kategóriák lekérdezése (annak ellenőrzéséhez, hogy már létezik-e ilyen kategória)
            $existing_categorys = $this->szolgaltatas_list_query();
            // bejárjuk a kategória neveket és összehasonlítjuk az új névvel (kisbetűssé alakítjuk, hogy ne számítson a nagybetű-kisbetű eltérés)
            foreach ($existing_categorys as $value) {
                if ((strtolower($data['szolgaltatas_list_name']) == strtolower($value['szolgaltatas_list_name'])) && $id != $value['szolgaltatas_list_id']) {
                    Message::set('error', 'category_already_exists');
                    return false;
                }
            }
        }

        if (isset($_FILES['upload_szolgaltatas_category_photo']) && $_FILES['upload_szolgaltatas_category_photo']['error'] != 4) {
            // kép feltöltése, upload_szolgaltatas_category_picture() metódussal (visszatér a feltöltött kép elérési útjával, vagy false-al)
            $image_name = $this->upload_szolgaltatas_category_photo($_FILES['upload_szolgaltatas_category_photo']);

            if ($image_name === false) {
                return false;
            }
        }

        if (isset($image_name)) {
            $data['szolgaltatas_list_photo'] = $image_name;

            //megnézzük, hogy a régi kép a default-e, mert azt majd nem akarjuk törölni
            if ($old_img_name == Config::get('szolgaltatascategoryphoto.default_photo')) {
                $default_photo = true;
            } else {
                $default_photo = false;
                $old_thumb_name = Util::thumb_path($old_img_name);
            }
        }

        // módosítjuk az adatbázisban a kategória nevét	és kép elérési utat ha kell
        $this->query->reset();
        $this->query->set_table(array('szolgaltatasok_list'));
        $this->query->set_where('szolgaltatas_list_id', '=', $id);
        $result = $this->query->update($data);

        // ha sikeres az insert visszatérési érték true
        if ($result) {
            // megvizsgáljuk, hogy létezik-e új feltöltött kép és a régi kép, nem a default
            if (isset($image_name) && $default_photo === false) {
                //régi képek törlése
                if (!Util::del_file(Config::get('szolgaltatascategoryphoto.upload_path') . $old_img_name)) {
                    Message::set('error', 'unknown_error');
                };
                if (!Util::del_file(Config::get('szolgaltatascategoryphoto.upload_path') . $old_thumb_name)) {
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
     * 	Lekérdezi a kategóriák nevét és id-jét a szolgaltatasok_list táblából (az option listához)
     */
    public function category_list_query() {
        $this->query->reset();
        $this->query->set_table(array('szolgaltatasok_list'));
        $this->query->set_columns(array('szolgaltatas_list_id', 'szolgaltatas_list_name'));
        $this->query->set_orderby('szolgaltatas_list_name', 'ASC');
        $result = $this->query->select();
        return $result;
    }

    /**
     * 	Lakás képet méretezi és tölti fel a szerverre (thumb képet is)
     * 	
     * 	@param	$files_array	Array ($_FILES['valami'])
     * 	@return	Array (képek nevét tartalmazó tömb) or echo errors (json)
     */
    public function upload_szolgaltatas_extra_photos($files_array) {
        include(LIBS . "/upload_class.php");
// feltöltés helye
        $imagePath = Config::get('szolgaltatasphoto.upload_path');
//hibákat tartalmazó tömb	
        $errors = array();

// multiple feltöltésnél át kell alakítani a $_FILES tömb szerkezetét single-re mert az osztály csak úgy tudja feldolgozni
        $files = array();
        foreach ($files_array as $k => $l) {
            foreach ($l as $i => $v) {
                if (!array_key_exists($i, $files))
                    $files[$i] = array();
                $files[$i][$k] = $v;
            }
        }

// több file feltöltése
        foreach ($files as $file) {
//képkezelő objektum létrehozása (a kép a szerveren a tmp könyvtárba kerül)	
            $handle = new Upload($file);
// fájlneve utáni random karakterlánc
            $suffix = md5(uniqid());

//file átméretezése, vágása, végleges helyre mozgatása
            if ($handle->uploaded) {
// kép paramétereinek módosítása
                $handle->file_auto_rename = true;
                $handle->file_safe_name = true;
                $handle->allowed = array('image/*');
                $handle->file_new_name_body = "szolgaltatas_" . $suffix;
                $handle->image_resize = true;
                $handle->image_x = Config::get('szolgaltatasphoto.width', 323); //kép szélessége

                if (Config::get('szolgaltatasphoto.y_ratio') === true) {
                    $handle->image_ratio_y = true;
                } else {
                    $handle->image_y = Config::get('szolgaltatasphoto.height', 200); //kép magassága
//képarány meghatározása a nézőképhez
                    $ratio = ($handle->image_x / $handle->image_y);
                }

// Kép készítése
                $handle->Process($imagePath);
                if ($handle->processed) {
//kép elérési útja és új neve (ezzel tér vissza a metódus, ha nincs hiba!)
//$dest_imagePath = $imagePath . $handle->file_dst_name;
//a kép neve (ezzel tér vissza a metódus, ha nincs hiba!)
                    $image_name = $handle->file_dst_name;
                } else {
                    $errors[] = Message::send($handle->error);
                    continue;
// return false;
                }
                $original_name = $handle->file_dst_name_body;
                $handle->file_new_name_body = $original_name;
                $handle->file_name_body_add = '_small';

                $handle->image_resize = true;
                $handle->image_x = Config::get('szolgaltatasphoto.small_width', 400); //nézőkép szélessége

                if (Config::get('ingatlan_photo.y_ratio') === true) {
                    $handle->image_ratio_y = true;
                } else {
                    $handle->image_y = round($handle->image_x / $ratio);
                }

                $handle->Process($imagePath);



// Nézőkép készítése
//nézőkép nevének megadása (kép új neve utána _thumb)	
                $handle->file_new_name_body = $original_name;
                $handle->file_name_body_add = '_thumb';

                $handle->image_resize = true;
                $handle->image_x = Config::get('szolgaltatasphoto.thumb_width', 80); //nézőkép szélessége

                if (Config::get('szolgaltatasphoto.y_ratio') === true) {
                    $handle->image_ratio_y = true;
                } else {
                    $handle->image_y = round($handle->image_x / $ratio);
                }

                $handle->Process($imagePath);
                if ($handle->processed) {
//temp file törlése a szerverről
                    $handle->clean();
                } else {
//$errors[] = Message::send($handle->error);
                    continue;
//return false;
                }
            } else {
                $errors[] = Message::send($handle->error);
                continue;
//return false;	
            }
// ha nincs hiba visszadja a feltöltött kép nevét
            $image_names[] = $image_name;
            unset($handle);
        }

        if (!empty($errors)) {
//visszaküldi a hibákat a javascriptnek és megállítja a php script futását
            echo json_encode($errors);
            exit();
        } else {
//ha nincs hiba visszaadja a képek neveit tartalmazó tömböt
            return $image_names;
        }
    }

    /**
     * 	A sorbarendezett képek adatait teszi az adatbázisba
     *
     * 	@param	integer	$id 			a rekord id-je
     * 	@param	string	$sort_json 	json string: elem_1[]=3,elem_2[]=1,elem_3[]=2
     * 	@return	bool	true || false	 
     */
    public function photo_sort($id, $sort_json) {
// képek adatainak lekérdezése
        $string_json = $this->file_data_query($id, 'szolgaltatas_extra_photos');
// képek nevei tömbbe
        $photo_arr = json_decode($string_json);

// sorrendet tartalamzó string átalakítása tömb formára
        parse_str($sort_json, $key_array);

// új sorrendet tartalmazó tömb ($result_arr) létrehozása 
        $result_arr = array();
//a $key_array tartalama pl.: 'elem' => array(1,5,3,4,2)
//a $sort_array tartalma pl.: array(1,5,3,4,2)
        foreach ($key_array as $key => $sort_array) {
            foreach ($sort_array as $index => $value) {
                $new_index = $value - 1;
                $result_arr[] = $photo_arr[$new_index];
            }
        }

        $data['szolgaltatas_extra_photos'] = json_encode($result_arr);

// beírjuk az adatbázisba
        $this->query->reset();
        $this->query->set_table(array('szolgaltatasok'));
        $this->query->set_where('szolgaltatas_id', '=', $id);
        return $this->query->update($data);
    }

    /**
     * 	File törlése (a feltöltöttek listából)
     *
     * 	@param	integer		$id  annak a sornak az id-je az ingatlanok táblában, ahol a képet törölni akarjuk
     * 	@param	integer		$sort_id  annak a képnek az indexe amit törölni akarjuk (ha már tömb-bé van alakítva a json string)
     * 	@param	string		adatbázis oszlop neve (kepek vagy docs) megadja, hogy képet, vagy dokumentumot kell lekérdezni, törölni
     * 	@return	bool		true || false
     */
    public function file_delete($id, $sort_id) {
// képek vagy dokumentumok lekérdezése (json)
        $string_json = $this->file_data_query($id);

// fájlok nevét tartalmazó tömb
        $file_name_arr = json_decode($string_json);
// törlendő file neve
        $filename = $file_name_arr[$sort_id];
// töröljük a tömbből az elemet
        unset($file_name_arr[$sort_id]);

// ha az utolsó file-t is töröljük, akkor null értéket kell írnunk az adatbázisba
        if (empty($file_name_arr)) {
            $data['szolgaltatas_extra_photos'] = null;
        } else {
// ha nem üres a tömb, akkor újraindexeljük
            $file_name_arr = array_values($file_name_arr);
// új fájl lista átakaítása json formátumra 
            $new_file_list = json_encode($file_name_arr);

            $data['szolgaltatas_extra_photos'] = $new_file_list;
        }

// módosított file lista beírása az adatbázisba
        $this->query->reset();
        $this->query->set_table(array('szolgaltatasok'));
        $this->query->set_where('szolgaltatas_id', '=', $id);
        $result = $this->query->update($data);

        if ($result) {
// kép (és thumb) törlése

            $photo_path = Config::get('szolgaltatasphoto.upload_path') . $filename;
            $thumb_path = Util::thumb_path($photo_path);
            $small_path = Util::small_path($photo_path);

// nagy kép törlése
            if (!Util::del_file($photo_path)) {
                Message::log($filename . ' - nevü file törlése nem sikerült!');
            };
// thumb kép törlése
            if (!Util::del_file($thumb_path)) {
                Message::log($filename . ' - nevü file törlése nem sikerült!');
            };
// small kép törlése
            if (!Util::del_file($small_path)) {
                Message::log($filename . ' - nevü file törlése nem sikerült!');
            };
            return true;
        } else {
            return false;
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
    public function szolgaltatas_file_query($new_file_names, $id) {

// lekérdezzük a képek vagy docs mező értékét
        $result = $this->file_data_query($id);

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

// visszaalakítjuk json-ra
        $data['szolgaltatas_extra_photos'] = json_encode($temp_arr);

// beírjuk az adatbázisba
        $this->query->reset();
        $this->query->set_table(array('szolgaltatasok'));
        $this->query->set_where('szolgaltatas_id', '=', $id);
        return $this->query->update($data);
    }

    /**
     * 	Kép vagy dokumentum fájlok json adatainak lekérdezése
     *
     * 	@param	integer $id  		rekord id-je
     * 	@param	string  $column  	oszlop neve (kepek, docs)
     * 	@return	string				json string (kép vagy dokumentum fájlok neveit tartalmazó json)
     */
    public function file_data_query($id) {

        $this->query->reset();
        $this->query->debug(false);
        $this->query->set_table(array('szolgaltatasok'));
        $this->query->set_columns(array('szolgaltatas_extra_photos'));
        $this->query->set_where('szolgaltatas_id', '=', $id);
        $result = $this->query->select();

        if (!empty($result)) {
            return $result[0]['szolgaltatas_extra_photos'];
        } else {
            return $result;
        }
    }

}

?>