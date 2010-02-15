<?php

/**
 * Contenido form base class.
 *
 * @package    form
 * @subpackage contenido
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseContenidoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'titulo'     => new sfWidgetFormInput(),
      'contenido'  => new sfWidgetFormTextarea(),
      'permalink'  => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'Contenido', 'column' => 'id', 'required' => false)),
      'titulo'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'contenido'  => new sfValidatorString(array('required' => false)),
      'permalink'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted'    => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('contenido[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contenido';
  }

}
