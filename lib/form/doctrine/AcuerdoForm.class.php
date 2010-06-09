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
        $img_valids = array('image/jpeg','image/pjpeg','image/gif');
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
         for($i = 2000; $i<2015; $i++)
        {
          $years[$i] = $i;
        }


  	$this->setWidgets(array(
  	  'fecha'           => new sfWidgetFormJQueryDate(array('format' => '%day%/%month%/%year%', 'years'=> array_combine($years, $years), 'image'=>'/images/calendario.gif')),
          'nombre' 	    => new sfWidgetFormInput(array(), array('style'=>'width:330px;','class'=>'form_input')),
          'contenido'	    => new fckFormWidget(),
          'documento'       => new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/acuerdo/docs/'.$this->getObject()->getdocumento(), 'template'  => '<div>%input%<br /><label> <a href="%file%" class="nottit" target="_blank"></a></label><br />%delete%<label> Eliminar documento actual</label></div>', ), array('class' => 'form_input')),
          'categoria_acuerdo_id'    => new sfWidgetFormChoice(array('choices' => array(''=>'--seleccionar--')+_get_options_from_objects($categoria) )),
          'subcategoria_acuerdo_id' => new sfWidgetFormChoice(array('choices' => array(''=>'--seleccionar--')+_get_options_from_objects($subcategoria))),
        ));

    $this->setValidators(array(
          'fecha'             => new sfValidatorDate(array('required' => true), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
          'nombre' 	      => new sfValidatorString(array('required' => true), array('required'=>'El Nombre es obligatorio')),
          'contenido' 	      => new sfValidatorString(array('required' => false), array('required'=>'El Contenido es obligatorio')),
          'documento'         => new sfValidatorFile(array('path' => 'uploads/acuerdo/docs','required' => false, 'mime_types'=>array('application/msword', 'application/pdf', 'application/vnd.ms-excel')), array('mime_types'=>'Formato de documento incorrecto, permitidos (.doc, .pdf, .xls )')),
          'documento_delete'  => new sfValidatorBoolean(),
          'categoria_acuerdo_id'    => new sfValidatorChoice(array('choices' => array_keys(_get_options_from_objects($categoria)) , 'required' => true),array('required'=>'La Categoria es obligatoria')),
          'subcategoria_acuerdo_id' => new sfValidatorChoice(array('choices' => array_keys($subvalidcat), 'required' => false)),
        ));

    if($this->getObject()->getImagen())
    {
            $this->setWidget('imagen',new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/acuerdos/images/'.'s_'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  => '<div>%file%<br /><label></label>%input%<br /><label></label>%delete%<label> Eliminar imagen actual</label></div>', ), array('class' => 'form_input')));
            $this->setValidator('imagen',new sfValidatorFile(array( 'path' => 'uploads/acuerdos/images', 'required' => false, 'validated_file_class' => 'sfResizedFile', 'mime_types'=> $img_valids, 'max_size'=>2048000),array('invalid' => 'Invalid file.','mime_types'=>'Formato de imagen incorrecto, permitidos (.jpg, .gif)', 'max_size'=>'Máximo tamaño de imagen: 2 MB')));
            $this->setValidator('imagen_delete',new sfValidatorBoolean());
    }
    else
    {
            $this->setWidget('imagen',new sfWidgetFormInputFileEditable(array('file_src' => '/uploads/acuerdos/images/'.'s_'.$this->getObject()->getImagen(), 'is_image'  => true, 'template'  => '<div><label></label>%input%<br /><label></label></div>', ), array('class' => 'form_input')));
            $this->setValidator('imagen',new sfValidatorFile(array( 'path' => 'uploads/acuerdos/images', 'required' => false, 'validated_file_class' => 'sfResizedFile', 'mime_types'=> $img_valids, 'max_size'=>2048000),array('invalid' => 'Invalid file.' ,'mime_types'=>'Formato de imagen incorrecto, permitidos (.jpg, .gif)', 'max_size'=>'Máximo tamaño de imagen: 2 MB')));
    }



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