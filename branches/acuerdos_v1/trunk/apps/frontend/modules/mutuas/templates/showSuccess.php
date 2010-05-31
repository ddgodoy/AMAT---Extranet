<?php use_helper('Security');?>
<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $mutua->getid() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $mutua->getnombre() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $mutua->getcreated_at() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $mutua->getupdated_at() ?></td>
    </tr>
    <tr>
      <th>Deleted:</th>
      <td><?php echo $mutua->getdeleted() ?></td>
    </tr>
  </tbody>
</table>

<hr />
<?php if(validate_action('modificar')):?>
<a href="<?php echo url_for('mutuas/editar?id='.$mutua->getId()) ?>">Editar</a>
<?php endif;?>
&nbsp;
<a href="<?php echo url_for('mutuas/index') ?>">Listar</a>
