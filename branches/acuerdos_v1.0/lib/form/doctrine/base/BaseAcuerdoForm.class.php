<?php

/**
 * Acuerdo form base class.
 *
 * @package    form
 * @subpackage acuerdo
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseAcuerdoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'nombre'                  => new sfWidgetFormTextarea(),
      'contenido'               => new sfWidgetFormTextarea(),
      'fecha'                   => new sfWidgetFormDate(),
      'categoria_acuerdo_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaAcuerdo', 'add_empty' => true)),
      'subcategoria_acuerdo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaAcuerdo', 'add_empty' => true)),
      'documento'               => new sfWidgetFormInput(),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
      'deleted'                 => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorDoctrineChoice(array('model' => 'Acuerdo', 'column' => 'id', 'required' => false)),
      'nombre'                  => new sfValidatorString(array('required' => false)),
      'contenido'               => new sfValidatorString(array('required' => false)),
      'fecha'                   => new sfValidatorDate(),
      'categoria_acuerdo_id'    => new sfValidatorDoctrineChoice(array('model' => 'CategoriaAcuerdo', 'required' => false)),
      'subcategoria_acuerdo_id' => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaAcuerdo', 'required' => false)),
      'documento'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'updated_at'              => new sfValidatorDateTime(array('required' => false)),
      'deleted'                 => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('acuerdo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Acuerdo';
  }

}
