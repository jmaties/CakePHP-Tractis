<div id="principal">
<?php if ($usuario) { ?>
<h1>ESTAS CONECTADO <?php echo $html->link('Desconectar', '/users/logout', array('title'=>'Desconectar')) ?></h1>
<?php } else { ?>
<h1>NO ESTAS CONECTADO <?php echo $html->link('Zona protegida', '/noticias/editar', array('title'=>'Editar')) ?></h1>
<?php } ?>
<h2 class="titulo">Noticias</h2>
<?php foreach ($data as $noticia) {?>
<h3 class="noticia"><?php if ($noticia['Noticia']['titulo']<>''){
	echo $noticia['Noticia']['titulo']; } else { ?>Noticia antigua<?php } ?></h3>
<p class="noticia"><?php echo $noticia['Noticia']['texto']; ?> <br />
</p>
<hr>
<?php } ?>
<?php 
echo $this->renderElement('paginador'); 
?>
</div>