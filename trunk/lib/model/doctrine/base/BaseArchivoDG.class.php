<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseArchivoDG extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('archivo_d_g');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('fecha', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('fecha_caducidad', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('contenido', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('archivo', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('owner_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('disponibilidad', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'Solo Grupo',
              1 => 'Todos',
             ),
             ));
        $this->hasColumn('grupo_trabajo_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('documentacion_grupo_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        $this->hasOne('GrupoTrabajo', array(
             'local' => 'grupo_trabajo_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('DocumentacionGrupo', array(
             'local' => 'documentacion_grupo_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}