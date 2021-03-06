<?php

/**
 * DocumentacionConsejo form.
 *
 * @package    form
 * @subpackage DocumentacionConsejo
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class DocumentacionConsejoForm extends BaseDocumentacionConsejoForm
{
  public function configure()
  {
                $requets = sfContext::getInstance();
  		sfLoader::loadHelpers('Object');
  		$userId = $requets->getUser()->getAttribute('userId');
                $ConsejoTerritorial = $requets->getUser()->getAttribute('documentacion_consejos_nowconsejo')?$requets->getUser()->getAttribute('documentacion_consejos_nowconsejo'):'';
  		
  		$this->roles = UsuarioRol::getRepository()->getRolesByUser($userId,1);
		if(Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles))
		{
			$consejos = ConsejoTerritorialTable::getAllconsejo();
		}
		else 
		{
  			$consejos = ConsejoTerritorialTable::getConsejosTerritorialesByUsuario($userId);
		}	
		
  		$this->setWidgets(array(
			'id'                => new sfWidgetFormInputHidden(),
			'nombre'            => new sfWidgetFormInput(array(), array('style' => 'width: 330px;', 'class' => 'form_input')),
			'consejo_territorial_id'  => new sfWidgetFormChoice(array('choices' =>array('0'=>'--seleccionar--')+_get_options_from_objects($consejos)), array('class' => 'form_input', 'style' => 'width: 200px;')),
			'categoria_c_t_id'  => new sfWidgetFormDoctrineChoice(array('model' => 'CategoriaCT', 'add_empty' => false), array('class' => 'form_input', 'style' => 'width: 200px;')),
			'contenido'         => new fckFormWidget(),			
			'fecha'             => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_publicacion' => new sfWidgetFormInputHidden(),
                        'fecha_desde'        => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
                        'fecha_hasta'        => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
                        'confidencial'       => new sfWidgetFormChoice(array('expanded' => true,'choices' => array(1 => 'Confidencial', 0 => 'No confidencial')),array('style' => 'list-style-type: none;')),
			'owner_id'          => new sfWidgetFormInputHidden(),
			'estado'            => new sfWidgetFormInputHidden(),
		));

		$this->setValidators(array(
			'id'                => new sfValidatorDoctrineChoice(array('model' => 'DocumentacionConsejo', 'column' => 'id', 'required' => false)),
			'nombre'            => new sfValidatorString(array('max_length' => 100, 'required' => true), array('required' => 'El título es obligatorio')),
			'consejo_territorial_id'  => new sfValidatorDoctrineChoice(array('model' => 'ConsejoTerritorial'),array('invalid'=>'El consejo territorial es obligatorio')),
			'categoria_c_t_id'  => new sfValidatorDoctrineChoice(array('model' => 'CategoriaCT')),
			'contenido'         => new sfValidatorString(array('required' => false)),						
			'fecha'             => new sfValidatorDate(array(), array('required' => 'Debes seleccionar una fecha', 'invalid' => 'La fecha ingresada es incorrecta')),
			'fecha_publicacion' => new sfValidatorDate(array('required' => false ), array('invalid' => 'La fecha de publicacion es incorrecta')),
                        'fecha_desde'        => new sfValidatorDate(array('required' => false)),
                        'fecha_hasta'        => new sfValidatorDate(array('required' => false)),
                        'confidencial'       => new sfValidatorBoolean(),
			'owner_id'          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => true)),
			'estado'            => new sfValidatorString(),
		));


                if($requets->getRequest()->getParameter('documentacion_consejo[fecha_desde][day]') && $requets->getRequest()->getParameter('documentacion_consejo[fecha_hasta][day]') ){
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
                        'consejo_territorial_id' => $ConsejoTerritorial,
                        'confidencial'      => $this->getObject()->getConfidencial()==0?0:1
		));

		$this->widgetSchema->setNameFormat('documentacion_consejo[%s]');
  }
}