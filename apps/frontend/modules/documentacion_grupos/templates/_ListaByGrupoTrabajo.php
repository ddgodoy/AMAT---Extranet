<tr class="<?php echo $odd ?>">
				    <?php if(validate_action('publicar') || validate_action('baja') ):?>
					<td><input type="checkbox" name="id[]" value="<?php echo $valor->getId() ?>" /></td>
					<?php endif;?>
					<td valign="center" align="left">
						<?php echo date("d/m/Y", strtotime($valor->getFecha())) ?>
					</td>
					<td valign="center">
					<?php if(validate_action('listar')):?>
						<a href="<?php echo url_for('documentacion_grupos/show?id=' . $valor->getId()) ?>">
							<strong><?php echo $valor->getNombre() ?></strong>
						</a>
					<?php endif;?>	
					</td>
					<td valign="center" align="left">
					    <?php $Grupo = GrupoTrabajo::getRepository()->findOneById($valor->getGrupoTrabajoId())?>
						<?php echo $Grupo->getNombre() ?>
					</td>
					<td valign="center" align="left">
						<?php if($valor->getUserIdCreador()):?> 
					    <?php $usuario = Usuario::getRepository()->findOneById($valor->getUserIdCreador())?>
						<?php echo $usuario->getApellido().', '.$usuario->getNombre() ?>
						<?php endif;?>
					</td>
					<td valign="center" align="center">
						<?php
						if(ArchivoDG::getRepository()->getAllByDocumentacion($valor->getId())->count() >= 1){ 
							if (validate_action('listar','archivos_d_g')) { 
								echo link_to(image_tag('archivos.png', array('border' => 0, 'title' => ArchivoDG::getRepository()->getAllByDocumentacion($valor->getId())->count().' Archivo/s')), 'archivos_d_g/index?archivo_d_g[documentacion_grupo_id]='.$valor->getId().'&grupo_trabajo_id='.$valor->getGrupoTrabajoId(), array('method' => 'post'));
							}
						}		
						?>
					</td>
					<td valign="center" align="center">
						<?php
							if (validate_action('publicar') && $valor->getEstado() != 'publicado') { 
								echo link_to(image_tag('publicar.png', array('border' => 0, 'title' => 'Publicar')), 'documentacion_grupos/publicar?id=' . $valor->getId(), array('method' => 'post', 'confirm' => 'Confirma la publicación del registro?'));
							}	
						?>
					</td>
					<td valign="center" align="center">
					<?php if(validate_action('modificar')):?>
						<a href="<?php echo url_for('documentacion_grupos/editar?id=' . $valor->getId()) ?>">
							<?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Ver')) ?>
						</a>
					<?php endif; ?>	
					</td>
          <td valign="center" align="center">
          <?php if(validate_action('baja')):?>
          	<?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'documentacion_grupos/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
          <?php endif;?>	
          </td>
</tr>