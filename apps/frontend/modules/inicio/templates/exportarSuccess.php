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
                                        echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(Usuario::datosUsuario($r)))).'</td>';
                                    }
                                    else {
                                        echo '<td></td>';
                                    }
		 	   	  }
		 	   	  if($hy == 'mutua_id')
		 	   	  {
		 	   	  	if($r>= 1)
		 	   	  	{
		 	   	  	 echo '<td>'.utf8_decode(htmlspecialchars_decode($reS->Mutua->getNombre())).'</td>';
		 	   	  	}else{
		 	   	  	echo '<td></td>';
                                        }
		 	   	  	 
		 	   	  }
		 	   	  if($hy == 'seccion_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(CifraDatoSeccionTable::getIdseccion($r)))).'</td>';
		 	   	  }
		 	   	  if($hy == 'circular_cat_tema_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(CircularCatTemaTable::getCircularCat($r)))).'</td>';
		 	   	  }
		 	   	  if($hy == 'grupo_trabajo_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(GrupoTrabajoTable::getGrupoTrabajo($r)))).'</td>';
		 	   	  }
		 	   	   if($hy == 'categoria_d_g_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(CategoriaDGTable::getCategoriaDG($r)))).'</td>';
		 	   	  }
		 	   	   if($hy == 'documentacion_grupo_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(DocumentacionGrupoTable::getDocumentacionGrupoTrabajo($r)))).'</td>';
		 	   	  }
		 	   	   if($hy == 'consejo_territorial_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(ConsejoTerritorialTable::getConsejo($r)))).'</td>';
		 	   	  }
		 	   	   if($hy == 'categoria_c_t_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(CategoriaCTTable::getCategoriasCT($r)))).'</td>';
		 	   	  }
                                   if($hy == 'categoria_normativa_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim($reS->getCategoriaNormativa()->getNombre()))).'</td>';
                                       }else{
                                        echo '<td></td>';
                                       }
		 	   	  }
                                   if($hy == 'subcategoria_normativa_uno_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim($reS->getSubCategoriaNormativaN1()->getNombre()))).'</td>';
                                       }else{
                                        echo '<td></td>';
                                       }
		 	   	  }
                                   if($hy == 'subcategoria_normativa_dos_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim($reS->getSubCategoriaNormativaN2()->getNombre()))).'</td>';
                                       }else{
                                        echo '<td></td>';
                                       }
		 	   	  }
                                  if($hy == 'categoria_iniciativa_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim($reS->getCategoriaIniciativa()->getNombre()))).'</td>';
                                       }else{
                                        echo '<td></td>';
                                       }
		 	   	  }
                                  if($hy == 'subcategoria_iniciativa_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim($reS->getSubCategoriaIniciativa()->getNombre()))).'</td>';
                                       }else{
                                        echo '<td></td>';
                                       }
		 	   	  }
                                  if($hy == 'categoria_acuerdo_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim($reS->getCategoriaAcuerdo()->getNombre()))).'</td>';
                                       }else{
                                        echo '<td></td>';
                                       }
		 	   	  }
                                  if($hy == 'subcategoria_acuerdo_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim($reS->getSubCategoriaAcuerdo()->getNombre()))).'</td>';
                                       }else{
                                        echo '<td></td>';
                                       }
		 	   	  }
                                  
		 	   	   if($hy == 'documentacion_consejo_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(DocumentacionConsejoTable::getDocumentacionConsejo($r)))).'</td>';
		 	   	  }
		 	   	   if($hy == 'aplicacion_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(AplicacionRolTable::getAplicacionRol($r)))).'</td>';
		 	   	  }
		 	   	  if($hy == 'rol_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(RolTable::getRol($r)))).'</td>';
		 	   	  }
		 	   	  if($hy == 'categoria_organismo_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(CategoriaOrganismoTable::getCategoriaOrganismo($r)))).'</td>';
		 	   	  }
		 	   	  if($hy == 'subcategoria_organismo_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(SubCategoriaOrganismoTable::getSubcategoria($r)))).'</td>';
		 	   	  }
		 	   	  if($hy == 'organismo_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(OrganismoTable::getOrganismo($r)))).'</td>';
		 	   	  }
		 	   	  if($hy == 'documentacion_organismo_id')
		 	   	  {
		 	   	  	echo '<td>'.utf8_decode(htmlspecialchars_decode(trim(DocumentacionOrganismoTable::getDocumentacionOrganismo($r)))).'</td>';
		 	   	  }
		 	   	  if($hy == 'subcategoria_acuerdo_id' && $hy != 'categoria_acuerdo_id' && $hy != 'circular_sub_tema_id' && $hy != 'circular_tema_id' && $hy != 'subcategoria_iniciativa_id' &&  $hy != 'categoria_iniciativa_id' && $hy != 'subcategoria_normativa_dos_id' && $hy != 'subcategoria_normativa_uno_id' && $hy != 'categoria_normativa_id' && $hy != 'user_id_publicado' && $hy != 'user_id_modificado' && $hy != 'documentacion_organismo_id' && $hy != 'organismo_id' && $hy != 'subcategoria_organismo_id' && $hy != 'categoria_organismo_id' && $hy != 'rol_id' && $hy != 'aplicacion_id' && $hy != 'documentacion_consejo_id' && $hy != 'categoria_c_t_id'  &&  $hy != 'consejo_territorial_id' && $hy != 'documentacion_grupo_id' && $hy != 'categoria_d_g_id' &&  $hy != 'grupo_trabajo_id' && $hy!='salt' && $hy!='login' && $hy!='crypted_password' && $hy != 'owner_id' && $hy != 'user_id_creador' && $hy != 'mutua_id' && $hy != 'seccion_id' && $hy != 'circular_cat_tema_id' )
		 	   	  {
                                     if($r){
		 	             echo '<td>'.utf8_decode(htmlspecialchars_decode(trim($r))).'</td>';
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
                                        echo '"'.utf8_decode(htmlspecialchars_decode(trim(Usuario::datosUsuario($r)))).'",';
                                    }
                                    else {
                                        echo '"",';
                                    }
		 	   	  }
                                  if($hy == 'categoria_normativa_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.utf8_decode(htmlspecialchars_decode(trim($reS->getCategoriaNormativa()->getNombre()))).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                   if($hy == 'subcategoria_normativa_uno_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.utf8_decode(htmlspecialchars_decode(trim($reS->getSubCategoriaNormativaN1()->getNombre()))).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                   if($hy == 'subcategoria_normativa_dos_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.utf8_decode(htmlspecialchars_decode(trim($reS->getSubCategoriaNormativaN2()->getNombre()))).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                   if($hy == 'categoria_iniciativa_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.utf8_decode(htmlspecialchars_decode(trim($reS->getCategoriaIniciativa()->getNombre()))).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                  if($hy == 'subcategoria_iniciativa_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.utf8_decode(htmlspecialchars_decode(trim($reS->getSubCategoriaIniciativa()->getNombre()))).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                  if($hy == 'circular_tema_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.utf8_decode(htmlspecialchars_decode(trim($reS->getCircularCatTema()->getNombre()))).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
                                  if($hy == 'circular_sub_tema_id')
		 	   	  {
                                       if($r){
		 	   	  	echo '"'.utf8_decode(htmlspecialchars_decode(trim($reS->getCircularSubTema()->getNombre()))).'",';
                                       }else{
                                        echo '"",';
                                       }
		 	   	  }
		 	   	 if($hy == 'mutua_id')
		 	   	  {
		 	   	  	echo '"'.$reS->Mutua->getNombre().'",';
		 	   	  }
		 	   	  if($hy == 'seccion_id')
		 	   	  {
		 	   	  	echo '"'.CifraDatoSeccionTable::getIdseccion($r).'",';
		 	   	  }
		 	   	  if($hy == 'circular_cat_tema_id')
		 	   	  {
		 	   	  	echo '"'.CircularCatTemaTable::getCircularCat($r).'",';
		 	   	  }
		 	   	  if($hy == 'grupo_trabajo_id')
		 	   	  {
		 	   	  	echo '"'.GrupoTrabajoTable::getGrupoTrabajo($r).'",';
		 	   	  }
		 	   	   if($hy == 'categoria_d_g_id')
		 	   	  {
		 	   	  	echo '"'.CategoriaDGTable::getCategoriaDG($r).'",';
		 	   	  }
                                  
                                   if($hy == 'documentacion_grupo_id')
		 	   	  {
		 	   	  	echo '"'.DocumentacionGrupoTable::getDocumentacionGrupoTrabajo($r).'",';
		 	   	  }
		 	   	   if($hy == 'consejo_territorial_id')
		 	   	  {
		 	   	  	echo '"'.ConsejoTerritorialTable::getConsejo($r).'",';
		 	   	  }
		 	   	   if($hy == 'categoria_c_t_id')
		 	   	  {
		 	   	  	echo '"'.CategoriaCTTable::getCategoriasCT($r).'",';
		 	   	  }
		 	   	   if($hy == 'documentacion_consejo_id')
		 	   	  {
		 	   	  	echo '"'.DocumentacionConsejoTable::getDocumentacionConsejo($r).'",';
		 	   	  }
		 	   	  if($hy == 'aplicacion_id')
		 	   	  {
		 	   	  	echo '"'.AplicacionRolTable::getAplicacionRol($r).'",';
		 	   	  }
		 	   	  if($hy == 'rol_id')
		 	   	  {
		 	   	  	echo '"'.RolTable::getRol($r).'",';
		 	   	  }
		 	   	  if($hy == 'categoria_organismo_id')
		 	   	  {
		 	   	  	echo '"'.CategoriaOrganismoTable::getCategoriaOrganismo($r).'",';
		 	   	  }
		 	   	  if($hy == 'subcategoria_organismo_id')
		 	   	  {
		 	   	  	echo '"'.SubCategoriaOrganismoTable::getSubcategoria($r).'",';
		 	   	  }
		 	   	  if($hy == 'organismo_id')
		 	   	  {
		 	   	  	echo '"'.OrganismoTable::getOrganismo($r).'",';
		 	   	  }
		 	   	  if($hy == 'documentacion_organismo_id')
		 	   	  {
		 	   	  	echo '"'.DocumentacionOrganismoTable::getDocumentacionOrganismo($r).'",';
		 	   	  }
		 	   	  if($hy != 'circular_sub_tema_id' && $hy != 'circular_tema_id' && $hy != 'subcategoria_iniciativa_id' &&  $hy != 'categoria_iniciativa_id' && $hy != 'subcategoria_normativa_dos_id' && $hy != 'subcategoria_normativa_uno_id' && $hy != 'categoria_normativa_id' &&$hy != 'user_id_publicado' && $hy != 'user_id_modificado' && $hy != 'documentacion_organismo_id' && $hy != 'organismo_id' && $hy != 'subcategoria_organismo_id' && $hy != 'categoria_organismo_id' && $hy != 'rol_id' && $hy != 'aplicacion_id' && $hy != 'documentacion_consejo_id' && $hy != 'categoria_c_t_id'  &&  $hy != 'consejo_territorial_id' && $hy != 'documentacion_grupo_id' && $hy != 'categoria_d_g_id' &&  $hy != 'grupo_trabajo_id' && $hy != 'owner_id' && $hy != 'user_id_creador' && $hy != 'mutua_id' && $hy != 'seccion_id' && $hy!='login' && $hy!='crypted_password'&& $hy!='salt')
		 	   	  {
		 	              echo '"'.$r.'",';
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