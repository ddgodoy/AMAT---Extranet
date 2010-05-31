<?php

/**
 * CategoriaIniciativa form.
 *
 * @package    form
 * @subpackage CategoriaIniciativa
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CategoriaIniciativaForm extends BaseCategoriaIniciativaForm
{
  public function configure()
  {
  	
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'nombre'     => new sfWidgetFormInput(),
      'contenido'  => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'CategoriaIniciativa', 'column' => 'id', 'required' => false)),
      'nombre'     => new sfValidatorString(array('max_length' => 100, 'required' => true),array('required'=>'Ingrese el nombre')),
      'contenido'  => new sfValidatorString(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted'    => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('categoria_iniciativa[%s]');

   
  }

}