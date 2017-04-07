<?php

class Kalkulator extends Site_controller {

    function __construct() {
        parent::__construct();
        $this->loadModel('kalkulator_model');
    }

    public function index() {
        $this->view->js_link[] = $this->make_link('js', '', Util::auto_version(SITE_JS . 'pages/kalkulator.js'));

        // oldal tartalmának lekérdezése (paraméter a pages tábla page_id)
        $this->view->content = $this->kalkulator_model->get_page_data('kalkulator');
        $this->view->title = $this->view->content['page_metatitle'];
        $this->view->description = $this->view->content['page_metadescription'];
        $this->view->keywords = $this->view->content['page_metakeywords'];
        $this->view->content = $this->view->content['page_body'];

// $this->view->debug(true); 

        $this->view->render('kalkulator/tpl_kalkulator');
    }

    public function ajax() {
        $data = $_POST;



        $html = file_get_contents('system/site/view/kalkulator/tpl_ajax_response.php');

        /*         * ************ felhasználás célja: minőségi vakolással megelőzni a falnedvességi problémákat *********** */
        /*         * ****************************************************************************************************** */

        /*         * ********************** Goldmix ************************ */
        if ($data['felhcel'] == 1 && $data['kulter_belter'] == 1 && $data['esohely'] == 1 && $data['hely'] == 1) {
            $mennyiseg = 0.08 * $data['terulet'] * $data['vakolat_vastagsag'];
            $ar = 188.32 * $data['terulet'] * $data['vakolat_vastagsag'];
            $termek = 'Goldmix-re';
            $html = $this->contentReplace($mennyiseg, $ar, $termek, $html);
        } elseif (
        /*         * ********************** Mészpótló ************************ */
                $data['felhcel'] == 1 && $data['kulter_belter'] == 1 && $data['esohely'] == 2 && $data['hely'] == 1) {
            $mennyiseg = 0.02 * $data['terulet'] * $data['vakolat_vastagsag'];
            $ar = 31.32 * $data['terulet'] * $data['vakolat_vastagsag'];
            $termek = 'Mészpótlóra';

            $html = $this->contentReplace($mennyiseg, $ar, $termek, $html);
        } elseif (
        /*         * ********************** C+M ************************ */
                $data['felhcel'] == 1 && $data['kulter_belter'] == 2 && $data['falszarito'] == 1 && $data['hely'] == 1) {
            $mennyiseg = 0.025 * $data['terulet'] * $data['vakolat_vastagsag'];
            $ar = 62.775 * $data['terulet'] * $data['vakolat_vastagsag'];
            $termek = 'C+M-re';

            $html = $this->contentReplace($mennyiseg, $ar, $termek, $html);
        } elseif (
        /*         * ********************** Hidro ************************ */
                $data['felhcel'] == 1 && $data['kulter_belter'] == 1 && ($data['esohely'] == 1 || $data['esohely'] == 2) && $data['hely'] == 2) {
            $mennyiseg = 0.055 * $data['terulet'] * $data['vakolat_vastagsag'];
            $ar = 116.49 * $data['terulet'] * $data['vakolat_vastagsag'];
            $termek = 'Hidro-ra';

            $html = $this->contentReplace($mennyiseg, $ar, $termek, $html);
        } elseif (
        /*         * ********************** C+M ************************ */
                $data['felhcel'] == 1 && $data['kulter_belter'] == 2 && $data['falszarito'] == 1 && $data['hely'] == 3) {
            $mennyiseg = 0.025 * $data['terulet'] * $data['vakolat_vastagsag'];
            $ar = 62.775 * $data['terulet'] * $data['vakolat_vastagsag'];
            $termek = 'C+M-re';

            $html = $this->contentReplace($mennyiseg, $ar, $termek, $html);
        } elseif (
        /*         * ********************** C+M ************************ */
                $data['felhcel'] == 1 && $data['kulter_belter'] == 2 && $data['falszarito'] == 2 && $data['hely'] == 3
        ) {
            $mennyiseg = 0.08 * $data['terulet'] * $data['vakolat_vastagsag'];
            $ar = 188.32 * $data['terulet'] * $data['vakolat_vastagsag'];
            $termek = 'Goldmix-re';

            $html = $this->contentReplace($mennyiseg, $ar, $termek, $html);
        }

        echo $html;
    }

    public function contentReplace($mennyiseg, $ar, $termek, $html) {
        $html = str_replace('{{mennyiseg}}', $mennyiseg, $html);
        $html = str_replace('{{ar}}', $ar, $html);
        $html = str_replace('{{termek}}', $termek, $html);
        return $html;
    }

}

?>