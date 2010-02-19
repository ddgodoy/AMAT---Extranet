<?php

/**
 * Menu form.
 *
 * @package    form
 * @subpackage Menu
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class MenuForm extends BaseMenuForm
{
  public function configure()
  {
    $request = sfContext::getInstance()->getRequest();
    $idpadre = $request->getParameter('padreid');
     
  	$this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'padre_id'      => new sfWidgetFormInputHidden(),
      'nombre'        => new sfWidgetFormInput(array(),array('class'=>'form_input')),
      'descripcion'   => new sfWidgetFormInput(array(),array('class'=>'form_input')),
      'aplicacion_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Aplicacion', 'add_empty' => true)),
      'url_externa'   => new sfWidgetFormInput(array(),array('class'=>'form_input')),
      'habilitado'    => new sfWidgetFormInputCheckbox(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'deleted'       => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorDoctrineChoice(array('model' => 'Menu', 'column' => 'id', 'required' => false)),
      'padre_id'      => new sfValidatorInteger(array('required' => false)),
      'nombre'        => new sfValidatorString(array('required' => true),array('required' => 'ingrese el nombre')),
      'descripcion'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'aplicacion_id' => new sfValidatorDoctrineChoice(array('model' => 'Aplicacion', 'required' => false),array('required' => 'selecciones una aplicación')),
      'url_externa'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'habilitado'    => new sfValidatorBoolean(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'updated_at'    => new sfValidatorDateTime(array('required' => false)),
      'deleted'       => new sfValidatorBoolean(),
    ));

    if (empty($idpadre))
    { 
      	  $arrayElementos = array();
       	  $cantidadElementos = $request->getParameter('action') == 'nueva' || $request->getParameter('action') == 'create' ? 6 : Menu::Cantidadelemetos($request->getParameter('id'));
       	  //aca  estoy 
       	  for($i=1;$i<=$cantidadElementos;$i++)
       	  {
       	  	$arrayElementos[$i] = $i; 
       	  }
       	  $this->setDefaults(array('padre_id'=> 0));       	
       	        	
		    	$this->setWidget('posicion', new sfWidgetFormChoice(array('choices' => $arrayElementos)));
					
					$this->setValidator('posicion', new sfValidatorChoice(array('choices' => $arrayElementos,'required' => false)));
      	
    }	
    else 
    {
      
      	  $arrayElementos = array();
       	  $cantidadElementos = MenuTable::getMenuPadre($idpadre)->count() + 1;
       	  for($i=1;$i<=$cantidadElementos;$i++)
       	  {
       	  	$arrayElementos[$i] = $i; 
       	  }
       	         	   
		      $this->setDefaults(array('padre_id'=>$idpadre));
		    	
		    	$this->setWidget('posicion', new sfWidgetFormChoice(array('choices' => $arrayElementos)));
					
					$this->setValidator('posicion', new sfValidatorChoice(array('choices' => $arrayElementos,'required' => false)));
			
      
    }
    
    $this->widgetSchema->setNameFormat('menu[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}