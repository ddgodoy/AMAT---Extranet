<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Usuario filter form base class.
 *
 * @package    filters
 * @subpackage Usuario *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseUsuarioFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'login'                       => new sfWidgetFormFilterInput(),
      'crypted_password'            => new sfWidgetFormFilterInput(),
      'salt'                        => new sfWidgetFormFilterInput(),
      'nombre'                      => new sfWidgetFormFilterInput(),
      'apellido'                    => new sfWidgetFormFilterInput(),
      'email'                       => new sfWidgetFormFilterInput(),
      'activo'                      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'telefono'                    => new sfWidgetFormFilterInput(),
      'remember_token'              => new sfWidgetFormFilterInput(),
      'remember_token_expires'      => new sfWidgetFormFilterInput(),
      'mutua_id'                    => new sfWidgetFormDoctrineChoice(array('model' => 'Mutua', 'add_empty' => true)),
      'active_at'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'created_at'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'                     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'roles_list'                  => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Rol')),
      'grupos_trabajo_list'         => new sfWidgetFormDoctrineChoiceMany(array('model' => 'GrupoTrabajo')),
      'consejos_territoriales_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'ConsejoTerritorial')),
      'organismos_list'             => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Organismo')),
      'eventos_list'                => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Evento')),
      'aplicacion_externas_list'    => new sfWidgetFormDoctrineChoiceMany(array('model' => 'AplicacionExterna')),
    ));

    $this->setValidators(array(
      'login'                       => new sfValidatorPass(array('required' => false)),
      'crypted_password'            => new sfValidatorPass(array('required' => false)),
      'salt'                        => new sfValidatorPass(array('required' => false)),
      'nombre'                      => new sfValidatorPass(array('required' => false)),
      'apellido'                    => new sfValidatorPass(array('required' => false)),
      'email'                       => new sfValidatorPass(array('required' => false)),
      'activo'                      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'telefono'                    => new sfValidatorPass(array('required' => false)),
      'remember_token'              => new sfValidatorPass(array('required' => false)),
      'remember_token_expires'      => new sfValidatorPass(array('required' => false)),
      'mutua_id'                    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Mutua', 'column' => 'id')),
      'active_at'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'                     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'roles_list'                  => new sfValidatorDoctrineChoiceMany(array('model' => 'Rol', 'required' => false)),
      'grupos_trabajo_list'         => new sfValidatorDoctrineChoiceMany(array('model' => 'GrupoTrabajo', 'required' => false)),
      'consejos_territoriales_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'ConsejoTerritorial', 'required' => false)),
      'organismos_list'             => new sfValidatorDoctrineChoiceMany(array('model' => 'Organismo', 'required' => false)),
      'eventos_list'                => new sfValidatorDoctrineChoiceMany(array('model' => 'Evento', 'required' => false)),
      'aplicacion_externas_list'    => new sfValidatorDoctrineChoiceMany(array('model' => 'AplicacionExterna', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addRolesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.UsuarioRol UsuarioRol')
          ->andWhereIn('UsuarioRol.rol_id', $values);
  }

  public function addGruposTrabajoListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.UsuarioGrupoTrabajo UsuarioGrupoTrabajo')
          ->andWhereIn('UsuarioGrupoTrabajo.grupo_trabajo_id', $values);
  }

  public function addConsejosTerritorialesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.UsuarioConsejoTerritorial UsuarioConsejoTerritorial')
          ->andWhereIn('UsuarioConsejoTerritorial.consejo_territorial_id', $values);
  }

  public function addOrganismosListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.UsuarioOrganismo UsuarioOrganismo')
          ->andWhereIn('UsuarioOrganismo.organismo_id', $values);
  }

  public function addEventosListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.UsuarioEvento UsuarioEvento')
          ->andWhereIn('UsuarioEvento.evento_id', $values);
  }

  public function addAplicacionExternasListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.UsuarioAplicacionExterna UsuarioAplicacionExterna')
          ->andWhereIn('UsuarioAplicacionExterna.aplicacion_externa_id', $values);
  }

  public function getModelName()
  {
    return 'Usuario';
  }

  public function getFields()
  {
    return array(
      'id'                          => 'Number',
      'login'                       => 'Text',
      'crypted_password'            => 'Text',
      'salt'                        => 'Text',
      'nombre'                      => 'Text',
      'apellido'                    => 'Text',
      'email'                       => 'Text',
      'activo'                      => 'Boolean',
      'telefono'                    => 'Text',
      'remember_token'              => 'Text',
      'remember_token_expires'      => 'Text',
      'mutua_id'                    => 'ForeignKey',
      'active_at'                   => 'Date',
      'created_at'                  => 'Date',
      'updated_at'                  => 'Date',
      'deleted'                     => 'Boolean',
      'roles_list'                  => 'ManyKey',
      'grupos_trabajo_list'         => 'ManyKey',
      'consejos_territoriales_list' => 'ManyKey',
      'organismos_list'             => 'ManyKey',
      'eventos_list'                => 'ManyKey',
      'aplicacion_externas_list'    => 'ManyKey',
    );
  }
}