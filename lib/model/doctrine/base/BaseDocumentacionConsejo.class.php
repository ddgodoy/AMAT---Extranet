<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseDocumentacionConsejo extends Documentacion
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('documentacion_consejo');
        $this->hasColumn('consejo_territorial_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('categoria_c_t_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('estado', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'pendiente',
              1 => 'publicado',
             ),
             ));
        $this->hasColumn('owner_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('modificador_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('publicador_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('fecha_publicacion', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('user_id_creador', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id_modificado', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id_publicado', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('fecha_publicado', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('ConsejoTerritorial', array(
             'local' => 'consejo_territorial_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('CategoriaCT', array(
             'local' => 'categoria_c_t_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('ArchivoCT', array(
             'local' => 'id',
             'foreign' => 'documentacion_consejo_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}