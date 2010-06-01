<?php $getArchivo = explode('&',$redireccionGrupo );
      $getCategoria = explode('=', $getArchivo['0']);
      $getSubCategoria = explode('=', $getArchivo['1']);
?>
<tr class="<?php echo $odd ?>">
				    <?php if(validate_action('baja')):?>
					<td><input type="checkbox" name="id[]" value="<?php echo $valor->getId() ?>" /></td>
					<?php endif;?>
					<td valign="center" align="left">
						<?php echo date("d/m/Y", strtotime($valor->getFecha())) ?>
					</td>
					<td valign="center">
					<?php if(validate_action('listar')):?>
						<a href="<?php echo url_for('documentacion_organismos/show?id='.$valor->getId().'&'.$redireccionGrupo) ?>">
							<strong><?php echo $valor->getNombre() ?></strong>
						</a>
					<?php endif;?>	
					</td>
					<td valign="center" align="left">
					    <?php $Organismo = Organismo::getRepository()->findOneById($valor->getOrganismoId())?>
						<?php echo $Organismo->getNombre() ?>
					</td>
					<td valign="center" align="left">
					    <?php $usuario = Usuario::getRepository()->findOneById($valor->getUserIdCreador())?>
						<?php echo $usuario->getApellido().', '.$usuario->getNombre() ?>
					</td>
					<td valign="center" align="center">
						<?php if (validate_action('listar','archivos_d_o')) {
								echo link_to(image_tag('archivos.png', array('border' => 0, 'title' => ArchivoDO::getRepository()->getAllByDocumentacion($valor->getId())->count().' Archivo/s')), 'archivos_d_o/index?archivo_d_o[categoria_organismo_id]='.$getCategoria['1'].'&archivo_d_o[subcategoria_organismo_id]='.$getSubCategoria['1'].'&archivo_d_o[documentacion_organismo_id]='.$valor->getId().'&archivo_d_o[organismo_id]='.$valor->getOrganismoId(), array('method' => 'post'));
							}?>
					</td>
					<td valign="center" align="center">
						<?php
							if (validate_action('publicar') && $valor->getEstado() != 'publicado') { 
								echo link_to(image_tag('publicar.png', array('border' => 0, 'title' => 'Publicar')), 'documentacion_organismos/publicar?id=' . $valor->getId().'&'.$redireccionGrupo, array('method' => 'post', 'confirm' => 'Confirma la publicación del registro?'));
							}	
						?>
					</td>
					<td valign="center" align="center">
					<?php if(validate_action('modificar')):?>
						<a href="<?php echo url_for('documentacion_organismos/editar?id='.$valor->getId().'&'.$redireccionGrupo) ?>">
							<?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Ver')) ?>
						</a>
					<?php endif;?>	
					</td>
                                          <td valign="center" align="center">
                                          <?php if(validate_action('baja')):?>
                                                <?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'documentacion_organismos/delete?id='.$valor->getId().'&'.$redireccionGrupo, array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
                                          <?php endif;?>
                                          </td>
</tr>