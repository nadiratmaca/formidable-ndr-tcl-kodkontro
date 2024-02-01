<?php



defined('ABSPATH') or die('Bu dosya doğrudan çağırılarak çalışmaz.');

if(!function_exists("ndr_tr_uppercase")){
    function ndr_tr_uppercase($string)
    {
        $string= trim($string);
        $kucuk = array("ç", "i", "ı", "ğ", "ö", "ş", "ü");
        $buyuk = array("Ç", "İ", "I", "Ğ", "Ö", "Ş", "Ü");
        $string = str_replace($kucuk, $buyuk, $string);
        $string = strtoupper($string);
        return $string;
    }
<<<<<<< Updated upstream
}
=======

if (!function_exists("trace")) {
    function trace($content, $point = null, $echo = 0)
        {

        $ret = '<pre style="max-width:100%;font-size:12px;background-color:#f1f1f1;padding:10px;margin:5px;display:block; border:solid 1px gray;">';
        //$ret.= "<hr>";
        $ret .= '<strong style="color:red;">Point : </strong>' . ($point ? (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'].' # '.$point) : debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function']);
        $ret .=  $point ? '<br><strong style="color:red;">key : </strong> ' .$point :"";
        $ret .= "<br>";
        $ret .= '<strong style="color:red;">type : </strong> ' . gettype($content);
        $ret .= "<br>";
        $ret .= '<strong style="color:red;">value : </strong> ';
        $ret .= gettype($content) == "string" ? $content : (gettype($content) == "array" || gettype($content) == "object" ? print_r($content, true) : var_export($content, true));
        $ret .= "</pre>";
           echo $ret;
        return null;
        }
    }

>>>>>>> Stashed changes

/****************************************************************************************** */
if (!function_exists("ndr_frm_field_shortcode_render")) {
    function ndr_frm_field_shortcode_render($string,$yenidegerler=null){

<<<<<<< Updated upstream
if(!function_exists("ndr_tcl_kod_pre_valid")){
function ndr_tcl_kod_pre_valid($fld_kod)
{   
    $fld_kod=ndr_tr_uppercase($fld_kod);//Büyük Harf Dönüşümü
=======

        // Düzenli ifade kullanarak "[]" içindeki değerleri ve bu değerlere göre değiştirme
        $result = preg_replace_callback('/\[(\d+)\]/', function($matches) use ($yenidegerler) {
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
>>>>>>> Stashed changes

    $fld_kod=trim($fld_kod);     
    if (strlen($fld_kod) != 12) {return false;}
    $pattern = '/^[A-Z0-9]{12}$/';  
    return trim($fld_kod) == "" ? false : preg_match($pattern, $fld_kod);
 }
} 

/****************************************************************************************** */


<<<<<<< Updated upstream
if(!function_exists("ndr_TclCacheControl")){

    function ndr_TclCacheControl($kod,$cacheData=false){
    $expiration_time = (60*60)*4;



         if(trim($kod)=="") return false;

        $cacheDir=WP_CONTENT_DIR.'/cache_tcl/';
        $cacheFile=$cacheDir.$kod.".cache";
        if(!is_dir($cacheDir)) mkdir($cacheDir);
    

    if($cacheData!=false){ 
        echo "Cache Write<br>";
        return !file_put_contents($cacheFile,json_encode($cacheData)) ? false : $cacheData;
=======
if (!function_exists("ndr_cacheFile")) {
    function ndr_cacheFile($file = false)
        {
        $file      = $file ? $file : uniqid("cache_");
        $cacheDir  = WP_CONTENT_DIR . '/cache_tcl/';
        $cacheFile = $cacheDir . $file . ".cache";
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir);
            }

       if(isset($_GET["cachePurge"])) {@unlink($cacheFile);}
        return $cacheFile;
        }

    }


if (!function_exists("ndr_cacheGet")) {
    function ndr_cacheGet($file = false)
        {
        $cache_expiration_time = 10;
        $cacheFile             = ndr_cacheFile($file);

       

        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cache_expiration_time)) {
            // Önbellekteki veriyi oku ve geri döndür
            //echo "Cache DATA<br>";
            return json_decode(file_get_contents($cacheFile), true);
            } else {
            @unlink($cacheFile);
            return false;

            }
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

        $data_type = gettype($cacheData);
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
                if(json_last_error() == JSON_ERROR_NONE){
                    $cache['data'] = json_encode($cacheData);
                }                
                break;
            }


        $cacheFile = ndr_cacheFile($kod);
        return !file_put_contents($cacheFile, json_encode($cache));


        }

>>>>>>> Stashed changes
    }


 if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $expiration_time)) {
        // Önbellekteki veriyi oku ve geri döndür
        echo "Cache DATA<br>";
        return file_get_contents($cacheFile);
    }

return false;
    
    }

<<<<<<< Updated upstream
}

/*
$kod=2;
$data=false;
//$data=time();

if(!$data=ndr_TclCacheControl("TESTKOD".$kod)){
echo "sleep";
sleep(2);

$data=time();
var_dump(ndr_TclCacheControl("TESTKOD".$kod,$data));
}else{
echo $data;

}*/
=======
>>>>>>> Stashed changes
