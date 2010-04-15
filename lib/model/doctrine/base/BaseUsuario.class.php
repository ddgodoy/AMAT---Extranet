<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseUsuario extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('usuario');
        $this->hasColumn('login', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('crypted_password', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('salt', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('nombre', 'string', 150, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '150',
             ));
        $this->hasColumn('apellido', 'string', 150, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '150',
             ));
        $this->hasColumn('email', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('activo', 'boolean', null, array(
             'type' => 'boolean',
             'values' => 
             array(
              0 => 0,
             ),
             ));
        $this->hasColumn('telefono', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('remember_token', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('remember_token_expires', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('mutua_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        $this->hasOne('Mutua', array(
             'local' => 'mutua_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Rol as Roles', array(
             'refClass' => 'UsuarioRol',
             'local' => 'usuario_id',
             'foreign' => 'rol_id'));

        $this->hasMany('GrupoTrabajo as GruposTrabajo', array(
             'refClass' => 'UsuarioGrupoTrabajo',
             'local' => 'usuario_id',
             'foreign' => 'grupo_trabajo_id'));

        $this->hasMany('ConsejoTerritorial as ConsejosTerritoriales', array(
             'refClass' => 'UsuarioConsejoTerritorial',
             'local' => 'usuario_id',
             'foreign' => 'consejo_territorial_id'));

        $this->hasMany('Organismo as Organismos', array(
             'refClass' => 'UsuarioOrganismo',
             'local' => 'usuario_id',
             'foreign' => 'organismo_id'));

        $this->hasMany('Evento as Eventos', array(
             'refClass' => 'UsuarioEvento',
             'local' => 'usuario_id',
             'foreign' => 'evento_id'));

        $this->hasMany('Asamblea', array(
             'local' => 'id',
             'foreign' => 'owner_id'));

        $this->hasMany('UsuarioAsamblea as UsuarioEventos', array(
             'local' => 'id',
             'foreign' => 'usuario_id'));

        $this->hasMany('Convocatoria', array(
             'local' => 'id',
             'foreign' => 'usuario_id'));

        $this->hasMany('Acta', array(
             'local' => 'id',
             'foreign' => 'owner_id'));

        $this->hasMany('Noticia', array(
             'local' => 'id',
             'foreign' => 'owner_id'));

        $this->hasMany('UsuarioRol as UsuarioRoles', array(
             'local' => 'id',
             'foreign' => 'usuario_id'));

        $this->hasMany('UsuarioConsejoTerritorial as UsuarioConsejosTerritoriales', array(
             'local' => 'id',
             'foreign' => 'usuario_id'));

        $this->hasMany('UsuarioGrupoTrabajo as UsuarioGruposTrabajo', array(
             'local' => 'id',
             'foreign' => 'usuario_id'));

        $this->hasMany('UsuarioAplicacionExterna as UsuarioAplicacionExternas', array(
             'local' => 'id',
             'foreign' => 'usuario_id'));

        $this->hasMany('UsuarioOrganismo as UsuarioOrganismos', array(
             'local' => 'id',
             'foreign' => 'usuario_id'));

        $this->hasMany('Agenda', array(
             'local' => 'id',
             'foreign' => 'usuario_id'));

        $this->hasMany('Publicacion', array(
             'local' => 'id',
             'foreign' => 'owner_id'));

        $this->hasMany('AplicacionExterna as AplicacionExternas', array(
             'refClass' => 'UsuarioAplicacionExterna',
             'local' => 'usuario_id',
             'foreign' => 'aplicacion_externa_id'));

        $this->hasMany('Actividad', array(
             'local' => 'id',
             'foreign' => 'owner_id'));

        $this->hasMany('CifraDato', array(
             'local' => 'id',
             'foreign' => 'owner_id'));

        $this->hasMany('EnvioError', array(
             'local' => 'id',
             'foreign' => 'usuario_id'));

        $this->hasMany('Envios', array(
             'local' => 'id',
             'foreign' => 'usuario_id'));

        $this->hasMany('UsuarioListaComunicado as UsuarioListasComunicado', array(
             'local' => 'id',
             'foreign' => 'usuario_id'));

        $this->hasMany('Notificacion', array(
             'local' => 'id',
             'foreign' => 'usuario_id'));

        $this->hasMany('SolicitudClave', array(
             'local' => 'id',
             'foreign' => 'usuario_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}