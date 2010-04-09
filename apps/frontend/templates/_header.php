<?php use_helper('Security'); $banderaPadre = 0; ?>

<script language="javascript" type="text/javascript">
    function trim(stringToTrim) {
        return stringToTrim.replace(/^\s+|\s+$/g,"");
	}
    
	function avoidNullSearch()
	{
		var txtclave = trim($('key_search_gral').value);
		if (txtclave == '') {
			alert('Ingrese una clave para la b\u00fasqueda'); $('key_search_gral').focus(); return false;
		}
		return true;
	}
</script>
<div class="head">
    <div class="img1">
      <?php echo image_tag('logo.png', array('width' => 249, 'height' => 66, 'alt' => 'Amat')) ?>
      <div class="buscador">
        <form action="<?php echo url_for('buscar/buscar') ?>" method="get">
          <input class="form_input" name="q" type="text" id="key_search_gral" />
          <input name="boton_buscar" type="submit" value="Buscar" class="boton" onclick="return avoidNullSearch();"/>
        </form>
      </div>
      <h1>Extranet de Asociados AMAT</h1>
      <?php $arrMenu = sfContext::getInstance()->getUser()->getAttribute('menu');
       		$banderaPadre = 0;
                $banderaInicio = 0;
      ?>
       <!--<pre>
       <?php // print_r($arrMenu) ?>
       </pre>		
       <?php //exit(); ?>	-->	
      
      <div class="menu" style="z-index:1000;">
        <ul class="sf-menu"> 
        <?php foreach ($arrMenu as $item) : if( $banderaInicio == 1){$banderaInicio = 0;} ?>
            <?php if (count($item['hijos']) >=1) :?>
                 <?php foreach ($item['hijos'] as $verelmoduloInicial) : ?>
                        <?php if(validate_action('listar',$verelmoduloInicial['modulo'])|| validate_action('publicar',$verelmoduloInicial['modulo']) ):
			          $banderaInicio = 1;
			endif;?>
	         <?php endforeach; ?>
	        <?php if($banderaInicio == 1): if( $banderaPadre == 1){$banderaPadre = 0;}?>
        	<li id="primerNivel" class="current" style="cursor:pointer;"> <a><?php echo $item['nombre'] ?></a>
        	<?php if (count($item['hijos']) >=1) :?>
        	  <?php foreach ($item['hijos'] as $verelmoduloPadre) : ?>
			          				<?php if(validate_action('listar',$verelmoduloPadre['modulo'])|| validate_action('publicar',$verelmoduloPadre['modulo']) ):
			          				  $banderaPadre = 1;
			          				  endif;?>
			   <?php endforeach; ?>       				  
			  <?php if($banderaPadre == 1):?>
	        	<ul>
	        	<?php foreach ($item['hijos'] as $hijo) : ?>
	        	  <?php if(validate_action('listar',$hijo['modulo']) || validate_action('publicar',$hijo['modulo']) ):?>
		              <li ><a <?php if($hijo['hijos']):?> class="current" <?php endif; ?>  <?php if($hijo['aplicacion']):?> href="<?php echo url_for($hijo['aplicacion'])?>" <?php else: ?> href="<?php echo url_for($hijo['url'])?>" <?php endif; ?>><?php echo $hijo['nombre'] ?></a>
		              <?php if(count($hijo['hijos'])>= 1): $banderahijo= 0; ?>
		              <?php foreach ($hijo['hijos'] as $verelmodulo) : ?>
			          				<?php if(validate_action('listar',$verelmodulo['modulo'])|| validate_action('publicar',$verelmodulo['modulo']) ):
			          				  $banderahijo = 1;
			          				  endif;?>
			          <?php endforeach; ?>				  
			          <?php if( $banderahijo == 1) : ?>
		          			<ul>		          				
		          				<?php foreach ($hijo['hijos'] as $nieto) : ?>
			          				<?php if(validate_action('listar',$nieto['modulo']) || validate_action('publicar',$nieto['modulo']) ):?>
			                  			<li ><a <?php if($nieto['aplicacion']):?> href="<?php echo url_for($nieto['aplicacion'])?>" <?php else: ?> href="<?php echo url_for($nieto['url'])?>" <?php endif; ?>><?php echo $nieto['nombre'] ?></a></li>	 
			          		  		<?php endif; ?>
			      		  		<?php endforeach; ?>
		          			</ul>
		          	  <?php endif; ?>
		          	  <?php endif; ?>
		          	  </li>
		            <?php endif; ?>
	        	<?php endforeach; ?>
	            </ul>
	        <?php endif; ?>	
	        <?php endif; ?>	
            </li>
          <?php endif;?>
         <?php endif;?>
       <?php endforeach; ?>         
        </ul>
      </div>
    </div>
  </div>