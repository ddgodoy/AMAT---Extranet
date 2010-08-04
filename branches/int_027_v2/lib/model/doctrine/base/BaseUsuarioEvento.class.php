<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseUsuarioEvento extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('usuario_evento');
        $this->hasColumn('usuario_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('evento_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        $this->hasOne('Usuario', array(
             'local' => 'usuario_id',
             'foreign' => 'id'));

        $this->hasOne('Evento', array(
             'local' => 'evento_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}