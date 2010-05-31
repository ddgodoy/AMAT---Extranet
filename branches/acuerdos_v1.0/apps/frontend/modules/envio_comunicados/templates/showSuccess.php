<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $envio_comunicado->getid() ?></td>
    </tr>
    <tr>
      <th>Tipo comunicado:</th>
      <td><?php echo $envio_comunicado->gettipo_comunicado_id() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $envio_comunicado->getcreated_at() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $envio_comunicado->getupdated_at() ?></td>
    </tr>
    <tr>
      <th>Deleted:</th>
      <td><?php echo $envio_comunicado->getdeleted() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('envio_comunicados/edit?id='.$envio_comunicado->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('envio_comunicados/index') ?>">List</a>
