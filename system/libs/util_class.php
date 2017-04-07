<?php

class Util {

    /**
     * Redirects to another page.
     *
     * @param string $location The path to redirect to
     * @param int $status Status code to use
     * @return bool False if $location is not set
     */
    public static function redirect($location, $status = 302) {
        $registry = Registry::get_instance();

        if ($location == '') {
            header("Location: " . $registry->site_url, true, $status);
            exit;
        }

        header("Location: " . $registry->site_url . $location, true, $status);
        exit;
    }

    /**
     * Ellenőrzi, hogy a Ajax hívás történt-e
     *
     * @return bool true|false
     */
    public static function is_ajax() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            return true;
        }
        return false;
    }

    /**
     * 	File törlése
     *
     * 	@param	$filename	a törlendő file elérésiútja mappa/filename.ext
     * 	@return	true|false
     */
    public static function del_file($filename) {
        if (is_file($filename)) {
            //ha a file megnyitható és írható
            if (is_writable($filename)) {
                unlink($filename);
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Egy kép elérési útvonalából generál egy elérési útvonalat a bélyegképéhez
     * Minta: path/to/file/filename.jpg -> path/to/file/filename_thumb.jpg
     * 
     * @param	string	$path (a file elérési útja)
     * @param	bool	$thumb (hozzárak az elérési út végéhez egy thumb mappát)
     * @return	string	a bélyegkép elérési útvonala
     */
    public static function thumb_path($path, $thumb = false) {
        $path_parts = pathinfo($path);
        $dirname = $path_parts['dirname'];
        $filename = $path_parts['filename'];
        $extension = $path_parts['extension'];

        if (!$thumb) {
            if (($dirname == '.') || ($dirname == '\\')) {
                $path_with_thumb = $filename . '_thumb.' . $extension;
            } else {
                $path_with_thumb = $dirname . '/' . $filename . '_thumb.' . $extension;
            }
        } else {
            if (($dirname == '.') || ($dirname == '\\')) {
                $path_with_thumb = 'thumb/' . $filename . '_thumb.' . $extension;
            } else {
                $path_with_thumb = $dirname . '/thumb/' . $filename . '_thumb.' . $extension;
            }
        }
        return $path_with_thumb;
    }

    /**
     * Egy kép elérési útvonalából generál egy elérési útvonalat a nagyobb bélyegképéhez (small
     * Minta: path/to/file/filename.jpg -> path/to/file/filename_small.jpg
     * 
     * @param	string	$path (a file elérési útja)
     * @param	bool	$small (hozzárak az elérési út végéhez egy thumb mappát)
     * @return	string	a bélyegkép elérési útvonala
     */
    public static function small_path($path, $small = false) {
        $path_parts = pathinfo($path);
        $dirname = $path_parts['dirname'];
        $filename = $path_parts['filename'];
        $extension = $path_parts['extension'];

        if (!$small) {
            if (($dirname == '.') || ($dirname == '\\')) {
                $path_with_small = $filename . '_small.' . $extension;
            } else {
                $path_with_small = $dirname . '/' . $filename . '_small.' . $extension;
            }
        } else {
            if (($dirname == '.') || ($dirname == '\\')) {
                $path_with_thumb = 'small/' . $filename . '_small.' . $extension;
            } else {
                $path_with_small = $dirname . '/small/' . $filename . '_small.' . $extension;
            }
        }
        return $path_with_small;
    }

    /**
     * 	Visszaadja a jelenlegi url-t a paraméterben megadott nyelvi kóddal módosítva
     *
     * 	@param	String	$lang_code	(nyelvi kód)
     * 	@return	String
     */
    public static function url_with_language($lang_code = 'hu') {
        $registry = Registry::get_instance();
        $lang = ($lang_code == 'hu') ? '' : $lang_code . '/';
        $area = ($registry->area == 'site') ? '' : $registry->area . '/';
        return BASE_URL . $area . $lang . $registry->uri;
    }

    /**
     * Spamektől védett e-mail linket generál Javascripttel
     *
     * @param	string	$email: e-mail cím
     * @param	string	$title: title
     * @param	mixed	$attributes: attribútumok
     * @return	string
     */
    public static function safe_mailto($email, $title = '', $attributes = '') {
        $title = (string) $title;

        if ($title == "") {
            $title = $email;
        }

        for ($i = 0; $i < 16; $i++) {
            $x[] = substr('<a href="mailto:', $i, 1);
        }

        for ($i = 0; $i < strlen($email); $i++) {
            $x[] = "|" . ord(substr($email, $i, 1));
        }

        $x[] = '"';

        if ($attributes != '') {
            if (is_array($attributes)) {
                foreach ($attributes as $key => $val) {
                    $x[] = ' ' . $key . '="';
                    for ($i = 0; $i < strlen($val); $i++) {
                        $x[] = "|" . ord(substr($val, $i, 1));
                    }
                    $x[] = '"';
                }
            } else {
                for ($i = 0; $i < strlen($attributes); $i++) {
                    $x[] = substr($attributes, $i, 1);
                }
            }
        }

        $x[] = '>';

        $temp = array();
        for ($i = 0; $i < strlen($title); $i++) {
            $ordinal = ord($title[$i]);

            if ($ordinal < 128) {
                $x[] = "|" . $ordinal;
            } else {
                if (count($temp) == 0) {
                    $count = ($ordinal < 224) ? 2 : 3;
                }

                $temp[] = $ordinal;
                if (count($temp) == $count) {
                    $number = ($count == 3) ? (($temp['0'] % 16) * 4096) + (($temp['1'] % 64) * 64) + ($temp['2'] % 64) : (($temp['0'] % 32) * 64) + ($temp['1'] % 64);
                    $x[] = "|" . $number;
                    $count = 1;
                    $temp = array();
                }
            }
        }

        $x[] = '<';
        $x[] = '/';
        $x[] = 'a';
        $x[] = '>';

        $x = array_reverse($x);
        ob_start();
        ?><script type="text/javascript">
            //<![CDATA[
            var l = new Array();
        <?php
        $i = 0;
        foreach ($x as $val) {
            ?>l[<?php echo $i++; ?>] = '<?php echo $val; ?>';<?php } ?>

                for (var i = l.length - 1; i >= 0; i = i - 1) {
                    if (l[i].substring(0, 1) == '|')
                        document.write("&#" + unescape(l[i].substring(1)) + ";");
                    else
                        document.write(unescape(l[i]));
                }
                //]]>
        </script><?php
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    /**
     * 	Ékezetes karaktereket és a szóközt cseréli le ékezet nélkülire és alulvonásra
     * 	minden karaktert kisbetűre cserél
     */
    public static function string_to_slug($string) {
        $accent = array(",", "(", ")", "?", "!", ".", ":", "&", " ", "_", "á", "é", "í", "ó", "ö", "ő", "ú", "ü", "ű", "Á", "É", "Í", "Ó", "Ö", "Ő", "Ú", "Ü", "Ű");
        $no_accent = array('', '-', '-', '', '', '-', '-', '-', '-', '-', 'a', 'e', 'i', 'o', 'o', 'o', 'u', 'u', 'u', 'A', 'E', 'I', 'O', 'O', 'O', 'U', 'U', 'U');
        $string = str_replace($accent, $no_accent, $string);
        $string = strtolower($string);
        return $string;
    }

    /**
     * Az angol nónapokat cseréli le magyar hónap nevekre
     * 
     * @param   string  $string a dátum 
     * @return  string  a dátum magyra hónap nevekkel
     */
    public static function hun_month($string) {
        $eng = array('january', 'January', 'february', 'February', 'march', 'March', 'april', 'April', 'may', 'May', 'june', 'June', 'july', 'July', 'august', 'August', 'september', 'September', 'october', 'October', 'november', 'November', 'december', 'December');
        $hun = array('január', 'Január', 'február', 'Február', 'március', 'Március', 'április', 'Április', 'május', 'Május', 'június', 'Június', 'július', 'Július', 'augusztus', 'Augusztus', 'szeptember', 'Szeptember', 'október', 'Október', 'november', 'November', 'december', 'December');
        $string = str_replace($eng, $hun, $string);
        return $string;
    }

    /**
     * E-mail küldés a simple_mail class-szal
     *
     * @param	string	$címzett: a címzett e-mail címe
     * @param	string	$subject: a tárgy
     * @return	string
     */
    public static function send_mail($cimzett, $subject) {

        include('system/libs/simple_mail_class.php');


        $mail = new SimpleMail();
        $mail->setTo($cimzett, 'Megajátszóhaz');
        $mail->setSubject($subject);
        $mail->setFrom($_POST['email'], $_POST['name']);
        $mail->addMailHeader('Reply-To', $_POST['email'], $_POST['name']);
        $mail->addGenericHeader('MIME-Version', '1.0');
        $mail->addGenericHeader('Content-Type', 'text/html; charset="utf-8"');
        $mail->addGenericHeader('X-Mailer', 'PHP/' . phpversion());

        $mail->setMessage(
                '<html>' .
                '<body>' .
                '<p>Üzenet érkezett a Megajátszóház weboldaltól:</p>' .
                '<table>' .
                '<tr><td><strong>Név: </strong></td><td>' . $_POST['name'] . '</td></tr>' .
                '<tr><td><strong>E-mail: </strong></td><td>' . $_POST['email'] . '<td></tr>' .
                '<tr><td><strong>Üzenet: </strong></td><td>' . $_POST['message'] . '<td></tr>' .
                '</table>' .
                '</body>' .
                '</html>'
        );

        $mail->setWrap(100);
        $send = $mail->send();
        if ($send) {
            echo 'sent';
        } else {
            echo 'fail';
        }
    }

    /**
     * A fájl nevéhez hozzáilleszt egy query stringet (pl: style.css?v=2314564321
     * A szám a fájl utolsó módosításának timestamp-je
     *  
     * @param   string  $uri  a file elérési útvonala pl.: valami,hu/public/site_assets/css/style.css
     * @return  string  a fájl verzióval ellátott elérési útvonala
     */
    public static function auto_version($uri) {
        if (substr($uri, 0, 1) == "/") {
            // relatív URI
            $fname = $_SERVER["DOCUMENT_ROOT"] . $uri;
        } else {
            // abszolút URI
            $fname = $uri;
        }
        $ftime = filemtime($fname);
        return $uri . '?v=' . $ftime;
    }

    public static function convert_array_to_utf8($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = self::convert_array_to_utf8($v);
            }
        } else if (is_string($d)) {
            return mb_convert_encoding($d, "UTF8", "auto");
        }
        return $d;
    }

    /**
     * Egy szövegből adott karakterszámú rész ad vissza szóra kerekítve
     *  
     * @param   int  $char  karakterek száma
     * @return  string  a levágott szöveg
     */
    public static function substr_word($string, $char) {
        $s = mb_substr($string, 0, $char, 'UTF-8');
        $result = substr($s, 0, strrpos($s, ' '));
        return $result;
    }

    /**
     * Egy szövegből adott karakterszámú rész ad vissza szóra kerekítve
     *  
     * @param   int  $char  karakterek száma
     * @return  string  a levágott szöveg
     */
    static function sentence_trim($body, $sentencesToDisplay = 1) {
        $nakedBody = preg_replace('/\s+/', ' ', strip_tags($body));
        $sentences = preg_split('/(\.|\?|\!)(\s)/', $nakedBody);

        if (count($sentences) <= $sentencesToDisplay)
            return $nakedBody;

        $stopAt = 0;
        foreach ($sentences as $i => $sentence) {
            $stopAt += strlen($sentence);

            if ($i >= $sentencesToDisplay - 1)
                break;
        }

        $stopAt += ($sentencesToDisplay * 2);
        return trim(substr($nakedBody, 0, $stopAt));
    }

    public static function outputFile($file, $name, $mime_type = '') {
        if (!is_readable($file))
            die('File not found or inaccessible!');
        $size = filesize($file);
        $name = rawurldecode($name);
        $known_mime_types = array(
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "doc" => "application/msword",
            "jpg" => "image/jpg",
            "php" => "text/plain",
            "xls" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "png" => "image/png",
            "jpeg" => "image/jpg"
        );

        if ($mime_type == '') {
            $file_extension = strtolower(substr(strrchr($file, "."), 1));
            if (array_key_exists($file_extension, $known_mime_types)) {
                $mime_type = $known_mime_types[$file_extension];
            } else {
                $mime_type = "application/force-download";
            };
        };
        @ob_end_clean();
        if (ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');

        if (isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
            list($range) = explode(",", $range, 2);
            list($range, $range_end) = explode("-", $range);
            $range = intval($range);
            if (!$range_end) {
                $range_end = $size - 1;
            } else {
                $range_end = intval($range_end);
            }

            $new_length = $range_end - $range + 1;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range-$range_end/$size");
        } else {
            $new_length = $size;
            header("Content-Length: " . $size);
        }

        $chunksize = 1 * (1024 * 1024);
        $bytes_send = 0;
        if ($file = fopen($file, 'r')) {
            if (isset($_SERVER['HTTP_RANGE']))
                fseek($file, $range);

            while (!feof($file) &&
            (!connection_aborted()) &&
            ($bytes_send < $new_length)
            ) {
                $buffer = fread($file, $chunksize);
                echo($buffer);
                flush();
                $bytes_send += strlen($buffer);
            }
            fclose($file);
        } else
            die('Error - can not open file.');
        die();
    }

    static function group_array_by_field($array, $field) {
        $group = array();

        foreach ($array as $value) {
            $group[$value[$field]][] = $value;
        }
        return $group;
    }
    
    public static function clean_input($input) {

        $search = array(
            '@<script[^>]*?>.*?</script>@si', // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
        );

        $output = preg_replace($search, '', $input);
        return $output;
    }    

}
?>