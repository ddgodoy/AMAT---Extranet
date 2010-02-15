<?php

/**
 * Comunicado form base class.
 *
 * @package    form
 * @subpackage comunicado
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseComunicadoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'nombre'      => new sfWidgetFormInput(),
      'detalle'     => new sfWidgetFormTextarea(),
      'en_intranet' => new sfWidgetFormInputCheckbox(),
      'enviado'     => new sfWidgetFormInputCheckbox(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'deleted'     => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => 'Comunicado', 'column' => 'id', 'required' => false)),
      'nombre'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'detalle'     => new sfValidatorString(array('required' => false)),
      'en_intranet' => new sfValidatorBoolean(array('required' => false)),
      'enviado'     => new sfValidatorBoolean(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
      'deleted'     => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('comunicado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Comunicado';
  }

}
