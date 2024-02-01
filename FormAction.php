<?php 



/***************************************************************************************** */

add_action('frm_registered_form_actions', 'register_my_action');
function register_my_action( $actions ) {
    $actions['ndr_service_call'] = 'NdrActionServiceCall';
   
    class NdrActionServiceCall extends FrmFormAction {

        function __construct() {
            $action_ops = array(
                'classes'   => 'dashicons dashicons-airplane',
                'limit'     => 10,
                'active'    => true,
                'priority'  => 50,
                'event'  => array( 'create', 'update', 'delete' ),
            );
            
            $this->FrmFormAction('ndr_service_call', __('APRON TCL-Bilkom Servis', 'formidable'), $action_ops);
        }
    
        /**
        * Get the HTML for your action settings
        */
        function form( $form_action, $args = array() ) {
            extract($args);
            $action_control = $this;
    ?>
            <table class="form-table frm-no-margin">
            <tbody>
            <tr>
                <th>
                    <label>Servis URL</label>
                </th>
                <td>
                    <input type="text" class="large-text" value="<?php echo esc_attr($form_action->post_content['service_url']); ?>" name="<?php echo $action_control->get_field_name('service_url') ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label>Methot</label>
                </th>
                <td>
                    
                <input type="text" class="large-text" placeholder="POST or GET" value="<?php echo esc_attr($form_action->post_content['service_methot']); ?>" name="<?php echo $action_control->get_field_name('service_methot') ?>">
                </td>
            </tr>   <tr>
                <th>
                    <label>Basic Auth (user:pass)</label>
                </th>
                <td>
                <input type="text" class="large-text" placeholder="user:password" value="<?php echo esc_attr($form_action->post_content['service_auth']); ?>" name="<?php echo $action_control->get_field_name('service_auth') ?>">
                </td>
            </tr>   <tr>
                <th>
                    <label>HTTP Header </label>
                </th>
                <td>
                    <textarea class="large-text" rows="5" cols="50" placeholder="Authorization: Basic Ymlsa2tnNlZpc3NnQ6YXZW5hbDo=&#10;Content-Type: application/json;charset=utf-8&#10;header_key: header_value&#10;  ..." name="<?php echo $action_control->get_field_name('service_header') ?>" id="<?php echo esc_attr( $this->get_field_id( 'service_header' ) ); ?>" ><?php echo esc_attr($form_action->post_content['service_header']); ?></textarea>
                    <div>Her bir satıra ayrı hader "key:value" şeklinde giriniz.</div>
                </td><tr>
                    
                <th>
                    <label>Data (Raw-Json)</label>
                </th>
                <td><p class="frm_has_shortcodes">
                    <textarea class="large-text" rows="5" cols="50" placeholder="Json Format : {key:value ...}" name="<?php echo $action_control->get_field_name('service_body') ?>" id="<?php echo esc_attr( $this->get_field_id( 'service_body' ) ); ?>" ><?php echo esc_attr($form_action->post_content['service_body']); ?></textarea></p>
                </td>
            </tr>  
            </tbody>
            </table>
    
            // If you have scripts to include, you can include them here
    <?php
        }
        
        /**
        * Add the default values for your options here
        */
        function get_defaults() {
            return array(
                'service_url' => '',
                'service_methot'=> 'GET',
                'service_auth'=> '',
                'service_header'=> 'Content-Type: application/json;charset=utf-8',
                'service_body'=> '',
            );
        }
    }
    
    return $actions;
}


add_action('frm_trigger_ndr_service_call_create_action', 'ndr_service_create_action_trigger', 10, 3);
function ndr_service_create_action_trigger($action, $entry, $form) {


     trace($action->post_content,"action");
     trace($entry,"entry");

   //  trace(do_shortcode($action->post_content['service_body']));
    // trace($_REQUEST);

     $service_body=ndr_frm_field_shortcode_render($action->post_content['service_body'],$entry->metas);
trace(json_decode($service_body));
trace(base64_encode($entry->name));
trace($action->post_content['service_url']);
trace(json_decode($service_body));
trace(json_decode($service_body));
    
//arsenalcampaign_kod_activate(base64_encode($entry->name),$action->post_content['service_url'],$service_body);

}



function arsenalcampaign_kod_activate($kod,$url,$body) {

    $url='https://api.servissoft.net/v1/bilkom/arsenalcampaign_validate';
   $body = wp_json_encode(array( "Code"=> $kod ));

    try{
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 3,
      CURLOPT_TIMEOUT => 5,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>$body,
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic Ymlsa29tOnNlcnZpc3NvZnQ6YXJzZW5hbDo=',
        'Content-Type: application/json'
      ),
    ));
    
    $response=json_decode(curl_exec($curl));   
    $response->CurlInfo = curl_getinfo($curl);
    // $response->HttpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
   // trace($response);

    ndr_cacheSet("activecode_".$kod,$response);
       
    return true;
    }catch(Exception $e){
        // throw new Exception("Invalid URL OR CURL error",0,$e);
    }
    
    return true;
    
    }