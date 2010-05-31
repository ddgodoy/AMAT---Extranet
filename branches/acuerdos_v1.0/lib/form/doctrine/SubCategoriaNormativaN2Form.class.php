<?php

/**
 * SubCategoriaNormativaN2 form.
 *
 * @package    form
 * @subpackage SubCategoriaNormativaN2
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class SubCategoriaNormativaN2Form extends BaseSubCategoriaNormativaN2Form
{
  public function configure()
  {
  	$categoria = CategoriaNormativa::getArrayCategoria();
  	
  	if($this->getObject()->getCategoriaNormativaId())
  	{
  		$subcategoria = SubCategoriaNormativaN1::getArraySubCategoria($this->getObject()->getCategoriaNormativaId());
  	}
  	else 
  	{
		$subcategoria = array('0'=>'--seleccionar--');  		
  	}
  	
  	$subvalidcat = array('0'=>'--seleccionar--');

  	foreach (Doctrine_Query::create()->from('SubCategoriaNormativaN1')->where('deleted = 0')->execute() as $s)
  	{
  		$subvalidcat[$s->getId()] = '';
  	}  	
  	
  	$this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'nombre'                    => new sfWidgetFormInput(array(),array('style'=>'width:250px;')),
      'contenido'                 => new sfWidgetFormTextarea(),
      'categoria_normativa_id'    => new sfWidgetFormChoice(array('choices' => $categoria),array('id'=>'categoria')),
      'subcategoria_normativa_id' => new sfWidgetFormChoice(array('choices' => $subcategoria)),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
      'deleted'                   => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaNormativaN2', 'column' => 'id', 'required' => false)),
      'nombre'                    => new sfValidatorString(array('max_length' => 255, 'required' => true),array('required'=>'Ingrese el nombre')),
      'contenido'                 => new sfValidatorString(array('required' => false)),
      'categoria_normativa_id'    => new sfValidatorChoice(array('choices' => array_keys($categoria), 'required' => false)),
      'subcategoria_normativa_id' => new sfValidatorChoice(array('choices' => array_keys($subvalidcat), 'required' => false), array('invalid'=>'Seleccione una Subcategoria (nivel 1)')),
      'created_at'                => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                => new sfValidatorDateTime(array('required' => false)),
      'deleted'                   => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('sub_categoria_normativa_n2[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  	
  	
  	
  	
  }
}