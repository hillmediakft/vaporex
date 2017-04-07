<?php

class Products_model extends Model {

    /**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * 	Egy termék minden adatát lekérdezi a részletek megjelenítéséhez
     */
    public function one_product_alldata_query($id = null) {
        $id = (int) $id;

        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('products'));

        $this->query->set_columns(array(
          'products.product_id',
          'products.product_title',
          'products.product_description',
          'products.product_price',
          'products.product_tax',
          'products.product_status',
          'products.product_create_timestamp',
          'products.product_update_timestamp',
          'products.product_category_id',
          'products.product_photo',
          'product_categories.product_category_name'
        ));
        $this->query->set_join('left', 'product_categories', 'products.product_category_id', '=', 'product_categories.product_category_id');
        $this->query->set_where('product_id', '=', $id);
        return $this->query->select();
    }

    /**
     * 	Egy termék minden adatát lekérdezi a részletek megjelenítéséhez
     */
    public function one_product_alldata_query_ajax() {
        //$id = (int)$_POST['id'];
        $id = (int) $this->registry->params['id'];

        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('products'));
        $this->query->set_columns(array(
          'products.product_id',
          'products.product_title',
          'products.product_description',
          'products.product_price',
          'products.product_tax',
          'products.product_status',
          'products.product_create_timestamp',
          'products.product_update_timestamp',
          'products.product_category_id',
          'products.product_photo',
          'product_categories.product_category_name'
        ));
        $this->query->set_join('left', 'product_categories', 'products.product_category_id', '=', 'product_categories.product_category_id');
        $this->query->set_where('product_id', '=', $id);
        $result = $this->query->select();

        $result[0]['product_create_timestamp'] = date('Y-m-d H:i', $result[0]['product_create_timestamp']);
        $result[0]['product_update_timestamp'] = (!empty($result[0]['product_update_timestamp'])) ? date('Y-m-d H:i', $result[0]['product_update_timestamp']) : $result[0]['product_update_timestamp'];

        return $result[0];
    }

    /**
     * 	Egy termék minden "nyers" adatát lekérdezi
     * 	A termék módosításához kell 
     */
    public function one_product_query($id) {
        $id = (int) $id;
        $this->query->reset();
        $this->query->set_table(array('products'));
        $this->query->set_columns('*');
        $this->query->set_where('product_id', '=', $id);
        return $this->query->select();
    }

    /**
     * 	A termékek táblázathoz kérdezi le az adatokat
     * 	@return array
     */
    public function all_products_query() {
        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('products'));
        $this->query->set_columns(array(
          'products.product_id',
          'products.product_title',
          'products.product_description',
          'products.product_price',
          'products.product_tax',
          'products.product_status',
          'products.product_create_timestamp',
          'products.product_update_timestamp',
          'products.product_category_id',
          'products.product_photo',
          'product_categories.product_category_name'
        ));
        $this->query->set_join('left', 'product_categories', 'products.product_category_id', '=', 'product_categories.product_category_id');

        return $this->query->select();
    }

    /**
     * 	Lekérdezi a termék kategóriákat a products_categories táblából (és az id-ket)
     * 	@param	integer	$id  (ha csak egy elemet akarunk lekérdezni)
     * 	@return	array	
     */
    public function product_categories_query() {
        $this->query->reset();
        $this->query->set_table('product_categories a');
        $this->query->set_columns('a.product_category_id AS cat_id, a.product_category_name AS cat_name,b.product_category_id AS parent_id, b.product_category_name AS parent_name, a.product_category_photo'
        );

        /*
         * 


          $sql2 = '
          SELECT a.product_category_id AS "Cat_ID",
          a.product_category_name AS "Category Name",
          b.product_category_id AS "Parent ID",
          b.product_category_name AS "Parent Name"
          FROM product_categories a
          LEFT JOIN product_categories b ON a.product_category_parent = b.product_category_id';
          $sql = '
         */


        $this->query->set_join('left', 'product_categories b', 'a.product_category_parent', '=', 'b.product_category_id');
        $this->query->set_where('a.product_category_id', '!=', 1);

        $result = $this->query->select();

        return $result;
    }

    /**
     * 	Lekérdezi a termékkategóriát a product_categories táblából 
     * 	@param	integer	$id  (ha csak egy elemet akarunk lekérdezni)
     * 	@return	array	
     */
    public function one_product_category($id = null) {
        $this->query->reset();
        $this->query->set_table(array('product_categories'));
        $this->query->set_columns('*');
        $id = (int) $id;
        $this->query->set_where('product_category_id', '=', $id);
        return $this->query->select();
    }

    /**
     * 	Lekérdezi a kategóriák nevét és id-jét 
     */
    public function category_list_query() {
        $this->query->reset();
        $this->query->set_table(array('product_categories'));
        $this->query->set_columns(array('product_category_id', 'product_category_name'));
        $result = $this->query->select();
        return $result;
    }

    /**
     * 	Termék hozzáadása
     */
    public function insert_product() {

        $have_subcategories = (!empty($_POST['product_category_id'])) ? $this->get_subcategory($_POST['product_category_id']) : '';
        $error_counter = 0;
        //megnevezés ellenőrzése	
        if (empty($_POST['product_title'])) {
            $error_counter++;
            Message::set('error', 'A termék megnevezése nem lehet üres!');
        }
        if (empty($_POST['product_description'])) {
            $error_counter++;
            Message::set('error', 'A termék leírása nem lehet üres!');
        }
        if (empty($_POST['product_category_id'])) {
            $error_counter++;
            Message::set('error', 'Választani kell egy kategóriát!');
        }
        if (empty($_POST['product_price'])) {
            $error_counter++;
            Message::set('error', 'Adja meg a termék árát!');
        }
        if (!empty($have_subcategories)) {
            $error_counter++;
            Message::set('error', 'A ketagória már tartalmaz alkategóriát, ezért nem hozhat létre terméket! Hozzon létre új alkategóriát');
        }


        if ($error_counter != 0) {
            return false;
        }

        $data['product_photo'] = (!empty($_POST['img_url'])) ? $_POST['img_url'] : Config::get('productphoto.default_photo');


        $data['product_title'] = $_POST['product_title'];
        $data['product_description'] = $_POST['product_description'];
        $data['product_price'] = (int) $_POST['product_price'];
        $data['product_tax'] = (int) $_POST['product_tax'];
        $data['product_category_id'] = $_POST['product_category_id'];
        $data['product_status'] = $_POST['product_status'];

        //létrehozás dátuma timestamp
        $data['product_create_timestamp'] = time();

        // új adatok az adatbázisba
        $this->query->reset();
        //           $this->query->debug(true);
        $this->query->set_table(array('products'));
        $this->query->insert($data);

        Message::set('success', 'Termék sikeresen hozzáadva.');
        return true;
    }

    /**
     * 	Munka módosítása
     *
     * 	@param integer	$id
     * @return bool true, ha sikeres; false, ha nem
     */
    public function update_product($id) {


        $has_subcategories = (!empty($_POST['product_category_id'])) ? $this->get_subcategory($_POST['product_category_id']) : '';
        $error_counter = 0;
        //megnevezés ellenőrzése	
        if (empty($_POST['product_title'])) {
            $error_counter++;
            Message::set('error', 'A termék megnevezése nem lehet üres!');
        }
        if (empty($_POST['product_description'])) {
            $error_counter++;
            Message::set('error', 'A termék leírása nem lehet üres!');
        }
        if (empty($_POST['product_category_id'])) {
            $error_counter++;
            Message::set('error', 'Választani kell egy kategóriát!');
        }
        if (empty($_POST['product_price'])) {
            $error_counter++;
            Message::set('error', 'Adja meg a termék árát!');
        }
        if (!empty($has_subcategories)) {
            $error_counter++;
            Message::set('error', 'A ketagória már tartalmaz alkategóriát, ezért nem hozhat létre terméket! Hozzon létre új alkategóriát');
        }


        if ($error_counter != 0) {
            return false;
        }

        if ($error_counter == 0) {


            $data['product_title'] = $_POST['product_title'];
            $data['product_description'] = $_POST['product_description'];
            $data['product_price'] = (int) $_POST['product_price'];
            $data['product_tax'] = (int) $_POST['product_tax'];
            $data['product_category_id'] = $_POST['product_category_id'];
            $data['product_status'] = $_POST['product_status'];

            if (isset($_POST['img_url']) && !empty($_POST['img_url'])) {
                $data['product_photo'] = $_POST['img_url'];
                $old_img_name = $_POST['old_img'];
                //megnézzük, hogy a régi kép a default-e, mert azt majd nem akarjuk törölni
                if ($old_img_name == Config::get('productphoto.default_photo')) {
                    $default_photo = true;
                } else {
                    $default_photo = false;
                    $old_thumb_name = Util::thumb_path($old_img_name);
                }
            } else {
                $data['product_photo'] = $_POST['old_img'];
            }


            // módosítás dátuma timestamp formátumban
            $data['product_update_timestamp'] = time();


            // új adatok az adatbázisba
            $this->query->reset();
            $this->query->set_table(array('products'));
            $this->query->set_where('product_id', '=', $id);
            $result = $this->query->update($data);

            if ($result) {
                // megvizsgáljuk, hogy létezik-e új feltöltött kép és a régi kép, nem a default
                if (!empty($_POST['img_url']) && $default_photo === false) {
                    //régi képek törlése
                    if (!Util::del_file($old_img_name)) {
                        Message::set('error', 'unknown_error');
                    };
                    if (!Util::del_file($old_thumb_name)) {
                        Message::set('error', 'unknown_error');
                    };
                }
                Message::set('success', 'Termék adatai sikeresen módosítva.');
                return true;
            }
        } else {
            Message::set('error', 'Ismeretlen hiba!');
            return false;
        }
    }

    /**
     * Termék (illetve termékek) törlése
     * @return true, ha sikeres a törlés, false, ha hibás az sql parancs
     */
    public function delete_product() {
        // a sikeres törlések számát tárolja
        $success_counter = 0;
        // a sikertelen törlések számát tárolja
        $fail_counter = 0;

        // Több user törlése
        if (!empty($_POST)) {
            $data_arr = $_POST;

            //eltávolítjuk a tömbből a felesleges elemeket	
            /* if(isset($data_arr['delete_product'])) {
              unset($data_arr['delete_product']);
              } */
            if (isset($data_arr['products_length'])) {
                unset($data_arr['products_length']);
            }
        } else {
            // egy user törlése (nem POST adatok alapján)
            if (!isset($this->registry->params['id'])) {
                throw new Exception('Nincs id-t tartalmazo parameter az url-ben (ezert nem tudunk torolni id alapjan)!');
                return false;
            }
            //berakjuk a $data_arr tömbbe a törlendő felhasználó id-jét
            $data_arr = array($this->registry->params['id']);
        }

        // bejárjuk a $data_arr tömböt és minden elemen végrehajtjuk a törlést
        foreach ($data_arr as $value) {
            //átalakítjuk a integer-ré a kapott adatot
            $value = (int) $value;

            //felhasználó törlése	
            $this->query->reset();
            $this->query->set_table(array('products'));
            //a delete() metódus integert (lehet 0 is) vagy false-ot ad vissza
            $result = $this->query->delete('product_id', '=', $value);

            if ($result !== false) {
                // ha a törlési sql parancsban nincs hiba
                if ($result > 0) {
                    //sikeres törlés
                    $success_counter += $result;
                } else {
                    //sikertelen törlés
                    $fail_counter += 1;
                }
            } else {
                // ha a törlési sql parancsban hiba van
                throw new Exception('Hibas sql parancs: nem sikerult a DELETE lekerdezes az adatbazisbol!');
                return false;
            }
        }

        // üzenetek eltárolása
        if ($success_counter > 0) {
            Message::set('success', $success_counter . ' termék törlése sikerült.');
        }
        if ($fail_counter > 0) {
            Message::set('error', $fail_counter . ' termék törlése nem sikerült!');
        }

        // default visszatérési érték (akkor tér vissza false-al ha hibás az sql parancs)	
        return true;
    }

    /**
     * Termék kategória hozzáadása
     * 
     * @return true, ha sikeres, false, ha nem
     */
    public function category_insert() {
        //ha üresen küldték el a formot
        if (empty($_POST['product_category_name'])) {
            Message::set('error', 'Meg kell adni a kategória nevét!');
            return false;
        }

        $data['product_category_name'] = $_POST['product_category_name'];

        // kategóriák lekérdezése (annak ellenőrzéséhez, hogy már létezik-e ilyen kategória)
        $existing_categorys = $this->category_list_query();
        // bejárjuk a kategória neveket és összehasonlítjuk az új névvel (kisbetűssé alakítjuk, hogy ne számítson a nagybetű-kisbetű eltérés)
        foreach ($existing_categorys as $value) {
            $data['product_category_name'] = trim($data['product_category_name']);
            if (strtolower($data['product_category_name']) == strtolower($value['product_category_name'])) {
                Message::set('error', 'category_already_exists');
                return false;
            }
        }


        $data['product_category_photo'] = (!empty($_POST['img_url'])) ? $_POST['img_url'] : Config::get('productphoto.upload_path') . Config::get('categoryphoto.default_photo');

        $data['product_category_parent'] = (int) $_POST['product_category_parent_id'];


        // adatbázis lekérdezés	
        $this->query->reset();
//        $this->query->debug(true);
        $this->query->set_table(array('product_categories'));
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
     * Termék kategória módosítása
     * 
     * @param int $id a kategória azonosítója
     * @return true, ha sikeres, false, ha nem
     */
    public function category_update($id) {

        //ha üresen küldték el a formot
        if (empty($_POST['product_category_name'])) {
            Message::set('error', 'Meg kell adni a kategória nevét!');
            return false;
        }

        $data['product_category_name'] = $_POST['product_category_name'];
        $data['product_category_parent'] = (int) $_POST['product_category_parent_id'];
        ;

        // régi képek elérési útjának változókhoz rendelése (ezt használjuk a régi kép törléséhez, ha új kép lett feltöltve)
        $old_img_name = $_POST['old_img'];
        $old_category = $_POST['old_category'];
        $id = (int) $id;

        // kategóriák lekérdezése (annak ellenőrzéséhez, hogy már létezik-e ilyen kategória)
        $existing_categorys = $this->category_list_query();
        // bejárjuk a kategória neveket és összehasonlítjuk az új névvel (kisbetűssé alakítjuk, hogy ne számítson a nagybetű-kisbetű eltérés)
        foreach ($existing_categorys as $value) {
            $data['product_category_name'] = trim($data['product_category_name']);
            if (strtolower($data['product_category_name']) == strtolower($value['product_category_name']) && $id != $value['product_category_id']) {
                Message::set('error', 'category_already_exists');
                return false;
            }
        }

        if (isset($_POST['img_url']) && !empty($_POST['img_url'])) {
            $data['product_category_photo'] = $_POST['img_url'];
            //megnézzük, hogy a régi kép a default-e, mert azt majd nem akarjuk törölni
            if ($old_img_name == Config::get('categoryphoto.default_photo')) {
                $default_photo = true;
            } else {
                $default_photo = false;
                $old_thumb_name = Util::thumb_path($old_img_name);
            }
        } else {
            $data['product_category_photo'] = $_POST['old_img'];
        }




        // módosítjuk az adatbázisban a kategória nevét	és kép elérési utat ha kell
        $this->query->reset();
//        $this->query->debug(true);
        $this->query->set_table(array('product_categories'));
        $this->query->set_where('product_category_id', '=', $id);
        $result = $this->query->update($data);

        // ha sikeres az insert visszatérési érték true
        if ($result) {
            // megvizsgáljuk, hogy létezik-e új feltöltött kép és a régi kép, nem a default
            if (!empty($_POST['img_url']) && $default_photo === false) {
                //régi képek törlése
                if (!Util::del_file($old_img_name)) {
                    Message::set('error', 'unknown_error');
                };
                if (!Util::del_file($old_thumb_name)) {
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
     * Kategória törlése
     * 
     * @return true, ha sikeres, false, ha nem
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
            Message::set('error', 'A kategória nem törölhető! A kategória terméket tartalmaz, vagy alkategóriái vannak!');
            return;
        }

        $this->query->reset();
        $this->query->set_table(array('product_categories'));
        //a delete() metódus integert (lehet 0 is) vagy false-ot ad vissza
        $result = $this->query->delete('product_category_id', '=', $id);

        if ($result !== false) {
            // ha a törlési sql parancsban nincs hiba
            if ($result > 0) {
                //sikeres törlés
                Message::set('success', 'A kategória törlése sikerült.');
            } else {
                //sikertelen törlés
                Message::set('error', 'A kategória törlése nem sikerült!');
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
     * Visszaadja a products tábla product_category_id oszlop tartalmát
     * Egy kategóriához tertozó termékek számának meghatározásához kell
     * @return array
     */
    public function product_category_counter_query() {
        $this->query->reset();
        $this->query->set_table(array('products'));
        $this->query->set_columns('product_category_id');
        return $this->query->select();
    }

    /**
     * Visszaadja a products tábla product_category_id oszlop tartalmát
     * Egy kategóriához tertozó termékek számának meghatározásához kell
     * 
     * @param integer $id
     * @return array
     */
    public function product_number_in_category($id) {
        $this->query->reset();
        $this->query->set_table('products');
        $this->query->set_columns('COUNT(*)');
        $this->query->set_where('product_category_id', '=', $id);
        $count = $this->query->select();
        return $count[0]['COUNT(*)'];
    }

    /**
     * 	(AJAX) A products tábla product_status mezőjének ad értéket
     * 	siker vagy hiba esetén megy vissza az üzenet a javascriptnek 	
     *
     * 	@param	integer	$id	
     * 	@param	integer	$data (0 vagy 1)	
     * 	@return void
     */
    public function change_status_query($id, $data) {
        $this->query->reset();
        $this->query->set_table(array('products'));
        $this->query->set_where('product_id', '=', $id);
        $result = $this->query->update(array('product_status' => $data));

        if ($result) {
            echo json_encode(array("status" => 'success'));
        } else {
            echo json_encode(array("status" => 'error'));
        }
    }

    /**
     * 	termék képet méretezi és tölti fel a szerverre (thumb képet is)
     * 	(ez a metódus a category_insert() metódusban hívódik meg!)
     *
     * 	@param	$files_array	Array ($_FILES['valami'])
     * 	@return	String (kép elérési útja) or false
     */
    private function upload_product_photo($files_array) {
        include(LIBS . "/upload_class.php");
        // feltöltés helye
        $imagePath = Config::get('productphoto.upload_path');
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
            $handle->file_new_name_body = "product_" . $suffix;
            $handle->image_resize = true;
            $handle->image_x = Config::get('productphoto.width', 400); //productphoto kép szélessége
            $handle->image_y = Config::get('productphoto.height', 300); //productphoto kép magassága
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
            $handle->image_x = Config::get('productphoto.thumb_width', 80); //productphoto nézőkép szélessége
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

    /**
     * 	Munka kategória képet méretezi és tölti fel a szerverre (thumb képet is)
     * 	(ez a metódus a category_insert() metódusban hívódik meg!)
     *
     * 	@param	$files_array	Array ($_FILES['valami'])
     * 	@return	String (kép elérési útja) or false
     */
    private function upload_product_category_photo($files_array) {
        include(LIBS . "/upload_class.php");
        // feltöltés helye
        $imagePath = Config::get('categoryphoto.upload_path');
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
            $handle->file_new_name_body = "productcategory_" . $suffix;
            $handle->image_resize = true;
            $handle->image_x = Config::get('categoryphoto.width', 400); //productphoto kép szélessége
            $handle->image_y = Config::get('categoryphoto.height', 300); //productphoto kép magassága
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
            $handle->image_x = Config::get('categoryphoto.thumb_width', 80); //productphoto nézőkép szélessége
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

    /**
     * 	Termék kategóriákból list alétrehozása fa generáláshoz 	
     *
     * 	@return string html kód
     */
    public function get_category_tree() {
        $result = $this->get_subcategory(1);
        $list = '<ul>';
        foreach ($result as $value) {

            $list .= '<li>' . $value['product_category_name'] . ' (' . $this->get_product_count($value['product_category_id']) . ')';
            $list .= '<ul>';

            $sub_result = $this->get_subcategory($value['product_category_id']);

            foreach ($sub_result as $sub_value) {

                $list .= '<li>' . $sub_value['product_category_name'] . ' (' . $this->get_product_count($sub_value['product_category_id']) . ')';
                $list .= '<ul>';
                $sub_sub_result = $this->get_subcategory($sub_value['product_category_id']);

                foreach ($sub_sub_result as $sub_sub_value) {
                    $list .= '<li>' . $sub_sub_value['product_category_name'] . ' (' . $this->get_product_count($sub_sub_value['product_category_id']) . ')';
                    $list .= '<ul>';
                    $sub_sub_sub_result = $this->get_subcategory($sub_sub_value['product_category_id']);
                    foreach ($sub_sub_sub_result as $sub_sub_sub_value) {
                        $list .= '<li>' . $sub_sub_sub_value['product_category_name'] . ' (' . $this->get_product_count($sub_sub_sub_value['product_category_id']) . ')' . '</li>';
                    }

                    $list .= '</ul>';
                    $list .= '</li>';
                }
                $list .= '</ul>';
                $list .= '</li>';
            }
            $list .= '</ul>';
            $list .= '</li>';
        }
        $list .= '</ul>';

        return $list;
    }

    /**
     * Egy katefgória alá tartozó alkategóriák lekérdezése 	
     *
     * @param integer $id
     * @return array kategórák tömbje
     */
    public function get_subcategory($cat_id) {
        $this->query->reset();
        $this->query->set_table('product_categories');
        $this->query->set_columns(array('product_category_id', 'product_category_parent', 'product_category_name'));
        $this->query->set_where('product_category_parent', '=', $cat_id);
        return $this->query->select();
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
        $this->query->set_table('products');
        $this->query->set_columns('product_id');
        $this->query->set_where('product_category_id', '=', $id);
        $result = $this->query->select();

        if (!empty($result)) {
            return false;
        }

        $path_info = $this->get_subcategory($id);


        if (!empty($path_info)) {
            foreach ($path_info as $value) {

                if (in_array($id, $value)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Crew member képének vágása és feltöltése
     * Az $this->registry->params['id'] paraméter értékétől függően feltölti a kiválasztott képet
     * upload paraméter esetén: feltölti a kiválasztott képet
     * crop paraméter esetén: megvágja a kiválasztott képet és feltölti	
     *
     */
    public function product_crop_img_upload() {


        if (isset($this->registry->params['id'])) {



            include(LIBS . "/upload_class.php");

            // Kiválasztott kép feltöltése
            if ($this->registry->params['id'] == 'upload') {

                // feltöltés helye
                $imagePath = Config::get('productphoto.upload_path');

                //képkezelő objektum létrehozása (a kép a szerveren a tmp könyvtárba kerül)	
                $handle = new Upload($_FILES['img']);

                if ($handle->uploaded) {
                    // kép paramétereinek módosítása
                    $handle->file_auto_rename = true;
                    $handle->file_safe_name = true;
                    //$handle->file_new_name_body   	 = 'lorem ipsum';
                    $handle->allowed = array('image/*');
                    $handle->image_resize = true;
                    $handle->image_x = Config::get('productphoto.width', 400);
                    $handle->image_ratio_y = true;

                    //végrehajtás: kép átmozgatása végleges helyére
                    $handle->Process($imagePath);

                    if ($handle->processed) {
                        //temp file törlése a szerverről
                        $handle->clean();

                        $response = array(
                          "status" => 'success',
                          //"url" => $handle->file_dst_name,
                          "url" => $imagePath . $handle->file_dst_name,
                          "width" => $handle->image_dst_x,
                          "height" => $handle->image_dst_y
                        );
                        return json_encode($response);
                    } else {
                        $response = array(
                          "status" => 'error',
                          "message" => $handle->error . ': Can`t upload File; no write Access'
                        );
                        return json_encode($response);
                    }
                } else {
                    $response = array(
                      "status" => 'error',
                      "message" => $handle->error . ': Can`t upload File; no write Access'
                    );
                    return json_encode($response);
                }
            }


            // Kiválasztott kép vágása és vágott kép feltöltése
            if ($this->registry->params['id'] == 'crop') {

                // a croppic js küldi ezeket a POST adatokat 	
                $imgUrl = $_POST['imgUrl'];
                // original sizes
                $imgInitW = $_POST['imgInitW'];
                $imgInitH = $_POST['imgInitH'];
                // resized sizes
                //kerekítjük az értéket, mert lebegőpotos számot is kaphatunk és ez hibát okozna a kép generálásakor
                $imgW = round($_POST['imgW']);
                $imgH = round($_POST['imgH']);
                // offsets
                // megadja, hogy mennyit kell vágni a kép felső oldalából
                $imgY1 = $_POST['imgY1'];
                // megadja, hogy mennyit kell vágni a kép bal oldalából
                $imgX1 = $_POST['imgX1'];
                // crop box
                $cropW = $_POST['cropW'];
                $cropH = $_POST['cropH'];
                // rotation angle
                //$angle = $_POST['rotation'];
                //a $right_crop megadja, hogy mennyit kell vágni a kép jobb oldalából
                $right_crop = ($imgW - $imgX1) - $cropW;
                //a $bottom_crop megadja, hogy mennyit kell vágni a kép aljából
                $bottom_crop = ($imgH - $imgY1) - $cropH;

                // feltöltés helye
                $imagePath = Config::get('productphoto.upload_path');

                //képkezelő objektum létrehozása (a feltöltött kép elérése a paraméter)	
                $handle = new Upload($imgUrl);

                // fájlneve utáni random karakterlánc
                $suffix = md5(uniqid());

                if ($handle->uploaded) {

                    // kép paramétereinek módosítása
                    //$handle->file_auto_rename 		 = true;
                    //$handle->file_safe_name 		 = true;
                    //$handle->file_name_body_add   	 = '_thumb';
                    $handle->file_new_name_body = "product_" . $suffix;
                    //kép átméretezése
                    $handle->image_resize = true;
                    $handle->image_x = $imgW;
                    $handle->image_ratio_y = true;
                    //utána kép vágása
                    $handle->image_crop = array($imgY1, $right_crop, $bottom_crop, $imgX1);

                    //végrehajtás: kép átmozgatása végleges helyére
                    $handle->Process($imagePath);

                    if ($handle->processed) {

                        $response = array(
                          "status" => 'success',
                          //"url" => $handle->file_dst_name
                          "url" => $imagePath . $handle->file_dst_name
                        );

                        $img_on_server = $handle->file_dst_name;

                        $handle->clean();
                        // Nézőkép készítése
                        $handle = new upload($imagePath . $img_on_server);
                        $handle->file_name_body_add = '_thumb';

                        $handle->image_resize = true;
                        $handle->image_x = Config::get('productphoto.thumb_width', 100); //productphoto nézőkép szélessége
                        $handle->image_ratio_y = true;

                        $handle->Process($imagePath);


                        return json_encode($response);
                    } else {
                        $response = array(
                          "status" => 'error',
                          "message" => $handle->error . ': Can`t upload File; no write Access'
                        );
                        return json_encode($response);
                    }
                } else {
                    $response = array(
                      "status" => 'error',
                      "message" => $handle->error . ': Can`t upload File; no write Access'
                    );
                    return json_encode($response);
                }
            }
        }
    }

    /**
     * Termék kategória képének vágása és feltöltése
     * Az $this->registry->params['id'] paraméter értékétől függően feltölti a kiválasztott képet
     * upload paraméter esetén: feltölti a kiválasztott képet
     * crop paraméter esetén: megvágja a kiválasztott képet és feltölti	
     *
     */
    public function product_category_crop_img_upload() {


        if (isset($this->registry->params['id'])) {



            include(LIBS . "/upload_class.php");

            // Kiválasztott kép feltöltése
            if ($this->registry->params['id'] == 'upload') {

                // feltöltés helye
                $imagePath = Config::get('categoryphoto.upload_path');

                //képkezelő objektum létrehozása (a kép a szerveren a tmp könyvtárba kerül)	
                $handle = new Upload($_FILES['img']);

                if ($handle->uploaded) {
                    // kép paramétereinek módosítása
                    $handle->file_auto_rename = true;
                    $handle->file_safe_name = true;
                    //$handle->file_new_name_body   	 = 'lorem ipsum';
                    $handle->allowed = array('image/*');
                    $handle->image_resize = true;
                    $handle->image_x = Config::get('categoryphoto.width', 400);
                    $handle->image_ratio_y = true;

                    //végrehajtás: kép átmozgatása végleges helyére
                    $handle->Process($imagePath);

                    if ($handle->processed) {
                        //temp file törlése a szerverről
                        $handle->clean();

                        $response = array(
                          "status" => 'success',
                          //"url" => $handle->file_dst_name,
                          "url" => $imagePath . $handle->file_dst_name,
                          "width" => $handle->image_dst_x,
                          "height" => $handle->image_dst_y
                        );
                        return json_encode($response);
                    } else {
                        $response = array(
                          "status" => 'error',
                          "message" => $handle->error . ': Can`t upload File; no write Access'
                        );
                        return json_encode($response);
                    }
                } else {
                    $response = array(
                      "status" => 'error',
                      "message" => $handle->error . ': Can`t upload File; no write Access'
                    );
                    return json_encode($response);
                }
            }


            // Kiválasztott kép vágása és vágott kép feltöltése
            if ($this->registry->params['id'] == 'crop') {

                // a croppic js küldi ezeket a POST adatokat 	
                $imgUrl = $_POST['imgUrl'];
                // original sizes
                $imgInitW = $_POST['imgInitW'];
                $imgInitH = $_POST['imgInitH'];
                // resized sizes
                //kerekítjük az értéket, mert lebegőpotos számot is kaphatunk és ez hibát okozna a kép generálásakor
                $imgW = round($_POST['imgW']);
                $imgH = round($_POST['imgH']);
                // offsets
                // megadja, hogy mennyit kell vágni a kép felső oldalából
                $imgY1 = $_POST['imgY1'];
                // megadja, hogy mennyit kell vágni a kép bal oldalából
                $imgX1 = $_POST['imgX1'];
                // crop box
                $cropW = $_POST['cropW'];
                $cropH = $_POST['cropH'];
                // rotation angle
                //$angle = $_POST['rotation'];
                //a $right_crop megadja, hogy mennyit kell vágni a kép jobb oldalából
                $right_crop = ($imgW - $imgX1) - $cropW;
                //a $bottom_crop megadja, hogy mennyit kell vágni a kép aljából
                $bottom_crop = ($imgH - $imgY1) - $cropH;

                // feltöltés helye
                $imagePath = Config::get('categoryphoto.upload_path');

                //képkezelő objektum létrehozása (a feltöltött kép elérése a paraméter)	
                $handle = new Upload($imgUrl);

                // fájlneve utáni random karakterlánc
                $suffix = md5(uniqid());

                if ($handle->uploaded) {

                    // kép paramétereinek módosítása
                    //$handle->file_auto_rename 		 = true;
                    //$handle->file_safe_name 		 = true;
                    //$handle->file_name_body_add   	 = '_thumb';
                    $handle->file_new_name_body = "productcategory_" . $suffix;
                    //kép átméretezése
                    $handle->image_resize = true;
                    $handle->image_x = $imgW;
                    $handle->image_ratio_y = true;
                    //utána kép vágása
                    $handle->image_crop = array($imgY1, $right_crop, $bottom_crop, $imgX1);

                    //végrehajtás: kép átmozgatása végleges helyére
                    $handle->Process($imagePath);

                    if ($handle->processed) {


                        $response = array(
                          "status" => 'success',
                          //"url" => $handle->file_dst_name
                          "url" => $imagePath . $handle->file_dst_name
                        );

                        $img_on_server = $handle->file_dst_name;

                        $handle->clean();
                        // Nézőkép készítése
                        $handle = new upload($imagePath . $img_on_server);
                        $handle->file_name_body_add = '_thumb';

                        $handle->image_resize = true;
                        $handle->image_x = Config::get('categoryphoto.thumb_width', 100); //productphoto nézőkép szélessége
                        $handle->image_ratio_y = true;

                        $handle->Process($imagePath);

                        return json_encode($response);
                    } else {
                        $response = array(
                          "status" => 'error',
                          "message" => $handle->error . ': Can`t upload File; no write Access'
                        );
                        return json_encode($response);
                    }
                } else {
                    $response = array(
                      "status" => 'error',
                      "message" => $handle->error . ': Can`t upload File; no write Access'
                    );
                    return json_encode($response);
                }
            }
        }
    }

    /**
     * Termékekek száma kategóriában és az alá tartozó kategóriákban 	
     *
     * @param integer $cat_id kategória id-je
     * @return int a termékek száma
     */
    public function get_product_count($cat_id) {
        $count = $this->product_number_in_category($cat_id);

        $children = $this->get_children($cat_id);
        if (!empty($children)) {
            foreach ($children as $value) {
                $count = $count + $this->product_number_in_category($value);
                $sub_children = $this->get_children($value);
                if (!empty($sub_children)) {
                    foreach ($sub_children as $sub_value) {
                        $count = $count + $this->product_number_in_category($sub_value);
                        $sub_sub_children = $this->get_children($sub_value);
                        if (!empty($sub_sub_children)) {
                            foreach ($sub_sub_children as $sub_sub_value) {
                                $count = $count + $this->product_number_in_category($sub_sub_value);
                            }
                        }
                    }
                }
            }
        }

        return $count;
    }

    /**
     * Kategória alá tartozó kategóriák (children nodes) 
     * 	
     * @param integer $cat_id
     * @return array $children_array a leszármazottak 
     */
    public function get_children($cat_id) {
        $this->query->reset();
        $this->query->set_table('product_categories');
        $this->query->set_columns('product_category_id');
        $this->query->set_where('product_category_parent', '=', $cat_id);
        $children = $this->query->select();
        $children_array = array();
        if (!empty($children)) {
            foreach ($children as $key => $value) {
                $children_array[] = $children[$key]['product_category_id'];
            }
        }
        return $children_array;
    }

}

?>