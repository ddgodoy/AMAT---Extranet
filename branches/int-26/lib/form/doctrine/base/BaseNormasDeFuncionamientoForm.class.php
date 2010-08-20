<?php

/**
 * NormasDeFuncionamiento form base class.
 *
 * @package    form
 * @subpackage normas_de_funcionamiento
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseNormasDeFuncionamientoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'titulo'           => new sfWidgetFormTextarea(),
      'descripcion'      => new sfWidgetFormTextarea(),
      'grupo_trabajo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'GrupoTrabajo', 'add_empty' => false)),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'deleted'          => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => 'NormasDeFuncionamiento', 'column' => 'id', 'required' => false)),
      'titulo'           => new sfValidatorString(array('required' => false)),
      'descripcion'      => new sfValidatorString(array('required' => false)),
      'grupo_trabajo_id' => new sfValidatorDoctrineChoice(array('model' => 'GrupoTrabajo')),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
      'deleted'          => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('normas_de_funcionamiento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NormasDeFuncionamiento';
  }

}
