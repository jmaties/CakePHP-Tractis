<?php
/** 
 * tractis_login.php
 *
 * A CakePHP Component that will login the Auth session with Tractis. 
 *
 * Copyright 2009, Javier Maties - www.javiermaties.com
 * Licensed under The MIT License - Modification, Redistribution allowed but must retain the above copyright notice
 * @link	http://www.opensource.org/licenses/mit-license.php
 *
 * @package	Tractis
 * @created	Aug 8, 2009
 * @version 0.3 Aug 12, 2009
 * @link	http://github.com/jmaties/CakePHP-Tractis/tree/master
 * @changelog	http://www.javiermaties.com/sipuedo/2009/08/07/tractis-identity-verifications-con-el-componente-auth-de-cakephp/ 
 *
 * Modificaciones:
 *	0.3:
 *		- Cambio de nombre tractis -> tractislogin
 *		- Todas las operaciones se realizan ahora desde el propio componente
 */
/* Constantes */
define('API_KEY', '19aaf0d1fa79f5dc0b0ebeefd02923e6f72d81d7');
define('URL_OK', 'http://tractis.javiermaties.com/users/tractis');

class TractisLoginComponent extends Object 
{
var $components = array('Auth','Session');  


function initialize(&$controller) {
        $this->controller = $controller;
		if ($controller->Auth->user()) {
            // already authenticated
            return;
        } else {
		$usuario = $this->__iniciar();
		if ($usuario){
			$this->validar($usuario);
			$controller->redirect($this->Auth->redirect());
		} 
		}
}


private function __iniciar()
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


function validar($usuario){
// find the user
        App::import('Model', 'Users');
         $User = new User();
				$user_record =
                $User->find('first', array(
                    'conditions' => array('tracdni' => $usuario['dni']),
                    'fields' => array('User.tracdni', 'User.username', 'User.password'),
                    'contain' => array()
                ));

				if(empty($user_record)):
					$user_record['tracdni'] = $usuario['dni'];
					$user_record['realname'] = $usuario['name'];
					$user_record['trpassword'] = $this->__randomString();
					$user_record['password'] = $this->Auth->password($user_record['trpassword']);

					$User->create();
					$User->save($user_record);
				endif;

				//change the Auth fields
				$this->Auth->fields = array('username' => 'tracdni', 'password' => 'password');

				//log in the user with tractis credentials
				$this->Auth->login($user_record); 

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