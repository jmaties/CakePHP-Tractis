<?php 
class UsersController extends AppController {

    var $name = "Users";
    var $components = array('Tractis','Auth'); //No es necesario si se declaro en el app controller
    /**
     *  El AuthComponent proporciona la funcionalidad necesaria
     *  para el acceso (login), por lo que se puede dejar esta función en blanco.
     */
    function login() {
    }

function tractis()
    {
		$idtractis = $this->Tractis->iniciar();
		
		if ($idtractis) {	
			$this->Tractis->validartractis($idtractis, $this->Auth, $this->User);
			$this->set('userdata', $idtractis);
			$this->redirect($this->Auth->redirect());
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