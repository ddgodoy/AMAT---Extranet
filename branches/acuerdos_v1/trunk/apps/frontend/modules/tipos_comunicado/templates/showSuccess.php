<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $tipo_comunicado->getid() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $tipo_comunicado->getnombre() ?></td>
    </tr>
    <tr>
      <th>Archivo:</th>
      <td><?php echo $tipo_comunicado->getarchivo() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $tipo_comunicado->getcreated_at() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $tipo_comunicado->getupdated_at() ?></td>
    </tr>
    <tr>
      <th>Deleted:</th>
      <td><?php echo $tipo_comunicado->getdeleted() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('tipos_comunicado/edit?id='.$tipo_comunicado->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('tipos_comunicado/index') ?>">List</a>
