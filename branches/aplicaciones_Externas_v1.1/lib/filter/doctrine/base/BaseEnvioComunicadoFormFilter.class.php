<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * EnvioComunicado filter form base class.
 *
 * @package    filters
 * @subpackage EnvioComunicado *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseEnvioComunicadoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'comunicado_id'          => new sfWidgetFormDoctrineChoice(array('model' => 'Comunicado', 'add_empty' => true)),
      'tipo_comunicado_id'     => new sfWidgetFormDoctrineChoice(array('model' => 'TipoComunicado', 'add_empty' => true)),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'deleted'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'lista_comunicados_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'ListaComunicado')),
    ));

    $this->setValidators(array(
      'comunicado_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Comunicado', 'column' => 'id')),
      'tipo_comunicado_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'TipoComunicado', 'column' => 'id')),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'lista_comunicados_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'ListaComunicado', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('envio_comunicado_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addListaComunicadosListColumnQuery(Doctrine_Query $query, $field, $values)
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
          ->andWhereIn('ListaComunicadoEnvio.lista_comunicado_id', $values);
  }

  public function getModelName()
  {
    return 'EnvioComunicado';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'comunicado_id'          => 'ForeignKey',
      'tipo_comunicado_id'     => 'ForeignKey',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'deleted'                => 'Boolean',
      'lista_comunicados_list' => 'ManyKey',
    );
  }
}