<?php 
App::import('Vendor', 'tractis'); 
class UsersController extends AppController {

    var $name = "Users";
    var $components = array('Auth'); //No es necesario si se declaro en el app controller

    /**
     *  El AuthComponent proporciona la funcionalidad necesaria
     *  para el acceso (login), por lo que se puede dejar esta función en blanco.
     */
    function login() {
    }

    function tractis()
    {
		$identificacion = new Tractics;		
		$idtractis = $identificacion->iniciar();
		if ($idtractis) {	
			if(!$this->Auth->user()):
				$user_record =
                $this->User->find('first', array(
                    'conditions' => array('tracdni' => $idtractis['dni']),
                    'fields' => array('User.tracdni', 'User.username', 'User.password'),
                    'contain' => array()
                ));

				if(empty($user_record)):
					$user_record['tracdni'] = $idtractis['dni'];
					$user_record['trpassword'] = $this->__randomString();
					$user_record['password'] = $this->Auth->password($user_record['trpassword']);
				//$user_record['password'] = $this->Auth->password('serena');

					$this->User->create();
					$this->User->save($user_record);
				endif;

				//change the Auth fields
				$this->Auth->fields = array('username' => 'tracdni', 'password' => 'password');

				//log in the user with facebook credentials
				$this->Auth->login($user_record);
			endif;
			$this->set('userdata', $idtractis);
		} else {
			$this->Session->setFlash('Idenficacion no realizada');
		}
    }
	function logout() {
        $this->redirect($this->Auth->logout());
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
	
	function beforeFilter() 
	{
		$this->Auth->allow("tractis");
		parent::beforeFilter();
	}
}

?>