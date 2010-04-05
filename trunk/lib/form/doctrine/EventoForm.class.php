<?php

/**
 * Evento form.
 *
 * @package    form
 * @subpackage Evento
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class EventoForm extends BaseEventoForm
{
	public function configure()
	{
		$img_valids = array('image/jpeg','image/pjpeg','image/gif');
                $request    = sfContext::getInstance()->getUser();
                $usurID     = $request->getAttribute('userId');
                $nombreUser = $request->getAttribute('nombre');
                $apellidoUser = $request->getAttribute('apellido');


                $usuario = Doctrine::getTable('Usuario')->find($usurID);
		$arrUsuarios = $usuario->UsuariosdeMisGrupos();
		$arrUsuariosGrupo = array(); 
		$arrUsuariosGrupo[$usurID] = $apellidoUser.", ".$nombreUser; 
		$mutuas = Mutua::getArrayMutuas(); 

		foreach ($arrUsuarios AS $usuario) {
			$arrUsuariosGrupo [$usuario->getId()] = $usuario->getApellido().", ".$usuario->getNombre();
		}
		$userId = sfContext::getInstance()->getUser()->getAttribute('userId');

		$this->setWidgets(array(
			'id'              => new sfWidgetFormInputHidden(),
			'titulo'          => new sfWidgetFormInput(array(), array('class' => 'form_input', 'style' => 'width:280px;')),
			'organizador'     => new sfWidgetFormInput(array(), array('class' => 'form_input', 'style' => 'width:280px;')),
			'descripcion'     => new sfWidgetFormTextarea(array(), array('rows' => '5', 'style' => 'width:840px;')),
			'mas_info'        => new fckFormWidget(),
			'fecha'           => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_caducidad' => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'mas_imagen'      => new sfWidgetFormInputCheckbox(),
			'ambito'          => new sfWidgetFormChoice(array('choices' => array('intranet' => 'extranet', 'web' => 'web', 'ambos' => 'Extranet y Web')), array('class' => 'form_input', 'style' => 'width:400px;')),
			'estado'          => new sfWidgetFormInputHidden(),
			'owner_id'        => new sfWidgetFormInputHidden(),
			'usuarios_list'   => new sfWidgetFormSelectDoubleList(array('choices' => $arrUsuariosGrupo, 'label_associated' => 'Seleccionados', 'label_unassociated' => 'Opciones')	),
			'mutua_id'        => new sfWidgetFormChoice(array('choices' => $mutuas), array('class' => 'form_input', 'style' => 'width: 200px;')),
		));

		$this->setValidators(array(
			'id'              => new sfValidatorDoctrineChoice(array('model' => 'Evento', 'column' => 'id', 'required' => false)),
			'titulo'          => new sfValidatorString(array('required' => true), array('required' => 'El título es obligatorio')),
			'organizador'     => new sfValidatorString(array('max_length' => 255, 'required' => false), array('required' => 'El organizador es obligatorio')),
			'descripcion'     => new sfValidatorString(array('required' => false), array('required' => 'La descripción es obligatoria')),
			'mas_info'        => new sfValidatorString(array('required' => false)),
			'fecha'           => new sfValidatorDate(array('required' => true), array('required' => 'La fecha es obligatoria', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_caducidad' => new sfValidatorDate(array('required' => false)),
			'mas_imagen'      => new sfValidatorBoolean(array('required' => false)),
			'ambito'          => new sfValidatorChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'ambos' => 'ambos'), 'required' => false)),
			'estado'          => new sfValidatorChoice(array('choices' => array('guardado' => 'guardado', 'pendiente' => 'pendiente', 'publicado' => 'publicado'), 'required' => true)),
			'owner_id'        => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => false)),
			'usuarios_list'   => new sfValidatorDoctrineChoiceMany(array('model' => 'Usuario', 'required' => false), array('invalid' => 'El usuario ingresado es incorrecto')),
			'mutua_id'        => new sfValidatorChoice(array('choices' => array_keys($mutuas), 'required' => false),array()),
		));

		if ($this->getObject()->getImagen())
		{
			$this->setWidget('imagen',new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/eventos/images/'.'s_'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  => '<div>%file%<br /><label></label>%input%<br /><label></label>%delete%<label> Eliminar imagen actual</label></div>', ), array('class' => 'form_input')));
			$this->setValidator('imagen',new sfValidatorFile(array( 'path'=>'uploads/eventos/images', 'required'=>false, 'validated_file_class'=>'sfResizedFile', 'mime_types'=> $img_valids, 'max_size'=>2048000), array('invalid' => 'Invalid file.','mime_types'=>'Formato de imagen incorrecto, permitidos (.jpg, .gif)', 'max_size'=>'Máximo tamaño de imagen: 2 MB')));
			$this->setValidator('imagen_delete',new sfValidatorBoolean());	
		}
		else 
		{
			$this->setWidget('imagen',new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/eventos/images/'.'s_'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  => '<div><label></label>%input%<br /><label></label></div>', ), array('class' => 'form_input')));
			$this->setValidator('imagen',new sfValidatorFile(array( 'path'=>'uploads/eventos/images', 'required'=>false, 'validated_file_class'=>'sfResizedFile', 'mime_types'=> $img_valids, 'max_size'=>2048000),array('invalid' => 'Invalid file.' ,'mime_types'=>'Formato de imagen incorrecto, permitidos (.jpg, .gif)', 'max_size'=>'Máximo tamaño de imagen: 2 MB')));
		}
		
		if ($this->getObject()->getDocumento())
		{
			$this->setWidget('documento', new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/eventos/docs', 'template'  => '<div><label></label>%input%<br /><label></label>%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')));
			$this->setValidator('documento', new sfValidatorFile(array('path' => 'uploads/eventos/docs', 'required' => false)));
		  $this->setValidator('documento_delete', new sfValidatorBoolean());
		}
		else 
		{
			$this->setWidget('documento', new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/eventos/docs', 'template'  => '<div><label></label>%input%<br /><label></label></div>', ), array('class' => 'form_input')));
			$this->setValidator('documento', new sfValidatorFile(array('path' => 'uploads/eventos/docs', 'required' => false)));
		}

		$this->setDefaults(array( 'usuarios_list' => $userId,
		                          'owner_id' => $userId, 
		                          'mas_imagen' => 1,
		                          'ambito'=>'ambos',
		                          'mutua_id'=>'0'));

		$this->widgetSchema->setNameFormat('evento[%s]');
	}
}