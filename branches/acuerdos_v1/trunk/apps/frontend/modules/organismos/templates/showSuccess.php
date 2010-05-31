<?php use_helper('Security');?>
<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $organismo->getid() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $organismo->getnombre() ?></td>
    </tr>
    <tr>
      <th>Detalle:</th>
      <td><?php echo $organismo->getdetalle() ?></td>
    </tr>
    <tr>
      <th>Grupo trabajo:</th>
      <td><?php echo $organismo->getgrupo_trabajo_id() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $organismo->getcreated_at() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $organismo->getupdated_at() ?></td>
    </tr>
    <tr>
      <th>Deleted:</th>
      <td><?php echo $organismo->getdeleted() ?></td>
    </tr>
  </tbody>
</table>

<hr />
<?php if(validate_action('modificar')):?>
<a href="<?php echo url_for('organismos/edit?id='.$organismo->getId()) ?>">Edit</a>
<?php endif; ?>
&nbsp;
<a href="<?php echo url_for('organismos/index') ?>">List</a>
