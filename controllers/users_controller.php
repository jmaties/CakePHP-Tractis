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
	
	
	function beforeFilter() 
	{
		$this->Auth->allow("tractis");
		parent::beforeFilter();
	}
}

?>
