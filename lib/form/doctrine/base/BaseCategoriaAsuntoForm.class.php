<?php

/**
 * CategoriaAsunto form base class.
 *
 * @package    form
 * @subpackage categoria_asunto
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseCategoriaAsuntoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'nombre'     => new sfWidgetFormTextarea(),
      'email_1'    => new sfWidgetFormInput(),
      'activo_1'   => new sfWidgetFormInput(),
      'email_2'    => new sfWidgetFormInput(),
      'activo_2'   => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'CategoriaAsunto', 'column' => 'id', 'required' => false)),
      'nombre'     => new sfValidatorString(array('required' => false)),
      'email_1'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'activo_1'   => new sfValidatorInteger(array('required' => false)),
      'email_2'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'activo_2'   => new sfValidatorInteger(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted'    => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('categoria_asunto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategoriaAsunto';
  }

}
