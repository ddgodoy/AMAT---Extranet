<?php

/**
 * SubCategoriaAcuerdo form.
 *
 * @package    form
 * @subpackage SubCategoriaAcuerdo
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class SubCategoriaAcuerdoForm extends BaseSubCategoriaAcuerdoForm
{
  public function configure()
  {
    sfLoader::loadHelpers('Object');
    $categoria = CategoriaAcuerdoTable::getAll();

    $this->setWidgets(array(
          'id'                      => new sfWidgetFormInputHidden(),
          'nombre'                  => new sfWidgetFormInput(),
          'contenido'               => new sfWidgetFormTextarea(),
          'categoria_acuerdo_id' => new sfWidgetFormChoice(array('choices' =>array('0'=>'--seleccionar--')+_get_options_from_objects( $categoria))),
          'created_at'              => new sfWidgetFormDateTime(),
          'updated_at'              => new sfWidgetFormDateTime(),
          'deleted'                 => new sfWidgetFormInputCheckbox(),
        ));

    $this->setValidators(array(
          'id'                      => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaIniciativa', 'column' => 'id', 'required' => false)),
          'nombre'                  => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required'=>'Ingrese le Titulo')),
          'contenido'               => new sfValidatorString(array('required' => false)),
          'categoria_acuerdo_id' => new sfValidatorDoctrineChoice(array('model' => 'CategoriaAcuerdo', 'required' => true),array('required'=>'Seleccione un Categoria','invalid'=>'Seleccione un Categoria')),
          'created_at'              => new sfValidatorDateTime(array('required' => false)),
          'updated_at'              => new sfValidatorDateTime(array('required' => false)),
          'deleted'                 => new sfValidatorBoolean(),
        ));

    $this->widgetSchema->setNameFormat('sub_categoria_acuerdo[%s]');
  }
}