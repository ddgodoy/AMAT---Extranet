<?php

/**
 * ArchivoDG form.
 *
 * @package    form
 * @subpackage ArchivoDG
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ArchivoDGForm extends BaseArchivoDGForm
{
  public function configure()
  {
  	$rqArchivo = false;
  	$msArchivo = array();
  	$ctxAction = sfContext::getInstance()->getActionName();
  	$userId    = sfContext::getInstance()->getUser()->getAttribute('userId');

  	if ($ctxAction == 'create') {
  		$rqArchivo = true;
  		$msArchivo = array('required' => 'El archivo es obligatorio', 'invalid' => 'El archivo no es válido');
  	}
  	$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'nombre'            => new sfWidgetFormInput(array(), array('style' => 'width: 430px;', 'class' => 'form_input')),			
			'grupo_trabajo_id'  => new sfWidgetFormDoctrineChoice(array('model' => 'GrupoTrabajo', 'add_empty' => false), array('class' => 'form_input', 'style' => 'width: 200px;')),
			'documentacion_grupo_id'  => new sfWidgetFormDoctrineChoice(array('model' => 'DocumentacionGrupo', 'add_empty' => false), array('class' => 'form_input', 'style' => 'width: 200px;')),
			'contenido'         => new fckFormWidget(),			
			'archivo'           => new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/archivos_d_g/docs', 'template'  => '<div><label></label>%input%<br /><label></label>%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')),
			'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_caducidad'   => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'disponibilidad'    => new sfWidgetFormChoice(array('choices' => array('Solo Grupo' => 'solo grupo', 'Todos' => 'todos'))),
			'owner_id'          => new sfWidgetFormInputHidden(),
		));

		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'ArchivoDG', 'column' => 'id', 'required' => false), array('required' => 'id req', 'invalid' => 'id inval' )),
			'nombre'            => new sfValidatorString(array('required' => true), array('required' => 'El título es obligatorio')),
			'contenido'         => new sfValidatorString(array('required' => true), array('required' => 'La descripción es obligatoria')),
			'archivo'           => new sfValidatorFile(array('path' => 'uploads/archivos_d_g/docs', 'required' => $rqArchivo), $msArchivo),
			'archivo_delete'    => new sfValidatorBoolean(),
			'fecha'             => new sfValidatorDate(array('required' => true), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_caducidad'   => new sfValidatorDate(array('required' => true), array('required' => 'Debes seleccionar una fecha de caducidad', 'invalid' => 'La fecha de caducidad ingresada es incorrecta')),
			'disponibilidad'    => new sfValidatorChoice(array('choices' => array('Solo Grupo' => 'Solo Grupo', 'Todos' => 'Todos'), 'required' => true), array('required' => 'La disponibilidad es obligatoria', 'invalid' => 'La disponibilidad no es válida' )),
			'grupo_trabajo_id'  => new sfValidatorDoctrineChoice(array('model' => 'GrupoTrabajo', 'required' => true),array('invalid' => 'El Grupo de Trabajo es obligatorio')),
			'documentacion_grupo_id' => new sfValidatorDoctrineChoice(array('model' => 'DocumentacionGrupo', 'required' => true),array('invalid' => 'La Documentacion es obligatoria')),
			'owner_id'          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
		));

		$this->setDefaults(array(
			'owner_id' => $userId,					
		));

		$this->widgetSchema->setNameFormat('archivo_d_g[%s]');
  }
}