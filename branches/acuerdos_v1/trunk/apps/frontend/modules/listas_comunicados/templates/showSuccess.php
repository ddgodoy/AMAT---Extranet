<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $lista_comunicado->getid() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $lista_comunicado->getnombre() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $lista_comunicado->getcreated_at() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $lista_comunicado->getupdated_at() ?></td>
    </tr>
    <tr>
      <th>Deleted:</th>
      <td><?php echo $lista_comunicado->getdeleted() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('listas_comunicados/edit?id='.$lista_comunicado->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('listas_comunicados/index') ?>">List</a>
