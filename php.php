<?php



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

//echo ndr_frm_field_shortcode_render($string,$yenidegerler);


function ndr_array_over($sablon, $veri, $type=false)
    {
    $return = [];

    // İki diziyi birleştir
    $return = array_merge((array) $sablon, (array) $veri);
    // Anahtarları kontrol et
    $return = array_intersect_key($return, (array) $sablon);

    return !$type ? (array) $return : (object) $return;
    }



$sablon = [
    'service_url'    => '',
    'service_methot' => 'GET',
    'service_auth'   => '',
    'service_header' => 'Content-Type: application/json;charset=utf-8',
    'service_body'   => '',
];

$veri = [
    'service_url'    => 'http://deneme',
    'service_methot' => 'POST',
    'service_auth'   => 'Basic',

];

//var_dump(ndr_array_over($sablon, $veri));




$metin = "Content-Type: application/json;charset=utf-8
Authorization: Basic Ymlsa29tOnNlcnZpc3NvZnQ6YXJzZW5hbDo=
X-header: header değeri";

// Her satırı dizi elemanına dönüştür
$metinDizisi = explode("\n", $metin);

// Boş satırları kaldır
$metinDizisi = array_filter(array_map('trim', $metinDizisi));

// Her bir satırı anahtar ve değer olarak ayır
$sonucDizisi = [];
foreach ($metinDizisi as $satir) {
    list($anahtar, $deger) = explode(': ', $satir, 2);
    $sonucDizisi[$anahtar] = $deger;
}

// Sonucu yazdır
print_r($sonucDizisi);