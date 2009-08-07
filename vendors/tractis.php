<?php
/* Constantes */
define('API_KEY', '676e36f302f87bcbbd0da2a88238b8cdf082ed6f');
//define('URL_OK', 'http://admin.javiermaties.com/users/tractis');
define('URL_OK', 'http://localhost/admin/users/tractis');
class Tractics
{
var $status;

function iniciar()
{
    $_GET['api_key'] = API_KEY;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $_GET);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, 'https://www.tractis.com/data_verification');
    curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
	if ($status==200) {
			$user_data = array(
				'name' => $_GET['tractis:attribute:name'],
				'dni' => $_GET['tractis:attribute:dni'],
				'issuer' => $_GET['tractis:attribute:issuer'],
			);	
		
			return $user_data;
		} else {
			return false;
		}
}

}

?>