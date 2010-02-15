<?php

/**
 * SubCategoriaIniciativa form.
 *
 * @package    form
 * @subpackage SubCategoriaIniciativa
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class SubCategoriaIniciativaForm extends BaseSubCategoriaIniciativaForm
{
  public function configure()
  {
  	
  	$categoria = CategoriaIniciativa::getArrayCategoria();
  	
  	$this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'nombre'                  => new sfWidgetFormInput(),
      'contenido'               => new sfWidgetFormTextarea(),
      'categoria_iniciativa_id' => new sfWidgetFormChoice(array('choices' => $categoria)),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
      'deleted'                 => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaIniciativa', 'column' => 'id', 'required' => false)),
      'nombre'                  => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required'=>'Ingrese le Titulo')),
      'contenido'               => new sfValidatorString(array('required' => false)),
      'categoria_iniciativa_id' => new sfValidatorDoctrineChoice(array('model' => 'CategoriaIniciativa', 'required' => true),array('required'=>'Seleccione un Categoria','invalid'=>'Seleccione un Categoria')),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'updated_at'              => new sfValidatorDateTime(array('required' => false)),
      'deleted'                 => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('sub_categoria_iniciativa[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  	
  	
  	
  }
}