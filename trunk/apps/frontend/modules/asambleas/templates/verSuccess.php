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
    <?php if($convocado->count() > 0): ?>
    <div class="mapa"> 
    <strong class="subtitulo">Comentario:</strong><br />
    <form action="<?php echo url_for('asambleas/comentar') ?>" method="post" enctype="multipart/form-data" > 
    <input type="hidden" name="<?php echo $DAtos['campo'];?>" value="<?php echo $DAtos['valor'];?>" />
    <?php echo input_hidden_tag('idCon',$asamblea->getId())?>
    <?php echo input_hidden_tag('id',$asamblea->getAsamblea()->getId())?>
    <?php $options = array('rich' => 'fck','height' => 200,'width' => 800,'config'=>'fckeditor/myfckconfig.js');
    echo textarea_tag('comentario',$asamblea->getDetalle(), $options ); ?>
    <br>
    <input style="margin-left:750px;" type="submit" class="boton" value="Enviar">
    </form>
    <br>
    </div>
    <?php endif;?>
    </div>
    </div>
    
    <br />
    <div class="botonera">
    <?php if($asamblea->getUsuarioId() == $sf_user->getAttribute('userId')):?>
	<?php if($asamblea->getEstado() != 'aceptada'):?>
    <input type="button" onclick="javascript:location.href='<?php echo url_for('asambleas/aceptar?id='.$asamblea->getId().'&'.$DAtos['get']) ?>';"  value="Aceptar" class="boton"/>
    <?php endif;?>
    <?php if($asamblea->getEstado() !='rechazada'):?>
    <input type="button" onclick="javascript:location.href='<?php echo url_for('asambleas/rechazar?id='.$asamblea->getId().'&'.$DAtos['get']) ?>';"  value="Rechazar" class="boton"/>
    <?php endif;?>
    <input type="button" onclick="javascript:location.href='<?php echo url_for('asambleas/index?'.$DAtos['get']) ?>';"  value="Listado de Asambleas" class="boton"/>
    <?php else:?>
    <input type="button" onclick="javascript:location.href='<?php echo url_for('asambleas/convocados?id='.$asamblea->Asamblea->getId().'&'.$DAtos['get']) ?>';"  value="Listado de Convocados" class="boton"/>
    <?php endif;?>
    </div>
    <br />