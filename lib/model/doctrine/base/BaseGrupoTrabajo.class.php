<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseGrupoTrabajo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('grupo_trabajo');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('detalle', 'clob', null, array(
             'type' => 'clob',
             ));
    }

    public function setUp()
    {
        $this->hasMany('Usuario as Usuarios', array(
             'refClass' => 'UsuarioGrupoTrabajo',
             'local' => 'grupo_trabajo_id',
             'foreign' => 'usuario_id'));

        $this->hasMany('Organismo', array(
             'local' => 'id',
             'foreign' => 'grupo_trabajo_id'));

        $this->hasMany('NormasDeFuncionamiento', array(
             'local' => 'id',
             'foreign' => 'grupo_trabajo_id'));

        $this->hasMany('UsuarioGrupoTrabajo as UsuarioGruposTrabajo', array(
             'local' => 'id',
             'foreign' => 'grupo_trabajo_id'));

        $this->hasMany('DocumentacionGrupo', array(
             'local' => 'id',
             'foreign' => 'grupo_trabajo_id'));

        $this->hasMany('ArchivoDG', array(
             'local' => 'id',
             'foreign' => 'grupo_trabajo_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}