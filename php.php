<?php 



function ndr_frm_field_shortcode_render($string,$yenidegerler=null){


// Düzenli ifade kullanarak "[]" içindeki değerleri ve bu değerlere göre değiştirme
$result = preg_replace_callback('/\[(\d+)\]/', function($matches) use ($yenidegerler) {
    $number = intval($matches[1]);
    // Değiştirme dizisinde ilgili numara varsa değiştir, yoksa aynı numarayı kullan
    return isset($yenidegerler[$number]) ? $yenidegerler[$number] : $matches[0];
}, $string);

// Değiştirilmiş metni ekrana yazdır
return $result;

}


$string = '{
    "Code":"[1]",
    "key":"[2]",
    "val":"[3]"
    }';
    
    // Verilen değerler
    $yenidegerler = [
        1 => "birinci",
       // 2 => "ikinci",
        3 => "üçüüncü",
    ];

echo ndr_frm_field_shortcode_render($string,$yenidegerler);