<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseContenidoNotificacion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('contenido_notificacion');
        $this->hasColumn('titulo', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('mensaje', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('accion', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'creacion',
              1 => 'lectura',
              2 => 'modificacion',
              3 => 'eliminacion',
              4 => 'invitacion',
             ),
             ));
        $this->hasColumn('entidad', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
    }

    public function setUp()
    {
        $this->hasMany('Notificacion', array(
             'local' => 'id',
             'foreign' => 'contenido_notificacion_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}