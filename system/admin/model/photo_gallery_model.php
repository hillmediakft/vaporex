<?php

class Photo_gallery_model extends Model {

    /**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Az összes kép lekérdezése
     *
     * @return az összes kép adatai tümbben
     */
    public function all_photos() {
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('photo_gallery'));
        $this->query->set_columns(array('photo_id', 'photo_filename', 'photo_caption', 'photo_category', 'photo_slider'));
        $result = $this->query->select();

        return $result;
    }

    /**
     * Fotó hozzáadása, kép feltötése és adatok mentése
     *
     * @return boolean - true ha sikeres a mentés, false ha hoba történt
     */
    public function save_photo() {
        // ******************* kép feltöltése ************************** //

        include(LIBS . "/upload_class.php");
        // feltöltés helye
        $imagePath = UPLOADS . "photo_gallery/";
        //képkezelő objektum létrehozása (a kép a szerveren a tmp könyvtárba kerül)	
        $handle = new Upload($_FILES['upload_gallery_photo']);

        if ($handle->uploaded) {

            $handle->allowed = array('image/*');

            $random_number = md5(date('Y-m-d H:i:s:u'));

            $handle->image_resize = true;
            $handle->image_ratio_y = true;
            $handle->image_x = 800;
            $handle->file_new_name_body = $random_number;

            //végrehajtás: kép átmozgatása végleges helyére
            $handle->Process($imagePath);

            $filename = $handle->file_dst_name;


            if ($handle->processed) {
                //	$_SESSION["feedback_positive"][] = FEEDBACK_NEW_PHOTO_SUCCESS;


                $handle->image_resize = true;
                $handle->image_ratio_y = true;
                $handle->image_x = 320;
                $handle->file_new_name_body = $random_number . '_thumb';

                //végrehajtás: kép átmozgatása végleges helyére
                $handle->Process($imagePath);


                $handle->clean();
            } else {
                Message::set('error', 'Nem sikerült a feltöltés! Hiba: ' . $handle->error);
                return false;
            }
        } else {
            Message::set('error', 'Nem sikerült a feltöltés! Hiba: ' . $handle->error);
            return false;
        }



        $data['photo_filename'] = UPLOADS . 'photo_gallery/' . $filename;
        $data['photo_caption'] = $_POST['photo_caption'];
        $data['photo_category'] = $_POST['photo_category'];
        if (isset($_POST['photo_slider'])) {
            $data['photo_slider'] = $_POST['photo_slider'];
        } else
            $data['photo_slider'] = 0;



        $this->query->reset();
        $this->query->set_table(array('photo_gallery'));
        $result = $this->query->insert($data);

        // ha sikeres az insert visszatérési érték true
        if ($result) {
            Message::set('success', 'Fotó sikeresen feltöltve.');
            return true;
        } else {
           Message::set('error', 'Hiba történt!');
            return false;
        }
    }

    /**
     * Kép adatainak módosítása
     *
     *
     * @param 	int $id	
     * @return 	true vagy false
     */
    public function update_photo($id) {
        $flag = false;


        if (isset($_FILES['upload_gallery_photo']) && $_FILES['upload_gallery_photo']['tmp_name'] != '') {

            // ******************* kép feltöltése ************************** //
            $flag = true;
            include(LIBS . "/upload_class.php");
            // feltöltés helye
            $imagePath = UPLOADS . "photo_gallery/";
            //képkezelő objektum létrehozása (a kép a szerveren a tmp könyvtárba kerül)	
            $handle = new Upload($_FILES['upload_gallery_photo']);

            if ($handle->uploaded) {

                $handle->allowed = array('image/*');

                $random_number = md5(date('Y-m-d H:i:s:u'));
                $handle->jpeg_quality = 80;
                $handle->image_resize = true;
                $handle->image_ratio_y = true;
                $handle->image_x = 800;
                $handle->file_new_name_body = $random_number;

                //végrehajtás: kép átmozgatása végleges helyére
                $handle->Process($imagePath);

                $filename = $handle->file_dst_name;

                $data['photo_filename'] = UPLOADS . 'photo_gallery/' . $filename;

                if ($handle->processed) {
                    //	$_SESSION["feedback_positive"][] = FEEDBACK_NEW_PHOTO_SUCCESS;

                    $handle->jpeg_quality = 80;
                    $handle->image_resize = true;
                    $handle->image_ratio_y = true;
                    $handle->image_x = 320;
                    $handle->file_new_name_body = $random_number . '_thumb';

                    //végrehajtás: kép átmozgatása végleges helyére
                    $handle->Process($imagePath);


                    $handle->clean();
                } else {
                     Message::set('error', 'Nem sikerült a feltöltés! Hiba: ' . $handle->error);
                    return false;
                }
            } else {
                Message::set('error', 'Nem sikerült a feltöltés! Hiba: ' . $handle->error);
                return false;
            }
        }


        $data['photo_caption'] = $_POST['photo_caption'];
        $data['photo_category'] = $_POST['photo_category'];
        if (isset($_POST['photo_slider'])) {
            $data['photo_slider'] = $_POST['photo_slider'];
        } else
            $data['photo_slider'] = 0;

        $old_img = $_POST['old_photo'];
        /* 		
          var_dump($id);
          echo 'POST<br>';
          var_dump($_POST);
          echo 'data:<br>';
          var_dump($data);
          die();
         */
        // új adatok beírása az adatbázisba (update) a $data tömb tartalmazza a frissítendő adatokat 
        $this->query->reset();
        $this->query->set_table(array('photo_gallery'));
        $this->query->set_where('photo_id', '=', $id);
        $result = $this->query->update($data);

        if ($result) {
            if ($flag) {
                unlink($old_img);
                unlink(Util::thumb_path($old_img));
            }
            Message::set('success', 'Fotó sikeresen módosítva!');
            return true;
        } else {
            Message::set('error', 'Hiba történt!');
            return false;
        }
    }

    /**
     * 	Kép törlése a photo_gallery táblából
     *
     * 	@param	$id String or Integer
     * 	@return	boolean
     */
    public function delete_photo($id) {


        $this->query->reset();
        $this->query->set_table(array('photo_gallery'));
        $this->query->set_columns(array('photo_filename'));
        $this->query->set_where('photo_id', '=', $id);
        $result = $this->query->select();


        $image = $result[0]['photo_filename'];
        $image_thumb = Util::thumb_path($image);

        $this->query->reset();
        $this->query->set_table(array('photo_gallery'));
        $this->query->set_where('photo_id', '=', $id);
        $result = $this->query->delete();

        // ha sikeres a törlés 1 a vissaztérési érték
        if ($result == 1) {

            unlink($image);
            unlink($image_thumb);

             Message::set('success', 'Fotó sikeresen törölve!');
            return true;
        } else {
            Message::set('error', 'unknown_error');
            return false;
        }
    }

    /**
     * 	Egy kép adatait kérdezi le az adatbázisból (photo_gallery tábla)
     *
     * 	@param	$id a kép rekordjának azonosítója
     * 	@return	az adatok tömbben
     */
    public function photo_data_query($id) {
        $this->query->reset();
        $this->query->set_table(array('photo_gallery'));
        $this->query->set_columns(array('photo_id', 'photo_filename', 'photo_caption', 'photo_category', 'photo_slider'));
        $this->query->set_where('photo_id', '=', $id);

        return $this->query->select();
    }

    /**
     * 	Lekérdezi a fotó kategóriákat a photo_category táblából (és az id-ket)
     * 	@param	integer	$id  (ha csak egy elemet akarunk lekérdezni, pl.: munka kategória módosításhoz)
     * 	@return	array	
     */
    public function photo_category_query($id = null) {
        $this->query->reset();
        $this->query->set_table(array('photo_category'));
        $this->query->set_columns('*');
        if (!is_null($id)) {
            $id = (int) $id;
            $this->query->set_where('id', '=', $id);
        }
        return $this->query->select();
    }

    /**
     * 	Kép kategória hozzáadása
     */
    public function category_insert() {
        $data['category_name'] = trim($_POST['photo_category_name']);

        // kategóriák lekérdezése (annak ellenőrzéséhez, hogy már létezik-e ilyen kategória)
        $existing_categorys = $this->photo_category_query();
        // bejárjuk a kategória neveket és összehasonlítjuk az új névvel (kisbetűssé alakítjuk, hogy ne számítson a nagybetű-kisbetű eltérés)
        foreach ($existing_categorys as $value) {
            $data['category_name'] = trim($data['category_name']);
            if (strtolower($data['category_name']) == strtolower($value['category_name'])) {
                Message::set('error', 'Már létezik ilyen nevű kategória!');
                return false;
            }
        }



        // adatbázis lekérdezés	
        $this->query->reset();
        $this->query->set_table(array('photo_category'));
        $result = $this->query->insert($data);

        // ha sikeres az insert visszatérési érték egy id
        if ($result) {
            Message::set('success', 'A kategória sikeresen létrehozva!');
            return true;
        } else {
            Message::set('error', 'Hiba történt, próbálja újra!');
            return false;
        }
    }

    /**
     * 	fotó kategóriáka nevének módosítása 
     * 	@param	integer	$id 
     * 	@return	boolean true vagy false	
     */
    public function category_update($id) {
        $data['category_name'] = trim($_POST['category_name']);
        // régi képek elérési útjának változókhoz rendelése (ezt használjuk a régi kép törléséhez, ha új kép lett feltöltve)
        $old_category = $_POST['old_category'];
        $id = (int) $id;

        //ha módosított a kategória nevén
        if ($old_category != $data['category_name']) {
            // kategóriák lekérdezése (annak ellenőrzéséhez, hogy már létezik-e ilyen kategória)
            $existing_categorys = $this->photo_category_query();
            // bejárjuk a kategória neveket és összehasonlítjuk az új névvel (kisbetűssé alakítjuk, hogy ne számítson a nagybetű-kisbetű eltérés)
            foreach ($existing_categorys as $value) {
                if (strtolower($data['category_name']) == strtolower($value['category_name'])) {
                    Message::set('error', 'Már létezik ilyen nevű kategória!');
                    return false;
                }
            }
        }


        // módosítjuk az adatbázisban a kategória nevét	és kép elérési utat ha kell
        $this->query->reset();
        $this->query->set_table(array('photo_category'));
        $this->query->set_where('id', '=', $id);
        $result = $this->query->update($data);

        // ha sikeres az insert visszatérési érték true
        if ($result) {

            Message::set('success', 'A kategória neve módosítva');
            return true;
        } else {
            Message::set('error', 'Hiba történt, próbálja újra!');
            return false;
        }
    }

    /**
     * 	Lekérdezi kategóriák nevét és id-jét a photo_category táblából (az option listához)
     */
    public function photo_category_list_query() {
        $this->query->reset();
        $this->query->set_table(array('photo_category'));
        $this->query->set_columns(array('id', 'category_name'));
        $result = $this->query->select();
        return $result;
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
            Message::set('error', 'A kategória nem törölhető! A kategória képet tartalmaz!');
            return;
        }

        $this->query->reset();
        $this->query->set_table(array('photo_category'));
        //a delete() metódus integert (lehet 0 is) vagy false-ot ad vissza
        $result = $this->query->delete('id', '=', $id);

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
    }
    
   /**
     * Ellenőrizzük, hogy a kategória törölhető-e: tartalmaz-e képet 	
     *
     * @param integer $id
     * @return boolean $result
     */
    public function is_category_deletable($id) {

        $this->query->reset();
//        $this->query->debug(true);
        $this->query->set_table('photo_gallery');
        $this->query->set_columns('photo_id');
        $this->query->set_where('photo_category', '=', $id);
        $result = $this->query->select();

        if (!empty($result)) {
            return false;
        }

        return true;
    }    

}

?>