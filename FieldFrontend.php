<?php
defined('ABSPATH') or die('Bu dosya doğrudan çağırılarak çalışmaz.');

add_filter('frm_validate_field_entry', 'ndr_formidable_tcl_kod_validator', 10, 3);
function ndr_formidable_tcl_kod_validator($errors, $field, $value)
    {

    if ($field->type == 'type_kodkontrol') {
        /********
         echo "<pre>";
        print_r($value);
        echo "<hr>"; 
        print_r($field);
        echo "</pre>"; 
        echo "<hr>"; 
        echo $field->field_options['fld_kod'];
        /********** */

        $kod = trim($_POST['item_meta'][$field->field_options['fld_kod']]);

        $errorMesage = $field->field_options['error_kodkontrol'];

        if (ndr_tcl_kod_pre_valid($kod) == false) {

            $errors['field' . $field->id] = "Hatalı KOD! Lütfen SMS ile gelen kodu doğru girdiğinizi kontrol ediniz. ";;

            } else {


            $response       = ndr_formidable_tcl_servis_sorgula($kod);
            $HttpStatusCode = $response["status"];

            if ($response["code"] != 0) {
                if ($HttpStatusCode == 404) {

                    $errorMesage = "Kod Bulunamadı! Lütfen SMS ile gelen kodu doğru girdiğinizi kontrol ediniz.";

                    } else if ($HttpStatusCode > 499) {
                    $errorMesage = "Gecici bir sorun oluştu. Daha sonra yeniden deneyiniz.";

                    $subject = 'APRN-TCL-Kampanya servis : ' . $HttpStatusCode;
                    $body    = $subject . "<hr>";
                    $body .= '<pre>';
                    $body .= "<hr>Function : ndr_formidable_tcl_kod_validator ";
                    $body .= "<hr>SERVER info: " . var_export($_SERVER, true);
                    $body .= '</pre>';
                    ndr_send_mail($subject, $body);

                    }

                $errors['field' . $field->id] = $errorMesage;
                }


            }

        }

    return $errors;
    }

/**************************
Local Servis validasyon
*/

function ndr_formidable_tcl_servis_sorgula($kod = '')
    {

    $kod      = trim($kod);
    $response = [];
    if (ndr_tcl_kod_pre_valid($kod) == false) {
        return false;
        }
    #Cache kontrolü
    $cacheData = ndr_cacheGet($kod);
    if ($cacheData !== false) {
        $response = $cacheData["data"];

        } else {
        #Local Servis sorgusu 
        $endpoint = get_rest_url(null, 'tcl/v1/kod_kontrol/');
        $url      = $endpoint . $kod;
        $args     = array(
            'timeout'     => 10,
            'httpversion' => '1.1',
        );
        // $url="http://localhost";
        $request  = wp_remote_get($url, $args);
        $response = json_decode(wp_remote_retrieve_body($request), true);

        ndr_cacheSet($kod, $response);
        }


    return $response;
    return $response["data"] === true ? true : $response["status"];


    }






