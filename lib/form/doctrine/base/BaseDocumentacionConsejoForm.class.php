<?php

/**
 * DocumentacionConsejo form base class.
 *
 * @package    form
 * @subpackage documentacion_consejo
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseDocumentacionConsejoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'nombre'                 => new sfWidgetFormTextarea(),
      'contenido'              => new sfWidgetFormTextarea(),
      'fecha'                  => new sfWidgetFormDate(),
      'consejo_territorial_id' => new sfWidgetFormDoctrineChoice(array('model' => 'ConsejoTerritorial', 'add_empty' => false)),
      'categoria_c_t_id'       => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaCT', 'add_empty' => false)),
      'estado'                 => new sfWidgetFormChoice(array('choices' => array('guardado' => 'guardado', 'pendiente' => 'pendiente', 'publicado' => 'publicado'))),
      'owner_id'               => new sfWidgetFormInput(),
      'modificador_id'         => new sfWidgetFormInput(),
      'publicador_id'          => new sfWidgetFormInput(),
      'fecha_publicacion'      => new sfWidgetFormDate(),
      'user_id_creador'        => new sfWidgetFormInput(),
      'user_id_modificado'     => new sfWidgetFormInput(),
      'user_id_publicado'      => new sfWidgetFormInput(),
      'fecha_publicado'        => new sfWidgetFormDateTime(),
      'fecha_desde'            => new sfWidgetFormDate(),
      'fecha_hasta'            => new sfWidgetFormDate(),
      'confidencial'           => new sfWidgetFormInputCheckbox(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'deleted'                => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorDoctrineChoice(array('model' => 'DocumentacionConsejo', 'column' => 'id', 'required' => false)),
      'nombre'                 => new sfValidatorString(array('required' => false)),
      'contenido'              => new sfValidatorString(array('required' => false)),
      'fecha'                  => new sfValidatorDate(),
      'consejo_territorial_id' => new sfValidatorDoctrineChoice(array('model' => 'ConsejoTerritorial')),
      'categoria_c_t_id'       => new sfValidatorDoctrineChoice(array('model' => 'CategoriaCT')),
      'estado'                 => new sfValidatorChoice(array('choices' => array('guardado' => 'guardado', 'pendiente' => 'pendiente', 'publicado' => 'publicado'), 'required' => false)),
      'owner_id'               => new sfValidatorInteger(array('required' => false)),
      'modificador_id'         => new sfValidatorInteger(array('required' => false)),
      'publicador_id'          => new sfValidatorInteger(array('required' => false)),
      'fecha_publicacion'      => new sfValidatorDate(array('required' => false)),
      'user_id_creador'        => new sfValidatorInteger(array('required' => false)),
      'user_id_modificado'     => new sfValidatorInteger(array('required' => false)),
      'user_id_publicado'      => new sfValidatorInteger(array('required' => false)),
      'fecha_publicado'        => new sfValidatorDateTime(array('required' => false)),
      'fecha_desde'            => new sfValidatorDate(array('required' => false)),
      'fecha_hasta'            => new sfValidatorDate(array('required' => false)),
      'confidencial'           => new sfValidatorBoolean(),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'deleted'                => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('documentacion_consejo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocumentacionConsejo';
  }

}
