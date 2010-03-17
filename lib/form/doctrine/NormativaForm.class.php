<?php
/**
 * Normativa form.
 *
 * @package    form
 * @subpackage Normativa
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class NormativaForm extends BaseNormativaForm
{
  public function configure()
  {
  	
  	$categoria = CategoriaNormativa::getArrayCategoria();
  	
  	if($this->getObject()->getCategoriaNormativaId())
  	{
  		$subcategoriaN1 = SubCategoriaNormativaN1::getArraySubCategoria($this->getObject()->getCategoriaNormativaId());
  	}
  	else 
  	{
		$subcategoriaN1 = array('0'=>'--seleccionar--');  		
  	}
  	
  	if($this->getObject()->getSubcategoriaNormativaUnoId())
  	{
  		$subcategoriaN2 = SubCategoriaNormativaN2::getArraySubCategoria($this->getObject()->getSubcategoriaNormativaUnoId());
  	}
  	else 
  	{
		$subcategoriaN2 = array('0'=>'--seleccionar--');  		
  	}
  	
  	$subvalidcatN1 = array('0'=>'--seleccionar--');

  	foreach (Doctrine_Query::create()->from('SubCategoriaNormativaN1')->where('deleted = 0')->execute() as $s)
  	{
  		$subvalidcatN1[$s->getId()] = '';
  	}  	
  	
  	$subvalidcatN2 = array('0'=>'--seleccionar--');

  	foreach (Doctrine_Query::create()->from('SubCategoriaNormativaN2')->where('deleted = 0')->execute() as $s)
  	{
  		$subvalidcatN2[$s->getId()] = '';
  	}  	
  	$years = range(2000, 2020);

  	
  	$this->setWidgets(array(
  	  'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%','years' => array_combine($years, $years))),
  	  'publicacion_boe'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%','years' => array_combine($years, $years))),
      'nombre'            => new sfWidgetFormInput(array(), array('style'=>'width:330px;','class'=>'form_input')),
      'contenido'         => new fckFormWidget(),
      'documento'         => new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/normativas/docs/'.$this->getObject()->getdocumento(), 'template'  => '<div>%input%<br /><label> <a href="%file%" class="nottit" target="_blank">%file%</a></label><br />%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')),
      'categoria_normativa_id'        => new sfWidgetFormChoice(array('choices' => $categoria)),
      'subcategoria_normativa_uno_id' => new sfWidgetFormChoice(array('choices' => $subcategoriaN1)),
      'subcategoria_normativa_dos_id' => new sfWidgetFormChoice(array('choices' => $subcategoriaN2)),
    ));

    $this->setValidators(array(
      'fecha'             => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
      'publicacion_boe'   => new sfValidatorDate(array('required' =>false), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
      'nombre'            => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required'=>'El Nombre es obligatorio')),
      'contenido'         => new sfValidatorString(array('required' => true), array('required'=>'El Contenido es obligatorio')),
      'documento'         => new sfValidatorFile(array('path' => 'uploads/normativas/docs','required' => false, 'mime_types'=>array('application/msword', 'application/pdf'),) , array('mime_types' => 'Formato de documento incorrecto, permitidos (.doc, .pdf )')),
      'categoria_normativa_id'        => new sfValidatorChoice(array('choices' => array_keys($categoria), 'required' => false),array('invalid'=>'0')),
      'subcategoria_normativa_uno_id' => new sfValidatorChoice(array('choices' => array_keys($subvalidcatN1), 'required' => false),array('invalid'=>'1')),
      'subcategoria_normativa_dos_id' => new sfValidatorChoice(array('choices' => array_keys($subvalidcatN2), 'required' => false),array('invalid'=>'2')),
      'documento_delete'  => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setLabels(array(
    		'fecha'     => 'Fecha *',
			'nombre'    => 'Nombre *',
			'contenido' => 'Contenido *',
			'categoria_normativa_id' => 'Categoria',
      		'subcategoria_normativa_uno_id' => 'SubCategoria (nivel 1)',
      		'subcategoria_normativa_dos_id' => 'SubCategoria (nivel 2)',
			
		));
	

    $this->widgetSchema->setNameFormat('normativa[%s]');
  }
}