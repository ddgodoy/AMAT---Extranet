<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseEvento extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('evento');
        $this->hasColumn('titulo', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('descripcion', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('mas_info', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('fecha', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('fecha_caducidad', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('imagen', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('mas_imagen', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('documento', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('organizador', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('estado', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'guardado',
              1 => 'pendiente',
              2 => 'publicado',
             ),
             ));
        $this->hasColumn('ambito', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'intranet',
              1 => 'web',
              2 => 'ambos',
             ),
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
        $this->hasColumn('mutua_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        $this->hasOne('Mutua', array(
             'local' => 'mutua_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Usuario as Usuarios', array(
             'refClass' => 'UsuarioEvento',
             'local' => 'evento_id',
             'foreign' => 'usuario_id'));

        $this->hasMany('Agenda', array(
             'local' => 'id',
             'foreign' => 'evento_id'));

        $this->hasMany('UsuarioEvento as UsuarioEventos', array(
             'local' => 'id',
             'foreign' => 'evento_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}