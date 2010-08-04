    <div class="mapa">
     <strong><?php echo $DAtos['tipo']; ?></strong> &gt; Convocatoria - <?php if($DAtos['titulo'] != 'Convocatoria'){ echo 'Asamblea';}?>

    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="95%"><h1><?php echo $asamblea->getAsamblea()->getTitulo() ?></h1></td>
        <td width="5%" align="right"><a href="#"><a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a></a></td>
      </tr>
    </table><br />
    
    <?php if ($sf_user->hasFlash('notice')): ?>
	<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
	<?php endif; ?>
	<strong class="subtitulo"><?php echo $DAtos['tipo'].': '.$DAtos['Entidad'] ?> </strong><br />
	<br />
	<span class="subtitulo">Fecha de asamblea:  <?php echo date("d/m/Y", strtotime($asamblea->Asamblea->getFecha())) ?> &nbsp;&nbsp;Horario:  <?php echo $asamblea->Asamblea->getHorario() ?>&nbsp;&nbsp;Dirección:  <?php echo $asamblea->Asamblea->getDireccion() ?></span><br />
    <span class="subtitulo">Fecha de caducidad: <?php echo date("d/m/Y", strtotime($asamblea->Asamblea->getFechaCaducidad())) ?></span><br />
    <div class="noticias">
    <strong class="subtitulo">Contenido:</strong><br />
    <div><?php echo $asamblea->Asamblea->getContenido()?>
    <br /><br />
    <span class="notfecha">Convocado por: <?php echo $user->getNombre().','.$user->getApellido()?></span><br />
    <br>
    </div>
    </div>
    
    <br />
    <div class="botonera">
    <input type="button" onclick="javascript:location.href='<?php echo url_for('asambleas_grupos_trabajos/index?'.$DAtos['get']) ?>';"  value="Listado de Asambleas" class="boton"/>
    </div>
    <br />