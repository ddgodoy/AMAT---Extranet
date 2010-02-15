<?php
/**
 * AplicacionRol form.
 *
 * @package    form
 * @subpackage AplicacionRol
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class AplicacionRolForm extends BaseAplicacionRolForm
{
	
	public function configure()
	{
		$Aplicaciones = Aplicacion::getArrayAplicacion();
		
		
		
		$this->setWidgets(array(
			'accion_alta'      => new sfWidgetFormInputCheckbox(array('label'=>'Crear')),
			'accion_baja'      => new sfWidgetFormInputCheckbox(array('label'=>'Eliminar')),
			'accion_modificar' => new sfWidgetFormInputCheckbox(array('label'=>'Modificar')),
			'accion_listar'    => new sfWidgetFormInputCheckbox(array('label'=>'Listar')),
			'accion_publicar'  => new sfWidgetFormInputCheckbox(array('label'=>'Publicar')),
			'aplicacion_id'    => new sfWidgetFormChoice
															(
																array('label'=>'Aplicaci&oacute;n *', 'choices' => array('0'=>'-- seleccionar --')+$Aplicaciones),
																array('style'=>'width:330px;','class'=>'form_input')
															),
			'rol_id' => new sfWidgetFormDoctrineChoice
										(
											array('label'=>'Rol/Perfil *','model' => 'Rol', 'add_empty' => '-- seleccionar --'),
											array('style'=>'width:330px;','class'=>'form_input')
										),
		));
		
		$this->setValidators(array(
			'accion_alta'      => new sfValidatorBoolean(array('required' => false)),
			'accion_baja'      => new sfValidatorBoolean(array('required' => false)),
			'accion_modificar' => new sfValidatorBoolean(array('required' => false)),
			'accion_listar'    => new sfValidatorBoolean(array('required' => false)),
			'accion_publicar'  => new sfValidatorBoolean(array('required' => false)),
			'aplicacion_id'    => new sfValidatorChoice(array('choices' => array_keys($Aplicaciones), 'required' => true), array('required'=>'La Aplicaci&oacute;n es obligatoria')),
			'rol_id'           => new sfValidatorDoctrineChoice(array('model' => 'Rol', 'required' => true), array('required'=>'El Rol/Perfil es obligatorio')),
		));
		
		$this->widgetSchema->setNameFormat('aplicacion_rol[%s]');
	}
}