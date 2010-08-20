<?php

/**
 * CategoriaAcuerdo form.
 *
 * @package    form
 * @subpackage CategoriaAcuerdo
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CategoriaAcuerdoForm extends BaseCategoriaAcuerdoForm
{

 public function configure()
  {
      $this->setWidgets(array(
          'id'         => new sfWidgetFormInputHidden(),
          'nombre'     => new sfWidgetFormInput(),
          'contenido'  => new sfWidgetFormTextarea(),
          'created_at' => new sfWidgetFormDateTime(),
          'updated_at' => new sfWidgetFormDateTime(),
          'deleted'    => new sfWidgetFormInputCheckbox(),
        ));

        $this->setValidators(array(
          'id'         => new sfValidatorDoctrineChoice(array('model' => 'CategoriaIniciativa', 'column' => 'id', 'required' => false)),
          'nombre'     => new sfValidatorString(array('max_length' => 128, 'required' => true),array('required'=>'Ingrese el Titulo')),
          'contenido'  => new sfValidatorString(array('required' => false)),
          'created_at' => new sfValidatorDateTime(array('required' => false)),
          'updated_at' => new sfValidatorDateTime(array('required' => false)),
          'deleted'    => new sfValidatorBoolean(),
        ));

        $this->widgetSchema->setNameFormat('categoria_acuerdo[%s]');
  }

}