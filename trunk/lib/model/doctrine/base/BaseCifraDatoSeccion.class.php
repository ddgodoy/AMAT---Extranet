<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCifraDatoSeccion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cifra_dato_seccion');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
    }

    public function setUp()
    {
        $this->hasMany('CifraDato', array(
             'local' => 'id',
             'foreign' => 'seccion_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}