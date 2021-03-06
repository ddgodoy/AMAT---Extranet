<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCircularCatTema extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('circular_cat_tema');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
    }

    public function setUp()
    {
        $this->hasMany('Circular', array(
             'local' => 'id',
             'foreign' => 'circular_tema_id'));

        $this->hasMany('CircularSubTema', array(
             'local' => 'id',
             'foreign' => 'circular_cat_tema_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}