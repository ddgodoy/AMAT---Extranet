<?php
/**
 * AplicacionExterna form.
 *
 * @package    form
 * @subpackage AplicacionExterna
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class AplicacionExternaForm extends BaseAplicacionExternaForm
{
  public function configure()
  {
  	$dir_upload = sfConfig::get('sf_upload_dir').'/aplicaciones_externas/';
  	$img_valids = array('image/jpeg','image/pjpeg','image/gif','image/png');

  	$this->setWidgets(array(
          'nombre'  => new sfWidgetFormInput(array('label'=>'Nombre *'), array('style'=>'width:400px;','class'=>'form_input')),
          'detalle' => new sfWidgetFormTextarea(array('label'=>'Detalle'), array('style'=>'width:400px;height:150px;','class'=>'form_input')),
          'imagen'  => new sfWidgetFormInputFile(array('label'=>'Imagen'), array('class'=>'form_input')),
          'url'     => new sfWidgetFormInput(array('label'=>'Url *'), array('style'=>'width:400px;','class'=>'form_input')),
          'Requiere'=> new sfWidgetFormInputCheckbox(),
        ));

        $this->setValidators(array(
          'url'     => new sfValidatorUrl(array('required' => true), array('required'=>'La Url es obligatoria','invalid'=>'Formato de url incorrecto')),
          'nombre'  => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required'=>'El Nombre es obligatorio')),
          'detalle' => new sfValidatorString(array('required' => false)),
          'imagen'  => new sfValidatorFile(array('required'=>false, 'path'=>$dir_upload, 'mime_types'=>$img_valids),
                                           array('mime_types' => 'Debe ingresar un tipo de imagen v&aacute;lido (JPG, PNG, GIF)')),
          'Requiere'=> new sfValidatorBoolean(array('required' => false)),

        ));

    $this->widgetSchema->setNameFormat('aplicacion_externa[%s]');
  }
}