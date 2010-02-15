<script language="JavaScript">

function SetAllCheckBoxes(formName, className, checkValue)
{
	var checkboxs = $$("input." + className);
	checkboxs.each(function(s) {
		s.checked = checkValue;
	});
}

</script>

    <div class="mapa">
     <strong><?php echo $DAtos['tipo']; ?></strong> &gt; Convocatoria - <?php if($DAtos['titulo'] != 'Convocatoria'){ echo 'Asamblea';}?>- Convocados
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
        <td width="95%"><h1><?php echo $DAtos['tipo']; ?></h1></td>
        <td width="5%" align="right"><a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a></td>
      </tr>
    </tbody></table><br/>
    
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
      <tbody><tr>
        <th width="30%">Nombre</th>
        <th width="30%">Apellido</th>
        <th width="20%">Estado de convocatoria</th>
        <th width="20%">Comentario</th>
      </tr>
      <?php $i=0; foreach ($convocados as $convocado): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
      <tr class="<?php echo $odd ?>">
        <td><?php echo $convocado->getUsuario()->getNombre() ?></td>
        <td><?php echo $convocado->getUsuario()->getApellido() ?></td>
        <td>
          <span href="#" class="estatus <?php echo $convocado->getEstado() ?>"><?php echo ucwords($convocado->getEstado()) ?></span>
        </td>        
        <td valign="top" >
         <?php if($convocado->getDetalle()):?>
         <?php echo image_tag('aceptada.png').' '; echo link_to('ver comentario','asambleas/ver?idCon='.$convocado->getId().'&'.$DAtos['get'])?>
         <?php endif;?>
        </td>        
      </tr>
      <?php endforeach; ?>
    </tbody></table>
    