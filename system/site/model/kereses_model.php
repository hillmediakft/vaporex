<?php

class Kereses_model extends Site_model {

    /**
     * Constructor, létrehozza az adatbáziskapcsolatot
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * 	Kersési kulcsszó alapján keresés
     *
     */
    public function search($search_term) {
        $arg = Util::clean_input($search_term);

        // keresés a referenciák között
/*        $this->query->reset();
        $this->query->debug(false);
        $this->query->set_table(array('references'));
        $this->query->set_columns('reference_id, reference_title_' . $this->registry->lang);

        $this->query->set_where('reference_description_' . $this->registry->lang, 'LIKE', '%' . urldecode($arg) . '%', 'and');
        $this->query->set_where('reference_title_' . $this->registry->lang, 'LIKE', '%' . urldecode($arg) . '%', 'or');
        $this->query->set_where('reference_status', '>', 0);


        $this->query->set_orderby(array('reference_id'), 'DESC');

        $result = $this->query->select();
        
        $reference_results_list = $this->generate_reference_results($result, 'reference_title_' . $this->registry->lang); */
        
        $this->query->reset();
        $this->query->debug(false);
        $this->query->set_table(array('blog'));
        $this->query->set_columns(array('blog_id', 'blog_title', 'blog_slug'));
        $this->query->set_where('blog_title', 'LIKE', '%' . urldecode($arg) . '%', 'or');
        $this->query->set_where('blog_body', 'LIKE', '%' . urldecode($arg) . '%', 'or');
        $this->query->set_orderby(array('blog_id'), 'DESC');

        $result = $this->query->select();
        
        $blog_results_list = $this->generate_blog_results($result, 'blog_title');
        
        
        // keresésé az oldalak között
        $this->query->reset();
        $this->query->debug(false);
        $this->query->set_table(array('pages'));
        $this->query->set_columns('page_friendlyurl, page_metatitle');

        $this->query->set_where('page_body', 'LIKE', '%' . urldecode($arg) . '%', 'and');
        $this->query->set_orderby(array('page_friendlyurl'), 'DESC');

        $result = $this->query->select(); 

        $pages_results_list = $this->generate_pages_results($result, 'page_metatitle');

        
        $result_list = array('Hírek/aktuális információk' => $blog_results_list, 'Oldalak' => $pages_results_list );
  //      $result_list = array_merge($blog_results_list, $pages_results_list );
        return array($result_list, $arg);
    }
    
    /**
     * 	Kersési kulcsszó alapján keresés
     *
     */
    public function generate_reference_results($result, $title_lang) {
        $list = array();
        foreach($result as $value) {
            $list[] = array(
                'title' => $value[$title_lang],
                'link' => BASE_URL . 'referenciak'
                );
         
        }
        return $list;
    }  
 
    /**
     * 	Kersési kulcsszó alapján keresés
     *
     */
    public function generate_blog_results($result, $title_lang) {
        $list = array();
        foreach($result as $value) {
            $list[] = array(
                'title' => $value[$title_lang],
                'link' => $this->registry->site_url . 'hirek/' . $value['blog_slug'] . '/' . $value['blog_id']
                );
         
        }
        return $list;
    }    
    
    /**
     * 	Kersési kulcsszó alapján keresés
     *
     */
    public function generate_pages_results($result, $title_lang) {
        $list = array();
        foreach($result as $value) {
            $slug = ($value['page_friendlyurl'] == 'home') ? '' : $value['page_friendlyurl'];
            $list[] = array(
                'title' => $value[$title_lang],
                'link' => BASE_URL . $slug
                );
         
        }

        return $list;
    }     

}
?>

