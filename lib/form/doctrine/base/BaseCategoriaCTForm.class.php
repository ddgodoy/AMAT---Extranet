<?php

/**
 * CategoriaCT form base class.
 *
 * @package    form
 * @subpackage categoria_ct
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseCategoriaCTForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'nombre'     => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'CategoriaCT', 'column' => 'id', 'required' => false)),
      'nombre'     => new sfValidatorString(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted'    => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('categoria_ct[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategoriaCT';
  }

}