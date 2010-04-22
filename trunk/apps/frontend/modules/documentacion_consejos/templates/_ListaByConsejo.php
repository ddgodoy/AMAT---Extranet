<tr class="<?php echo $odd ?>">
				    <?php if(validate_action('publicar') || validate_action('baja') ):?>
					<td><input type="checkbox" name="id[]" value="<?php echo $valor->getId() ?>" /></td>
					<?php endif;?>
					<td valign="center" align="left">
						<?php echo date("d/m/Y", strtotime($valor->getFecha())) ?>
					</td>
					<td valign="center">
					<?php if(validate_action('listar')):?>
						<a href="<?php echo url_for('documentacion_consejos/show?id=' . $valor->getId()) ?>">
							<strong><?php echo $valor->getNombre() ?></strong>
						</a>
					<?php endif;?>	
					</td>
					<td valign="center" align="left">
					    <?php $Consejo = ConsejoTerritorial::getRepository()->findOneById($valor->getConsejoTerritorialId())?>
						<?php echo $Consejo->getNombre() ?>
					</td>
					<td valign="center" align="left">
					    <?php $usuario = Usuario::getRepository()->findOneById($valor->getUserIdCreador())?>
						<?php echo $usuario->getApellido().', '.$usuario->getNombre() ?>
					</td>
					<td valign="center" align="center">
					<?php
						if(ArchivoCT::getRepository()->getAllByDocumentacion($valor->getId())->count() >= 1){ 
					
							if (validate_action('listar','archivos_c_t')) { 
								echo link_to(image_tag('archivos.png', array('border' => 0, 'title' => ArchivoCT::getRepository()->getAllByDocumentacion($valor->getId())->count().' Archivo/s')), 'archivos_c_t/index?archivo_c_t[documentacion_consejo_id]=' . $valor->getId().'&consejo_territorial_id='.$valor->getConsejoTerritorialId(), array('method' => 'post'));
							}
						}		
					 ?>
					</td>
					<td valign="center" align="center">
						<?php if ( validate_action('publicar') && $valor->getEstado() != 'publicado') { 
								echo link_to(image_tag('publicar.png', array('border' => 0, 'title' => 'Publicar')), 'documentacion_consejos/publicar?id=' . $valor->getId(), array('method' => 'post', 'confirm' => 'Est&aacute;s seguro que deseas publicar el documento ' . $valor->getNombre() . '?'));
							}	
						?>
					</td>
					</td>
					<td valign="center" align="center">
					<?php if(validate_action('modificar')):?> 
						<a href="<?php echo url_for('documentacion_consejos/editar?id=' . $valor->getId()) ?>">
							<?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Ver')) ?>
						</a>
					<?php endif;?>	
					</td>
          <td valign="center" align="center">
          <?php if(validate_action('baja')):?>
          	<?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'documentacion_consejos/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
          <?php endif;?>	
          </td>
</tr>