<tr class="<?php echo $odd ?>">
					<td valign="center" align="left">
						<?php echo date("d/m/Y", strtotime($valor->getFecha())) ?>
					</td>
					<td valign="center">
					<?php if(validate_action('listar')):?>
						<a href="<?php echo url_for('documenatcion_grupos_trabajo/show?id='.$valor->getId().'&'.$redireccionGrupo) ?>">
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
                                                if($responsable){
                                                include_partial('CarpetaDocumentos', array('valor'=>$valor));
                                                }elseif($valor->getConfidencial() != 1) {
                                                 include_partial('CarpetaDocumentos', array('valor'=>$valor));
                                                }elseif($valor->getConfidencial() == 1){
                                                 include_partial('CarpetaDocumentosConfidencial', array('valor'=>$valor));
                                                }
                                                ?>
					</td>
</tr>