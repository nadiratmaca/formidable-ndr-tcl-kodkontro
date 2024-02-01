<?php

/**
 * Plugin Name:       Formidable (NDR) TCL Kod Kontrol 
 * Plugin URI:        https://nadiratmaca.com/wp-plugins
 * Description:       Bu eklenti Formidable Form eklentisi için TLC kampanya kodu  sorgulama özelliği kazandırmaktadır.
 * Version:           24.02.02.1
 * Requires PHP:      7.4
 * Author:            Nadir Atmaca
 * Author URI:        https://nadiratmaca.com
 * Text Domain:       formidable-ndr-kodkontrol
 * Domain Path:       /languages
 */
/*


1 // Code not presented
2 // Code not correct
3 // Unable to activate
4 // Already activated
5 // Code activated



5WPS4MDEYCHG
3F49GZTK7AUL
CSZJYI1F9LOH
LES0XA1HCWB4
LK346YFIUBHW
Q7CMLEFW5H39
NQRB41D6J3VG
M0QAX7OTC3FR
PT3SHEKOY9NA
IDCQTSWB3NEM
R5BKOE7CQL9Y
35OKCN2GUPYQ
RA08TN472UV6
5TUMQNHCXFRK
1QGELHW3V8Z7
F3CDV42TRO98
IYV07NH6C1ZL
UID8XSAZQB6J
FPCVJ7Y26B1N
3QJ0IM7B9YWD
RX12QKFPJW3E
D248HRVTSPB3

*/




defined('ABSPATH') or die('Bu dosya doğrudan  çalışmaz.');
function ndr_include($filePath=false){

  // $filePath=dirname( dirname( __FILE__ ) ) .'/'. $filePath;
  // echo $filePath;
//  if (file_exists($filePath)){
     
//   }  
 include_once($filePath);
}
/*
^([A-Z0-9]{12}+)$

*/



if (!defined('_NDR_TCL')) {
    defined('_NDR_TCL') or define('_NDR_TCL', TRUE);

    ndr_include('functions.php');
    ndr_include('service.php');



    add_action( 'admin_init', function (){
      ndr_include('FieldBackend.php');     
      
    },99);

    ndr_include('FieldFrontend.php');                 
 //   ndr_include('FormAction.php');

    




/*********************/
}