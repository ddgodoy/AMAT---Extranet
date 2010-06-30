    <div class="mapa">
      <strong>Administrador </strong>&gt; <a href="<?php echo url_for('noticias/index') ?>">Noticia</a> &gt; Modificar Noticia
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="95%"><h1>Ficha de Noticia - Modificar</h1></td>
        <td width="5%" align="right"><a href="#"><a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a></a></td>
      </tr>
    </table>
    <div class="botonera">
    </div>

<?php include_partial('form', array('form' => $form)) ?>
