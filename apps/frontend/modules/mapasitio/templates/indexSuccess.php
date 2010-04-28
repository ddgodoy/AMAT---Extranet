<?php use_helper('Security');?>
<div class="content">
    <div class="mapaweb">
      <h1>Mapa de Web</h1>
 <?php $r = 0; $arrMenu = sfContext::getInstance()->getUser()->getAttribute('menu') ?>
  <?php foreach ($arrMenu as $item) : $r++; $banderaInicio = 0; ?>
    <?php if (count($item['hijos']) >=1) :?>
        <?php foreach ($item['hijos'] as $verelmoduloInicial) : ?>
             <?php if(validate_action('listar',$verelmoduloInicial['modulo'])|| validate_action('publicar',$verelmoduloInicial['modulo']) ):
                $banderaInicio = 1;
              endif;?>
             <?php endforeach; ?>
       <?php if($banderaInicio == 1): ?>
       <?php if($r == 1 ){ echo '<div class="col1">';}?>
         <ul class="tema"> 
           <li> 
        	<h4><?php echo $item['nombre'] ?></h4>
        	<?php if ($item['hijos']) :?>
	        	<ul>
	        	<?php foreach ($item['hijos'] as $hijo) : ?>
	        	  <?php if(validate_action('listar',$hijo['modulo'])):?>
		             <li>
		                <a <?php if($hijo['hijos']):?> class="current" <?php endif; ?>  <?php if($hijo['modulo']):?> href="<?php echo url_for($hijo['modulo'].'/index') ?>" <?php else: ?> style="cursor:default;" <?php endif; ?>><?php echo $hijo['nombre'] ?></a>
		              <?php if($hijo['hijos']):?>
		          			<ul>		          				
		          				<?php foreach ($hijo['hijos'] as $nieto) : ?>
			          				<?php if(validate_action('listar',$nieto['modulo'])):?>
			                  			<li><a href="<?php echo url_for($nieto['modulo'].'/index') ?>"><?php echo $nieto['nombre'] ?></a></li>	 
			          		  		<?php endif; ?>
		          		  		<?php endforeach; ?>
		          			</ul>
		          	  <?php endif; ?>
		          	  </li>
		          <?php endif; ?>
	          	<?php endforeach; ?>
	            </ul>
	        <?php endif; ?>	
	       </li>
	      </ul>
	     <br clear="all" />
	    <?php if($r == 2 ){ echo '</div>'; $r = 0;}?>
           <?php endif; ?>
        <?php endif; ?>
      <?php endforeach; ?> 
       <br clear="all" />
      <br clear="all" />
      <br clear="all" />
      <br clear="all" />
    <ul class="especial">
        <h4>Otros Links</h4>
       <li><a href="<?php echo url_for('inicio/index') ?>" class="a">INICIO</a></li>
		<li><a href="<?php echo url_for('mapasitio/index') ?>" class="d">MAPA DE WEB</a></li>
		<li><a href="<?php echo url_for('usuarios/perfil') ?>" class="b">MIS DATOS</a></li>
        <li><a href="<?php echo url_for('contacto/index') ?>">CONTACTO</a></li>
      </ul> 
     </div>
</div>  