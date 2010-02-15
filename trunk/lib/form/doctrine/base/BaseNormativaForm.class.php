<?php

/**
 * Normativa form base class.
 *
 * @package    form
 * @subpackage normativa
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseNormativaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                            => new sfWidgetFormInputHidden(),
      'nombre'                        => new sfWidgetFormTextarea(),
      'contenido'                     => new sfWidgetFormTextarea(),
      'fecha'                         => new sfWidgetFormDate(),
      'categoria_normativa_id'        => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaNormativa', 'add_empty' => true)),
      'subcategoria_normativa_uno_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaNormativaN1', 'add_empty' => true)),
      'subcategoria_normativa_dos_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaNormativaN2', 'add_empty' => true)),
      'documento'                     => new sfWidgetFormInput(),
      'created_at'                    => new sfWidgetFormDateTime(),
      'updated_at'                    => new sfWidgetFormDateTime(),
      'deleted'                       => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                            => new sfValidatorDoctrineChoice(array('model' => 'Normativa', 'column' => 'id', 'required' => false)),
      'nombre'                        => new sfValidatorString(array('required' => false)),
      'contenido'                     => new sfValidatorString(array('required' => false)),
      'fecha'                         => new sfValidatorDate(),
      'categoria_normativa_id'        => new sfValidatorDoctrineChoice(array('model' => 'CategoriaNormativa', 'required' => false)),
      'subcategoria_normativa_uno_id' => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaNormativaN1', 'required' => false)),
      'subcategoria_normativa_dos_id' => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaNormativaN2', 'required' => false)),
      'documento'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'                    => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                    => new sfValidatorDateTime(array('required' => false)),
      'deleted'                       => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('normativa[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Normativa';
  }

}
