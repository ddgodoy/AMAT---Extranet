    <div class="mapa">
     <strong><?php echo $DAtos['tipo']; ?></strong> &gt; Acta - <?php echo $Actas->getNombre() ?>

    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="95%"><h1><?php echo $Actas->getNombre() ?></h1></td>
        <td width="5%" align="right"><a href="#"><a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a></a></td>
      </tr>
    </table><br />
    
    <?php if ($sf_user->hasFlash('notice')): ?>
	<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
	<?php endif; ?>
	<strong class="subtitulo"><?php echo $DAtos['tipo'].': '.$DAtos['Entidad'] ?> </strong><br />
	<br />
	<span class="subtitulo">Fecha de creación:  <?php echo date("d/m/Y", strtotime($Actas->getCreatedAt())) ?> </span><br />
    <span class="subtitulo">Ultima Actualización: <?php echo date("d/m/Y", strtotime($Actas->getUpdatedAt())) ?></span><br />
    <div class="noticias">
    <strong class="subtitulo">Contenido:</strong><br />
    <div><?php echo $Actas->getDetalle() ?>
    <br /><br />
    <span class="notfecha">Creada por: <?php echo $user->getNombre().','.$user->getApellido()?></span><br />
    <span class="notfecha">Fecha de asamblea: <?php echo date("d/m/Y", strtotime($Actas->Asamblea->getFecha())) ?></span><br />
    <span class="notfecha">Horario de asamblea: <?php echo $Actas->Asamblea->getHorario() ?></span><br />
    <span class="notfecha">Dirección de asamblea: <?php echo $Actas->Asamblea->getDireccion() ?></span><br />
    <br>
    </div>
    </div>
    
    <br />
    <div class="botonera">
    <input type="button" onclick="javascript:location.href='<?php echo url_for('actas_grupos_trabajo/index?'.$DAtos['get']) ?>';"  value="Listado de Actas" class="boton"/>
    </div>
    <br />