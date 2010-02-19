<?php

/**
 * ArchivoDO form base class.
 *
 * @package    form
 * @subpackage archivo_do
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseArchivoDOForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'nombre'                     => new sfWidgetFormTextarea(),
      'fecha'                      => new sfWidgetFormDate(),
      'fecha_caducidad'            => new sfWidgetFormDate(),
      'contenido'                  => new sfWidgetFormTextarea(),
      'archivo'                    => new sfWidgetFormInput(),
      'owner_id'                   => new sfWidgetFormInput(),
      'disponibilidad'             => new sfWidgetFormChoice(array('choices' => array('organismo' => 'organismo', 'todos' => 'todos'))),
      'categoria_organismo_id'     => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaOrganismo', 'add_empty' => true)),
      'subcategoria_organismo_id'  => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'add_empty' => true)),
      'organismo_id'               => new sfWidgetFormDoctrineChoice(array('model' => 'Organismo', 'add_empty' => true)),
      'documentacion_organismo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'DocumentacionOrganismo', 'add_empty' => true)),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
      'deleted'                    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorDoctrineChoice(array('model' => 'ArchivoDO', 'column' => 'id', 'required' => false)),
      'nombre'                     => new sfValidatorString(array('required' => false)),
      'fecha'                      => new sfValidatorDate(),
      'fecha_caducidad'            => new sfValidatorDate(array('required' => false)),
      'contenido'                  => new sfValidatorString(array('required' => false)),
      'archivo'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'owner_id'                   => new sfValidatorInteger(array('required' => false)),
      'disponibilidad'             => new sfValidatorChoice(array('choices' => array('organismo' => 'organismo', 'todos' => 'todos'), 'required' => false)),
      'categoria_organismo_id'     => new sfValidatorDoctrineChoice(array('model' => 'CategoriaOrganismo', 'required' => false)),
      'subcategoria_organismo_id'  => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'required' => false)),
      'organismo_id'               => new sfValidatorDoctrineChoice(array('model' => 'Organismo', 'required' => false)),
      'documentacion_organismo_id' => new sfValidatorDoctrineChoice(array('model' => 'DocumentacionOrganismo', 'required' => false)),
      'created_at'                 => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                 => new sfValidatorDateTime(array('required' => false)),
      'deleted'                    => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('archivo_do[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArchivoDO';
  }

}
