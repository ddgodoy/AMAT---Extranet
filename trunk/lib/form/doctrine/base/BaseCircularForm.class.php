<?php

/**
 * Circular form base class.
 *
 * @package    form
 * @subpackage circular
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseCircularForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'nombre'                    => new sfWidgetFormTextarea(),
      'contenido'                 => new sfWidgetFormTextarea(),
      'fecha'                     => new sfWidgetFormDate(),
      'fecha_caducidad'           => new sfWidgetFormDate(),
      'numero'                    => new sfWidgetFormInput(),
      'documento'                 => new sfWidgetFormInput(),
      'circular_sub_tema_id'      => new sfWidgetFormDoctrineChoice(array('model' => 'CircularSubTema', 'add_empty' => true)),
      'subcategoria_organismo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'add_empty' => true)),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
      'deleted'                   => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorDoctrineChoice(array('model' => 'Circular', 'column' => 'id', 'required' => false)),
      'nombre'                    => new sfValidatorString(array('required' => false)),
      'contenido'                 => new sfValidatorString(array('required' => false)),
      'fecha'                     => new sfValidatorDate(),
      'fecha_caducidad'           => new sfValidatorDate(array('required' => false)),
      'numero'                    => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'documento'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'circular_sub_tema_id'      => new sfValidatorDoctrineChoice(array('model' => 'CircularSubTema', 'required' => false)),
      'subcategoria_organismo_id' => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'required' => false)),
      'created_at'                => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                => new sfValidatorDateTime(array('required' => false)),
      'deleted'                   => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('circular[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Circular';
  }

}
