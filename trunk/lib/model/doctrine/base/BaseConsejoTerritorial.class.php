<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseConsejoTerritorial extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('consejo_territorial');
        $this->hasColumn('nombre', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('detalle', 'clob', null, array(
             'type' => 'clob',
             ));
    }

    public function setUp()
    {
        $this->hasMany('Usuario as Usuarios', array(
             'refClass' => 'UsuarioConsejoTerritorial',
             'local' => 'consejo_territorial_id',
             'foreign' => 'usuario_id'));

        $this->hasMany('UsuarioConsejoTerritorial as UsuarioConsejosTerritoriales', array(
             'local' => 'id',
             'foreign' => 'consejo_territorial_id'));

        $this->hasMany('DocumentacionConsejo', array(
             'local' => 'id',
             'foreign' => 'consejo_territorial_id'));

        $this->hasMany('ArchivoCT', array(
             'local' => 'id',
             'foreign' => 'consejo_territorial_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}