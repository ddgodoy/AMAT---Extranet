<?php

/**
 * SubCategoriaOrganismo form.
 *
 * @package    form
 * @subpackage SubCategoriaOrganismo
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class SubCategoriaOrganismoForm extends BaseSubCategoriaOrganismoForm
{
  public function configure()
  {
  	$categorias = CategoriaOrganismoTable::getAllcategoriaorg();
  	$arraycategoria = array();
  	foreach ($categorias AS $c)
  	{
  		$arraycategoria[0] = '--seleccionar--';
  		$arraycategoria[$c->getId()] = $c->getNombre();
  	}
  	
  	
  	
  	
  	$this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'nombre'                 => new sfWidgetFormInput(),
      'categoria_organismo_id' => new sfWidgetFormChoice(array('choices' => $arraycategoria)),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'deleted'                => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'column' => 'id', 'required' => false)),
      'nombre'                 => new sfValidatorString(array('required' => false)),
      'categoria_organismo_id' => new sfValidatorDoctrineChoice(array('model' => 'CategoriaOrganismo'),array('invalid' => 'Ingrese la categoria')),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'deleted'                => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('sub_categoria_organismo[%s]');
  	
  	
  }
}