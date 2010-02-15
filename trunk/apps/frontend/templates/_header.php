<?php use_helper('Security'); $banderaPadre = 0; ?>

<div class="head">
    <div class="img1">
      <?php echo image_tag('logo.png', array('width' => 249, 'height' => 66, 'alt' => 'Amat')) ?>
      <div class="buscador">
        <form action="<?php echo url_for('buscar/buscar') ?>" method="get">
          <input class="form_input" name="q" type="text" />
          <input name="boton_buscar" type="submit" value="Buscar" class="boton" />
        </form>
      </div>
      <h1>Extranet de Asociados AMAT</h1>
      <?php $arrMenu = sfContext::getInstance()->getUser()->getAttribute('menu') ?>

      <div class="menu" style="z-index:1000;">
        <ul class="sf-menu"> 
        <?php foreach ($arrMenu as $item) : ?>
        	<li id="primerNivel" class="current" style="cursor:pointer;"> <a><?php echo $item['nombre'] ?></a>
        	<?php if ($item['hijos']) :?>
        	  <?php foreach ($item['hijos'] as $verelmoduloPadre) : ?>
			          				<?php if(validate_action('listar',$verelmoduloPadre['modulo'])|| validate_action('publicar',$verelmoduloPadre['modulo']) ):
			          				  $banderaPadre = 1;
			          				  else:
			          				  $banderaPadre = 0;
			          				  endif;?>
			  
			  <?php if($banderaPadre == 1):?>
	        	<ul>
	        	<?php foreach ($item['hijos'] as $hijo) : ?>
	        	  <?php if(validate_action('listar',$hijo['modulo']) || validate_action('publicar',$hijo['modulo']) ):?>
		              <li style="z-index:200;"><a <?php if($hijo['hijos']):?> class="current" <?php endif; ?>  <?php if($hijo['aplicacion']):?> href="<?php echo url_for($hijo['aplicacion'])?>" <?php else: ?> style="cursor:default;" <?php endif; ?>><?php echo $hijo['nombre'] ?></a>
		              <?php if($hijo['hijos']):?>
		              <?php foreach ($hijo['hijos'] as $verelmodulo) : ?>
			          				<?php if(validate_action('listar',$verelmodulo['modulo'])|| validate_action('publicar',$verelmodulo['modulo']) ):
			          				  $bandera = 1;
			          				  else:
			          				  $bandera = 0;
			          				  endif;?>
			          <?php if( $bandera == 1) : ?>
		          			<ul>		          				
		          				<?php foreach ($hijo['hijos'] as $nieto) : ?>
			          				<?php if(validate_action('listar',$nieto['modulo']) || validate_action('publicar',$nieto['modulo']) ):?>
			                  			<li style="z-index:300;"><a href="<?php echo url_for($nieto['aplicacion']) ?>"><?php echo $nieto['nombre'] ?></a></li>	 
			          		  		<?php endif; ?>
			      		  		<?php endforeach; ?>
		          			</ul>
		          	  <?php endif; ?>
		          	  <?php endforeach; ?>
		          	  <?php endif; ?>
		          	  </li>
		            <?php endif; ?>
	        	<?php endforeach; ?>
	            </ul>
	        <?php endif; ?>	
	        <?php endforeach; ?>
	        <?php endif; ?>	
            </li> 
        <?php endforeach; ?>         
        </ul>
      </div>
    </div>
  </div>