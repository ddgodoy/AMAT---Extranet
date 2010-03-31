<?php use_helper('Security'); ?>
  <div class="content">
    <div class="resultadoBus">
      		 <h1>Resultado de B&uacute;squeda para "<?php echo $word ?>"</h1>
						<?php if (isset($categoria)):?>
						<div >
						<?php if(!empty($asambleas)): ?>
						<ul class="tema">
						<h4><span><?php echo count($resCategoria)?> resultados encontrados</span><?php echo $labelCategoria ?></h4>
						<?php foreach ($resCategoria as $res): ?>
							<li><a href="<?php echo url_for($asambleas.'/ver?id=' . $res['id'].$tipo) ?>"><?php echo $res['titulo'] ?></a></li>
						<?php endforeach;?>
						</ul>
						<?php else : ?> 
							<?php if($categoria == 'documentacion' && validate_action('listar','documentacion')): ?>
								<?php if (count($resCategoria)): ?>
								<ul class="tema">
									<h4><span><?php echo count($resCategoria)?> resultados encontrados</span><?php echo $labelCategoria ?></h4>	
									<?php foreach ($resCategoria as $res): ?>
										<li><a href="<?php echo url_for($res['modulo'].'/show?id=' . $res['id']) ?>"><?php echo $res['nombre'] ?></a></li>
									<?php endforeach;?>
								</ul>
								<?php endif; ?> 				
							<?php else: ?> 
						  		<?php $module = explode('/',$path); if (count($resCategoria) && validate_action('listar',$module[0])): ?>
								<ul class="tema">
									<h4><span><?php echo count($resCategoria)?> resultados encontrados</span><?php echo $labelCategoria ?></h4>	
									<?php foreach ($resCategoria as $obj): ?>
										<li><a href="<?php echo url_for( $path . $obj->getId() ) ?>"><?php echo $obj ?></a></li>		
									<?php endforeach;?>
								</ul>
								<?php endif; ?> 
							<?php endif; ?> 
						<?php endif; ?> 
						</div>
						<input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="javascript:window.history.back();"/>
						<?php else: $resultadoBusqueda = array();?> 
						 <div style=" width:60%;float:left;">  
						    <?php // AGENDA            ************************************************************ ?>
							<?php if (count($resAgenda) && validate_action('listar','eventos') ): ?>
							<ul class="tema">
								<h4><span><?php if (count($resAgenda) > 5): ?> 5 <?php else : echo count($resAgenda); endif;?> de <?php echo count($resAgenda)?> resultados</span>Eventos</h4>
								<?php $count = 0 ?>
								<?php foreach ($resAgenda as $obj): ?>
									<li><a href="<?php echo url_for('eventos/show?id=' . $obj->getId()) ?>"><?php echo $obj->getTitulo() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resAgenda) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=agenda&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['eventos']['Nombre']='Eventos'; 
							$resultadoBusqueda['eventos']['url']='buscar/buscar?categoria=agenda&q='.$word; 
							$resultadoBusqueda['eventos']['cantidad']=count($resAgenda); 
							endif; ?> 
							
						
							<?php // NOTICIAS         ************************************************************ ?>			
							<?php if (count($resNoticias) && validate_action('listar','noticias')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resNoticias) > 5): ?> 5 <?php else : echo count($resNoticias); endif;?> de <?php echo count($resNoticias)?> resultados</span>Noticias</h4>
								<?php $count = 0 ?>
								<?php foreach ($resNoticias as $obj): ?>
									<li><a href="<?php echo url_for('noticias/show?id=' . $obj->getId()) ?>"><?php echo $obj->getTitulo() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
							
								<?php if (count($resNoticias) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=noticias&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['noticias']['Nombre']='Noticias'; 
							$resultadoBusqueda['noticias']['url']='buscar/buscar?categoria=noticias&q='.$word; 
							$resultadoBusqueda['noticias']['cantidad']=count($resNoticias); 
							endif; ?> 
							
							<?php // APLICACIONES   ************************************************************ ?>			
							<?php if (count($resAplicaciones) && validate_action('listar','aplicaciones_externas')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resAplicaciones) > 5): ?> 5 <?php else : echo count($resAplicaciones); endif;?> de <?php echo count($resAplicaciones)?> resultados</span>Aplicaciones</h4>
								<?php $count = 0 ?>
								<?php foreach ($resAplicaciones as $obj): ?>
									<li><a href="<?php echo url_for('aplicaciones_externas/editar?id=' . $obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resAplicaciones) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=aplicaciones_externas&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['aplicaciones_externas']['Nombre']='Aplicaciones'; 
							$resultadoBusqueda['aplicaciones_externas']['url']='buscar/buscar?categoria=aplicaciones_externas&q='.$word; 
							$resultadoBusqueda['aplicaciones_externas']['cantidad']=count($resAplicaciones); 
							endif; ?>  
							
							<?php // Cifras y Datos   ************************************************************ ?>			
							<?php if (count($resCifraDato) && validate_action('listar','cifras_datos')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resCifraDato) > 5): ?> 5 <?php else : echo count($resCifraDato); endif;?> de <?php echo count($resCifraDato)?> resultados</span>Cifras y Datos</h4>
								<?php $count = 0 ?>
								<?php foreach ($resCifraDato as $obj): ?>
									<li><a href="<?php echo url_for('cifras_datos/show?id=' . $obj->getId()) ?>"><?php echo $obj->getTitulo() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resCifraDato) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=cifras_datos&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['cifras_datos']['Nombre']='Cifras y Datos'; 
							$resultadoBusqueda['cifras_datos']['url']='buscar/buscar?categoria=cifras_datos&q='.$word; 
							$resultadoBusqueda['cifras_datos']['cantidad']=count($resCifraDato); 
							endif; ?> 
							
							<?php // Actividades   ************************************************************ ?>			
							<?php if (count($resActividades) && validate_action('listar','actividades')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resActividades) > 5): ?> 5 <?php else : echo count($resActividades); endif;?> de <?php echo count($resActividades)?> resultados</span>Actividades</h4>
								<?php $count = 0 ?>
								<?php foreach ($resActividades as $obj): ?>
									<li><a href="<?php echo url_for('actividades/show?id=' . $obj->getId()) ?>"><?php echo $obj->getTitulo() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resActividades) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=actividades&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['actividades']['Nombre']='Actividades'; 
							$resultadoBusqueda['actividades']['url']='buscar/buscar?categoria=actividades&q='.$word; 
							$resultadoBusqueda['actividades']['cantidad']=count($resActividades); 
							endif; ?> 
							
							<?php // Publicaciones   ************************************************************ ?>			
							<?php if (count($resPublicacion) && validate_action('listar','publicaciones')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resPublicacion) > 5): ?> 5 <?php else : echo count($resPublicacion); endif;?> de <?php echo count($resPublicacion)?> resultados</span>Publicaciones</h4>
								<?php $count = 0 ?>
								<?php foreach ($resPublicacion as $obj): ?>
									<li><a href="<?php echo url_for('publicaciones/show?id=' . $obj->getId()) ?>"><?php echo $obj->getTitulo() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resPublicacion) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=publicaciones&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['publicaciones']['Nombre']='Publicaciones'; 
							$resultadoBusqueda['publicaciones']['url']='buscar/buscar?categoria=publicaciones&q='.$word; 
							$resultadoBusqueda['publicaciones']['cantidad']=count($resPublicacion); 
							endif; ?> 
							
							<?php // Normativas   ************************************************************ ?>			
							<?php if (count($resNormativas) && validate_action('listar','normativas')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resNormativas) > 5): ?> 5 <?php else : echo count($resNormativas); endif;?> de <?php echo count($resNormativas)?> resultados</span>Normativas</h4>
								<?php $count = 0 ?>
								<?php foreach ($resNormativas as $obj): ?>
									<li><a href="<?php echo url_for('normativas/show?id=' . $obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resNormativas) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=normativas&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['normativas']['Nombre']='Normativas'; 
							$resultadoBusqueda['normativas']['url']='buscar/buscar?categoria=normativas&q='.$word; 
							$resultadoBusqueda['normativas']['cantidad']=count($resNormativas); 
							endif; ?> 
							
							<?php // Iniciativas   ************************************************************ ?>			
							<?php if (count($resIniciativas) && validate_action('listar','iniciativas')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resIniciativas) > 5): ?> 5 <?php else : echo count($resIniciativas); endif;?> de <?php echo count($resIniciativas)?> resultados</span>Iniciativas</h4>
								<?php $count = 0 ?>
								<?php foreach ($resIniciativas as $obj): ?>
									<li><a href="<?php echo url_for('iniciativas/show?id=' . $obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resIniciativas) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=iniciativas&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['iniciativas']['Nombre']='Iniciativas'; 
							$resultadoBusqueda['iniciativas']['url']='buscar/buscar?categoria=iniciativas&q='.$word; 
							$resultadoBusqueda['iniciativas']['cantidad']=count($resIniciativas); 
							endif; ?> 
														
							<?php // Circulares   ************************************************************ ?>			
							<?php if (count($resCirculares) && validate_action('listar','circulares')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resCirculares) > 5): ?> 5 <?php else : echo count($resCirculares); endif;?> de <?php echo count($resCirculares)?> resultados</span>Circulares</h4>
								<?php $count = 0 ?>
								<?php foreach ($resCirculares as $obj): ?>
									<li><a href="<?php echo url_for('circulares/show?id=' . $obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								
								<?php if (count($resCirculares) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=circulares&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['circulares']['Nombre']='Circulares'; 
							$resultadoBusqueda['circulares']['url']='buscar/buscar?categoria=circulares&q='.$word; 
							$resultadoBusqueda['circulares']['cantidad']=count($resCirculares); 
							endif; ?>
							
						
							<?php // Documentacion         ************************************************************ ?>			
							<?php if (count($resDocumentacion) && validate_action('listar','documentacion')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resDocumentacion) > 5): ?> 5 <?php else : echo count($resDocumentacion); endif;?> de <?php echo count($resDocumentacion)?> resultados</span>Documentación</h4>
								<?php $count = 0 ?>
								<?php foreach ($resDocumentacion as $res): ?>
									<li><a href="<?php echo url_for($res['modulo'].'/show?id=' . $res['id']) ?>"><?php echo $res['nombre'] ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>			
								<?php endforeach;?>
								<?php if (count($resDocumentacion) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=documentacion&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['documentacion']['Nombre']='Documentación'; 
							$resultadoBusqueda['documentacion']['url']='buscar/buscar?categoria=documentacion&q='.$word; 
							$resultadoBusqueda['documentacion']['cantidad']=count($resDocumentacion); 
							endif; ?> 
						
							<?php // Asamblea Directores Gerntes         ************************************************************ ?>			
							<?php if (count($resAsambleaDirectores) && validate_action('listar','asambleas')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resAsambleaDirectores) > 5): ?> 5 <?php else : echo count($resAsambleaDirectores); endif;?> de <?php echo count($resAsambleaDirectores)?> resultados</span>Directores Gerentes<span> (Asamblea)</span></h4>
								<?php $count = 0 ?>
								<?php foreach ($resAsambleaDirectores as $obj): ?>
									<li><a href="<?php echo url_for('asambleas/ver?id='.$obj->Asamblea->getId().'&DirectoresGerente=1') ?>"><?php echo $obj->Asamblea->getTitulo() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resAsambleaDirectores) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=asambleas_director&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['asambleas']['Nombre']='Directores Gerentes<span> (Asamblea)</span>'; 
							$resultadoBusqueda['asambleas']['url']='buscar/buscar?categoria=asambleas_director&q='.$word; 
							$resultadoBusqueda['asambleas']['cantidad']=count($resAsambleaDirectores); 
							endif; ?>
							
							
							<?php // Asamblea Grupos de trabajo         ************************************************************ ?>			
							<?php if (count($resAsambleaGrupoTrabajo) && validate_action('listar','asamblea_grupo')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resAsambleaGrupoTrabajo) > 5): ?> 5 <?php else : echo count($resAsambleaGrupoTrabajo); endif;?> de <?php echo count($resAsambleaGrupoTrabajo)?> resultados</span>Grupos de trabajo <span> (Convocatoria)</span></h4>  
								<?php $count = 0 ?>
								<?php foreach ($resAsambleaGrupoTrabajo as $obj): ?>
									<li><a href="<?php echo url_for('asambleas/ver?id='.$obj->Asamblea->getId().'&GrupodeTrabajo=2') ?>"><?php echo $obj->Asamblea->getTitulo() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resAsambleaGrupoTrabajo) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=asambleas_grupo&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['asamblea_grupo']['Nombre']='Grupos de trabajo <span> (Convocatoria)</span>'; 
							$resultadoBusqueda['asamblea_grupo']['url']='buscar/buscar?categoria=asambleas_grupo&q='.$word; 
							$resultadoBusqueda['asamblea_grupo']['cantidad']=count($resAsambleaGrupoTrabajo); 
							endif; ?> 
							
							<?php // Asamblea Consejo Territorial         ************************************************************ ?>			
							<?php if (count($resAsambleaConsejoTerritorial) && validate_action('listar','asamblea_consejos')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resAsambleaConsejoTerritorial) > 5): ?> 5 <?php else : echo count($resAsambleaConsejoTerritorial); endif;?> de <?php echo count($resAsambleaConsejoTerritorial)?> resultados</span>Consejo Territorial <span> (Convocatoria)</span></h4> 
								<?php $count = 0 ?>
								<?php foreach ($resAsambleaConsejoTerritorial as $obj): ?>
									<li><a href="<?php echo url_for('asambleas/ver?id='.$obj->Asamblea->getId().'&ConsejoTerritorial=3') ?>"><?php echo $obj->Asamblea->getTitulo() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resAsambleaConsejoTerritorial) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=asambleas_consejo&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['asamblea_consejos']['Nombre']='Consejo Territorial <span> (Convocatoria)</span>'; 
							$resultadoBusqueda['asamblea_consejos']['url']='buscar/buscar?categoria=asambleas_consejo&q='.$word; 
							$resultadoBusqueda['asamblea_consejos']['cantidad']=count($resAsambleaConsejoTerritorial); 
							endif; ?>
							
							<?php // Asamblea Organismos         ************************************************************ ?>			
							<?php if (count($resAsambleaOrganismo) && validate_action('listar','asamblea_organismo')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resAsambleaOrganismo) > 5): ?> 5 <?php else : echo count($resAsambleaOrganismo); endif;?> de <?php echo count($resAsambleaOrganismo)?> resultados</span>Organismos <span> (Convocatoria)</span></h4> 
								<?php $count = 0 ?>
								<?php foreach ($resAsambleaOrganismo as $obj): ?>
									<li><a href="<?php echo url_for('asambleas/ver?id='.$obj->Asamblea->getId().'&Organismo=4') ?>"><?php echo $obj->Asamblea->getTitulo() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resAsambleaOrganismo) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=asambleas_organismos&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['asamblea_organismo']['Nombre']='Organismos <span> (Convocatoria)</span>'; 
							$resultadoBusqueda['asamblea_organismo']['url']='buscar/buscar?categoria=asambleas_organismos&q='.$word; 
							$resultadoBusqueda['asamblea_organismo']['cantidad']=count($resAsambleaOrganismo); 
							endif; ?> 
							
							<?php // Asamblea Junta         ************************************************************ ?>			
							<?php if (count($resAsambleaJunta) && validate_action('listar','asamblea_junta')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resAsambleaJunta) > 5): ?> 5 <?php else : echo count($resAsambleaJunta); endif;?> de <?php echo count($resAsambleaJunta)?> resultados</span>Junta Directiva<span> (Convocatoria)</span></h4> 
								<?php $count = 0 ?>
								<?php foreach ($resAsambleaJunta as $obj): ?>
									<li><a href="<?php echo url_for('asambleas/ver?id='.$obj->Asamblea->getId().'&Junta_directiva=5') ?>"><?php echo $obj->Asamblea->getTitulo() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resAsambleaJunta) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=asambleas_junta&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['asamblea_junta']['Nombre']='Junta Directiva<span> (Convocatoria)</span>'; 
							$resultadoBusqueda['asamblea_junta']['url']='buscar/buscar?categoria=asambleas_junta&q='.$word; 
							$resultadoBusqueda['asamblea_junta']['cantidad']=count($resAsambleaJunta); 
							endif; ?> 
							
							<?php // Asamblea Otros         ************************************************************ ?>			
							<?php if (count($resAsambleaOtros) && validate_action('listar','asamblea_otros')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resAsambleaOtros) > 5): ?> 5 <?php else : echo count($resAsambleaOtros); endif;?> de <?php echo count($resAsambleaOtros)?> resultados</span>Otros<span> (Convocatoria)</span></h4>
								<?php $count = 0 ?>
								<?php foreach ($resAsambleaOtros as $obj): ?>
									<li><a href="<?php echo url_for('asambleas/ver?id='.$obj->Asamblea->getId().'&Otros=6') ?>"><?php echo $obj->Asamblea->getTitulo() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resAsambleaOtros) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=asambleas_otros&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['asamblea_otros']['Nombre']='Otros<span> (Convocatoria)</span>'; 
							$resultadoBusqueda['asamblea_otros']['url']='buscar/buscar?categoria=asambleas_otros&q='.$word; 
							$resultadoBusqueda['asamblea_otros']['cantidad']=count($resAsambleaOtros); 
							endif; ?> 
							
							<?php // Grupos de trabajo      ************************************************************ ?>			
							<?php if (count($resGruposdetrabajo) && validate_action('listar','grupos_de_trabajo')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resGruposdetrabajo) > 5): ?> 5 <?php else : echo count($resGruposdetrabajo); endif;?> de <?php echo count($resGruposdetrabajo)?> resultados</span>Grupos de trabajo</h4>
								<?php $count = 0 ?>
								<?php foreach ($resGruposdetrabajo as $obj): ?>
									<li><a href="<?php echo url_for('miembros_grupo/index?grupo='.$obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resGruposdetrabajo) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=grupos_de_trabajos&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['grupos_de_trabajo']['Nombre']='Grupos de trabajo'; 
							$resultadoBusqueda['grupos_de_trabajo']['url']='buscar/buscar?categoria=grupos_de_trabajos&q='.$word; 
							$resultadoBusqueda['grupos_de_trabajo']['cantidad']=count($resGruposdetrabajo); 
							endif; ?> 
							
							<?php // Consejos Territoriales     ************************************************************ ?>			
							<?php if (count($ConsejosTerritoriales) && validate_action('listar','consejos_territoriales')): ?>
							<ul class="tema">
								<h4><span><?php if (count($ConsejosTerritoriales) > 5): ?> 5 <?php else : echo count($ConsejosTerritoriales); endif;?> de <?php echo count($ConsejosTerritoriales)?> resultados</span>Consejos Territoriales</h4>
								<?php $count = 0 ?>
								<?php foreach ($ConsejosTerritoriales as $obj): ?>
									<li><a href="<?php echo url_for('miembros_consejo/index?consejo='.$obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($ConsejosTerritoriales) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=consejos_territoriales&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['consejos_territoriales']['Nombre']='Consejos Territoriales'; 
							$resultadoBusqueda['consejos_territoriales']['url']='buscar/buscar?categoria=consejos_territoriales&q='.$word; 
							$resultadoBusqueda['consejos_territoriales']['cantidad']=count($ConsejosTerritoriales); 
							endif; ?>
							
							<?php // Organismos     ************************************************************ ?>			
							<?php if (count($Organismo) && validate_action('listar','organismos')): ?>
							<ul class="tema">
								<h4><span><?php if (count($Organismo) > 5): ?> 5 <?php else : echo count($Organismo); endif;?> de <?php echo count($Organismo)?> resultados</span>Organismos</h4>
								<?php $count = 0 ?>
								<?php foreach ($Organismo as $obj): ?>
									<li><a href="<?php echo url_for('miembros_organismo/index?organismo='.$obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($Organismo) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=organismos&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['organismos']['Nombre']='Organismos'; 
							$resultadoBusqueda['organismos']['url']='buscar/buscar?categoria=organismos&q='.$word; 
							$resultadoBusqueda['organismos']['cantidad']=count($Organismo); 
							endif; ?> 
							
							<?php // Aplicaciones      ************************************************************ ?>			
							<?php if (count($resAplicaciones1) && validate_action('listar','aplicaciones')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resAplicaciones1) > 5): ?> 5 <?php else : echo count($resAplicaciones1); endif;?> de <?php echo count($resAplicaciones1)?> resultados</span>Aplicaciones</h4>
								<?php $count = 0 ?>
								<?php foreach ($resAplicaciones1 as $obj): ?>
									<li><a href="<?php echo url_for('aplicaciones/show?id='.$obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resAplicaciones1) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=aplicaciones&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['aplicaciones']['Nombre']='Aplicaciones'; 
							$resultadoBusqueda['aplicaciones']['url']='buscar/buscar?categoria=aplicaciones&q='.$word; 
							$resultadoBusqueda['aplicaciones']['cantidad']=count($resAplicaciones1); 
							endif; ?> 
							
							<?php // Documentacion Grupos de trabajo       ************************************************************ ?>			
							<?php if (count($resDocumentacionGrupoTrabajo) && validate_action('listar','documentacion_grupos')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resDocumentacionGrupoTrabajo) > 5): ?> 5 <?php else : echo count($resDocumentacionGrupoTrabajo); endif;?> de <?php echo count($resDocumentacionGrupoTrabajo)?> resultados</span>Grupos de trabajo <span> (Documentaci&oacute;n)</span></h4>
								<?php $count = 0 ?>
								<?php foreach ($resDocumentacionGrupoTrabajo as $obj): ?>
									<li><a href="<?php echo url_for('documentacion_grupos/show?id=' . $obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
						
								<?php if (count($resDocumentacionGrupoTrabajo) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=documentacion_grupo&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['documentacion_grupos']['Nombre']='Grupos de trabajo <span> (Documentaci&oacute;n)'; 
							$resultadoBusqueda['documentacion_grupos']['url']='buscar/buscar?categoria=documentacion_grupo&q='.$word; 
							$resultadoBusqueda['documentacion_grupos']['cantidad']=count($resDocumentacionGrupoTrabajo); 
							endif; ?>
							
							<?php // Documentacion Consejo Territorial       ************************************************************ ?>			
							<?php if (count($resDocumentacionConsejoTerritorial) && validate_action('listar','documentacion_consejos')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resDocumentacionConsejoTerritorial) > 5): ?> 5 <?php else : echo count($resDocumentacionConsejoTerritorial); endif;?> de <?php echo count($resDocumentacionConsejoTerritorial)?> resultados</span>Consejo Territorial <span> (Documentaci&oacute;n)</span></h4>
								<?php $count = 0 ?>
								<?php foreach ($resDocumentacionConsejoTerritorial as $obj): ?>
									<li><a href="<?php echo url_for('documentacion_consejos/show?id=' . $obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resDocumentacionConsejoTerritorial) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=documentacion_consejo&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['documentacion_consejos']['Nombre']='Consejo Territorial <span> (Documentaci&oacute;n)</span>'; 
							$resultadoBusqueda['documentacion_consejos']['url']='buscar/buscar?categoria=documentacion_consejo&q='.$word; 
							$resultadoBusqueda['documentacion_consejos']['cantidad']=count($resDocumentacionConsejoTerritorial); 
							endif; ?>
						
						
							<?php // Documentacion Organismos       ************************************************************ ?>			
							<?php if (count($resDocumentacionOrganismo) && validate_action('listar','documentacion_organismos')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resDocumentacionOrganismo) > 5): ?> 5 <?php else : echo count($resDocumentacionOrganismo); endif;?> de <?php echo count($resDocumentacionOrganismo)?> resultados</span>Organismos <span> (Documentaci&oacute;n)</span></h4>
								<?php $count = 0 ?>
								<?php foreach ($resDocumentacionOrganismo as $obj): ?>
									<li><a href="<?php echo url_for('documentacion_organismos/show?id=' . $obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resDocumentacionOrganismo) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=documentacion_organismo&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['documentacion_organismos']['Nombre']='Organismos <span> (Documentaci&oacute;n)</span>'; 
							$resultadoBusqueda['documentacion_organismos']['url']='buscar/buscar?categoria=documentacion_organismo&q='.$word; 
							$resultadoBusqueda['documentacion_organismos']['cantidad']=count($resDocumentacionOrganismo); 
							endif; ?>
							
							<?php // ArchivoCT       ************************************************************ ?>			
							<?php if (count($resArchivoCT) && validate_action('listar','archivos_c_t')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resArchivoCT) > 5): ?> 5 <?php else : echo count($resArchivoCT); endif;?> de <?php echo count($resArchivoCT)?> resultados</span>Archivos Consejo Territorial</h4>
								<?php $count = 0 ?>
								<?php foreach ($resArchivoCT as $obj): ?>
									<li><a href="<?php echo url_for('archivos_c_t/show?id=' . $obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resArchivoCT) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=archivos_c_t&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['archivos_c_t']['Nombre']='Archivos Consejo Territorial'; 
							$resultadoBusqueda['archivos_c_t']['url']='buscar/buscar?categoria=archivos_c_t&q='.$word; 
							$resultadoBusqueda['archivos_c_t']['cantidad']=count($resArchivoCT); 
							endif; ?>
							
							<?php // ArchivoDG       ************************************************************ ?>			
							<?php if (count($resArchivoDG) && validate_action('listar','archivos_d_g')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resArchivoDG) > 5): ?> 5 <?php else : echo count($resArchivoDG); endif;?> de <?php echo count($resArchivoDG)?> resultados</span>Archivos Grupo de Trabajo</h4>
								<?php $count = 0 ?>
								<?php foreach ($resArchivoDG as $obj): ?>
									<li><a href="<?php echo url_for('archivos_d_g/show?id=' . $obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resArchivoDG) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=archivos_d_g&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['archivos_d_g']['Nombre']='Archivos Grupo de Trabajo'; 
							$resultadoBusqueda['archivos_d_g']['url']='buscar/buscar?categoria=archivos_d_g&q='.$word; 
							$resultadoBusqueda['archivos_d_g']['cantidad']=count($resArchivoDG); 
							endif; ?>
							
							<?php // ArchivoDO       ************************************************************ ?>			
							<?php if (count($resArchivoDO) && validate_action('listar','archivos_d_o')): ?>
							<ul class="tema">
								<h4><span><?php if (count($resArchivoDO) > 5): ?> 5 <?php else : echo count($resArchivoDO); endif;?> de <?php echo count($resArchivoDO)?> resultados</span>Archivos de Organismos</h4>
								<?php $count = 0 ?>
								<?php foreach ($resArchivoDO as $obj): ?>
									<li><a href="<?php echo url_for('archivos_d_o/show?id=' . $obj->getId()) ?>"><?php echo $obj->getNombre() ?></a></li>
									<?php $count ++ ?>
									<?php if ($count == 5): ?> <?php break ?> <?php endif;?>				
								<?php endforeach;?>
								<?php if (count($resArchivoDO) > 5): ?>  
								<a class="vermas" href="<?php echo url_for('buscar/buscar?categoria=archivos_d_o&q='.$word) ?>">+ Ver Mas Resultados</a>
								<?php endif;?>
							</ul>
							<?php 
							$resultadoBusqueda['archivos_d_g']['Nombre']='Archivos de Organismos'; 
							$resultadoBusqueda['archivos_d_g']['url']='buscar/buscar?categoria=archivos_d_o&q='.$word; 
							$resultadoBusqueda['archivos_d_g']['cantidad']=count($resArchivoDO); 
							endif; ?>
							
							
						   </div>
						<?php endif; //cierro el if de categoria ?> 	
						
      <!--////////////////////////////////////////////////////////////////-->
      <?php if(isset($resultadoBusqueda)):?>
		      <div style="float: left; z-index:10;"" class="cat_de_busqueda">
		      		<h2>Categorías de Esta Búsqueda</h2>
		      		<?php foreach ($resultadoBusqueda AS $K=>$ResBU):?>
		      		<?php if (validate_action('listar',$K)): ?>
			      	<a href="<?php echo $ResBU['url']; ?>"> <?php echo $ResBU['Nombre'].' ('.$ResBU['cantidad'].')'; ?></a>
			      	<?php endif;?>
			      	<?php endforeach; ?>
		      </div>
      <?php endif; ?>
      
     	 	<br  clear="all"/>

		<div class="clear"></div>
      <br clear="all" />
    </div>
  </div>