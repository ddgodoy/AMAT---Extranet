<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * NormasDeFuncionamiento filter form base class.
 *
 * @package    filters
 * @subpackage NormasDeFuncionamiento *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseNormasDeFuncionamientoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'titulo'           => new sfWidgetFormFilterInput(),
      'descripcion'      => new sfWidgetFormFilterInput(),
      'grupo_trabajo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'GrupoTrabajo', 'add_empty' => true)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'titulo'           => new sfValidatorPass(array('required' => false)),
      'descripcion'      => new sfValidatorPass(array('required' => false)),
      'grupo_trabajo_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'GrupoTrabajo', 'column' => 'id')),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('normas_de_funcionamiento_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NormasDeFuncionamiento';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'titulo'           => 'Text',
      'descripcion'      => 'Text',
      'grupo_trabajo_id' => 'ForeignKey',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'deleted'          => 'Boolean',
    );
  }
}