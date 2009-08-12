<?php 
class UsersController extends AppController {

    var $name = "Users";
    var $components = array('TractisLogin');
    
    function login() {
	/**
     *  El AuthComponent proporciona la funcionalidad necesaria
     *  para el acceso (login), por lo que se puede dejar esta funci�n en blanco.
     */
    }

	function tractis()
    {
		
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
