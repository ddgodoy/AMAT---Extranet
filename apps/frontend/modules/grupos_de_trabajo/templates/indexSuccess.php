<?php
	use_helper('TestPager');
	use_helper('Security');
	use_helper('Date');
?>
<div class="mapa"><strong>Administraci&oacute;n</strong> > Grupos de Trabajo</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Grupos de Trabajo</h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'GrupoTrabajo'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
				<td width="5%" align="center"><?php echo link_to(image_tag('export_csv.jpg', array('title' => 'Exportar csv', 'alt' => 'Exportar csv', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.csv'); ?></td>
				<td width="5%" align="center"><?php echo link_to(image_tag('export_xml.jpg', array('title' => 'Exportar xml', 'alt' => 'Exportar xml', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xml'); ?></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>

	<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>

<div class="leftside grupos-de-trabajo">
      <div class="lineaListados">
        <?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
	   <?php endif; ?>

        <h2 class="grupo" style="float:left; line-height:30px; width:auto; border:none;">&nbsp;</h2>
        <span style="float: left;" class="info">Hay <?php echo $cantidadRegistros ?> Grupo/s</span>
        <?php if(validate_action('alta')):?>
        <input type="button" class="boton" name="newNews" value="Crear Nuevo Grupo" style="float: right;" onclick="javascript:location.href='<?php echo url_for('grupos_de_trabajo/nueva') ?>';"/>
        <?php endif;?>
      </div>
      <br />
      <?php $i=0; foreach ($grupos_de_trabajo_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>

      <a href="<?php echo url_for('miembros_grupo/index?grupo='.$valor->getId()) ?>" class="grupo-titulo">
      	<strong><?php echo $valor->getNombre()?></strong>
      	<span>Creado el: <?php echo date('d/m/Y',strtotime($valor->getCreatedAt()))?></span>
      </a>
      <br />
      <table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados descrip-grupo">      
        <tr class="gris">
        <?php if ($valor->getDetalle()):?>
          <td><?php echo $valor->getDetalle()?></td>
        <?php else: ?>
         <td valign="top" align="center" class="doc">  </td>
          <td width="95%" align="left">&nbsp;&nbsp;</td> 
         <?php endif; ?>  
         <td  width="5%"valign="middle" align="center">
		  <?php if(validate_action('modificar')):?>
		   <a href="<?php echo url_for('grupos_de_trabajo/editar?id=' . $valor->getId()) ?>">
			 <?php echo image_tag('edit.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Editar')) ?>
		    </a>
		     <?php endif;?>	
		   </td>
           <td width="5%" valign="middle" align="center">
          <?php if(validate_action('baja')):?>
          	<?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'grupos_de_trabajo/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
          <?php endif;?>	
          </td>
        </tr>
      </table><br />
      <?php endforeach;?>
      <div class="lineaListados">
        <?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
	   <?php endif; ?>

        <h2 class="grupo" style="float:left; line-height:30px; width:auto; border:none;">&nbsp;</h2>
        <span style="float: left;" class="info">Hay <?php echo $cantidadRegistros ?> Grupo/s</span>
        <?php if(validate_action('alta')):?>
        <input type="button" class="boton" name="newNews" value="Crear Nuevo Grupo" style="float: right;" onclick="javascript:location.href='<?php echo url_for('grupos_de_trabajo/nueva') ?>';"/>
        <?php endif;?>
      </div>
    </div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar por Nombre</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('grupos_de_trabajo/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td width="20%">
					Nombre
					</td>
						 <td width="80%">
							<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
						</td>
					</tr>
					<tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
						</td>
						<td style="padding-top:5px;">
						<?php if ($cajaBsq): ?>
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