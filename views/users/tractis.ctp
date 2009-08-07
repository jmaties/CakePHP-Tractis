<?php if (isset($userdata)) { ?>
Datos del usuario: <?php print_r($userdata); ?>
<?php } else {?>
Debes <?php echo $html->link('identificarte', '/users/login', array('class'=>'add')); ?>
<?php } ?>