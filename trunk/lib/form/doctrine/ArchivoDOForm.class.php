<?php

/**
 * ArchivoDO form.
 *
 * @package    form
 * @subpackage ArchivoDO
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ArchivoDOForm extends BaseArchivoDOForm
{
  public function configure()
  {
  	
  	   $dir_upload = sfConfig::get('sf_upload_dir')."/archivos_d_o/docs/";
  	   $userId = sfContext::getInstance()->getUser()->getAttribute('userId');
  	
  		$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'nombre'            => new sfWidgetFormInput(array(), array('style' => 'width: 430px;', 'class' => 'form_input')),			
			'contenido'         => new fckFormWidget(),			
			'archivo'           => new sfWidgetFormInputFileEditable(array('file_src' => $dir_upload, 'template'  => '<div><label></label>%input%<br /><label></label>%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')),
			'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_caducidad'   => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'disponibilidad'    => new sfWidgetFormChoice(array('choices' => array('organismo' => 'organismo', 'todos' => 'todos'))),
			'categoria_organismo_id'     => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaOrganismo', 'add_empty' => true)),
	      	'subcategoria_organismo_id'  => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'add_empty' => true)),
	      	'organismo_id'               => new sfWidgetFormDoctrineChoice(array('model' => 'Organismo', 'add_empty' => true)),
	      	'documentacion_organismo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'DocumentacionOrganismo', 'add_empty' => true)),
			'owner_id'          => new sfWidgetFormInputHidden(),
		));

		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'ArchivoDO', 'column' => 'id', 'required' => false), array('required' => 'id req', 'invalid' => 'id inval' )),
			'nombre'            => new sfValidatorString(array('required' => true), array('required' => 'El título es obligatorio')),
			'contenido'         => new sfValidatorString(array('required' => false)),
			'archivo'           => new sfValidatorFile(array('path' => $dir_upload, 'required' => true), array('required' => 'arch req', 'invalid' => 'arch inval' )),
			'archivo_delete'    => new sfValidatorBoolean(),
			'fecha'             => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_caducidad'   => new sfValidatorDate(array('required' => false), array('required' => 'Debes seleccionar una fecha de caducidad', 'invalid' => 'La fecha de caducidad ingresada es incorrecta')),
			'disponibilidad'    => new sfValidatorChoice(array('choices' => array('organismo' => 'organismo', 'todos' => 'todos'), 'required' => true), array('required' => 'disp req', 'invalid' => 'disp inval' )),
			'categoria_organismo_id'     => new sfValidatorDoctrineChoice(array('model' => 'CategoriaOrganismo', 'required' => true),array('invalid'=>'La Categoria es obligatoria')),
	      	'subcategoria_organismo_id'  => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'required' => true),array('invalid'=>'La SubCategoria es obligatoria')),
	      	'organismo_id'               => new sfValidatorDoctrineChoice(array('model' => 'Organismo', 'required' => true),array('invalid'=>'El Organismo es obligatorio')),
	      	'documentacion_organismo_id' => new sfValidatorDoctrineChoice(array('model' => 'DocumentacionOrganismo', 'required' => true),array('invalid'=>'La Documentacion es obligatoria')),
			'owner_id'          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
		));

		$this->setDefaults(array(
			'owner_id'          => $userId,					
		));

		$this->widgetSchema->setNameFormat('archivo_d_o[%s]');
  }
}