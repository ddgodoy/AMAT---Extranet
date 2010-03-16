<?php use_helper('Fecha') ?>
<?php use_helper('TestPager') ?>

<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>
<div class="mapa">
	<strong>Canal Corporativo</strong> &gt; Agenda de Eventos
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Agenda de Eventos</h1></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="leftside">
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> registro/s en La Agenda</span>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="listados">
			  <tbody>
				<tr>
					<th width="10%"><a href="<?php echo url_for('agenda/index?sort=fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>" style="color:#ffffff;">Fecha</a></th>
					<th width="30%"><a href="<?php echo url_for('agenda/index?sort=titulo&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>" style="color:#ffffff;">T&iacute;tulo</a></th>
					<th width="30%"><a href="<?php echo url_for('agenda/index?sort=organizador&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>" style="color:#ffffff;">Organizador</a></th>
					<th width="30%"><a href="<?php echo url_for('agenda/index?sort=evento_id&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>" style="color:#ffffff;">Tipo</a></th>
				</tr>
				<?php $i=0; foreach ($agenda_list as $agenda): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
						<tr class="<?php echo $odd ?>">
							<td><?php echo date("d/m/Y", strtotime($agenda->getFecha())) ?></td>
							<td><a href="<?php echo url_for($agenda->getUrl()) ?>"><strong><?php echo $agenda->getTitulo() ?></strong></a></td>
							<td><?php echo $agenda->getOrganizador() ?></td>
							<td><?php echo $agenda->getConvocatoriaId()!= 0? 'Convocatoria': 'Evento' ?></td>
						</tr>
					<?php endforeach; ?>
			  </tbody>		
			</table>
		<?php else : ?>
			<?php if ($fechaSeleccionada != '') : ?>
				<div class="mensajeSistema comun">No hay Eventos en la fecha seleccionada</div>
			<?php else : ?>
				<div class="mensajeSistema comun">No hay Eventos registrados</div>
			<?php endif; ?>
		<?php endif; ?>
		<div class="lineaListados">
		<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> registro/s en La Agenda</span>
		</div>
	</div>

	<div class="rightside">
		<div class="paneles"><?php include_component('agenda', 'agenda') ?></div>
		<div class="paneles">
				<h1>Buscar</h1>
				<form method="post" enctype="multipart/form-data" action="<?php echo url_for('agenda/index') ?>">
				<table width="100%" cellspacing="4" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td><label>Por T&iacute;tulo:</label></td>
							<td><input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:89%;" name="caja_busqueda" value="<?php echo $cajaBsq ?>" class="form_input"/></td>
						</tr>
						<tr>
							<td width="29%"><label>Fecha Desde:</label></td>
							<td width="71%" valign="middle">
								<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="desde_busqueda" id="desde_busqueda" value="<?php echo $desdeBsq ?>" class="form_input"/>
								<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('desde_busqueda', this);"/>
							</td>
						</tr>
						<tr>
							<td style="padding-top: 5px;"><label>Fecha Hasta:</label></td>
							<td style="padding-top: 5px;">
								<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="hasta_busqueda" id="hasta_busqueda" value="<?php echo $hastaBsq ?>" class="form_input"/>
								<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('hasta_busqueda', this);"/>
							</td>
						</tr>
						<tr>
							<td style="padding-top: 5px;"><label>Tipo</label></td>
							<td style="padding-top: 5px;">
							<?php echo select_tag('estado',options_for_select( array('0'=>'--seleccionar--',1 => 'Evento', '2' => 'Convocatoria'),$estadoBq),array('class'=>"form_input"))?>	
						</tr>
						<tr>
						<td style="padding-top:5px;">
									<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>	
								</td>
								<td>
									<?php if ($cajaBsq  || $desdeBsq || $hastaBsq || $estadoBq ): ?>
									<span class="botonera"><input type="submit" class="boton" value="Limpiar" name="btn_quitar"/></span>
									<?php endif; ?>								
								
								</td>	
						</tr>
					</tbody>
				</table>
				</form>
			</div>
		</div>
	</div>
	<br clear="all" />
</div>
<br clear="all" />
</div>