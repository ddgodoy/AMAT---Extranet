<?php

/**
 * DocumentacionOrganismo form.
 *
 * @package    form
 * @subpackage DocumentacionOrganismo
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class DocumentacionOrganismoForm extends BaseDocumentacionOrganismoForm
{
  public function configure()
  {
                $requets = sfContext::getInstance();
  		$userId = $requets->getUser()->getAttribute('userId');
                
		
  		$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'nombre'            => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
		  	'contenido'         => new fckFormWidget(),			
			'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_publicacion' => new sfWidgetFormInputHidden(),
			'owner_id'          => new sfWidgetFormInputHidden(),
			'categoria_organismo_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaOrganismo', 'add_empty' => true)),
                        'subcategoria_organismo_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'add_empty' => true)),
                        'organismo_id'              => new sfWidgetFormDoctrineChoice(array('model' => 'Organismo', 'add_empty' => true)),
			'estado'            => new sfWidgetFormInputHidden(),
                        'fecha_desde'        => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
                        'fecha_hasta'        => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
                        'confidencial'       => new sfWidgetFormChoice(array('expanded' => true,'choices' => array(1 => 'Confidencial', 0 => 'No confidencial')),array('style' => 'list-style-type: none;')),
		));

		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'DocumentacionOrganismo', 'column' => 'id', 'required' => false)),
			'nombre'            => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required' => 'El título es obligatorio')),
			'contenido'         => new sfValidatorString(array('required' => false)),						
			'fecha'             => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_publicacion' => new sfValidatorDate(array('required' => false ), array('invalid' => 'La fecha de publicacion es incorrecta')),						
			'owner_id'          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
			'categoria_organismo_id'     => new sfValidatorDoctrineChoice(array('model' => 'CategoriaOrganismo', 'required' => true),array('invalid'=>'La Categoria es obligatoria')),
                        'subcategoria_organismo_id'  => new sfValidatorDoctrineChoice(array('model' => 'SubCategoriaOrganismo', 'required' => true),array('invalid'=>'La SubCategoria es obligatoria')),
                        'organismo_id'               => new sfValidatorDoctrineChoice(array('model' => 'Organismo', 'required' => true),array('invalid'=>'El Organismo es obligatorio')),
			'estado'            => new sfValidatorString(),
                        'fecha_desde'        => new sfValidatorDate(array('required' => false)),
                        'fecha_hasta'        => new sfValidatorDate(array('required' => false)),
                        'confidencial'       => new sfValidatorBoolean(),
		));


                if($requets->getRequest()->getParameter('documentacion_organismo[fecha_desde][day]') && $requets->getRequest()->getParameter('documentacion_organismo[fecha_hasta][day]') ){
                    $this->validatorSchema->setPostValidator(
                      new sfValidatorSchemaCompare('fecha_desde', sfValidatorSchemaCompare::LESS_THAN_EQUAL, 'fecha_hasta',
                        array(),
                        array('invalid' => 'La fecha desde debe ser anterior a la fecha hasta')
                      )
                    );
                }
		$this->setDefaults(array(
			'owner_id'          => $userId,			
			'estado'            => 'pendiente',			
		));

		$this->widgetSchema->setNameFormat('documentacion_organismo[%s]');
  }
}