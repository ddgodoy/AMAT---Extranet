<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * ListaComunicado filter form base class.
 *
 * @package    filters
 * @subpackage ListaComunicado *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseListaComunicadoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                 => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'envios_comunicado_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'EnvioComunicado')),
    ));

    $this->setValidators(array(
      'nombre'                 => new sfValidatorPass(array('required' => false)),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'envios_comunicado_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'EnvioComunicado', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lista_comunicado_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addEnviosComunicadoListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.ListaComunicadoEnvio ListaComunicadoEnvio')
          ->andWhereIn('ListaComunicadoEnvio.envio_comunicado_id', $values);
  }

  public function getModelName()
  {
    return 'ListaComunicado';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'nombre'                 => 'Text',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'deleted'                => 'Boolean',
      'envios_comunicado_list' => 'ManyKey',
    );
  }
}