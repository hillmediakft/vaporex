<?php

class Subscribers_model extends Admin_model {

    function __construct() {
        parent::__construct();
    }

    /**
     * 	Rekord(ok) törlése
     *
     * 	@param	array	$id_arr		a törlendő rekordok id-it tartalmazó tömb
     * 	@return	array
     */
    public function delete($id_arr) {
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
            $this->query->set_table(array('newsletter_subscribers'));
            //a delete() metódus integert (lehet 0 is) vagy false-ot ad vissza
            $result = $this->query->delete('id', '=', $id);

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

        return array("success" => $success_counter, "error" => $error_counter);
    }

    /**
     * 	Adatok visszaadása a táblázatba
     *
     */
    public function get_items($request_data) {
        // ebbe a tömbbe kerülnek a csoportos műveletek üzenetei
        $messages = array();

        if (isset($request_data['customActionType']) && isset($request_data['customActionName'])) {

            switch ($request_data['customActionName']) {

                case 'group_delete':
                    // az id-ket tartalmazó tömböt kapja paraméterként
                    $result = $this->delete($request_data['id']);

                    if ($result['success'] > 0) {
                        $messages['success'] = $result['success'] . ' ' . Message::send('felhasználó sikeresen törölve.');
                    }
                    if ($result['error'] > 0) {
                        $messages['error'] = $result['error'] . ' ' . Message::send('felhasználó törlése nem sikerült!');
                    }
                    break;
            }
        }


        //összes sor számának lekérdezése
        $total_records = $this->query->count('newsletter_subscribers');

        $display_length = intval($request_data['length']);
        $display_length = ($display_length < 0) ? $total_records : $display_length;
        $display_start = intval($request_data['start']);
        $display_draw = intval($request_data['draw']);

        $this->query->reset();
        // a query tulajdonság ($this->query) tartalmazza a query objektumot
        $this->query->set_table(array('newsletter_subscribers'));
        $this->query->set_columns('SQL_CALC_FOUND_ROWS 
			`newsletter_subscribers`.`id`,
			`newsletter_subscribers`.`name`,
			`newsletter_subscribers`.`email`,
			`newsletter_subscribers`.`active`,
			`newsletter_subscribers`.`county`,
			`newsletter_subscribers`.`creation_timestamp`,
                        `county_list`.`county_name`'
        );
        $this->query->set_join('left', 'county_list', 'newsletter_subscribers.county', '=', 'county_list.county_id');
        $this->query->set_offset($display_start);
        $this->query->set_limit($display_length);

        //szűrés beállítások
        if (isset($request_data['action']) && $request_data['action'] == 'filter') {
            if (!empty($request_data['search_id'])) {
                $this->query->set_where('id', '=', $request_data['search_id']);
            }
            if (!empty($request_data['name'])) {
                $this->query->set_where('name', 'LIKE', '%' . $request_data['search_name'] . '%');
            }
            if (!empty($request_data['search_email'])) {
                $this->query->set_where('email', 'LIKE', '%' . $request_data['search_email'] . '%');
            }
            if ($request_data['search_status'] != '') {
                $this->query->set_where('active', '=', (int) $request_data['search_status']);
            }
            if ($request_data['search_county'] != '') {
                $this->query->set_where('county', '=', (int) $request_data['search_county']);
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


            $temp['checkbox'] = (Session::get('user_role_id') < 3) ? '<input type="checkbox" class="checkboxes" name="user_id_' . $value['id'] . '" value="' . $value['id'] . '"/>' : '';
            $temp['id'] = '#' . $value['id'];
            $temp['name'] = $value['name'];
            $temp['email'] = $value['email'];
            $temp['active'] = ($value['active'] == 1) ? '<span class="label label-sm label-success">Aktív</span>' : '<span class="label label-sm label-danger">Inaktív</span>';
            $temp['county'] = $value['county_name'];

            $temp['menu'] = '						
			<div class="actions">
				<div class="btn-group">
				    <a class="btn btn-sm grey-steel" title="Műveletek" href="#" data-toggle="dropdown">
						<i class="fa fa-cogs"></i>
					</a>					
					<ul class="dropdown-menu pull-right">
				        <li><a href="javascript:;" class="delete_item_class" data-id="' . $value['id'] . '"> <i class="fa fa-trash"></i> Töröl</a></li>		
				    </ul>
                </div>
            </div>';

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