<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseDocumentacion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('documentacion');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('contenido', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('fecha', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
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