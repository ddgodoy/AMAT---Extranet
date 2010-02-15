<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseMenu extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('menu');
        $this->hasColumn('padre_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('nombre', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('descripcion', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('aplicacion_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('url_externa', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('posicion', 'integer', null, array(
             'type' => 'integer',
             'values' => 
             array(
              0 => 0,
             ),
             ));
        $this->hasColumn('habilitado', 'boolean', null, array(
             'type' => 'boolean',
             ));
    }

    public function setUp()
    {
        $this->hasOne('Aplicacion', array(
             'local' => 'aplicacion_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}