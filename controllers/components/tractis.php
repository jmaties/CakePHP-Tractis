<?php
/** 
 * tractis.php
 *
 * A CakePHP Component that will login the Auth session with Tractis. 
 *
 * Copyright 2009, Javier Maties - www.javiermaties.com
 * Licensed under The MIT License - Modification, Redistribution allowed but must retain the above copyright notice
 * @link 		http://www.opensource.org/licenses/mit-license.php
 *
 * @package	Tractis
 * @created	Aug 8, 2009
 * @version 	0.2
 * @link	http://github.com/jmaties/CakePHP-Tractis/tree/master
 * @changelog	http://www.javiermaties.com/sipuedo/2009/08/07/tractis-identity-verifications-con-el-componente-auth-de-cakephp/ 
 */
/* Constantes */
define('API_KEY', '676e36f302f87bcbbd0da2a88238b8cdf082ed6f');
define('URL_OK', 'http://localhost/admin/users/tractis');

class TractisComponent extends Object 
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

function validartractis($usuario, $auth, $tabla){

			if(!$auth->user()):
				$user_record =
                $tabla->find('first', array(
                    'conditions' => array('tracdni' => $usuario['dni']),
                    'fields' => array('User.tracdni', 'User.username', 'User.password'),
                    'contain' => array()
                ));

				if(empty($user_record)):
					$user_record['tracdni'] = $usuario['dni'];
					$user_record['realname'] = $usuario['name'];
					$user_record['trpassword'] = $this->__randomString();
					$user_record['password'] = $auth->password($user_record['trpassword']);

					$tabla->create();
					$tabla->save($user_record);
				endif;

				//change the Auth fields
				$auth->fields = array('username' => 'tracdni', 'password' => 'password');

				//log in the user with tractis credentials
				$auth->login($user_record);
			endif;
		}
		
private function __randomString($minlength = 20, $maxlength = 20, $useupper = true, $usespecial = false, $usenumbers = true){
        $charset = "abcdefghijklmnopqrstuvwxyz";
        if ($useupper) $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        if ($usenumbers) $charset .= "0123456789";
        if ($usespecial) $charset .= "~@#$%^*()_+-={}|][";
        if ($minlength > $maxlength) $length = mt_rand ($maxlength, $minlength);
        else $length = mt_rand ($minlength, $maxlength);
        $key = '';
        for ($i=0; $i<$length; $i++){
            $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];
        }
        return $key;
    }

}

?>