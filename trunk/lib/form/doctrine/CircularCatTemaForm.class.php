<?php
/**
 * CircularCatTema form.
 *
 * @package    form
 * @subpackage CircularCatTema
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CircularCatTemaForm extends BaseCircularCatTemaForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'nombre'=> new sfWidgetFormInput(array('label'=>'Nombre *'),array('style'=>'width:330px;','class'=>'form_input')),
    ));

    $this->setValidators(array(
      'nombre'=> new sfValidatorString(array('max_length' => 100, 'required' => true), array('required'=>'El Nombre es obligatorio')),
    ));

    $this->widgetSchema->setNameFormat('circular_cat_tema[%s]');
  }
}
