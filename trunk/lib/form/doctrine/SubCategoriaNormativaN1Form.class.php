<?php

/**
 * SubCategoriaNormativaN1 form.
 *
 * @package    form
 * @subpackage SubCategoriaNormativaN1
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class SubCategoriaNormativaN1Form extends BaseSubCategoriaNormativaN1Form
{
  public function configure()
  {
  	$categoria = CategoriaNormativa::getArrayCategoria();
  	
  	$this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'nombre'                 => new sfWidgetFormInput(),
      'contenido'              => new sfWidgetFormTextarea(),
      'categoria_normativa_id' => new sfWidgetFormChoice(array('choices' => $categoria)),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'deleted'                => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaNormativaN1', 'column' => 'id', 'required' => false)),
      'nombre'                 => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required'=>'Ingrese el titulo')),
      'contenido'              => new sfValidatorString(array('required' => false)),
      'categoria_normativa_id' => new sfValidatorDoctrineChoice(array('model' => 'CategoriaNormativa', 'required' => true),array('invalid'=>'Seleccione una categoria')),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'deleted'                => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('sub_categoria_normativa_n1[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    	
  	
  }
}