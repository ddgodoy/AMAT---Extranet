<?php

/**
 * CategoriaNormativa form base class.
 *
 * @package    form
 * @subpackage categoria_normativa
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseCategoriaNormativaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'nombre'     => new sfWidgetFormTextarea(),
      'contenido'  => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'CategoriaNormativa', 'column' => 'id', 'required' => false)),
      'nombre'     => new sfValidatorString(array('required' => false)),
      'contenido'  => new sfValidatorString(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted'    => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('categoria_normativa[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategoriaNormativa';
  }

}
