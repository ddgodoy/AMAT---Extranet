<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseEnvioError extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('envio_error');
        $this->hasColumn('envio_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('usuario_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('error', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('estado', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        $this->hasOne('Usuario', array(
             'local' => 'usuario_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('EnvioComunicado', array(
             'local' => 'envio_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}