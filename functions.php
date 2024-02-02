<?php



defined('ABSPATH') or die('Bu dosya doğrudan çağırılarak çalışmaz.');


if (!function_exists("ndr_array_over")) {
    function ndr_array_over($sablon, $veri, $type=false)
    {
    $return = [];

    // İki diziyi birleştir
    $return = array_merge((array) $sablon, (array) $veri);
    // Anahtarları kontrol et
    $return = array_intersect_key($return, (array) $sablon);

    return !$type ? (array) $return : (object) $return;
    }

}


if (!function_exists("ndr_tr_uppercase")) {
    function ndr_tr_uppercase($string)
        {
        $string = trim($string);
        $kucuk  = array("ç", "i", "ı", "ğ", "ö", "ş", "ü");
        $buyuk  = array("Ç", "İ", "I", "Ğ", "Ö", "Ş", "Ü");
        $string = str_replace($kucuk, $buyuk, $string);
        $string = strtoupper($string);
        return $string;
        }

    }

if (!function_exists("ndr_send_mail")) {
    function ndr_send_mail($subject = false, $body = "")
        {
        $to      = 'nadiratmaca@gmail.com';
        $subject = $subject ? $subject : 'APRN-TCL-Kampanya ';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        return wp_mail($to, $subject, $body, $headers);
        }
    }

if (!function_exists("trace")) {
    function trace($content, $point = null, $echo = 0)
        {


        ob_start(); // Tamponlamayı başlat    
        $backtrace = debug_backtrace();
        $caller    = $backtrace[0]; // Çağıran fonksiyon bilgisini al

        $ret = '<pre style="max-width:100%;font-size:12px;background-color:#f1f1f1;padding:10px;margin:5px;display:block; border:solid 1px gray;">';
        //$ret.= "<hr>";
        $ret .= '<strong style="color:red;">Point : </strong>' . ($point ? (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0]['function'] . ' # ' . $point) : debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0]['function']);
        $ret .= $point ? '<br><strong style="color:red;">key : </strong> ' . $point : "";
        $ret .= "<br>";
        $ret .= "Caller: {$caller['function']} in {$caller['file']} on <strong>line {$caller['line']}</strong>";
        $ret .= "<br>";
        $ret .= '<strong style="color:red;">type : </strong> ' . gettype($content);
        $ret .= "<br>";
        $ret .= '<strong style="color:red;">value : </strong> ';
        $type=gettype($content);
        $ret .=  $type == "string" ? $content : ($type == "array" ? print_r($content, true) : var_export($content, true));
        $ret .= "<hr>";
        //$ret .= print_r($backtrace[1], true);

        $ret .= "</pre>";
        echo $ret;
        ob_end_flush(); // Tamponu boşalt ve çıktıyı gönder

        }
    }



/****************************************************************************************** */
if (!function_exists("ndr_frm_field_shortcode_render")) {
    function ndr_frm_field_shortcode_render($string, $yenidegerler = null)
        {

        // Düzenli ifade kullanarak "[]" içindeki değerleri ve bu değerlere göre değiştirme
        $result = preg_replace_callback('/\[(\d+)\]/', function ($matches) use ($yenidegerler) {
            $number = intval($matches[1]);
            // Değiştirme dizisinde ilgili numara varsa değiştir, yoksa aynı numarayı kullan
            return isset($yenidegerler[$number]) ? $yenidegerler[$number] : $matches[0];
            }, $string);

        // Değiştirilmiş metni ekrana yazdır
        return $result;

        }

    }
/************************************************************************************* */
if (!function_exists("ndr_tcl_kod_pre_valid")) {
    function ndr_tcl_kod_pre_valid($fld_kod)
        {
        $fld_kod = ndr_tr_uppercase($fld_kod); //Büyük Harf Dönüşümü


        $fld_kod = trim($fld_kod);
        if (strlen($fld_kod) != 12) {
            return false;
            }
        $pattern = '/^[A-Z0-9]{12}$/';
        return trim($fld_kod) == "" ? false : preg_match($pattern, $fld_kod);
        }
    }

/****************************************************************************************** */


if (!function_exists("ndr_cacheFile")) {
    function ndr_cacheFile($file = false)
        {
        $file      = $file ? $file : uniqid("cache_");
        $cacheDir  = WP_CONTENT_DIR . '/cache_tcl/';
        $cacheFile = $cacheDir . $file . ".cache";
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir);
            }

        // if (isset($_REQUEST["cachePurge"])) {
        //     @unlink($cacheFile);
        //     return false;
        //     }

        return $cacheFile;
        }

    }


if (!function_exists("ndr_cacheGet")) {
    function ndr_cacheGet($file = false)
        {
        $cache_expiration_time = (60*60)*6;
        $cacheFile             = ndr_cacheFile($file);



        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cache_expiration_time)) {
            // Önbellekteki veriyi oku ve geri döndür
            //echo "Cache DATA<br>";
            return json_decode(file_get_contents($cacheFile), true);
            } else {
            @unlink($cacheFile);
            return false;

            }

        // if (isset($_REQUEST["cachePurge"])) {
        //     @unlink($cacheFile);
        //     return false;
        //     }

        return $cacheFile;
        }

    }


if (!function_exists("ndr_cacheSet")) {
    function ndr_cacheSet($kod, $cacheData = null)
        {

        if ($cacheData === null) {
            return false;
            }


        $cache = array(
            "timestamp" => time(),
            "timeout"   => 10,
            'date'      => date('Y-m-d H:i:s'),
            'data'      => $cacheData,
        );

        $data_type     = gettype($cacheData);
        $cache['data'] = $cacheData;
        switch ($data_type) {
            case 'array':
                //$cache['data'] = json_encode($cacheData);
                break;
            case 'object':
                //
                break;
            case 'string':
                json_encode($cacheData);
                if (json_last_error() == JSON_ERROR_NONE) {
                    $cache['data'] = json_encode($cacheData);
                    }
                break;
            }


        $cacheFile = ndr_cacheFile($kod);

        // if (isset($_REQUEST["cachePurge"])) {
        //     @unlink($cacheFile);
        //     return false;
        //     }

        return !file_put_contents($cacheFile, json_encode($cache));


        }
    }

