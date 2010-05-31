<?php
/**
 * Asamblea form.
 *
 * @package    form
 * @subpackage Asamblea
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class AsambleaForm extends BaseAsambleaForm
{
	public function configure()
	{
		
		$request =sfContext::getInstance();
		$userId = $request->getUser()->getAttribute('userId');
		$estado = 'activa';
		$grupos = array();
		$usuAsmblea = UsuarioAsamblea::getUsuariosDirectores($this->getObject()->getId());
//		echo '<pre>';
//		print_r($usuAsmblea);
//		echo '</pre>';
//		exit();
		
		$directoer = Usuario::getArrayUsuarioDir();

                $roles = UsuarioRol::getRepository()->getRolesByUser($userId,1);

		if (Common::array_in_array(array('1'=>'1', '2'=>'2'), $roles)) {
		$gruposTrabajo = GrupoTrabajoTable::getAllGrupoTrabajo();
		$consejosTerritoriales = ConsejoTerritorialTable::getAllconsejo();
		$organismos = OrganismoTable::getAllOrganismos();
                }
                else {
                $gruposTrabajo = Doctrine::getTable('GrupoTrabajo')->getGruposTrabajoByUsuario($userId);
		$consejosTerritoriales = Doctrine::getTable('ConsejoTerritorial')->getConsejosTerritorialesByUsuario($userId);
		$organismos = Doctrine::getTable('Organismo')->getOrganismoBysuer($userId);

                }

        if($request->getRequest()->getParameter('GrupodeTrabajo')==2)
        {
		if ($gruposTrabajo) {
			foreach ($gruposTrabajo as $g) { $grupos['GrupoTrabajo_'.$g->getId()] = "Grupo - ".$g->getNombre(); 
											 
			}
		}
        }
        if($request->getRequest()->getParameter('ConsejoTerritorial')==3)
        {
		//var_dump($gruposTrabajo->count()); echo '<br/><br/>';
		if ($consejosTerritoriales) {
			foreach ($consejosTerritoriales as $g) {$grupos['ConsejoTerritorial_'.$g->getId()] = "Consejo - ".$g->getNombre();}
		}
		
        }
        if($request->getRequest()->getParameter('Organismo')==4)
        {
		//var_dump($gruposTrabajo->count()); echo '<br/><br/>';
		if ($organismos) {
			foreach ($organismos as $g) {$grupos['Organismo_'.$g->getId()] = "Organismo - ".$g->getNombre();}
		}
		
        }
		 //die();

		$this->setWidgets(array(
			'id'              => new sfWidgetFormInputHidden(),
			'titulo'          => new sfWidgetFormInput(),
			'direccion'       => new sfWidgetFormInput(),
			'contenido'       => new fckFormWidget(),
			'fecha'           => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'fecha_caducidad' => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif', 'format' => '%day%/%month%/%year%')),
			'horario'         => new sfWidgetFormInput(),
			'estado'          => new sfWidgetFormInputHidden(),
			'owner_id'        => new sfWidgetFormInputHidden(),
		));
		//=> new sfWidgetFormTime(),
		$this->setValidators(array(
			'id'              => new sfValidatorDoctrineChoice(array('model' => 'Asamblea', 'column' => 'id', 'required' => false)),
			'titulo'          => new sfValidatorString(array('required' => true), array('required' => 'El título es obligatorio')),
			'direccion'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
			'contenido'       => new sfValidatorString(array('required' => false)),
			'fecha'           => new sfValidatorDate(array('required' => true), array('required' => 'La fecha es obligatoria')),
			'fecha_caducidad' => new sfValidatorDate(array('required' => true), array('required' => 'La fecha de caducidad es obligatoria')),
			'horario'         => new sfValidatorString(array('required' => false), array('required' => 'El horario es obligatorio')),
			'estado'          => new sfValidatorChoice(array('choices' => array('activa' => 'activa', 'anulada' => 'anulada', 'pendiente' => 'pendiente', 'caducada' => 'caducada'), 'required' => false)),
			'owner_id'        => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'required' => false)),
		));
		
		//$this->validatorSchema->setOption('allow_extra_fields', true);
		
		
		
	if ($request->getRequest()->getParameter('ConsejoTerritorial')==3 || $request->getRequest()->getParameter('GrupodeTrabajo')==2 || $request->getRequest()->getParameter('Organismo')==4 )
        {
            $this->setWidget('entidad', new sfWidgetFormChoice(array('choices' => $grupos)));
            $this->setValidator('entidad', new sfValidatorChoice(array('choices' => array_keys($grupos), 'required' => false)));
        }

        $this->setDefaults(array(
        'owner_id' => $userId,
        'estado' => $estado,
        'entidad' => $request->getUser()->getAttribute('asambleas_nowentidad')? $request->getUser()->getAttribute('asambleas_nowentidad'): '',
        ));
		
        if($request->getRequest()->getParameter('DirectoresGerente')==1)
        {
           $this->setWidget('entidad',new sfWidgetFormInputHidden());
           $this->setValidator('entidad', new sfValidatorString(array('max_length' => 255, 'required' => false)));
           $this->setWidget('usu',new sfWidgetFormSelectDoubleList(array('choices'=> $directoer,'label_associated' => 'Seleccionados', 'label_unassociated' => 'Opciones')));
    	   $this->setValidator('usu', new sfValidatorChoiceMany(array('choices' => array_keys($directoer), 'required' => true),array('required' => 'Debe seleccionar un Director Gerente')));
    	   
    	   
		   $this->setDefault('entidad','DirectoresGerentes_0');		
		   $this->setDefault('usu',array($userId));		
		   if($request->getActionName() == 'update' || $request->getActionName() == 'editar')
		   {
		      $this->setDefault('usu',$usuAsmblea);		
		   }   
        }
       
        
        if($request->getRequest()->getParameter('Junta_directiva')==5)
        {
           $this->setWidget('entidad', new sfWidgetFormInputHidden());
    	   $this->setValidator('entidad', new sfValidatorString(array('max_length' => 255, 'required' => false))); 	
           $this->setDefault('entidad','Junta_directiva_5');
        }
        
        if($request->getRequest()->getParameter('Otros')==6)
        {
           $this->setWidget('entidad', new sfWidgetFormInputHidden());
    	   $this->setValidator('entidad', new sfValidatorString(array('max_length' => 255, 'required' => false))); 	
           $this->setDefault('entidad','Otros_6');
        }
	
        $this->validatorSchema->setOption('allow_extra_fields', true);
		$this->widgetSchema->setNameFormat('asamblea[%s]');
	}
}