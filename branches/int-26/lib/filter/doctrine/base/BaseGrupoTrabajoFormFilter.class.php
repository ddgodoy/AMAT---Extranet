<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * GrupoTrabajo filter form base class.
 *
 * @package    filters
 * @subpackage GrupoTrabajo *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseGrupoTrabajoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'        => new sfWidgetFormFilterInput(),
      'detalle'       => new sfWidgetFormFilterInput(),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'usuarios_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Usuario')),
    ));

    $this->setValidators(array(
      'nombre'        => new sfValidatorPass(array('required' => false)),
      'detalle'       => new sfValidatorPass(array('required' => false)),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'usuarios_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'Usuario', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('grupo_trabajo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addUsuariosListColumnQuery(Doctrine_Query $query, $field, $values)
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
          ->andWhereIn('UsuarioGrupoTrabajo.usuario_id', $values);
  }

  public function getModelName()
  {
    return 'GrupoTrabajo';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'nombre'        => 'Text',
      'detalle'       => 'Text',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
      'deleted'       => 'Boolean',
      'usuarios_list' => 'ManyKey',
    );
  }
}