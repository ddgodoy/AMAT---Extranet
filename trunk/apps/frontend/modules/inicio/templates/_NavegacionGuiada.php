<div class="paneles">
    <h1>Navegación guiada</h1> <h4><?php echo ucfirst($modulo)?></h4>	  
			<div class="col1">
			   <ul class="tema_11">
				   <?php if(is_array($FEcha_circulares)):?>
				          <li><a><span id="mastiempo" style="cursor:pointer;<?php if($year) echo 'display:none;'?>"> + </span> <span id="menostiempo" style="<?php if(!$year) echo 'display:none;'?>cursor:pointer;"> - </span> Años</a></li>
				          <div id="can_años" style="<?php if(!$year) echo 'display:none;'?>">
				          <?php if($FEcha_circulares):?>
								<ul >
								<?php foreach ($FEcha_circulares AS $cat):?>
								 <li> <span id="<?php echo 'mas'.$cat?>" style="cursor:pointer;<?php if($months && $year==$cat) echo 'display:none;'?>"> + </span> <span id="<?php echo 'menos'.$cat ?>" style="<?php if(!$months || $year!=$cat) echo 'display:none;'?>cursor:pointer;"> - </span> <?php echo link_to($cat,$modulo."/index?desde_busqueda=01/01/$cat&hasta_busqueda=31/12/$cat")?> </li>
								 <div id="<?php echo 'mes'.$cat?>" style="<?php if(!$months || $year!=$cat) echo 'display:none;'?>">
								 <ul>
									 <li><a href="<?php echo url_for($modulo."/index?desde_busqueda=01/01/$cat&hasta_busqueda=31/01/$cat")?>"> Enero</a> </li>
									 <li><a href="<?php echo url_for($modulo."/index?desde_busqueda=01/02/$cat&hasta_busqueda=29/02/$cat")?>"> Febrero</a> </li>
									 <li><a href="<?php echo url_for($modulo."/index?desde_busqueda=01/03/$cat&hasta_busqueda=31/03/$cat")?>"> Marzo</a> </li>
									 <li><a href="<?php echo url_for($modulo."/index?desde_busqueda=01/04/$cat&hasta_busqueda=31/04/$cat")?>"> Abril</a> </li>
									 <li><a href="<?php echo url_for($modulo."/index?desde_busqueda=01/05/$cat&hasta_busqueda=31/05/$cat")?>"> Mayo</a> </li>
									 <li><a href="<?php echo url_for($modulo."/index?desde_busqueda=01/06/$cat&hasta_busqueda=31/06/$cat")?>"> Junio</a> </li>
									 <li><a href="<?php echo url_for($modulo."/index?desde_busqueda=01/07/$cat&hasta_busqueda=31/07/$cat")?>"> Julio</a> </li>
									 <li><a href="<?php echo url_for($modulo."/index?desde_busqueda=01/08/$cat&hasta_busqueda=31/08/$cat")?>"> Agosto</a> </li>
									 <li><a href="<?php echo url_for($modulo."/index?desde_busqueda=01/09/$cat&hasta_busqueda=31/09/$cat")?>"> Septiembre</a> </li>
									 <li><a href="<?php echo url_for($modulo."/index?desde_busqueda=01/10/$cat&hasta_busqueda=31/10/$cat")?>"> Octubre</a> </li>
									 <li><a href="<?php echo url_for($modulo."/index?desde_busqueda=01/11/$cat&hasta_busqueda=31/11/$cat")?>"> Noviembre</a> </li>
									 <li><a href="<?php echo url_for($modulo."/index?desde_busqueda=01/12/$cat&hasta_busqueda=31/12/$cat")?>"> Diciembre</a> </li>
								</ul>
								</div>
								<script language="javascript" type="text/javascript">
									$('<?php echo 'mas'.$cat ?>').observe('click', function(){
										if ($('<?php echo 'mes'.$cat ?>').style.display=='none') {
											$('<?php echo 'mes'.$cat ?>').show();
											$('<?php echo 'menos'.$cat ?>').show();
											$('<?php echo 'mas'.$cat ?>').style.display= 'none';
										} 
									});
									$('<?php echo 'menos'.$cat ?>').observe('click', function(){
										if ($('<?php echo 'mes'.$cat ?>').style.display!='none') {
											$('<?php echo 'mes'.$cat ?>').style.display='none';
											$('<?php echo 'mas'.$cat ?>').show();
											$('<?php echo 'menos'.$cat ?>').style.display= 'none';
										} 
									});
						  		</script>	
								<?php endforeach;?>   
								</ul>
						  <?php endif;?>
				          </div>     
				          <script language="javascript" type="text/javascript">
								$('mastiempo').observe('click', function(){
									if ($('can_años').style.display=='none') {
										$('can_años').show();
										$('menostiempo').show();
										$('mastiempo').style.display= 'none';
									} 
								});
								$('menostiempo').observe('click', function(){
									if ($('can_años').style.display!='none') {
										$('can_años').style.display='none';
										$('menostiempo').style.display= 'none';
										$('mastiempo').show();
									} 
								});
						  </script>	
			          <?php endif;?>
			          <!--###### Categoria Temas ######## -->
			          <?php  if(is_object($arrayCategoriasTema)):?>
			          <li ><a><span id="mascat" style="cursor:pointer;<?php if($SelectCatTemaBsq) echo 'display:none;'?>"> + </span> <span id="menoscat" style="<?php if(!$SelectCatTemaBsq) echo 'display:none;'?>cursor:pointer;"> - </span> Categor&iacute;a de <?php echo ucfirst($modulo)?></a></li>
			          <div id="lis_cat"  style="<?php if(!$SelectCatTemaBsq) echo 'display:none;'?>">
			          <?php if($arrayCategoriasTema):?>
						<ul>
						<?php foreach ($arrayCategoriasTema AS $cat):?>
						 <?php 
						    if($modulo == 'circulares')
							{	
					     		$subCAtTem = CircularSubTemaTable::doSelectByCategoria($cat->getId());
							}
							if($modulo == 'iniciativas')	
							{
								$subCAtTem = SubCategoriaIniciativaTable::getSubcategiriaBycategoria($cat->getId());
							}
							if($modulo == 'normativas')	
							{
								$subCAtTem = SubCategoriaNormativaN1Table::getSubcategiriaBycategoria($cat->getId());
							}
                                                        if($modulo == 'acuerdo')
							{
								$subCAtTem = SubCategoriaAcuerdoTable::getSubcategiriaBycategoria($cat->getId());
							}
						 ?>	
						 <li><a><?php if($subCAtTem->count()>=1):?><span id="<?php echo 'massub'.$cat->getId()?>" style="cursor:pointer;<?php if($SelectSubTemaBsq && $SelectCatTemaBsq == $cat->getId()) echo 'display:none;'?>"> + </span> <span id="<?php echo 'menossub'.$cat->getId() ?>" style="<?php if(!$SelectSubTemaBsq || $SelectCatTemaBsq != $cat->getId()) echo 'display:none;'?>cursor:pointer;"> - </span><?php endif;?> <?php echo link_to($cat->getNombre(),$modulo."/index?select_cat_tema=".$cat->getId()) ?></a> </li>
						 <div id="<?php echo 'tem'.$cat->getId()?>" style="<?php if(!$SelectSubTemaBsq || $SelectCatTemaBsq != $cat->getId()) echo 'display:none;'?>">
						 <!--############-->
						 <?php if(is_object($subCAtTem)):?>
						   <ul>
						   <?php foreach ($subCAtTem AS $sub):?>
						     <?php if($modulo == 'circulares'):?>
						      <li> <a href="<?php echo url_for($modulo.'/index?select_cat_tema='.$cat->getId().'&select_sub_tema='.$sub->getId())?>"><?php echo $sub->getNombre();?> </a> </li>
						     <?php endif;?> 
						     <?php if($modulo == 'iniciativas'):?>
						      <li> <a href="<?php echo url_for($modulo.'/index?select_cat_tema='.$cat->getId().'&iniciativa[subcategoria_iniciativa_id]='.$sub->getId())?>"><?php echo $sub->getNombre();?> </a> </li>
						     <?php endif;?>
                                                      <?php if($modulo == 'acuerdo'):?>
						      <li> <a href="<?php echo url_for($modulo.'/index?select_cat_tema='.$cat->getId().'&acuerdo[subcategoria_acuerdo_id]='.$sub->getId())?>"><?php echo $sub->getNombre();?> </a> </li>
						     <?php endif;?>
						     <?php if($modulo == 'normativas'):?>
						     <?php $subCAtTem2 = SubCategoriaNormativaN2Table::getSubcategiriaBycategoria($sub->getId());?>
						     <li><a><?php if($subCAtTem2->count()>=1):?><span id="<?php echo 'massub2'.$sub->getId()?>" style="cursor:pointer;<?php if($SelectSubTemaBsqDos && $SelectSubTemaBsq == $sub->getId()) echo 'display:none;'?>"> + </span> <span id="<?php echo 'menossub2'.$sub->getId() ?>" style="<?php if(!$SelectSubTemaBsqDos || $SelectSubTemaBsq != $sub->getId()) echo 'display:none;'?>cursor:pointer;"> - </span><?php endif;?> <?php echo link_to($sub->getNombre(),$modulo."/index?select_cat_tema=".$cat->getId()."&normativa[subcategoria_normativa_uno_id]=".$sub->getId()) ?></a> </li>
					         <div id="<?php echo 'tem2'.$sub->getId()?>" style="<?php if(!$SelectSubTemaBsqDos || $SelectSubTemaBsq != $sub->getId()) echo 'display:none;'?>" >
					         <?php if($subCAtTem2):?>
							   <ul>
							   <?php foreach ($subCAtTem2 AS $sub2):?>
							      <li> <a href="<?php echo url_for($modulo.'/index?select_cat_tema='.$cat->getId().'&normativa[subcategoria_normativa_uno_id]='.$sub->getId().'&normativa[subcategoria_normativa_dos_id]='.$sub2->getId())?>"><?php echo $sub2->getNombre();?> </a> </li>
							   <?php endforeach;?>   
							   </ul> 
							  <?php endif;?>				         
					         </div> 
					         <?php if($subCAtTem2->count()>=1):?>
					         <script language="javascript" type="text/javascript">
									$('<?php echo 'massub2'.$sub->getId() ?>').observe('click', function(){
										if ($('<?php echo 'tem2'.$sub->getId() ?>').style.display=='none') {
											$('<?php echo 'tem2'.$sub->getId() ?>').show();
											$('<?php echo 'menossub2'.$sub->getId() ?>').show();
											$('<?php echo 'massub2'.$sub->getId() ?>').style.display= 'none';
										} 
									});
									$('<?php echo 'menossub2'.$sub->getId() ?>').observe('click', function(){
										if ($('<?php echo 'tem2'.$sub->getId() ?>').style.display!='none') {
											$('<?php echo 'tem2'.$sub->getId() ?>').style.display='none';
											$('<?php echo 'massub2'.$sub->getId() ?>').show();
											$('<?php echo 'menossub2'.$sub->getId()?>').style.display= 'none';
										} 
									});
						  		</script>	
						     <?php  endif;?> 
						    <?php  endif;?> 
						   <?php endforeach;?>   
						  </ul> 
						 <?php endif;?> 
						 </div> 
						 <!--############-->
						 <?php if($subCAtTem->count()>=1):?>
						 <script language="javascript" type="text/javascript">
									$('<?php echo 'massub'.$cat->getId() ?>').observe('click', function(){
										if ($('<?php echo 'tem'.$cat->getId() ?>').style.display=='none') {
											$('<?php echo 'tem'.$cat->getId() ?>').show();
											$('<?php echo 'menossub'.$cat->getId() ?>').show();
											$('<?php echo 'massub'.$cat->getId() ?>').style.display= 'none';
										} 
									});
									$('<?php echo 'menossub'.$cat->getId() ?>').observe('click', function(){
										if ($('<?php echo 'tem'.$cat->getId() ?>').style.display!='none') {
											$('<?php echo 'tem'.$cat->getId() ?>').style.display='none';
											$('<?php echo 'massub'.$cat->getId() ?>').show();
											$('<?php echo 'menossub'.$cat->getId()?>').style.display= 'none';
										} 
									});
						  		</script>	
						 <?php endif?> 		
						<?php endforeach;?>   
						</ul>
			          </div> 
			          <script language="javascript" type="text/javascript">
								$('mascat').observe('click', function(){
									if ($('lis_cat').style.display=='none') {
										$('lis_cat').show();
										$('menoscat').show();
										$('mascat').style.display= 'none';
									} 
								});
								$('menoscat').observe('click', function(){
									if ($('lis_cat').style.display!='none') {
										$('lis_cat').style.display='none';
										$('menoscat').style.display= 'none';
										$('mascat').show();
									} 
								});
						</script>	
			          <?php endif;?>    
			          <?php endif;?> 
					  <!--###### Categoria Organismos ###### -->
			          <?php if($arrayCategoria):?>  
			          <li><a id="cta_organ"><span id="mascatorg" style="cursor:pointer;<?php if($SelectCatOrganismoBsq) echo 'display:none;'?>"> + </span> <span id="menoscatorg" style="<?php if(!$SelectCatOrganismoBsq) echo 'display:none;'?>cursor:pointer;"> - </span>Categor&iacute;a de Organismo</a></li>
			          <div id="lis_cat_organ" style="<?php if(!$SelectCatOrganismoBsq) echo 'display:none;'?>">
			          <?php if($arrayCategoria):?>
						<ul >
						<?php foreach ($arrayCategoria AS $cat):?>
                        <?php 
						    if($modulo == 'circulares')
							{	
					     		$subCAtOrg = SubCategoriaOrganismoTable::doSelectByCategoria($cat->getId());
							}
						 ?>	
						<li> 
						 <li><a> <?php if($subCAtOrg->count()>=1):?><span id="<?php echo 'massuborg'.$cat->getId()?>" style="cursor:pointer;<?php if($SelectSubOrganismoBsq) echo 'display:none;'?>"> + </span> <span id="<?php echo 'menossuborg'.$cat->getId() ?>" style="<?php if(!$SelectSubOrganismoBsq) echo 'display:none;'?>cursor:pointer;"> - </span><?php endif;?> <?php echo link_to($cat->getNombre(),$modulo."/index?categoria_organismo_id=".$cat->getId()) ?></a></li>
						 <div id="<?php echo 'org'.$cat->getId()?>" style="<?php if(!$SelectSubOrganismoBsq) echo 'display:none;'?>">
						 <?php if($subCAtOrg): ?>
						   <ul>
						   <?php foreach ($subCAtOrg AS $sub):?>
						      <li> <a href="<?php echo url_for("circulares/index?circular[subcategoria_organismo_id]=".$sub->getId()."&categoria_organismo_id=".$cat->getId())?>"><?php echo $sub->getNombre();?> </a> </li>
						   <?php endforeach;?>   
						  </ul>
						  <?php endif;?>   
						 </div> 
						 </li>
						 <?php if($subCAtOrg->count()>=1):?>
						 <script language="javascript" type="text/javascript">
									$('<?php echo 'massuborg'.$cat->getId() ?>').observe('click', function(){
										if ($('<?php echo 'org'.$cat->getId() ?>').style.display=='none') {
											$('<?php echo 'org'.$cat->getId() ?>').show();
											$('<?php echo 'menossuborg'.$cat->getId() ?>').show();
											$('<?php echo 'massuborg'.$cat->getId() ?>').style.display= 'none';
										} 
									});
									$('<?php echo 'menossuborg'.$cat->getId() ?>').observe('click', function(){
										if ($('<?php echo 'org'.$cat->getId() ?>').style.display!='none') {
											$('<?php echo 'org'.$cat->getId() ?>').style.display='none';
											$('<?php echo 'massuborg'.$cat->getId() ?>').show();
											$('<?php echo 'menossuborg'.$cat->getId()?>').style.display= 'none';
										} 
									});
						  		</script>	
						 <?php endif?> 		
						<?php endforeach;?>   
						</ul>
					   <?php endif;?>
			          </div>  
			          <script language="javascript" type="text/javascript">
								$('mascatorg').observe('click', function(){
									if ($('lis_cat_organ').style.display=='none') {
										$('lis_cat_organ').show();
										$('menoscatorg').show();
										$('mascatorg').style.display= 'none';
									} 
								});
								$('menoscatorg').observe('click', function(){
									if ($('lis_cat_organ').style.display!='none') {
										$('lis_cat_organ').style.display='none';
										$('menoscatorg').style.display= 'none';
										$('mascatorg').show();
									} 
								});
						</script>	    
			          <?php endif; ?>
					<!--###### fin #######-->
			        </ul>
			      </div>			      
</div>			      
