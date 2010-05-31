<?php

/**
 * Acuerdo form.
 *
 * @package    form
 * @subpackage Acuerdo
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class AcuerdoForm extends BaseAcuerdoForm
{
  public function configure()
  {
        sfLoader::loadHelpers('Object');
        $categoria = CategoriaAcuerdoTable::getAll();
  	if($this->getObject()->getCategoriaAcuerdoId())
  	{
  		$subcategoria = SubCategoriaAcuerdoTable::getSubcategiriaBycategoria($this->getObject()->getCategoriaAcuerdoId());
  	}
  	else
  	{
		$subcategoria = array();
  	}

  	$subvalidcat = array('0'=>'--seleccionar--');

  	foreach (Doctrine_Query::create()->from('SubCategoriaAcuerdo')->where('deleted = 0')->execute() as $s)
  	{
  		$subvalidcat[$s->getId()] = '';
  	}


  	$this->setWidgets(array(
  	  'fecha'           => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
          'nombre' 			=> new sfWidgetFormInput(array(), array('style'=>'width:330px;','class'=>'form_input')),
          'contenido'		=> new fckFormWidget(),
          'documento'       => new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/acuerdo/docs/'.$this->getObject()->getdocumento(), 'template'  => '<div>%input%<br /><label> <a href="%file%" class="nottit" target="_blank"></a></label><br />%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')),
          'categoria_acuerdo_id'    => new sfWidgetFormChoice(array('choices' => array(''=>'--seleccionar--')+_get_options_from_objects($categoria) )),
          'subcategoria_acuerdo_id' => new sfWidgetFormChoice(array('choices' => array(''=>'--seleccionar--')+_get_options_from_objects($subcategoria))),
        ));

    $this->setValidators(array(
          'fecha'             => new sfValidatorDate(array('required' => true), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
          'nombre' 			  => new sfValidatorString(array('required' => true), array('required'=>'El Nombre es obligatorio')),
          'contenido' 		  => new sfValidatorString(array('required' => false), array('required'=>'El Contenido es obligatorio')),
          'documento'         => new sfValidatorFile(array('path' => 'uploads/acuerdo/docs','required' => false, 'mime_types'=>array('application/msword', 'application/pdf', 'application/vnd.ms-excel')), array('mime_types'=>'Formato de documento incorrecto, permitidos (.doc, .pdf, .xls )')),
          'documento_delete'  => new sfValidatorBoolean(),
          'categoria_acuerdo_id'    => new sfValidatorChoice(array('choices' => array_keys(_get_options_from_objects($categoria)) , 'required' => true),array('required'=>'La Categoria es obligatoria')),
          'subcategoria_acuerdo_id' => new sfValidatorChoice(array('choices' => array_keys($subvalidcat), 'required' => false)),
        ));

    $this->widgetSchema->setLabels(array(
                        'fecha'     => 'Fecha *',
			'nombre' 	=> 'Nombre *',
			'categoria_acuerdo_id' 	 => 'Categoria *',
			'subcategoria_acuerdo_id' => 'Sub Categoria',
			'contenido' => 'Contenido ',
                        'documento' => 'Fichero ',
		));

     $this->widgetSchema->setNameFormat('acuerdo[%s]');


  }
}