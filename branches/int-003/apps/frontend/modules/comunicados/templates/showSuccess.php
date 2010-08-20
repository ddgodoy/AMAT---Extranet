<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $comunicado->getid() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $comunicado->getnombre() ?></td>
    </tr>
    <tr>
      <th>Detalle:</th>
      <td><?php echo $comunicado->getdetalle() ?></td>
    </tr>
    <tr>
      <th>En intranet:</th>
      <td><?php echo $comunicado->geten_intranet() ?></td>
    </tr>
    <tr>
      <th>Enviado:</th>
      <td><?php echo $comunicado->getenviado() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $comunicado->getcreated_at() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $comunicado->getupdated_at() ?></td>
    </tr>
    <tr>
      <th>Deleted:</th>
      <td><?php echo $comunicado->getdeleted() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('comunicados/edit?id='.$comunicado->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('comunicados/index') ?>">List</a>
