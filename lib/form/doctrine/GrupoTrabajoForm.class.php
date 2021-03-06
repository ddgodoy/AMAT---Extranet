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
      'detalle'                     => new sfWidgetFormTextarea(array('label'=>'Detalle'),array('style' => 'width:755px;', 'rows' => 5, 'onfocus' => "this.style.background='#D5F7FF'", 'onblur' => "this.style.background='#E1F3F7'")),
    ));

    $this->setValidators(array(
      'nombre'  => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required'=>'El Nombre es obligatorio')),
      'detalle' => new sfValidatorString(array('required' => true), array('required'=>'La Descripci&oacute;n es obligatoria')),
    ));


    $this->widgetSchema->setNameFormat('grupo_trabajo[%s]');
  }
}