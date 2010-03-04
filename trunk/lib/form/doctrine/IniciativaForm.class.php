<?php
/**
 * Iniciativa form.
 *
 * @package    form
 * @subpackage Iniciativa
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class IniciativaForm extends BaseIniciativaForm
{
  public function configure()
  {
  	$categoria = CategoriaIniciativa::getArrayCategoria();
  	if($this->getObject()->getCategoriaIniciativaId())
  	{
  		$subcategoria = SubCategoriaIniciativa::getArraySubCategoria($this->getObject()->getCategoriaIniciativaId());
  	}
  	else 
  	{
		$subcategoria = array('0'=>'--seleccionar--');  		
  	}
  	
  	$subvalidcat = array('0'=>'--seleccionar--');

  	foreach (Doctrine_Query::create()->from('SubCategoriaIniciativa')->where('deleted = 0')->execute() as $s)
  	{
  		$subvalidcat[$s->getId()] = '';
  	}
  	
  	
  	$this->setWidgets(array(
  	  'fecha'           => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
      'nombre' 			=> new sfWidgetFormInput(array(), array('style'=>'width:330px;','class'=>'form_input')),
      'contenido'		=> new fckFormWidget(),
      'documento'       => new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/iniciativas/docs/'.$this->getObject()->getdocumento(), 'template'  => '<div>%input%<br /><label> <a href="%file%" class="nottit" target="_blank">%file%</a></label><br />%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')),
      'categoria_iniciativa_id'    => new sfWidgetFormChoice(array('choices' => $categoria )),
      'subcategoria_iniciativa_id' => new sfWidgetFormChoice(array('choices' => $subcategoria)),
    ));

    $this->setValidators(array(
      'fecha'             => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
      'nombre' 			  => new sfValidatorString(array('required' => true), array('required'=>'El Nombre es obligatorio')),
      'contenido' 		  => new sfValidatorString(array('required' => true), array('required'=>'El Contenido es obligatorio')),
      'documento'         => new sfValidatorFile(array('path' => 'uploads/iniciativas/docs','required' => false, 'mime_types'=>array('application/msword', 'application/pdf', 'application/vnd.ms-excel')), array('mime_types'=>'Formato de documento incorrecto, permitidos (.doc, .pdf, .xls )')),
      'documento_delete'  => new sfValidatorBoolean(),
      'categoria_iniciativa_id'    => new sfValidatorChoice(array('choices' => array_keys($categoria) , 'required' => false)),
      'subcategoria_iniciativa_id' => new sfValidatorChoice(array('choices' => array_keys($subvalidcat), 'required' => false)),
    ));

    $this->widgetSchema->setLabels(array(
    		'fecha'     => 'Fecha *',
			'nombre' 	=> 'Nombre *',
			'categoria_iniciativa_id' 	 => 'Categoria',
			'subcategoria_iniciativa_id' => 'Sub Categoria',
			'contenido' => 'Contenido *',
		));
			

    $this->widgetSchema->setNameFormat('iniciativa[%s]');  }
}