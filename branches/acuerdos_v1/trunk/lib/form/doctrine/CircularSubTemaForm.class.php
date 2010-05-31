<?php
/**
 * CircularSubTema form.
 *
 * @package    form
 * @subpackage CircularSubTema
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CircularSubTemaForm extends BaseCircularSubTemaForm
{
  public function configure()
  {
  	$categoria = CircularCatTema::ArrayCirculares();
  	
  	
  
  	 $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'nombre'               => new sfWidgetFormInput(),
      'circular_cat_tema_id' => new sfWidgetFormChoice(array('choices' => $categoria)),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'deleted'              => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => 'CircularSubTema', 'column' => 'id', 'required' => false)),
      'nombre'               => new sfValidatorString(array('required' => false)),
      'circular_cat_tema_id' => new sfValidatorDoctrineChoice(array('model' => 'CircularCatTema')),
      'created_at'           => new sfValidatorDateTime(array('required' => false)),
      'updated_at'           => new sfValidatorDateTime(array('required' => false)),
      'deleted'              => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('circular_sub_tema[%s]');
  	
  	
  }
}
