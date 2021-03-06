<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * UsuarioListaComunicado filter form base class.
 *
 * @package    filters
 * @subpackage UsuarioListaComunicado *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseUsuarioListaComunicadoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('usuario_lista_comunicado_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioListaComunicado';
  }

  public function getFields()
  {
    return array(
      'usuario_id'          => 'Number',
      'lista_comunicado_id' => 'Number',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'deleted'             => 'Boolean',
    );
  }
}