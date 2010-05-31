<?php

/**
 * SubCategoriaAcuerdo form base class.
 *
 * @package    form
 * @subpackage sub_categoria_acuerdo
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseSubCategoriaAcuerdoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'nombre'               => new sfWidgetFormTextarea(),
      'contenido'            => new sfWidgetFormTextarea(),
      'categoria_acuerdo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaAcuerdo', 'add_empty' => true)),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'deleted'              => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaAcuerdo', 'column' => 'id', 'required' => false)),
      'nombre'               => new sfValidatorString(array('required' => false)),
      'contenido'            => new sfValidatorString(array('required' => false)),
      'categoria_acuerdo_id' => new sfValidatorDoctrineChoice(array('model' => 'CategoriaAcuerdo', 'required' => false)),
      'created_at'           => new sfValidatorDateTime(array('required' => false)),
      'updated_at'           => new sfValidatorDateTime(array('required' => false)),
      'deleted'              => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('sub_categoria_acuerdo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SubCategoriaAcuerdo';
  }

}
