<h1>
	Ultimos Avisos <span class="der"><a href="<?php echo url_for('notificaciones/index') ?>">Ver más avisos</a></span>
</h1>
<?php if (count($ultimos_avisos) > 0): ?>
<table class="herramientas" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
    <tr>
      <th align="left" width="10%">Fecha</th>
      <th align="left" width="60%">Titulo </th>
      <th align="left" width="30%">Tipo </th>
    </tr>
    <?php $i=0; foreach ($ultimos_avisos as $aviso): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
    <tr class="<?php echo $odd ?>">
      <td align="left"><?php echo date("d/m/Y", strtotime($aviso->getCreatedAt())) ?></td>
      <td><a href="<?php echo url_for($aviso->getUrl()) ?>"><?php echo $aviso->getNombre() /*$aviso->getContenidoNotificacion()->getTitulo()*/ ?></a></td>
      <td><?php echo $aviso->getContenidoNotificacion()->getEntidad() /*$aviso->getContenidoNotificacion()->getTitulo()*/ ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>