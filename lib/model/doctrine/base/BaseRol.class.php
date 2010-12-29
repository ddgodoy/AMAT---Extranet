<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseRol extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('rol');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('detalle', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('codigo', 'string', 32, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '32',
             ));
        $this->hasColumn('excepcion', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
    }

    public function setUp()
    {
        $this->hasMany('Usuario as Usuarios', array(
             'refClass' => 'UsuarioRol',
             'local' => 'rol_id',
             'foreign' => 'usuario_id'));

        $this->hasMany('AplicacionRol', array(
             'local' => 'id',
             'foreign' => 'rol_id'));

        $this->hasMany('UsuarioRol as UsuarioRoles', array(
             'local' => 'id',
             'foreign' => 'rol_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}