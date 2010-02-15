<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseNormativa extends Documentacion
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('normativa');
        $this->hasColumn('categoria_normativa_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('subcategoria_normativa_uno_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('subcategoria_normativa_dos_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('documento', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('CategoriaNormativa', array(
             'local' => 'categoria_normativa_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('SubCategoriaNormativaN1', array(
             'local' => 'subcategoria_normativa_uno_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('SubCategoriaNormativaN2', array(
             'local' => 'subcategoria_normativa_dos_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}