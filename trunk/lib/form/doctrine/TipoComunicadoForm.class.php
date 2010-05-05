<?php

/**
 * TipoComunicado form.
 *
 * @package    form
 * @subpackage TipoComunicado
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class TipoComunicadoForm extends BaseTipoComunicadoForm
{
  public function configure()
  {
  	 $this->setWidgets(array(
              'id'            => new sfWidgetFormInputHidden(),
              'nombre'        => new sfWidgetFormInput()
            ));

        $this->setValidators(array(
          'id'            => new sfValidatorDoctrineChoice(array('model' => 'TipoComunicado', 'column' => 'id', 'required' => false)),
          'nombre'        => new sfValidatorString(array('required' => false))

        ));
    
    if($this->getObject()->getImagen())
  	{
  	  $this->setWidget('imagen', new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/tipo_comunicado/images/'.$this->getObject()->getImagen(), 'is_image'  => true ,'template'  => '<div><br /><label></label>%input%<br /><label></label>%delete%<label> Eliminar imagen actual</label><br />%file%</div>'), array('class' => 'form_input')));
  	  $this->setValidator('imagen', new sfValidatorFile(array( 'path' => 'uploads/tipo_comunicado/images', 'required' => false, 'validated_file_class' => 'sfResizedFile', )));
	  $this->setValidator('imagen_delete', new sfValidatorBoolean());
  	} 
  	else 
  	{
  	  $this->setWidget('imagen',new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/tipo_comunicado/images/'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  =>'<div><br /><label></label>%input%<br /><label></label>%delete%<label> Eliminar imagen actual</label></div>' ), array('class' => 'form_input')));
  	  $this->setValidator('imagen', new sfValidatorFile(array( 'path' => 'uploads/tipo_comunicado/images', 'required' => false, 'validated_file_class' => 'sfResizedFile')));
	  $this->setValidator('imagen_delete', new sfValidatorBoolean());
  	}
    
    
    $this->widgetSchema->setLabels(array(
			'nombre'    => 'Nombre',
			'imagen'	=> 'Imagen de Cabecera',
		));

    $this->widgetSchema->setNameFormat('tipo_comunicado[%s]');
    
  }
}