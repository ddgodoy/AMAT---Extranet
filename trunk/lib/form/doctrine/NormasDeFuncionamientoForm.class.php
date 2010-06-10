<?php

/**
 * NormasDeFuncionamiento form.
 *
 * @package    form
 * @subpackage NormasDeFuncionamiento
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class NormasDeFuncionamientoForm extends BaseNormasDeFuncionamientoForm
{
  public function configure()
  {
  	
  		$userId = sfContext::getInstance()->getUser()->getAttribute('userId');
  		
  		$GruposUsuario = GrupoTrabajo::ArrayDeMigrupo($userId,1);
  	$this->setWidgets(array(
          'id'               => new sfWidgetFormInputHidden(),
          'titulo'           => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
          'descripcion'      => new fckFormWidget(),
          'grupo_trabajo_id' => new sfWidgetFormChoice(array('choices' => $GruposUsuario),array('class' => 'form_input', 'style' => 'width: 200px;')),
          'created_at'       => new sfWidgetFormDateTime(),
          'updated_at'       => new sfWidgetFormDateTime(),
          'deleted'          => new sfWidgetFormInputCheckbox(),
        ));

    $this->setValidators(array(
          'id'               => new sfValidatorDoctrineChoice(array('model' => 'NormasDeFuncionamiento', 'column' => 'id', 'required' => false)),
          'titulo'           => new sfValidatorString(array('required' => true), array('required' => 'El título es obligatorio')),
          'descripcion'      => new sfValidatorString(array('required' => false)),
          'grupo_trabajo_id' => new sfValidatorChoice(array('choices' => array_keys($GruposUsuario),'required' => true),array('required' => 'El Grupo de trabajo es obligatorio')),
          'created_at'       => new sfValidatorDateTime(array('required' => false)),
          'updated_at'       => new sfValidatorDateTime(array('required' => false)),
          'deleted'          => new sfValidatorBoolean(),
        ));

    
    $this->setDefaults(array(
			'owner_id'          => sfContext::getInstance()->getUser()->getAttribute('userId'),
			));
    
    $this->widgetSchema->setNameFormat('normas_de_funcionamiento[%s]');
  	
  	
  	
  }
}