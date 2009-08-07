<?php
class AppController extends Controller {
var $components = array("Auth");


function beforeFilter() {
// Handle the user auth filter
// This, along with no salt in the config file allows for straight
// md5 passwords to be used in the user model
Security::setHash("md5");
$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'myprofile');
$this->Auth->logoutRedirect = '/';
$this->Auth->loginError = 'Invalid username / password combination. Please try again';
$this->Auth->authorize = 'controller';
$this->set('usuario', $this->Auth->user());
}
function isAuthorized() {
	return true;
}

}
?>