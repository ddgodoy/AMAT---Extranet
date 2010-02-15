<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BasePublicacion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('publicacion');
        $this->hasColumn('titulo', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('autor', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '100',
             ));
        $this->hasColumn('contenido', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('imagen', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('documento', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('fecha', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('fecha_publicacion', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('fecha_caducidad', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('ambito', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'intranet',
              1 => 'web',
              2 => 'todos',
             ),
             ));
        $this->hasColumn('estado', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'pendiente',
              1 => 'publicado',
             ),
             ));
        $this->hasColumn('destacada', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('mutua_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('owner_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id_creador', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id_modificado', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id_publicado', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('fecha_publicado', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
    }

    public function setUp()
    {
        $this->hasOne('Mutua', array(
             'local' => 'mutua_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Usuario', array(
             'local' => 'owner_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}