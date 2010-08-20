<?php

/**
 * Iniciativa form base class.
 *
 * @package    form
 * @subpackage iniciativa
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseIniciativaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'nombre'                     => new sfWidgetFormTextarea(),
      'contenido'                  => new sfWidgetFormTextarea(),
      'fecha'                      => new sfWidgetFormDate(),
      'categoria_iniciativa_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaIniciativa', 'add_empty' => true)),
      'subcategoria_iniciativa_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaIniciativa', 'add_empty' => true)),
      'documento'                  => new sfWidgetFormInput(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
      'deleted'                    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorDoctrineChoice(array('model' => 'Iniciativa', 'column' => 'id', 'required' => false)),
      'nombre'                     => new sfValidatorString(array('required' => false)),
      'contenido'                  => new sfValidatorString(array('required' => false)),
      'fecha'                      => new sfValidatorDate(),
      'categoria_iniciativa_id'    => new sfValidatorDoctrineChoice(array('model' => 'CategoriaIniciativa', 'required' => false)),
      'subcategoria_iniciativa_id' => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaIniciativa', 'required' => false)),
      'documento'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'                 => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                 => new sfValidatorDateTime(array('required' => false)),
      'deleted'                    => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('iniciativa[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Iniciativa';
  }

}
