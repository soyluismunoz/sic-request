<?php

/*
Plugin Name: Sic Request
Plugin URI: https://github.com/soyluismunoz/sic-request
Description: Request by webservice https://sic.gov.co/
Author: Momoy developer team
Version: 1.0.0
Author URI: https://github.com/soyluismunoz
*/

defined('ABSPATH') or die("Bye bye");

require __DIR__ . '/vendor/autoload.php';

define('SR_URL', get_option('sr_url_request'));
define('SR_UBI_FORM', get_option('sr_ubi_form'));
define('SR_URI',  plugin_dir_url(__FILE__));


// Function to execute when activating the plugin 
function sr_activate_plugin()
{
	add_option( 'sr_url_request', 'https://wscundes.sic.gov.co/consultaCUNSIC_1.0.0/WSConsultaSIC/WSConsultaSIC?wsdl');
	add_option( 'sr_ubi_form', '#');
}

register_activation_hook( __FILE__, 'sr_activate_plugin' );

// Add option to dashboard menu 
function sr_addmenu() {

	add_menu_page( 	__( 'Sic request settings', 'sic-request' ),
					__( 'Sic request', 'sic-request' ),
			        'manage_options',
					'request-settings',
					'sr_settings'
			);
}

add_action( 'admin_menu', 'sr_addmenu' );

function sr_settings()
{
	if (isset($_POST['sr_url_request']) || isset($_POST['sr_ubi_form'])) {
        sr_set_option('sr_url_request', sanitize_text_field($_POST['sr_url_request']));
        sr_set_option('sr_ubi_form', sanitize_text_field($_POST['sr_ubi_form']));
        $success = true;

		$valueUrl = $_POST['sr_url_request'];
		$valueUbi = $_POST['sr_ubi_form'];
    }else{
		$valueUrl = SR_URL;
		$valueUbi = SR_UBI_FORM;
    }

	$title = "<h2>Configuración</h2>";

	$form = "<form action='' method='post'>";
	$form .= "<label> Url del web service </label><br>";
	$form .= "<input style='width: 500px;' type='text' placeholder='url del webservice' value='{$valueUrl}' name='sr_url_request'><br><hr>";
	$form .= "<label> Url donde estara ubicado el formulario </label><br>";
	$form .= "<input style='width: 500px;' type='text' placeholder='url del webservice' value='{$valueUbi}' name='sr_ubi_form'><br>";
	$form .= "<p class='submit'><input type='submit' name='submit' id='submit' class='button button-primary' value='Guardar'></p> </form>";
	$shortcode = "<label> Copia y pega el shortcode</label><br>";
	$shortcode .= "<input style='width: 500px;' type='text' placeholder='shortcode' value='[add_form_request]' >";


	if(isset($success) && $success){ 
    	echo "<div class='notice notice-success is-dismissible'><p>Cambios Guardados :)</p></div>";
    } 


	echo $title;
	echo $form;
	echo $shortcode;
}


// Run the query to the webservice
function sr_request()
{
	if (isset($_POST['table'])) {
		$wsdl   = SR_URL;

		try {
		    $client = new nusoap_client($wsdl, 'wsdl');
		    $client->soap_defencoding = 'UTF-8';
    		$client->decode_utf8 = FALSE;

		    $client->namespaces['dat'] = "http://ws.wso2.org/dataservice";

		    $action = "consultaCUN"; // webservice method name

		    $result = array();

		    $inputs = [
		        'identificadorOperador' => is_null($_POST['identificadorOperador'])	? 0 : intval($_POST['identificadorOperador']),
		        'anoRadicacionCun'      => is_null($_POST['anoRadicacionCun']) 		? 0 : intval($_POST['anoRadicacionCun']),
		        'ConsecutivoRadCun'     => is_null($_POST['ConsecutivoRadCun']) 	? 0 : intval($_POST['ConsecutivoRadCun']),
		        'numeroRadicacion'      => is_null($_POST['numeroRadicacion']) 		? 0 : intval($_POST['numeroRadicacion']),
		        'anoRadicacion'         => is_null($_POST['anoRadicacion']) 		? 0 : intval($_POST['anoRadicacion']),
		        'nombreOperador'        => is_null($_POST['nombreOperador']) 		? "%" : $_POST['nombreOperador'],
		        'tipoIdentificacion'    => is_null($_POST['tipoIdentificacion']) 	? "%" : $_POST['tipoIdentificacion'],
		        'numeroIdentificacion'  => is_null($_POST['numeroIdentificacion']) 	? 0 : intval($_POST['numeroIdentificacion']),
		    ];

		    $input = "<dat:consultaCUN>
		        <dat:identificadorOperador>{$inputs['identificadorOperador']}</dat:identificadorOperador>
		        <dat:anoRadicacionCun>{$inputs['anoRadicacionCun']}</dat:anoRadicacionCun>
		        <dat:ConsecutivoRadCun>{$inputs['ConsecutivoRadCun']}</dat:ConsecutivoRadCun>
		        <dat:numeroRadicacion>{$inputs['numeroRadicacion']}</dat:numeroRadicacion>
		        <dat:anoRadicacion>{$inputs['anoRadicacion']}</dat:anoRadicacion>
		        <dat:nombreOperador>{$inputs['nombreOperador']}</dat:nombreOperador>
		        <dat:tipoIdentificacion>{$inputs['tipoIdentificacion']}</dat:tipoIdentificacion>
		        <dat:numeroIdentificacion>{$inputs['numeroIdentificacion']}</dat:numeroIdentificacion>
		        </dat:consultaCUN>";

		    if (isset($action))
		    {
		        $result['response'] = $client->call($action, $input, $namespace = 'dat');
		    }
		} catch (nusoap_fault $e) {
		    echo $e->getMessage();
		}
	}
	
	include('form.php');
}

add_shortcode('add_form_request', 'sr_request' );

// Auxiliary functions
function sr_set_option($key = '', $value = '')
{
    if (!get_option($key) && !is_string(get_option($key))) {
        add_option($key, $value);
    } else {
        update_option($key, $value);
    }
}
