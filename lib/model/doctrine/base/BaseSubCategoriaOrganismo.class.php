<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseSubCategoriaOrganismo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('sub_categoria_organismo');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('categoria_organismo_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        $this->hasOne('CategoriaOrganismo', array(
             'local' => 'categoria_organismo_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Organismo', array(
             'local' => 'id',
             'foreign' => 'subcategoria_organismo_id'));

        $this->hasMany('Circular', array(
             'local' => 'id',
             'foreign' => 'subcategoria_organismo_id'));

        $this->hasMany('DocumentacionOrganismo', array(
             'local' => 'id',
             'foreign' => 'subcategoria_organismo_id'));

        $this->hasMany('ArchivoDO', array(
             'local' => 'id',
             'foreign' => 'subcategoria_organismo_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}