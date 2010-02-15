<?php

/**
 * CircularSubTema form base class.
 *
 * @package    form
 * @subpackage circular_sub_tema
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseCircularSubTemaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'nombre'               => new sfWidgetFormInput(),
      'circular_cat_tema_id' => new sfWidgetFormDoctrineChoice(array('model' => 'CircularCatTema', 'add_empty' => false)),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'deleted'              => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => 'CircularSubTema', 'column' => 'id', 'required' => false)),
      'nombre'               => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'circular_cat_tema_id' => new sfValidatorDoctrineChoice(array('model' => 'CircularCatTema')),
      'created_at'           => new sfValidatorDateTime(array('required' => false)),
      'updated_at'           => new sfValidatorDateTime(array('required' => false)),
      'deleted'              => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('circular_sub_tema[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CircularSubTema';
  }

}
