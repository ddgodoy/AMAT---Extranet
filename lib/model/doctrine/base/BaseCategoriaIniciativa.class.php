<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCategoriaIniciativa extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('categoria_iniciativa');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('contenido', 'clob', null, array(
             'type' => 'clob',
             ));
    }

    public function setUp()
    {
        $this->hasMany('Iniciativa', array(
             'local' => 'id',
             'foreign' => 'categoria_iniciativa_id'));

        $this->hasMany('SubCategoriaIniciativa', array(
             'local' => 'id',
             'foreign' => 'categoria_iniciativa_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}