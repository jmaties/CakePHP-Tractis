<?php
    if ($session->check('Message.auth')) $session->flash('auth');
    echo $form->create('User', array('action' => 'login'));
    echo $form->input('username');
    echo $form->input('password');
    echo $form->end('Login');
?>
<br/>
<?php 
	echo $form->create(null, array('url' => 'https://www.tractis.com/verifications'));
	echo $form->input(null,array('type'=>'hidden', 'name'=>'api_key', 'value'=>API_KEY));
	echo $form->input(null,array('type'=>'hidden', 'name'=>'notification_callback', 'value'=>URL_OK));
	echo $form->submit('Identificate', array('name'=>'commit'));
// OPCIONAL: el campo public_verification es opcional
	echo $form->input(null,array('type'=>'hidden', 'name'=>'public_verification', 'value'=>true));
	echo $form->end(); 
?>
