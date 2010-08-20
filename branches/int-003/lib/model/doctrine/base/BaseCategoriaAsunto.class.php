<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCategoriaAsunto extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('categoria_asunto');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('email_1', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('activo_1', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('email_2', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('activo_2', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}