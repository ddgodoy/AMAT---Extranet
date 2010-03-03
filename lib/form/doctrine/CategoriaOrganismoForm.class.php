<?php

/**
 * CategoriaOrganismo form.
 *
 * @package    form
 * @subpackage CategoriaOrganismo
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CategoriaOrganismoForm extends BaseCategoriaOrganismoForm
{
  public function configure()
  {
  	
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'nombre'     => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'CategoriaOrganismo', 'column' => 'id', 'required' => false)),
      'nombre'     => new sfValidatorString(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('categoria_organismo[%s]');

  	
  	
  }
}