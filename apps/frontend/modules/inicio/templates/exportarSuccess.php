<?php use_helper('LimpiarCaractere') ?>
<?php if(empty($Convocatoria)):?>
<?php if($extencion =='.xml' ||  $extencion == '.xls'):?> 

<table>
<tbody>
<tr>
<?php  
$f = 0; 
	foreach ($resultadoObj AS $tab => $reS)
		 {
		 	if($f==0)
		 	{
		 	   foreach ($reS AS $hy=>$r)
		 	   { $f++;
		 	     if($hy!='login' && $hy!='crypted_password'&& $hy!='salt')
		 	     {
		 	   	 echo '<td style="background-color: #50aec8; color: #FFFFFF; text-align: left; padding: 3px;">'.sfInflector::camelize($hy).'</td>';
		 	     }
		 	   	  
		 	   }
		 	}  
		 }		 
?>
</tr>
<?php  
	foreach ($resultadoObj AS $tab => $reS)
		 {
		 	 echo '<tr>';
		 	  foreach ($reS AS $hy=>$di)
		 	   {
		 	   	  $r = utf8_decode($di);
		 	   	  if ($hy == 'owner_id' || $hy == 'user_id_creador' || $hy =='user_id_modificado' || $hy =='user_id_publicado')
		 	   	  {
                                    if($r){
                                        echo '<td>'.slugify(utf8_decode(Usuario::datosUsuario($r))).'</td>';
                                    }
                                    else {
                                        echo '<td>&nbsp;</td>';
                                    }
		 	   	  }
		 	   	  if($hy == 'mutua_id')
		 	   	  {
		 	   	  	if($r>= 1)
		 	   	  	{
		 	   	  	 echo '<td>'.slugify(utf8_decode($reS->Mutua->getNombre())).'</td>';
		 	   	  	}else{
		 	   	  	echo '<td>&nbsp;</td>';
                                        }
		 	   	  	 
		 	   	  }
		 	   	  if($hy == 'seccion_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(utf8_decode(CifraDatoSeccionTable::getIdseccion($r))).'</td>';
		 	   	  }
		 	   	  if($hy == 'circular_cat_tema_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(utf8_decode(CircularCatTemaTable::getCircularCat($r))).'</td>';
		 	   	  }
		 	   	  if($hy == 'grupo_trabajo_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(utf8_decode(GrupoTrabajoTable::getGrupoTrabajo($r))).'</td>';
		 	   	  }
		 	   	   if($hy == 'categoria_d_g_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(utf8_decode(CategoriaDGTable::getCategoriaDG($r))).'</td>';
		 	   	  }
		 	   	   if($hy == 'documentacion_grupo_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(utf8_decode(DocumentacionGrupoTable::getDocumentacionGrupoTrabajo($r))).'</td>';
		 	   	  }
		 	   	   if($hy == 'consejo_territorial_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(utf8_decode(ConsejoTerritorialTable::getConsejo($r))).'</td>';
		 	   	  }
		 	   	   if($hy == 'categoria_c_t_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(utf8_decode(CategoriaCTTable::getCategoriasCT($r))).'</td>';
		 	   	  }
                                   if($hy == 'categoria_normativa_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.slugify(utf8_decode($reS->getCategoriaNormativa()->getNombre())).'</td>';
                                       }else{
                                        echo '<td>&nbsp;</td>';
                                       }
		 	   	  }
                                   if($hy == 'subcategoria_normativa_uno_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.slugify(utf8_decode($reS->getSubCategoriaNormativaN1()->getNombre())).'</td>';
                                       }else{
                                        echo '<td>&nbsp;</td>';
                                       }
		 	   	  }
                                   if($hy == 'subcategoria_normativa_dos_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.slugify(utf8_decode($reS->getSubCategoriaNormativaN2()->getNombre())).'</td>';
                                       }else{
                                        echo '<td>&nbsp;</td>';
                                       }
		 	   	  }
                                  if($hy == 'categoria_iniciativa_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.slugify(utf8_decode($reS->getCategoriaIniciativa()->getNombre())).'</td>';
                                       }else{
                                        echo '<td>&nbsp;</td>';
                                       }
		 	   	  }
                                  if($hy == 'subcategoria_iniciativa_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.slugify(utf8_decode($reS->getSubCategoriaIniciativa()->getNombre())).'</td>';
                                       }else{
                                        echo '<td>&nbsp;</td>';
                                       }
		 	   	  }
                                  if($hy == 'categoria_acuerdo_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.slugify(utf8_decode($reS->getCategoriaAcuerdo()->getNombre())).'</td>';
                                       }else{
                                        echo '<td>&nbsp;</td>';
                                       }
		 	   	  }
                                  if($hy == 'subcategoria_acuerdo_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.slugify(utf8_decode($reS->getSubCategoriaAcuerdo()->getNombre())).'</td>';
                                       }else{
                                        echo '<td>&nbsp;</td>';
                                       }
		 	   	  }
                                  if($hy == 'circular_tema_id')
		 	   	  {
                                        if($r){
		 	   	  	echo '<td>'.slugify(utf8_decode(CircularCatTemaTable::getCircularCat($r))).'<td>';
                                        }else{
                                          echo '<td>&nbsp;</td>';
                                        }

		 	   	  }
                                  if($hy == 'circular_sub_tema_id')
		 	   	  {
                                        if($r){
		 	   	  	echo '<td>'.slugify(utf8_decode(CircularSubTemaTable::getSubcategoria($r))).'<td>';
                                        }else{
                                          echo '<td>&nbsp;</td>';
                                        }

		 	   	  }
                                  
		 	   	   if($hy == 'documentacion_consejo_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(utf8_decode(DocumentacionConsejoTable::getDocumentacionConsejo($r))).'</td>';
		 	   	  }
		 	   	   if($hy == 'aplicacion_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(AplicacionRolTable::getAplicacionRol($r)).'</td>';
		 	   	  }
		 	   	  if($hy == 'rol_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(utf8_decode(RolTable::getRol($r))).'</td>';
		 	   	  }
		 	   	  if($hy == 'categoria_organismo_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(utf8_decode(utf8_decode(CategoriaOrganismoTable::getCategoriaOrganismo($r)))).'</td>';
		 	   	  }
		 	   	  if($hy == 'subcategoria_organismo_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(utf8_decode(SubCategoriaOrganismoTable::getSubcategoria($r))).'</td>';
		 	   	  }
		 	   	  if($hy == 'organismo_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(utf8_decode(OrganismoTable::getOrganismo($r))).'</td>';
		 	   	  }
		 	   	  if($hy == 'documentacion_organismo_id')
		 	   	  {
		 	   	  	echo '<td>'.slugify(utf8_decode(DocumentacionOrganismoTable::getDocumentacionOrganismo($r))).'</td>';
		 	   	  }
		 	   	  if($hy != 'circular_sub_tema_id' && $hy != 'circular_tema_id' && $hy != 'subcategoria_acuerdo_id' && $hy != 'categoria_acuerdo_id' &&   $hy != 'categoria_iniciativa_id' && $hy != 'subcategoria_normativa_dos_id' && $hy != 'subcategoria_normativa_uno_id' && $hy != 'categoria_normativa_id' && $hy != 'user_id_publicado' && $hy != 'user_id_modificado' && $hy != 'documentacion_organismo_id' && $hy != 'organismo_id' && $hy != 'subcategoria_organismo_id' && $hy != 'categoria_organismo_id' && $hy != 'rol_id' && $hy != 'aplicacion_id' && $hy != 'documentacion_consejo_id' && $hy != 'categoria_c_t_id'  &&  $hy != 'consejo_territorial_id' && $hy != 'documentacion_grupo_id' && $hy != 'categoria_d_g_id' &&  $hy != 'grupo_trabajo_id' && $hy!='salt' && $hy!='login' && $hy!='crypted_password' && $hy != 'owner_id' && $hy != 'user_id_creador' && $hy != 'mutua_id' && $hy != 'seccion_id' && $hy != 'circular_cat_tema_id' )
		 	   	  {
                                     if($r){
		 	             echo '<td>'.slugify($r).'</td>';
                                     }else{
                                     echo '<td>&nbsp;</td>';
                                     }
		 	   	  }  
		 	   	  
		 	   }
	     echo '</tr>';
		 }		 
?>

</tbody>
</table>
<?php else: ?>
<?php  
$f = 0; 
	foreach ($resultadoObj AS $tab => $reS)
		 {
		 	if($f==0)
		 	 {
		 	   foreach ($reS AS $hy=>$r)
		 	   { $f++;
					if($hy!='login' && $hy!='crypted_password'&& $hy!='salt')
		 	     {
		 	   	 echo '"'.sfInflector::camelize($hy).'",';
		 	     } 
		 	   }
		   }
		 }	
	echo '  ';	 	 
?>
<?php  
	foreach ($resultadoObj AS $tab => $reS)
		 {
		 	  foreach ($reS AS $hy=>$r)
		 	   {
		 	   	  if ($hy == 'owner_id' || $hy == 'user_id_creador'|| $hy =='user_id_modificado' || $hy =='user_id_publicado' )
		 	   	  {
		 	   	  if($r){
                                        echo '"'.slugify(utf8_decode(Usuario::datosUsuario($r))).'",';
                                    }
                                    else {
                                        echo '"",';
                                    }
		 	   	  }
                                  if($hy == 'categoria_normativa_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.slugify(utf8_decode($reS->getCategoriaNormativa()->getNombre())).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                   if($hy == 'subcategoria_normativa_uno_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.slugify(utf8_decode($reS->getSubCategoriaNormativaN1()->getNombre())).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                   if($hy == 'subcategoria_normativa_dos_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.slugify(utf8_decode($reS->getSubCategoriaNormativaN2()->getNombre())).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                   if($hy == 'categoria_iniciativa_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.slugify(utf8_decode($reS->getCategoriaIniciativa()->getNombre())).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                  if($hy == 'subcategoria_iniciativa_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.slugify(utf8_decode($reS->getSubCategoriaIniciativa()->getNombre())).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                  if($hy == 'circular_tema_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.slugify(utf8_decode($reS->getCircularCatTema()->getNombre())).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                  if($hy == 'circular_sub_tema_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.slugify(utf8_decode($reS->getCircularSubTema()->getNombre())).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                  if($hy == 'categoria_acuerdo_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.slugify(utf8_decode($reS->getCategoriaAcuerdo()->getNombre())).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                  if($hy == 'subcategoria_acuerdo_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.slugify(utf8_decode($reS->getSubCategoriaAcuerdo()->getNombre())).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                  if($hy == 'circular_tema_id')
		 	   	  {
                                        if($r){
		 	   	  	echo '"'.slugify(utf8_decode(CircularCatTemaTable::getCircularCat($r))).'",';
                                        }else{
                                          echo '"",';
                                        }

		 	   	  }
                                  if($hy == 'circular_sub_tema_id')
		 	   	  {
                                        if($r){
		 	   	  	echo '"'.slugify(utf8_decode(CircularSubTemaTable::getSubcategoria($r))).'",';
                                        }else{
                                          echo '"",';
                                        }

		 	   	  }
		 	   	 if($hy == 'mutua_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode($reS->Mutua->getNombre())).'",';
		 	   	  }
		 	   	  if($hy == 'seccion_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(CifraDatoSeccionTable::getIdseccion($r))).'",';
		 	   	  }
		 	   	  if($hy == 'circular_cat_tema_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(CircularCatTemaTable::getCircularCat($r))).'",';
		 	   	  }
		 	   	  if($hy == 'grupo_trabajo_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(GrupoTrabajoTable::getGrupoTrabajo($r))).'",';
		 	   	  }
		 	   	   if($hy == 'categoria_d_g_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(CategoriaDGTable::getCategoriaDG($r))).'",';
		 	   	  }
                                  
                                   if($hy == 'documentacion_grupo_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(DocumentacionGrupoTable::getDocumentacionGrupoTrabajo($r))).'",';
		 	   	  }
		 	   	   if($hy == 'consejo_territorial_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(ConsejoTerritorialTable::getConsejo($r))).'",';
		 	   	  }
		 	   	   if($hy == 'categoria_c_t_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(CategoriaCTTable::getCategoriasCT($r))).'",';
		 	   	  }
		 	   	   if($hy == 'documentacion_consejo_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(DocumentacionConsejoTable::getDocumentacionConsejo($r))).'",';
		 	   	  }
		 	   	  if($hy == 'aplicacion_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(AplicacionRolTable::getAplicacionRol($r))).'",';
		 	   	  }
		 	   	  if($hy == 'rol_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(RolTable::getRol($r))).'",';
		 	   	  }
		 	   	  if($hy == 'categoria_organismo_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(CategoriaOrganismoTable::getCategoriaOrganismo($r))).'",';
		 	   	  }
		 	   	  if($hy == 'subcategoria_organismo_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(SubCategoriaOrganismoTable::getSubcategoria($r))).'",';
		 	   	  }
		 	   	  if($hy == 'organismo_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(OrganismoTable::getOrganismo($r))).'",';
		 	   	  }
		 	   	  if($hy == 'documentacion_organismo_id')
		 	   	  {
		 	   	  	echo '"'.slugify(utf8_decode(DocumentacionOrganismoTable::getDocumentacionOrganismo($r))).'",';
		 	   	  }
		 	   	  if($hy != 'circular_sub_tema_id' && $hy != 'circular_tema_id' && $hy != 'subcategoria_acuerdo_id' && $hy != 'categoria_acuerdo_id' &&  $hy != 'subcategoria_iniciativa_id' &&  $hy != 'categoria_iniciativa_id' && $hy != 'subcategoria_normativa_dos_id' && $hy != 'subcategoria_normativa_uno_id' && $hy != 'categoria_normativa_id' &&$hy != 'user_id_publicado' && $hy != 'user_id_modificado' && $hy != 'documentacion_organismo_id' && $hy != 'organismo_id' && $hy != 'subcategoria_organismo_id' && $hy != 'categoria_organismo_id' && $hy != 'rol_id' && $hy != 'aplicacion_id' && $hy != 'documentacion_consejo_id' && $hy != 'categoria_c_t_id'  &&  $hy != 'consejo_territorial_id' && $hy != 'documentacion_grupo_id' && $hy != 'categoria_d_g_id' &&  $hy != 'grupo_trabajo_id' && $hy != 'owner_id' && $hy != 'user_id_creador' && $hy != 'mutua_id' && $hy != 'seccion_id' && $hy!='login' && $hy!='crypted_password'&& $hy!='salt')
		 	   	  {
		 	              echo '"'.slugify($r).'",';
		 	   	  }  
		 	   }
	
		 }
	echo '   ';	 		 
?>
<?php endif;?>
<?php else :?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="listados">
      <tr>
        <th>Fecha</th>
        <th>Horario</th>
        <th>Título</th>
        <th>Dirección</th>
        <th>Estado</th>
        <th>Entidad</th>
      </tr>
      
      <?php $i=0; foreach ($Convocatoria as $convocatoria): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
      <tr class="<?php echo $odd ?>">
        <td><?php echo date("d/m/Y", strtotime($convocatoria->getAsamblea()->getFecha())) ?></td>
        <td><?php echo date("H:i", strtotime($convocatoria->getAsamblea()->getHorario())) ?></td>        
        <td><?php echo $convocatoria->getAsamblea()->getTitulo() ?></td>
        <td><?php echo $convocatoria->getAsamblea()->getDireccion() ?></td>
        <td><?php echo $convocatoria->getAsamblea()->getEstado()?></td>
        <td><?php echo $convocatoria->getAsamblea()->getEntidad()?></td>
      </tr>
      <?php endforeach; ?>
    </table>
<?php endif;?>    