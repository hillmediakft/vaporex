<?php

class Category extends Model {

    /**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * 	Lekérdezi a termék kategóriákat, a szülőv dataival a products_categories táblából 
     * 
     * 	@return	array a kategóriák tömbben	
     */
    public function product_categories_query() {
        $this->query->reset();
        //   $this->query->debug(true);
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
        $this->query->set_orderby('cat_id', 'ASC');
        return $this->query->select();
    }

    /**
     * 	Lekérdezi a termék kategóriákat, a szülőv dataival a products_categories táblából 
     * 
     * 	@return	array a kategóriák tömbben	
     */
    public function product_category_path($category_id) {
        $path = '';
        $this->query->reset();
        //    $this->query->debug(true);
        $this->query->set_table('product_categories AS t1');
        $this->query->set_columns('t1.product_category_name AS lev1, t2.product_category_name as lev2, t3.product_category_name as lev3, t4.product_category_name as lev4'
        );

        /*
          SELECT t1.product_category_name AS lev1, t2.product_category_name as lev2, t3.product_category_name as lev3, t4.product_category_name as lev4
          FROM product_categories AS t1
          LEFT JOIN product_categories AS t2 ON t2.product_category_parent = t1.product_category_id
          LEFT JOIN product_categories AS t3 ON t3.product_category_parent = t2.product_category_id
          LEFT JOIN product_categories AS t4 ON t4.product_category_parent = t3.product_category_id
          WHERE t1.product_category_name = 'termekek' AND t4.product_category_name = 'BMW 1 3 ajtós';
         */

        $this->query->set_join('left', 'product_categories AS t2', 't1.product_category_parent', '=', 't2.product_category_id');
        $this->query->set_join('left', 'product_categories AS t3', 't2.product_category_parent', '=', 't3.product_category_id');
        $this->query->set_join('left', 'product_categories AS t4', 't3.product_category_parent', '=', 't4.product_category_id');

        $this->query->set_where('t1.product_category_id', '=', $category_id);

        $result = $this->query->select();

        foreach (array_reverse($result[0]) as $key => $value) {
            if ($value != null) {
                $path .= $value . ' &raquo; ';
            }
        }
        $path = ltrim($path, 'termékek &raquo; ');
        $path = rtrim($path, ' &raquo; ');
        return $path;
    }

    /**
     * 	Minden termék kategória tömbhöz hozzáilleszti a lategória elérési útvonalát
     * 
     * 	@return	array a kategóriák + path tömbben	
     */
    public function product_categories_with_path($categories_arr) {
        // a termékek root kategória eltávolítása a tömbből 
        array_shift($categories_arr);

        foreach ($categories_arr as $key => $value) {
            $categories_arr[$key]['category_path'] = $this->product_category_path($value['cat_id']);
        }

        return $categories_arr;
    }

    /**
     * 	Lekérdezi egy kategória adatait id alapján
     * 	@param	integer	$id
     * 	@return	array	
     */
    public function product_category_by_id($id) {
        $id = (int) $id;
        $this->query->reset();
        $this->query->set_table(array('product_categories'));
        $this->query->set_columns('*');
        $this->query->set_where('product_category_id', '=', $id);
        return $this->query->select();
    }

    /**
     * 	Termék kategóriákból lista létrehozása fa generáláshoz 	
     *
     * 	@return string html kód
     */
    public function get_category_tree() {
        $result = $this->get_subcategory(0);
        $list = '<ul>';
        foreach ($result as $value) {

            $list .= '<li>' . $value['product_category_name'] . ' (' . $this->product_number_in_category($value['product_category_id']) . ')';
            $list .= '<ul>';

            $sub_result = $this->get_subcategory($value['product_category_id']);

            foreach ($sub_result as $sub_value) {

                $list .= '<li>' . $sub_value['product_category_name'] . ' (' . $this->product_number_in_category($sub_value['product_category_id']) . ')';
                $list .= '<ul>';
                $sub_sub_result = $this->get_subcategory($sub_value['product_category_id']);

                foreach ($sub_sub_result as $sub_sub_value) {
                    $list .= '<li>' . $sub_sub_value['product_category_name'] . ' (' . $this->product_number_in_category($sub_sub_value['product_category_id']) . ')';
                    $list .= '<ul>';
                    $sub_sub_sub_result = $this->get_subcategory($sub_sub_value['product_category_id']);
                    foreach ($sub_sub_sub_result as $sub_sub_sub_value) {
                        $list .= '<li>' . $sub_sub_sub_value['product_category_name'] . ' (' . $this->product_number_in_category($sub_sub_sub_value['product_category_id']) . ')' . '</li>';
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

}

?>