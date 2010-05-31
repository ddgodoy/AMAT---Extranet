<?php

/**
 * SubCategoriaIniciativa form base class.
 *
 * @package    form
 * @subpackage sub_categoria_iniciativa
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseSubCategoriaIniciativaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'nombre'                  => new sfWidgetFormTextarea(),
      'contenido'               => new sfWidgetFormTextarea(),
      'categoria_iniciativa_id' => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaIniciativa', 'add_empty' => true)),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
      'deleted'                 => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaIniciativa', 'column' => 'id', 'required' => false)),
      'nombre'                  => new sfValidatorString(array('required' => false)),
      'contenido'               => new sfValidatorString(array('required' => false)),
      'categoria_iniciativa_id' => new sfValidatorDoctrineChoice(array('model' => 'CategoriaIniciativa', 'required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'updated_at'              => new sfValidatorDateTime(array('required' => false)),
      'deleted'                 => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('sub_categoria_iniciativa[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SubCategoriaIniciativa';
  }

}
