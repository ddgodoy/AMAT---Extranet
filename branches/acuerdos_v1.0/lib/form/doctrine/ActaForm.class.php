<?php

/**
 * Acta form.
 *
 * @package    form
 * @subpackage Acta
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ActaForm extends BaseActaForm
{
	public function configure()
	{
		$userId = sfContext::getInstance()->getUser()->getAttribute('userId');
		
		$this->setWidgets(array(
			'id'              => new sfWidgetFormInputHidden(),
			'nombre'          => new sfWidgetFormInput(),
			'detalle'         => new fckFormWidget(),
			'owner_id'        => new sfWidgetFormInputHidden(),
			'asamblea_id'     => new sfWidgetFormInputHidden(),
		));
		
		$this->setValidators(array(
			'id'              => new sfValidatorDoctrineChoice(array('model' => 'Asamblea', 'column' => 'id', 'required' => false)),
			'nombre'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
			'detalle'         => new sfValidatorString(array('required' => false)),
			'owner_id'        => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
			'asamblea_id'     => new sfValidatorDoctrineChoice(array('model' => 'Asamblea', 'required' => true)),
		));
		
		$this->setDefaults(array(
			'owner_id'          => $userId,
		));
		
		$this->widgetSchema->setNameFormat('acta[%s]');
	}
}