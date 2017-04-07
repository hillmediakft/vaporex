<?php

class Model {

    public $connect; //adatbazis csatlakozas objektuma
    public $query; //adatbaziskezelő objektumot rendeljük hozzá 
    public $registry; //registry objektum

    function __construct() {
        // adatbáziskapcsolat létrehozása
        $this->connect = db::get_connect();
        $this->registry = Registry::get_instance();

        // hozzárendeljük a query tulajdonsághoz a Query objektumot
        // ez a query tulajdonság a gyerek model-ek bármelyik metódusában elérhető
        // megkapja paraméterként az adatbáziskapcsolatot
        $this->query = new Query($this->connect);
    }

    function __destruct() {
        // adatbáziskapcsolat lezárása
        $this->connect = db::close_connect();
    }

    /**
     * Adat lekérdezése egy táblából 
     *
     * 	PÉLDA:
     * 	$args = array(
     * 		'table' => array('jobs'),
     * 		'columns' => array('jobs', 'users', 'slider'),
     * 		'limit' => 5,
     * 		'offset' => 3,
     * 		'orderby' => array(array(vezeteknev), DESC)
     * 	);
     * 
     * @param	array	$args		egy tömb, amiben megadjuk a lekérdezés paramétereit
     * @return 	array
     */
    public function get_data($args = array()) {
        $this->query->reset();

        if (isset($args['table'])) {
            $this->query->set_table($args['table']);
        }
        if (isset($args['columns'])) {
            $this->query->set_columns($args['columns']);
        } else {
            $this->query->set_columns('*');
        }
        if (isset($args['limit'])) {
            $this->query->set_limit($args['limit']);
        }
        if (isset($args['offset'])) {
            $this->query->set_offset($args['offset']);
        }
        if (isset($args['orderby'])) {
            $this->query->set_orderby($args['orderby']);
        }

        return $this->query->select();
    }

    /**
     * 	Az oldal adatait kérdezi le az adatbázisból (pages tábla)
     *
     * 	@param	$id String or Integer
     * 	@return	az adatok tömbben
     */
    public function page_data_query($page) {
        $this->query->reset();
        $this->query->set_table(array('pages'));
        $this->query->set_columns(array('page_id', 'page_title', 'page_body', 'page_friendlyurl', 'page_metatitle', 'page_metadescription', 'page_metakeywords'));
        $this->query->set_where('page_friendlyurl', '=', $page);

        return $this->query->select();
    }

    /**
     * 	A home oldal rólunk mondták (testimonials) slider-höz a szövegeket olvassa be
     *
     * 	@return	string a rólunk mondták slider html kódja
     */
    public function get_sidebar() {
        $gallery_slider = $this->get_gallery_slider();
        $testimonials = $this->get_testimonials();

        $this->query->reset();
        $this->query->set_table(array('content'));
        $this->query->set_columns(array('content_body'));
        $this->query->set_where('content_name', '=', 'sidebar');
        $result = $this->query->select();
        $content = $result[0]['content_body'];


        $content = str_replace('{$gallery_slider}', $gallery_slider, $content);
        $content = str_replace('{$testimonials}', $testimonials, $content);


        return $content;
    }

    /**
     * 	A home oldal rólunk mondták (testimonials) slider-höz a szövegeket olvassa be
     *
     * 	@return	string a rólunk mondták slider html kódja
     */
    public function get_testimonials() {

        $this->query->reset();
        $this->query->set_table(array('testimonials'));
        $this->query->set_columns(array('text', 'name', 'title'));
        $result = $this->query->select();

//		var_dump($result);
//		exit();

        $slider_html = '';
        $slider_html .= '<div id="myCarousel3" class="carousel testimonials slide">';
        $slider_html .= '<div class="carousel-inner"> ';
        $i = 0;

        foreach ($result as $value) {
            if ($i == 0) {
                $active = 'active';
            } else {
                $active = '';
            }
            $slider_html .= '<div class="item ' . $active . '">';
            $slider_html .= '<div>';
            $slider_html .= '<i>' . $value['text'] . '</i>';
            $slider_html .= '<p class="right"><span class="pull-right"><small><b>' . $value['name'] . '</b><br />' . $value['title'] . '</small></span></p>';
            $slider_html .= '</div>';
            $slider_html .= '</div>';
            $i = $i + 1;
        }
        $slider_html .= '</div>';
        $slider_html .= '</div>';


        return $slider_html;
    }

    /**
     * 	A home oldal képgaléria slider-höz a kiemelt képek adatait olvassa be
     *
     * 	@return	string a gallery slider html kódja
     */
    public function get_gallery_slider() {

        $this->query->reset();
        $this->query->set_table(array('photo_gallery'));
        $this->query->set_columns(array('photo_filename'));
        $this->query->set_where('photo_slider', '=', 1);
        $result = $this->query->select();

//		var_dump($result);
//		exit();

        $slider_html = '';
        $slider_html .= '<div id="myCarousel2" class="carousel slide marginbottom">';
        $slider_html .= '<div class="carousel-inner shadow">';
        $i = 0;

        foreach ($result as $value) {
            if ($i == 0) {
                $active = 'active';
            } else {
                $active = '';
            }
            $slider_html .= '<div class="item ' . $active . '">';
            $slider_html .= '<a href="kepgaleria"><img alt="" src=' . UPLOADS . $value['photo_filename'] . '></a>';
            $slider_html .= '</div>';
            $i = $i + 1;
        }
        $slider_html .= '</div>';
        $slider_html .= '<a class="left carousel-control" href="#myCarousel2" data-slide="prev">&lsaquo;</a> <a class="right carousel-control" href="#myCarousel2" data-slide="next">&rsaquo;</a>';
        $slider_html .= '</div>';

        return $slider_html;
    }

///////////////////////////////////////////////////////////////////////////////////
}

//osztály vége
?>