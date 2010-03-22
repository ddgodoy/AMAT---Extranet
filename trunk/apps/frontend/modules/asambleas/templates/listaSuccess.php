<?php use_helper('Security') ?> 
    <div class="mapa">
      <strong><?php echo $DAtos['tipo']; ?></strong> > Convocatoria - <?php if($DAtos['titulo'] != 'Convocatoria'){ echo 'Asamblea';}?>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
        <td width="95%"><h1><?php echo $DAtos['titulo']?></h1></td>
        <td width="5%" align="right"><a href="#"><a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a></a></td>
      </tr>
    </tbody></table><br/>
    
      <?php if(!empty($Grupo)): include_partial('miembros_grupo/MenuGrupo',array('Grupo' => $Grupo, 'modulo'=>$modulo)); endif;?>
      <?php if(!empty($Consejo)): include_partial('miembros_consejo/MenuConsejo',array('Consejo' => $Consejo, 'modulo'=>$modulo)); endif;?>
      <?php if(!empty($Organismos)): include_partial('miembros_organismo/MenuOrganismos',array('Organismos' => $Organismos, 'modulo'=>$modulo)); endif;?>
    
    <?php if ($sf_user->hasFlash('notice')): ?>
      <ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
    <?php endif; ?>
 <div class="leftside"><!-- abre div left-side	-->   
    <div class="lineaListados">
      <?php if($pager->haveToPaginate()): ?>
      <div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType, $DAtos['get']) ?></div>
      <?php endif; ?>
      <span class="info" style="float: left;"><!--Hay 50 Evento/s--></span>
      <?php if (validate_action('alta')):?>
      <input type="button" onclick="javascript:location.href='<?php echo url_for('asambleas/nueva?'.$DAtos['get']) ?>';" style="float: right;" value="Crear Asamblea para <?php echo $DAtos['titulo']?>" class="boton"/>
      <?php endif; ?>
    </div>
    <?php if(count($asamblea_list)>0):?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
      <tbody><tr>
        <th width="8%"><a href="<?php echo url_for('asambleas/lista?sort=a.fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$DAtos['get']) ?>">Fecha</a></th>
        <th width="20%"><a href="<?php echo url_for('asambleas/lista?sort=a.titulo&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$DAtos['get']) ?>">Título</a></th>
         <th width="10%"><a href="<?php echo url_for('asambleas/lista?sort=a.horario&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$DAtos['get']) ?>">Horario</a></th>
        <th width="20%"><a href="<?php echo url_for('asambleas/lista?sort=a.direccion&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$DAtos['get']) ?>">Dirección</a></th>
        <th width="11%"><a href="<?php echo url_for('asambleas/lista?sort=a.estado&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$DAtos['get']) ?>">Estado</a></th>
        <th width="3%"> </th>
        <th width="3%"> </th>
        <th width="3%"> </th>
        <?php if (validate_action('modificar','acta') && $DAtos['valor']!= 1 && $DAtos['valor']!= 5 && $DAtos['valor']!= 6):?>     
        <th width="3%"> </th>
        <?php endif; ?>
        <th width="3%"> </th>
        <th width="3%"> </th>
      </tr>
      <?php $i=0; foreach ($asamblea_list as $asamblea): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
      <tr class="<?php echo $odd ?>">
        <td><?php echo date("d/m/Y", strtotime($asamblea->getFecha())) ?></td>
    <?php if (validate_action('modificar')):?>
        <?php if ($asamblea->getEstado() == 'pendiente'): ?>
        <td><a href="<?php echo url_for('asambleas/editar?id='.$asamblea->getId().'&'.$DAtos['get']) ?>"><strong><?php echo $asamblea->getTitulo() ?></strong></a></td>
        <?php else: ?>
        <td><a href="#" onclick="alert('Esta asamblea ya no puede ser modificada')"><strong><?php echo $asamblea->getTitulo() ?></strong></a></td>
        <?php endif; ?>
   <?php endif; ?>
        <td><?php echo $asamblea->getHorario() ?></td>
        <td><?php echo $asamblea->getDireccion() ?></td>
        <td><?php echo ucwords($asamblea->getEstado()) ?></td>
        
   
   <?php if (validate_action('publicar')):?>
        <?php if ($asamblea->getEstado() == 'pendiente'): ?>
        <td><a href="#" onclick="alert('Todavía no hay convocados')"><?php echo image_tag('convocados.png', array('title' => 'Convocar', 'alt' => 'Convocar', 'width' => '22', 'height' => '22', 'border' => '0')) ?></a></td>
        <?php else: ?>
        <td><a href="<?php echo url_for('asambleas/convocados?id='.$asamblea->getId().'&'.$DAtos['get']) ?>"><?php echo image_tag('convocados.png', array('border' => 0, 'alt' => 'Convocados', 'title' => 'Convocados')) ?></a></td>
        <?php endif; ?>
   <?php endif; ?>
        
   <?php if (validate_action('publicar')):?>
        <?php if ($asamblea->getEstado() == 'pendiente'): ?>
        <td><?php echo link_to(image_tag('convocar.png', array('title' => 'Convocar', 'alt' => 'Convocar', 'width' => '22', 'height' => '22', 'border' => '0')), 'asambleas/convocar?id='.$asamblea->getId().'&'.$DAtos['get'], array('method' => 'post', 'confirm' => 'Est&aacute;s seguro que deseas convocar a los miembros del grupo?')) ?></td>
        <?php else: ?>
        <td><a href="#" onclick="alert('La convocatoria ya ha sido realizada anteriormente')"><?php echo image_tag('convocar.png', array('title' => 'Convocar', 'alt' => 'Convocar', 'width' => '22', 'height' => '22', 'border' => '0')) ?></a></td>
        <?php endif; ?>
   <?php endif; ?>
   <?php if (validate_action('modificar')):?>
        <td><?php echo link_to(image_tag('anular.png', array('title' => 'Anular', 'alt' => 'Anular', 'width' => '22', 'height' => '22', 'border' => '0')), 'asambleas/anular?id='.$asamblea->getId().'&'.$DAtos['get'], array('method' => 'post', 'confirm' => 'Est&aacute;s seguro que deseas anular la asamblea "' . $asamblea->getTitulo() . '"?')) ?></td>
   <?php endif;?>     
   <?php if (validate_action('modificar','acta') && $DAtos['valor']!= 1 && $DAtos['valor']!= 5 && $DAtos['valor']!= 6):?>     
        <td><a href="<?php echo url_for('acta/editar?asamblea='.$asamblea->getId().'&'.$DAtos['get']) ?>"><?php echo image_tag('acta.png', array('border' => 0, 'alt' => 'Acta', 'title' => 'Acta')) ?></a></td>
   <?php endif; ?>
   
   <?php if (validate_action('modificar')):?>
        <?php if ($asamblea->getEstado() == 'pendiente'): ?>
        <td><a href="<?php echo url_for('asambleas/editar?id='.$asamblea->getId().'&'.$DAtos['get']) ?>"><?php echo image_tag('edit.png', array('border' => 0, 'alt' => 'Editar', 'title' => 'Editar')) ?></a></td>
        <?php else: ?>
        <td><a href="#" onclick="alert('Esta asamblea ya no puede ser modificada')"><?php echo image_tag('edit.png', array('title' => 'Editar', 'alt' => 'Editar', 'border' => '0')) ?></a></td>
        <?php endif; ?>
   <?php endif; ?>

   <?php if (validate_action('baja')):?>  
        <td><?php echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'width' => '20', 'height' => '20', 'border' => '0')), 'asambleas/delete?id='.$asamblea->getId().'&'.$DAtos['get'], array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar la asamblea "' . $asamblea->getTitulo() . '"?')) ?></td>
   <?php endif; ?>
      </tr>
      <?php endforeach; ?>
    </tbody></table>
    <?php else :?>
				<div class="mensajeSistema comun">No hay registros cargados</div>
	<?php endif; ?>
    <?php if(count($asamblea_list)>0):?>
    <div class="lineaListados">
      <?php if($pager->haveToPaginate()): ?>
      <div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType, $DAtos['get']) ?></div>
      <?php endif; ?>
      <span class="info" style="float: left;"><!--Hay 50 Evento/s--></span>
      <input type="button" onclick="javascript:location.href='<?php echo url_for('asambleas/nueva?'.$DAtos['get']) ?>';" style="float: right;" value="Crear Asamblea para <?php echo $DAtos['titulo']?>" class="boton"/>
    </div>
    <?php endif; ?>
    <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('asambleas/index?'.$DAtos['get']) ?>';"/>
 </div><!-- cierra div left-side	-->   
    
    
  <div class="rightside">
		<div class="paneles">
			<h1>Buscar</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('asambleas/lista') ?>">
			<input type="hidden" name="<?php echo $DAtos['campo'];?>" value="<?php echo $DAtos['valor'];?>" />
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td>Titulo</td>
						<td><?php echo input_tag('titulo',$sf_user->getAttribute('asambleas_nowtitulo'),array('class' =>'form_input', 'style'=>'width:190px;'));?></td>
					</tr>
					<?php if($DAtos['busqueda'] != ''):?>
					<tr>
					 <td><?php echo $DAtos['busqueda'] ?></td>
					 <td><?php include_component('grupos_de_trabajo','listagrupodetrabajo',array('grupodetrabajoBsq'=>$grupodetrabajoBsq));?></td>
					</tr>
					<?php endif;?>
					<td>Estado de la asamblea</td>
					<td>
							<?php echo select_tag('tipoasamblea',options_for_select(array('0'=>'--seleccionar--','anulada'=>'Anulada','caducada'=>'Caducada'),$sf_user->getAttribute('asambleas_nowtipoasamblea')));?>
					</td>
					</tr>
					<tr>
					<td ><label>Fecha Desde:</label></td>
					<td width="71%" valign="middle">
						<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="desde_busqueda" id="desde_busqueda" value="<?php echo $sf_user->getAttribute('asambleas_nowdesde')?>" class="form_input"/>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('desde_busqueda', this);"/>
					</td>
				</tr>
				<tr>
					<td><label>Fecha Hasta:</label></td>
					<td width="71%" valign="middle">
						<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="hasta_busqueda" id="hasta_busqueda" value="<?php echo $sf_user->getAttribute('asambleas_nowhasta')?>" class="form_input"/>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('hasta_busqueda', this);"/>
					</td>
				</tr>
				<tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
						</td>
						<td>
						<?php if ( $tipoasambleaBsq || $tituloBsq || $grupodetrabajoBsq || $desdeBsq || $hastaBsq ): ?>
							<span class="botonera"><input type="submit" class="boton" value="Limpiar" name="btn_quitar"/></span>
							<?php endif;  ?>
						</td>
					</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>
	
	<div class="clear"></div>