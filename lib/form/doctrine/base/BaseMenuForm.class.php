<?php

/**
 * Menu form base class.
 *
 * @package    form
 * @subpackage menu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseMenuForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'padre_id'      => new sfWidgetFormInput(),
      'nombre'        => new sfWidgetFormInput(),
      'descripcion'   => new sfWidgetFormInput(),
      'aplicacion_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Aplicacion', 'add_empty' => true)),
      'url_externa'   => new sfWidgetFormInput(),
      'posicion'      => new sfWidgetFormInput(),
      'habilitado'    => new sfWidgetFormInputCheckbox(),
      'habilitado_sa' => new sfWidgetFormInputCheckbox(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'deleted'       => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorDoctrineChoice(array('model' => 'Menu', 'column' => 'id', 'required' => false)),
      'padre_id'      => new sfValidatorInteger(array('required' => false)),
      'nombre'        => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'descripcion'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'aplicacion_id' => new sfValidatorDoctrineChoice(array('model' => 'Aplicacion', 'required' => false)),
      'url_externa'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'posicion'      => new sfValidatorInteger(array('required' => false)),
      'habilitado'    => new sfValidatorBoolean(array('required' => false)),
      'habilitado_sa' => new sfValidatorBoolean(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'updated_at'    => new sfValidatorDateTime(array('required' => false)),
      'deleted'       => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('menu[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Menu';
  }

}
