<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCategoriaOrganismo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('categoria_organismo');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
    }

    public function setUp()
    {
        $this->hasMany('Organismo', array(
             'local' => 'id',
             'foreign' => 'categoria_organismo_id'));

        $this->hasMany('Circular', array(
             'local' => 'id',
             'foreign' => 'categoria_organismo_id'));

        $this->hasMany('DocumentacionOrganismo', array(
             'local' => 'id',
             'foreign' => 'categoria_organismo_id'));

        $this->hasMany('ArchivoDO', array(
             'local' => 'id',
             'foreign' => 'categoria_organismo_id'));

        $this->hasMany('SubCategoriaOrganismo', array(
             'local' => 'id',
             'foreign' => 'categoria_organismo_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}