<?php use_helper('Javascript') ?>

   <div class="mapa">
      <strong><?php echo $DAtos['tipo']; ?></strong> &gt; <a href="<?php echo url_for('asambleas/index?'.$DAtos['get']) ?>"> Convocatoria <?php if($DAtos['titulo'] != 'Convocatoria'){ echo 'Asamblea';}?></a> &gt; Crear <?php echo $DAtos['titulo'] ?>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="95%"><h1>Ficha de <?php echo $DAtos['titulo'] ?> - Crear Nueva</h1></td>
        <td width="5%" align="right"><a href="#"><a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a></a></td>
      </tr>
    </table>
    <div class="botonera">
    </div>

<?php include_partial('actas/form', array('form' => $form)) ?>