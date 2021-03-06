<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseOrganismo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('organismo');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('detalle', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('grupo_trabajo_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
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
        $this->hasOne('GrupoTrabajo', array(
             'local' => 'grupo_trabajo_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Usuario as Usuarios', array(
             'refClass' => 'UsuarioOrganismo',
             'local' => 'organismo_id',
             'foreign' => 'usuario_id'));

        $this->hasOne('CategoriaOrganismo', array(
             'local' => 'categoria_organismo_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('SubCategoriaOrganismo', array(
             'local' => 'subcategoria_organismo_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('UsuarioOrganismo as UsuarioOrganismos', array(
             'local' => 'id',
             'foreign' => 'organismo_id'));

        $this->hasMany('DocumentacionOrganismo', array(
             'local' => 'id',
             'foreign' => 'organismo_id'));

        $this->hasMany('ArchivoDO', array(
             'local' => 'id',
             'foreign' => 'organismo_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}