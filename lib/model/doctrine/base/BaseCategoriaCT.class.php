<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCategoriaCT extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('categoria_c_t');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
    }

    public function setUp()
    {
        $this->hasMany('DocumentacionConsejo', array(
             'local' => 'id',
             'foreign' => 'categoria_c_t_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}