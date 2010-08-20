<?php

/**
 * CifraDato form base class.
 *
 * @package    form
 * @subpackage cifra_dato
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseCifraDatoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'titulo'             => new sfWidgetFormTextarea(),
      'autor'              => new sfWidgetFormInput(),
      'contenido'          => new sfWidgetFormTextarea(),
      'imagen'             => new sfWidgetFormInput(),
      'documento'          => new sfWidgetFormInput(),
      'link'               => new sfWidgetFormInput(),
      'fecha'              => new sfWidgetFormDate(),
      'fecha_publicacion'  => new sfWidgetFormDate(),
      'ambito'             => new sfWidgetFormChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'))),
      'estado'             => new sfWidgetFormChoice(array('choices' => array('pendiente' => 'pendiente', 'publicado' => 'publicado'))),
      'destacada'          => new sfWidgetFormInputCheckbox(),
      'mutua_id'           => new sfWidgetFormDoctrineChoice(array('model' => 'Mutua', 'add_empty' => true)),
      'owner_id'           => new sfWidgetFormDoctrineChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'seccion_id'         => new sfWidgetFormDoctrineChoice(array('model' => 'CifraDatoSeccion', 'add_empty' => true)),
      'user_id_creador'    => new sfWidgetFormInput(),
      'user_id_modificado' => new sfWidgetFormInput(),
      'user_id_publicado'  => new sfWidgetFormInput(),
      'fecha_publicado'    => new sfWidgetFormDateTime(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'deleted'            => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => 'CifraDato', 'column' => 'id', 'required' => false)),
      'titulo'             => new sfValidatorString(),
      'autor'              => new sfValidatorString(array('max_length' => 100)),
      'contenido'          => new sfValidatorString(array('required' => false)),
      'imagen'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'documento'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'link'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fecha'              => new sfValidatorDate(),
      'fecha_publicacion'  => new sfValidatorDate(),
      'ambito'             => new sfValidatorChoice(array('choices' => array('intranet' => 'intranet', 'web' => 'web', 'todos' => 'todos'), 'required' => false)),
      'estado'             => new sfValidatorChoice(array('choices' => array('pendiente' => 'pendiente', 'publicado' => 'publicado'), 'required' => false)),
      'destacada'          => new sfValidatorBoolean(array('required' => false)),
      'mutua_id'           => new sfValidatorDoctrineChoice(array('model' => 'Mutua', 'required' => false)),
      'owner_id'           => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => false)),
      'seccion_id'         => new sfValidatorDoctrineChoice(array('model' => 'CifraDatoSeccion', 'required' => false)),
      'user_id_creador'    => new sfValidatorInteger(array('required' => false)),
      'user_id_modificado' => new sfValidatorInteger(array('required' => false)),
      'user_id_publicado'  => new sfValidatorInteger(array('required' => false)),
      'fecha_publicado'    => new sfValidatorDateTime(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
      'deleted'            => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('cifra_dato[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CifraDato';
  }

}
