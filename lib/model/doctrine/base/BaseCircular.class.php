<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCircular extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('circular');
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
        $this->hasColumn('fecha_caducidad', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('numero', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('documento', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('circular_tema_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('circular_sub_tema_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('categoria_organismo_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('subcategoria_organismo_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        $this->hasOne('CircularCatTema', array(
             'local' => 'circular_tema_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('CircularSubTema', array(
             'local' => 'circular_sub_tema_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('CategoriaOrganismo', array(
             'local' => 'categoria_organismo_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('SubCategoriaOrganismo', array(
             'local' => 'subcategoria_organismo_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}