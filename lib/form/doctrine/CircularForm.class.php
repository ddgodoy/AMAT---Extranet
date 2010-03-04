<?php
/**
 * Circular form.
 *
 * @package    form
 * @subpackage Circular
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CircularForm extends BaseCircularForm
{
  public function configure()
  {
  	$this->setWidgets(array(
  	  'fecha'     => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
  	  'fecha_caducidad'  => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
      'nombre'    => new sfWidgetFormTextarea(array(), array('style'=>'width:730px;','class'=>'form_input')),
      'contenido' => new fckFormWidget(),
      'numero'    => new sfWidgetFormInput(array(), array('style'=>'width:130px;','class'=>'form_input')),
      'documento' => new sfWidgetFormInputFileEditable(array('file_src' => 'uploads/circulares/docs', 'template'  => '<div><label></label>%input%<br /><label></label>%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')),
      'circular_sub_tema_id'      => new sfWidgetFormDoctrineChoice(array('model' => 'CircularSubTema', 'add_empty' => true)),
      'subcategoria_organismo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'fecha'             	=> new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
      'fecha_caducidad'   	=> new sfValidatorDate(array('required' => false), array('required' => 'Debes seleccionar una fecha de caducidad', 'invalid' => 'La fecha de caducidad ingresada es incorrecta')),
      'nombre'    			=> new sfValidatorString(array('required' => true), array('required'=>'El Nombre es obligatorio')),      
      'contenido' 			=> new sfValidatorString(array('required' => true), array('required'=>'El Contenido es obligatorio')),
      'numero'    			=> new sfValidatorString(array('max_length' => 100, 'required' => true),array('required'=>'El Numero es obligatorio') ),
      'documento'         	=> new sfValidatorFile(array('path' => 'uploads/circulares/docs', 'required' => true),array('required'=>'El Documento es obligatorio') ),
      'circular_sub_tema_id'=> new sfValidatorDoctrineChoice(array('model' => 'CircularSubTema', 'required' => true),array('required'=>'La Subcategoría de Tema es obligatorio','invalid'=>'La Subcategoría de Tema es obligatorio')),
      'subcategoria_organismo_id' => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'required' => true), array('required'=>'La Subcategoría Organismos es obligatorio','invalid'=>'La Subcategoría Organismos es obligatorio')),
    ));

    $this->widgetSchema->setLabels(array(
    		'fecha'     => 'Fecha *',
    		'fecha_caducidad' => 'Fecha Caducidad ',
			'nombre'    => 'Nombre *',
			'contenido' => 'Contenido *',
			'numero'    => 'Numero',
			'documento' => 'Documento *',
		));

       
       	
    $this->widgetSchema->setNameFormat('circular[%s]');
  }
}