<?php if($redireccionGrupo!=''){
      $getArchivo = explode('&',$redireccionGrupo );
      $getCategoria = explode('=', $getArchivo['0']);
      $getSubCategoria = explode('=', $getArchivo['1']);

      $redireccionArchivo = '&archivo_d_o[categoria_organismo_id]='.$getCategoria['1'].'&archivo_d_o[subcategoria_organismo_id]='.$getSubCategoria['1'];

      }else{
       $redireccionArchivo ='';
      }
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
						<a href="<?php echo url_for('documentacion_organismos_lista/show?id='.$valor->getId().'&'.$redireccionGrupo) ?>">
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
						<?php
                                                if($responsable){
                                                include_partial('CarpetaDocumentos', array('valor'=>$valor, 'redireccionArchivo'=>$redireccionArchivo));
                                                }elseif($valor->getConfidencial() != 1) {
                                                 include_partial('CarpetaDocumentos', array('valor'=>$valor, 'redireccionArchivo'=>$redireccionArchivo));
                                                }elseif($valor->getConfidencial() == 1){
                                                 include_partial('CarpetaDocumentosConfidencial', array('valor'=>$valor, 'redireccionArchivo'=>$redireccionArchivo));
                                                }
                                                ?>
					</td>
</tr>