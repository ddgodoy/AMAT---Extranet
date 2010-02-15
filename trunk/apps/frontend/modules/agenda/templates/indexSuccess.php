<?php use_helper('Fecha') ?>

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
		<?php if ($cantidadRegistros > 0) : ?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="listados">
				<tr>
					<th width="10%">Fecha</th>
					<th width="30%">T&iacute;tulo</th>
					<th width="30%">Organizador</th>
					<th width="30%">Tipo</th>
				</tr>
				<?php $i=0; foreach ($evento_list as $k => $evento): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
					<?php foreach ($evento as $show): ?>
						<?php
							if ($k == 1) {
								$url 	  = 'eventos/show?id='.$show->getId();
								$fecha  = $show->getFecha();
								$titulo = $show->getTitulo();
								$organizador = $show->getOrganizador();
								$tipo = 'Evento';
							} else {
								$TipoAsamblea = explode('_', $show->Asamblea->getEntidad());
	
								if ($TipoAsamblea[0] == 'DirectoresGerentes') {
									$url = 'asambleas/ver?id='.$show->getAsambleaId().'&DirectoresGerente=1';
								}
								if ($TipoAsamblea[0] == 'GrupoTrabajo') {
									$url = 'asambleas/ver?id='.$show->getAsambleaId().'&GrupodeTrabajo=2';
								}
								if ($TipoAsamblea[0] == 'ConsejoTerritorial') {
									$url = 'asambleas/ver?id='.$show->getAsambleaId().'&ConsejoTerritorial=3';
								}
								$fecha  = $show->Asamblea->getFecha();
								$titulo = $show->Asamblea->getTitulo();
								$organizador = $show->Asamblea->Usuario->getNombre().','.$show->Asamblea->Usuario->getApellido();
								$tipo = 'Asamblea';
							}  
						?>
						<tr class="<?php echo $odd ?>">
							<td><?php echo date("d/m/Y", strtotime($fecha)) ?></td>
							<td><a href="<?php echo url_for($url) ?>"><strong><?php echo $titulo ?></strong></a></td>
							<td><?php echo $organizador ?></td>
							<td><?php echo $tipo ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</table>
		<?php else : ?>
			<?php if ($fechaSeleccionada != '') : ?>
				<div class="mensajeSistema comun">No hay Eventos en la fecha seleccionada</div>
			<?php else : ?>
				<div class="mensajeSistema comun">No hay Eventos registrados</div>
			<?php endif; ?>
		<?php endif; ?>
		<div class="lineaListados">
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> registro/s en La Agenda</span>
		</div>
	</div>

	<div class="rightside">
		<div class="paneles"><?php include_component('agenda', 'agenda') ?></div>
	</div>
	<br clear="all" />
</div>
<br clear="all" />
</div>