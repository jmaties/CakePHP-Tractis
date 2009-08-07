<div id="principal">
<h2 class="titulo">Noticias PROTEGIDAS</h2>
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