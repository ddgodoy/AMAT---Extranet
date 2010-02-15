<?php

/**
 * GrupoTrabajo form.
 *
 * @package    form
 * @subpackage GrupoTrabajo
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class GrupoTrabajoForm extends BaseGrupoTrabajoForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'nombre'  => new sfWidgetFormInput(array('label'=>'Nombre *'),array('style'=>'width:400px;','class'=>'form_input')),
      'detalle' => new fckFormWidget(array('label'=>'Detalle'),array('style'=>'width:400px;height:200px;','class'=>'form_input')),
    ));

    $this->setValidators(array(
      'nombre'  => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required'=>'El Nombre es obligatorio')),
      'detalle' => new sfValidatorString(array('required' => true), array('required'=>'La Descripci&oacute;n es obligatoria')),
    ));

    $defaulDetailValue = '<p><img align="left" nottit="" style="margin-right: 10px; width: 69px; height: 65px;" alt="" src="/uploads/image/noimage.jpg" /></p>'.
    										 '<p><a href="#"><strong>T&iacute;tulo documentaci&oacute;n 1</strong></a></p>'.
    										 '<p>Descripci&oacute;n 1 Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>';

		$this->setDefaults(array('detalle' => $defaulDetailValue,));

    $this->widgetSchema->setNameFormat('grupo_trabajo[%s]');
  }
}