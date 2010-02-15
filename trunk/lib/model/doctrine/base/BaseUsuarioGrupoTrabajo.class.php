<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseUsuarioGrupoTrabajo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('usuario_grupo_trabajo');
        $this->hasColumn('usuario_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('grupo_trabajo_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
    }

    public function setUp()
    {
        $this->hasOne('Usuario', array(
             'local' => 'usuario_id',
             'foreign' => 'id'));

        $this->hasOne('GrupoTrabajo', array(
             'local' => 'grupo_trabajo_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}