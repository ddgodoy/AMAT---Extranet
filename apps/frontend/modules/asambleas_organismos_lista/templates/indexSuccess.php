   <?php use_helper('Security') ?> 
   <?php use_helper('Javascript') ?>
   <?php use_helper('Object') ?>
<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>
   <div class="mapa">
      <strong><?php echo $DAtos['tipo']; ?></strong> &gt; Convocatoria - <?php if($DAtos['titulo'] != 'Convocatoria'){ echo 'Asamblea';}?>
    </div>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%"><h1><?php echo $DAtos['titulo']?></h1></td>
      </tr>
    </table>
    <?php $id_organismos = !empty ($organismomenu)?$organismomenu:''; include_component('miembros_organismo_lista','MenuOrganismos',array('id' => $id_organismos,'modulo'=>$modulo)); ?>
    <?php if ($sf_user->hasFlash('notice')): ?>
	<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
	<?php endif; ?>
    
<div class="leftside"><!-- abre div left-side	-->
	
	<strong class="subtitulo">Pendientes de Aceptaci&oacute;n</strong>   
    <?php if (count($convocatorias_pendientes) > 0): ?> 
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="listados">
      <tr>
        <th width="7%"><a href="#">Fecha</a></th>
        <th width="20%"><a href="#">T&iacute;tulo</a></th>
        <th width="12%"><a href="#">Horario</a></th>
        <th width="31%"><a href="#">Direcci&oacute;n</a></th>
        <th width="10%">&nbsp;</th>
      </tr>
      
      <?php $i=0; foreach ($convocatorias_pendientes as $convocatoria): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
      <tr class="<?php echo $odd ?>">
        <td><?php echo date("d/m/Y", strtotime($convocatoria->getAsamblea()->getFecha())) ?></td>  
        <td><a href="<?php echo url_for('asambleas_organismos_lista/ver?id=' . $convocatoria->getAsambleaId().'&'.$DAtos['get']) ?>"><strong><?php echo $convocatoria->getAsamblea()->getTitulo() ?></strong></a></td>
         <td><?php echo $convocatoria->getAsamblea()->getHorario() ?></td>      
        <td><?php echo $convocatoria->getAsamblea()->getDireccion() ?></td>
        <td><a href="<?php echo url_for('asambleas_organismos_lista/ver?id=' . $convocatoria->getAsambleaId().'&'.$DAtos['get']) ?>">M&aacute;s Informaci&oacute;n</a></td>
      </tr>
      <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p><em>No tienes convocatorias pendientes<em></p><br /><br />
    <?php endif; ?>
    
    <strong class="subtitulo">Aceptadas / Rechazadas</strong>
    <?php if (count($convocatorias) > 0): ?> 
    <table width="100%"%" border="0" cellpadding="0" cellspacing="0" class="listados">
      <tr>
        <th width="7%"><a href="#">Fecha</a></th>
        <th width="20%"><a href="#">T&iacute;tulo</a></th>
		<th width="12%"><a href="#">Horario</a></th>
        <th width="41%"><a href="#">Direcci&oacute;n</a></th>
        <th width="10%">&nbsp;</th>
        <th width="10%">&nbsp;</th>
        <th width="10%">&nbsp;</th>
      </tr>
      <?php $i=0; foreach ($convocatorias as $convocatoria): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
      <tr class="<?php echo $odd ?>">
        <td><?php echo date("d/m/Y", strtotime($convocatoria->getAsamblea()->getFecha())) ?></td>   
        <td><a href="<?php echo url_for('asambleas_organismos_lista/ver?id=' . $convocatoria->getAsambleaId().'&'.$DAtos['get']) ?>"><strong><?php echo $convocatoria->getAsamblea()->getTitulo() ?></strong></a></td>
         <td><?php echo $convocatoria->getAsamblea()->getHorario() ?></td>     
        <td><?php echo $convocatoria->getAsamblea()->getDireccion() ?></td>
        <td><span class="estatus <?php echo $convocatoria->getEstado() ?>" href="#"><?php echo ucwords($convocatoria->getEstado()) ?></span></td>
        <td><a href="<?php echo url_for('asambleas_organismos_lista/ver?id=' . $convocatoria->getAsambleaId().'&'.$DAtos['get']) ?>">M&aacute;s Informaci&oacute;n</a></td>
      </tr>
      <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p><em>No tienes convocatorias aceptadas ni rechazadas<em></p><br />
    <?php endif; ?>
   <br />
</div><!-- cierra div left-side	-->
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('asambleas_organismos_lista/index') ?>">
			<input type="hidden" name="<?php echo $DAtos['campo'];?>" value="<?php echo $DAtos['valor'];?>" />
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td colspan="2" align="center" style="padding:8px;background-color:#EAEAEA;">
							<span style="color:#666666;">Convocatoria a realizar la b&uacute;squeda</span>
							<br />
							<?php echo select_tag('tipo',options_for_select(array('0'=>'--seleccionar--','1'=>'Pendientes','2'=>'Aceptadas'), $sf_user->getAttribute('asambleas_organismos_lista_tipo')), array('style'=>'width:150px;margin-top:10px;'));?>
						</td>
					</tr>
					<tr><td style="height:5px;"></td></tr>
					<tr>
						<td>Titulo</td>
						<td><?php echo input_tag('titulo',$sf_user->getAttribute('asambleas_organismos_lista_nowtitulo'),array('class' =>'form_input', 'style'=>'width:190px;'));?></td>
					</tr>
					<?php if($DAtos['busqueda'] != ''):?>
					<tr>
					 <td><?php echo $DAtos['busqueda'] ?></td>
                                         <td><?php include_component('grupos_trabajo','listagrupodetrabajo',array('grupodetrabajoBsq' => $grupodetrabajoBsq));?></td>
					</tr>
					<?php endif;?>
					<tr>
					<td>Estado de la asamblea</td>
					<td>
							<?php echo select_tag('tipoasamblea',options_for_select(array('0'=>'--seleccionar--','anulada'=>'Anulada','caducada'=>'Caducada'),$sf_user->getAttribute('asambleas_organismos_lista_nowtipoasamblea')));?>
					</td>
					</tr>
					<tr>
					<td ><label>Fecha Desde:</label></td>
					<td width="71%" valign="middle">
						<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="desde_busqueda" id="desde_busqueda" value="<?php echo $sf_user->getAttribute('asambleas_organismos_lista_nowdesde')?>" class="form_input"/>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('desde_busqueda', this);"/>
					</td>
                                        </tr>
                                        <tr>
                                                <td><label>Fecha Hasta:</label></td>
                                                <td width="71%" valign="middle">
                                                        <input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="hasta_busqueda" id="hasta_busqueda" value="<?php echo $sf_user->getAttribute('asambleas_organismos_lista_nowhasta')?>" class="form_input"/>
                                                        <img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('hasta_busqueda', this);"/>
                                                </td>
                                        </tr>
                                        <tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
						</td>
						<td>
						<?php if ($tipobqd || $tipoasambleaBsq || $tituloBsq || $grupodetrabajoBsq || $desdeBsq || $hastaBsq ): ?>
							<span class="botonera"><input type="submit" class="boton" value="Limpiar" name="btn_quitar"/></span>
							<?php endif;  ?>
						</td>
					</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>
<!-- * -->
	<div class="clear"></div>