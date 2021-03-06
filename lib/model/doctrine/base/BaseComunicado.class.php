<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseComunicado extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('comunicado');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('detalle', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('en_intranet', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('enviado', 'boolean', null, array(
             'type' => 'boolean',
             'values' => 
             array(
              0 => 0,
             ),
             ));
    }

    public function setUp()
    {
        $this->hasMany('EnvioComunicado', array(
             'local' => 'id',
             'foreign' => 'comunicado_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}