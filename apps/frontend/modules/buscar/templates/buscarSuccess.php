<?php use_helper('Security'); ?>
  <div class="content">
    <div class="resultadoBus">
            <h1>Resultado de B&uacute;squeda para "<?php echo $word ?>"</h1>
  <?php if (isset($categoria)):?>
    <?php if(!empty($asambleas)): ?>
    <ul class="tema" style="display:block; width:100%;">
	<h4><?php echo $labelCategoria ?>  </h4>
	<?php foreach ($resCategoria as $res): ?>
		<li><a href="<?php echo url_for($asambleas.'/ver?id=' . $res['id'].$tipo) ?>"><?php echo $res['titulo'] ?></a></li>
	<?php endforeach;?>
	<a class="vermas"><?php echo count($resCategoria) ?> resultados encontrados</a>
    </ul>
    <?php else : ?> 
		<?php if($categoria == 'documentacion' && validate_action('listar','documentacion')): ?>
			<?php if (count($resCategoria)): ?>
			<ul class="tema" style="display:block; width:100%;">
				<h4><?php echo $labelCategoria ?>  </h4>
				<?php foreach ($resCategoria as $res): ?>
					<li><a href="<?php echo url_for($res['modulo'].'/show?id=' . $res['id']) ?>"><?php echo $res['nombre'] ?></a></li>
				<?php endforeach;?>
				<a class="vermas"><?php echo count($resCategoria) ?> resultados encontrados</a>
			</ul>
			<?php endif; ?> 				
		<?php else: ?> 
	  		<?php $module = explode('/',$path); if (count($resCategoria) && validate_action('listar',$module[0])): ?>
			<ul class="tema" style="display:block; width:100%;">
				<a class="vermas"><?php echo count($resCategoria) ?> resultados encontrados</a>
				<h4><?php echo $labelCategoria ?></h4>
				<?php foreach ($resCategoria as $obj): ?>
					<li><a href="<?php echo url_for( $path . $obj->getId() ) ?>"><?php echo $obj ?></a></li>		
				<?php endforeach;?>
				<a class="vermas"><?php echo count($resCategoria) ?> resultados encontrados</a>
			</ul>
			<?php endif; ?> 
		<?php endif; ?> 
    <?php endif; ?> 
  
  <?php else: ?> 
      
        <?php // AGENDA            ************************************************************ ?>
		<?php if (count($resAgenda) && validate_action('listar','eventos') ): ?>
		<ul class="tema">
			<h4>Agenda</h4>
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
		<?php endif; ?> 
		

		<?php // NOTICIAS         ************************************************************ ?>			
		<?php if (count($resNoticias) && validate_action('listar','noticias')): ?>
		<ul class="tema">
			<h4>Noticias</h4>
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
		<?php endif; ?> 
		
		<?php // APLICACIONES   ************************************************************ ?>			
		<?php if (count($resAplicaciones) && validate_action('listar','aplicaciones_externas')): ?>
		<ul class="tema">
			<h4>Aplicaciones</h4>
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
		<?php endif; ?> 
		
		<?php // Cifras y Datos   ************************************************************ ?>			
		<?php if (count($resCifraDato) && validate_action('listar','cifras_datos')): ?>
		<ul class="tema">
			<h4>Cifras y Datos</h4>
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
		<?php endif; ?> 
		
		<?php // Actividades   ************************************************************ ?>			
		<?php if (count($resActividades) && validate_action('listar','actividades')): ?>
		<ul class="tema">
			<h4>actividades</h4>
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
		<?php endif; ?> 
		
		<?php // Publicaciones   ************************************************************ ?>			
		<?php if (count($resPublicacion) && validate_action('listar','publicaciones')): ?>
		<ul class="tema">
			<h4>publicaciones</h4>
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
		<?php endif; ?> 
		
		<?php // Normativas   ************************************************************ ?>			
		<?php if (count($resNormativas) && validate_action('listar','normativas')): ?>
		<ul class="tema">
			<h4>normativas</h4>
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
		<?php endif; ?> 
		
		<?php // Iniciativas   ************************************************************ ?>			
		<?php if (count($resIniciativas) && validate_action('listar','iniciativas')): ?>
		<ul class="tema">
			<h4>iniciativas</h4>
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
		<?php endif; ?>
		
		<?php // Circulares   ************************************************************ ?>			
		<?php if (count($resCirculares) && validate_action('listar','circulares')): ?>
		<ul class="tema">
			<h4>circulares</h4>
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
		<?php endif; ?>
		
	
		<?php // Documentacion         ************************************************************ ?>			
		<?php if (count($resDocumentacion) && validate_action('listar','documentacion')): ?>
		<ul class="tema">
			<h4>Documentación</h4>
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
		<?php endif; ?> 

		<?php // Asamblea Directores Gerntes         ************************************************************ ?>			
		<?php if (count($resAsambleaDirectores) && validate_action('listar','asambleas')): ?>
		<ul class="tema">
			<h4>Directores Gerentes<span> (Asamblea)</span></h4>  
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
		<?php endif; ?> 
		
		
		<?php // Asamblea Grupos de trabajo         ************************************************************ ?>			
		<?php if (count($resAsambleaGrupoTrabajo) && validate_action('listar','asamblea_grupo')): ?>
		<ul class="tema">
			<h4>Grupos de trabajo <span> (Convocatoria)</span></h4>  
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
		<?php endif; ?> 
		
		<?php // Asamblea Consejo Territorial         ************************************************************ ?>			
		<?php if (count($resAsambleaConsejoTerritorial) && validate_action('listar','asamblea_consejos')): ?>
		<ul class="tema">
			<h4>Consejo Territorial <span> (Convocatoria)</span></h4>
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
		<?php endif; ?> 
		
		<?php // Asamblea Organismos         ************************************************************ ?>			
		<?php if (count($resAsambleaOrganismo) && validate_action('listar','asamblea_organismo')): ?>
		<ul class="tema">
			<h4>Organismos <span> (Convocatoria)</span></h4>
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
		<?php endif; ?> 
		
		<?php // Asamblea Junta         ************************************************************ ?>			
		<?php if (count($resAsambleaJunta) && validate_action('listar','asamblea_junta')): ?>
		<ul class="tema">
			<h4>Junta Directiva<span> (Convocatoria)</span></h4>
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
		<?php endif; ?> 
		
		<?php // Asamblea Otros         ************************************************************ ?>			
		<?php if (count($resAsambleaOtros) && validate_action('listar','asamblea_otros')): ?>
		<ul class="tema">
			<h4>Otros<span> (Convocatoria)</span></h4>
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
		<?php endif; ?> 
		
		<?php // Grupos de trabajo      ************************************************************ ?>			
		<?php if (count($resGruposdetrabajo) && validate_action('listar','grupos_de_trabajo')): ?>
		<ul class="tema">
			<h4>Grupos de trabajo</h4>
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
		<?php endif; ?> 
		
		<?php // Consejos Territoriales     ************************************************************ ?>			
		<?php if (count($ConsejosTerritoriales) && validate_action('listar','consejos_territoriales')): ?>
		<ul class="tema">
			<h4>Consejos Territoriales</h4>
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
		<?php endif; ?> 
		
		<?php // Organismos     ************************************************************ ?>			
		<?php if (count($Organismo) && validate_action('listar','organismos')): ?>
		<ul class="tema">
			<h4>Organismos</h4>
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
		<?php endif; ?> 
		
		<?php // Aplicaciones      ************************************************************ ?>			
		<?php if (count($resAplicaciones1) && validate_action('listar','aplicaciones')): ?>
		<ul class="tema">
			<h4>Aplicaciones </h4>
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
		<?php endif; ?> 
		
		
		<?php // Documentacion Grupos de trabajo       ************************************************************ ?>			
		<?php if (count($resDocumentacionGrupoTrabajo) && validate_action('listar','documentacion_grupos')): ?>
		<ul class="tema">
			<h4>Grupos de trabajo <span> (Documentaci&oacute;n)</span></h4>
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
		<?php endif; ?> 
		
		<?php // Documentacion Consejo Territorial       ************************************************************ ?>			
		<?php if (count($resDocumentacionConsejoTerritorial) && validate_action('listar','documentacion_consejos')): ?>
		<ul class="tema">
			<h4>Area Territorial <span> (Documentaci&oacute;n)</span></h4>
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
		<?php endif; ?> 


		<?php // Documentacion Organismos       ************************************************************ ?>			
		<?php if (count($resDocumentacionOrganismo) && validate_action('listar','documentacion_organismos')): ?>
		<ul class="tema">
			<h4>Organismos <span> (Documentaci&oacute;n)</span></h4>
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
		<?php endif; ?> 

   <?php endif; //cierro el if de categoria ?> 		
      <div class="clear"></div>
      <br clear="all" />
    </div>