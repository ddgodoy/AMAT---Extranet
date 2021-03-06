<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseAgenda extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('agenda');
        $this->hasColumn('fecha', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('titulo', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('Organizador', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('url', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('evento_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('convocatoria_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('usuario_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('publico', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        $this->hasOne('Convocatoria', array(
             'local' => 'convocatoria_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Evento', array(
             'local' => 'evento_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Usuario', array(
             'local' => 'usuario_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}