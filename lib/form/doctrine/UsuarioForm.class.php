<?php
/**
 * Usuario form.
 *
 * @package    form
 * @subpackage Usuario
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class UsuarioForm extends BaseUsuarioForm
{
	public function configure()
	{
		$request =sfContext::getInstance();
		$action = $request->getActionName();
		
		
		## Obtengo todos los roles
		$roles = Doctrine::getTable('Rol')->createQuery('r')->where('deleted=0')->addWhere('excepcion = 0')->orderBy('nombre')->execute();

		$arrRoles = array();
		foreach ($roles as $r) {
			$arrRoles[$r->getId()] = $r->getNombre();
		}

		## Obtengo todos los grupos de trabajo
		$gruposTrabajo = Doctrine::getTable('GrupoTrabajo')->createQuery('gt')->where('deleted=0')->orderBy('nombre')->execute();

		$arrGruposTrabajo = array();
		foreach ($gruposTrabajo as $r) {
			$arrGruposTrabajo[$r->getId()] = $r->getNombre();
		}
		
		## Obtengo todos los consejos territoriales
		$consejosTerritoriales = Doctrine::getTable('ConsejoTerritorial')->createQuery('ct')->where('deleted=0')->orderBy('nombre')->execute();

		$arrConsejosTerritoriales = array();
		foreach ($consejosTerritoriales as $r) {
			$arrConsejosTerritoriales[$r->getId()] = $r->getNombre();
		}
		
		## Obtengo todas las aplicaciones externas
		$aplicacionesExternas = Doctrine::getTable('AplicacionExterna')->createQuery('ae')->where('deleted=0')->orderBy('ae.nombre')->execute();

		$arrAplicacionesExternas = array();
		foreach ($aplicacionesExternas as $r) {
			$arrAplicacionesExternas[$r->getId()] = $r->getNombre();
		}
		
		## obtengo las mutuas 
		$mutuas = Doctrine::getTable('Mutua')->createQuery('m')->where('deleted=0')->orderBy('nombre')->execute();
		
		$arraMutuas = array();
		foreach ($mutuas as $m) {
			$arraMutuas[$m->getId()] = $m->getNombre();
		}

              
              
               if($request->getRequest()->getParameter('usuario'))
                {
                  $objRq = $request->getRequest()->getParameter('usuario');
                  if($objRq['email']!='')
                   {
                      $id = '';
                      $email = $objRq['email'];
                      $id = $objRq['id'];
                      $emailActivo = UsuarioTable::getUsuariosActivos($email,1, $id);
                      if(!empty($emailActivo))
                      {
                        $emailusu = $emailActivo->getEmail();
                      }
                   }
                }


		$this->setWidgets(array(
			'id'                          => new sfWidgetFormInputHidden(),
			'nombre'                      => new sfWidgetFormInput(array(), array('class' => 'form_input', 'style' => 'width: 355px;')),
			'apellido'                    => new sfWidgetFormInput(array(), array('class' => 'form_input', 'style' => 'width: 355px;')),
			'mutua_id'                    => new sfWidgetFormChoice(array('choices' => $arraMutuas), array('class' => 'form_input', 'style' => 'width: 200px;')),
			'telefono'                    => new sfWidgetFormInput(array(), array('class' => 'form_input', 'style' => 'width: 355px;')),
			'email'                       => new sfWidgetFormInput(array(),array('class' => 'form_input', 'style' => 'width: 355px;')),
			'activo'                      => new sfWidgetFormInputCheckbox(),
			'roles_list'                  => new sfWidgetFormSelectDoubleList(array('choices' => $arrRoles, 'label_associated' => 'Seleccionados', 'label_unassociated' => 'Opciones')),
			'consejos_territoriales_list' => new sfWidgetFormSelectDoubleList(array('choices' => $arrConsejosTerritoriales, 'label_associated' => 'Seleccionados', 'label_unassociated' => 'Opciones')),
			'grupos_trabajo_list'         => new sfWidgetFormSelectDoubleList(array('choices' => $arrGruposTrabajo, 'label_associated' => 'Seleccionados', 'label_unassociated' => 'Opciones')),
			'aplicacion_externas_list'    => new sfWidgetFormSelectDoubleList(array('choices' => $arrAplicacionesExternas, 'label_associated' => 'Seleccionados', 'label_unassociated' => 'Opciones'))
		));
		
		$this->setValidators(array(
			'id'                          => new sfValidatorDoctrineChoice(array('model' => 'Usuario', 'column' => 'id', 'required' => false)),
			'nombre'                      => new sfValidatorString(array('max_length' => 150, 'required' => true), array('required' => 'El nombre es obligatorio')),
			'apellido'                    => new sfValidatorString(array('max_length' => 150, 'required' => true), array('required' => 'El apellido es obligatorio')),
			'mutua_id'                    => new sfValidatorChoice(array('choices' => array_keys($arraMutuas))),
			'telefono'                    => new sfValidatorString(array('max_length' => 150, 'required' => false), array()),
			'email'                       => new sfValidatorAnd(array(new sfValidatorEmail(array(),array('invalid'=>'Ingrese un cuenta de correo v&aacute;lido'))),array(),array('required' => 'El email es obligatorio',)),
			'activo'                      => new sfValidatorBoolean(),
			'roles_list'                  => new sfValidatorDoctrineChoiceMany(array('model' => 'Rol', 'required' => false)),
			'consejos_territoriales_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'ConsejoTerritorial', 'required' => false)),
			'grupos_trabajo_list'         => new sfValidatorDoctrineChoiceMany(array('model' => 'GrupoTrabajo', 'required' => false), array('invalid' => 'Acción inválida')),
		        'aplicacion_externas_list'    => new sfValidatorDoctrineChoiceMany(array('model' => 'AplicacionExterna', 'required' => false), array('invalid' => 'Acción inválida')),

		));

                

		if($action == 'editar' || $action == 'update' )
		{
			$this->setWidget('password',new sfWidgetFormInputHidden(array(), array('class' => 'form_input', 'style' => 'width: 200px;')));
			$this->setWidget('repassword', new sfWidgetFormInputHidden(array(), array('class' => 'form_input', 'style' => 'width: 200px;')));
			$this->setWidget('login', new sfWidgetFormInputHidden(array(), array('class' => 'form_input', 'style' => 'width: 200px;')));
									
			$this->setValidator('password',new sfValidatorString(array('max_length' => 150, 'required' => false), array('required' => 'La contraseña es obligatoria')));
			$this->setValidator('repassword', new sfValidatorString(array('max_length' => 150,'required' => false),  array('required' => 'Ingrese el campo Repetir contraseña para validarla ')));						
			$this->setValidator('login', new sfValidatorString(array('max_length' => 150,'required' => false),  array('required' => 'Ingrese el campo Repetir contraseña para validarla ')));						
		}
		else 
		{
			$this->setWidget('password',new sfWidgetFormInputPassword(array(), array('class' => 'form_input', 'style' => 'width: 200px;')));
			$this->setWidget('repassword', new sfWidgetFormInputPassword(array(), array('class' => 'form_input', 'style' => 'width: 200px;')));
			$this->setWidget('login', new sfWidgetFormInput(array(), array('class' => 'form_input', 'style' => 'width: 200px;')));
									
			$this->setValidator('password',new sfValidatorString(array('max_length' => 150, 'required' => true), array('required' => 'La contraseña es obligatoria')));
			$this->setValidator('repassword', new sfValidatorString(array('max_length' => 150,'required' => false),  array('required' => 'Ingrese el campo Repetir contraseña para validarla ')));	
			$this->setValidator('login', new sfValidatorString(array('max_length' => 150, 'required' => true), array('required' => 'El usuario es obligatorio')));
			
			$this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'repassword', array(), array('invalid' => 'Las claves no son iguales')));
		}
		if(!empty ($emailusu))
                {
                        $this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare('email', sfValidatorSchemaCompare::EQUAL, $emailusu, array(), array('invalid' => 'El email ya pertenece a un usuario registrado')));
                }
		
		
		$this->widgetSchema->setLabels(array(
			'nombre'     => 'Nombre',
			'apellido'   => 'Apellidos',
			'mutua_id'   => 'Mutua',
			'telefono'   => 'Teléfono',
			'roles_list' => 'Perfiles',
			'login'      => 'Usuario',
			'password'   => 'Clave',
			'repassword' => 'Repetir Clave',
			'consejos_territoriales_list'	=> 'Consejo Territorial',
			'grupos_trabajo_list' => 'Grupo de Trabajo',
			'aplicacion_externas_list' => 'Aplicaciones Externas',
		));
		
		$this->widgetSchema->setNameFormat('usuario[%s]');
		
		
  }
}