<?php

/**
 * asambleas actions.
 *
 * @package    extranet
 * @subpackage asambleas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class asambleasActions extends sfActions
{
		
	public function executeIndex(sfWebRequest $request)
	{
		
		
		if($this->getRequestParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
	   		
	   		$this->getUser()->getAttributeHolder()->remove('asambleas_nowentidad');
	   		$this->getUser()->getAttributeHolder()->remove('asambleas_nowfilter');
	   		$this->grupodetrabajoBsq='';

		   	
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			$this->Grupo = '';
			
		}
		if($this->getRequestParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
			$this->Consejo = '';
		}
		if($this->getRequestParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
			$this->Organismo = '';
		}
		if($this->getRequestParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva(); 
	   		$this->getUser()->getAttributeHolder()->remove('asambleas_nowentidad');
	   		$this->getUser()->getAttributeHolder()->remove('asambleas_nowfilter');
	   		$this->grupodetrabajoBsq='';

	   				   	
		}
		if($this->getRequestParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
	   		$this->getUser()->getAttributeHolder()->remove('asambleas_nowentidad');
	   		$this->getUser()->getAttributeHolder()->remove('asambleas_nowfilter');
	   		$this->grupodetrabajoBsq='';

		}

		## buscar segun el esatdo de canvocatria
		$this->tipobqd = !$this->getRequestParameter('tipo')?$this->getUser()->getAttribute('asambleas_tipo'):$this->getRequestParameter('tipo') ;

		$pendientes = 'a.estado!=\'anulada\' AND a.estado!=\'caducada\'';
		$aceptadas = 'a.estado!=\'anulada\' AND a.estado!=\'caducada\'';
		if(!empty($this->tipobqd))
		{
			if($this->tipobqd == 1)
			{
				$pendientes.= $this->setFiltroBusqueda();
				$this->getUser()->setAttribute('asambleas_tipo', $this->tipobqd);
				
			}
			if($this->tipobqd == 2)
			{
				 $aceptadas.= $this->setFiltroBusqueda();
				 $this->getUser()->setAttribute('asambleas_tipo', $this->tipobqd);
			}
		}
		else 
		{
			$pendientes.= $this->setFiltroBusqueda();
			$aceptadas.= $this->setFiltroBusqueda();
			
		}
		## Pendientes
		$this->pager1 = new sfDoctrinePager('Asamblea', 10);
		$this->pager1->getQuery()
			->from('Convocatoria c')
			->leftJoin('c.Asamblea a')
			->where('c.deleted = 0')
			->where('a.deleted = 0')
			->addWhere('c.usuario_id=' . $this->getUser()->getAttribute('userId'))
			->addWhere('c.estado=\'pendiente\'')
			->andWhere('a.fecha_caducidad >= NOW()')
			->addWhere($pendientes.' AND a.'.$this->DAtos['where'])
			->orderBy('a.fecha desc');
		$this->pager1->setPage($this->getRequestParameter('page', 1));
		$this->pager1->init();
		
		$this->convocatorias_pendientes = $this->pager1->getResults();
		
		## Aceptadas y rechazadas
		$this->pager2 = new sfDoctrinePager('Asamblea', 10);
		$this->pager2->getQuery()
			->from('Convocatoria c')
			->leftJoin('c.Asamblea a')
			->where('c.deleted=0')
			->addWhere('c.usuario_id=' . $this->getUser()->getAttribute('userId'))
			->addWhere('c.estado=\'aceptada\' OR c.estado=\'rechazada\'')
			->addWhere($aceptadas.' AND a.'.$this->DAtos['where'])
			->andWhere('a.fecha_caducidad >= NOW()')
			->andWhere('a.deleted = 0')
			->orderBy('a.fecha desc');
			
			
		$this->pager2->setPage($this->getRequestParameter('page', 1));
		$this->pager2->init();
		
		$this->convocatorias = $this->pager2->getResults();
	    
		$busqueda = explode('_',$this->grupodetrabajoBsq); 
		

		if($busqueda[0] == 'GrupoTrabajo')
			{
			  $this->Grupo = GrupoTrabajoTable::getGrupoTrabajo($busqueda[1]);
			}
		elseif($busqueda[0] == 'ConsejoTerritorial') 
			{
			  $this->Consejo = ConsejoTerritorialTable::getConsejo($busqueda[1]);
			}
		elseif($busqueda[0] == 'Organismo') 
			{
			  $this->Organismos = OrganismoTable::getOrganismo($busqueda[1]);
                          $this->organismomenu = $busqueda[1];
			}
		
	}
	
	public function executeLista(sfWebRequest $request)
	{
		
		if($this->getRequestParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
	   		$this->getUser()->getAttributeHolder()->remove('asambleas_nowentidad');
	   		$this->getUser()->getAttributeHolder()->remove('asambleas_nowfilter');
	   		$this->grupodetrabajoBsq='';

		   	
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($this->getRequestParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($this->getRequestParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		if($this->getRequestParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva();
	   		$this->getUser()->getAttributeHolder()->remove('asambleas_nowentidad');
	   		$this->getUser()->getAttributeHolder()->remove('asambleas_nowfilter');
	   		$this->grupodetrabajoBsq='';
 
		   	
		}
		if($this->getRequestParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
	   		$this->getUser()->getAttributeHolder()->remove('asambleas_nowentidad');
	   		$this->getUser()->getAttributeHolder()->remove('asambleas_nowfilter');
	   		$this->grupodetrabajoBsq='';

		   	
		}


		
  	    $this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		
//		echo 'a.owner_id='.$this->getUser()->getAttribute('userId').' '.$this->setFiltroBusqueda().' AND '.$this->DAtos['where'];
//		exit();
        $rolTrue = UsuarioRol::getRepository()->getRoAndUsurio($this->getUser()->getAttribute('userId'), '(1,2)');		


		$this->pager = new sfDoctrinePager('Asamblea', 10);
		$this->pager->getQuery()
			->from('Asamblea a')
			->where('a.deleted=0'.$this->setFiltroBusqueda());
			if( count($rolTrue) == 0)
			{
				$this->pager->getQuery()->andWhere('a.owner_id='.$this->getUser()->getAttribute('userId').' AND a.'.$this->DAtos['where']);
			}	
			$this->pager->getQuery()->orderBy($this->setOrdenamiento());
	
		$this->pager->setPage($this->getRequestParameter('page', 1));
		$this->pager->init();

		
		$this->asamblea_list = $this->pager->getResults();
		 
		$busqueda = explode('_',$this->grupodetrabajoBsq); 
		

		if($busqueda[0] == 'GrupoTrabajo')
			{
			  $this->Grupo = GrupoTrabajoTable::getGrupoTrabajo($busqueda[1]);
			}
		elseif($busqueda[0] == 'ConsejoTerritorial') 
			{
			  $this->Consejo = ConsejoTerritorialTable::getConsejo($busqueda[1]);
			}
		elseif($busqueda[0] == 'Organismo') 
			{
			  $this->Organismos = OrganismoTable::getOrganismo($busqueda[1]);
                          $this->organismomenu = $busqueda[1];
			}
	}

	public function executeNueva(sfWebRequest $request)
	{
		if($this->getRequestParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($this->getRequestParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($this->getRequestParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		if($this->getRequestParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva(); 
		   	
		}
		if($this->getRequestParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
		   	
		}

		
		$this->form = new AsambleaForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		
		if($request->getParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($request->getParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($request->getParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($request->getParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		if($request->getParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva(); 
		   	
		}
		if($request->getParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
		   	
		}

		
		$this->forward404Unless($request->isMethod('post'));
		
		$this->form = new AsambleaForm();
		
		$this->processForm($request, $this->form);
		
		$this->setTemplate('nueva');
	}

	public function executeEditar(sfWebRequest $request)
	{
		if($this->getRequestParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($this->getRequestParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($this->getRequestParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		if($this->getRequestParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva(); 
		   	
		}
		if($this->getRequestParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
		   	
		}

		
		$this->forward404Unless($asamblea = Doctrine::getTable('Asamblea')->find($request->getParameter('id')), sprintf('Object asamblea does not exist (%s).', $request->getParameter('id')));
		$this->form = new AsambleaForm($asamblea);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		if($request->getParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($request->getParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($request->getParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($request->getParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		if($request->getParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva(); 
		   	
		}
		if($request->getParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
		   	
		}

		
		
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($asamblea = Doctrine::getTable('Asamblea')->find($request->getParameter('id')), sprintf('Object asamblea does not exist (%s).', $request->getParameter('id')));
		$this->form = new AsambleaForm($asamblea);
		
		$this->processForm($request, $this->form);
		
		$this->setTemplate('editar');
	}

	public function executeDelete(sfWebRequest $request)
	{
		if($this->getRequestParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($this->getRequestParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($this->getRequestParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		if($this->getRequestParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva(); 
		   	
		}
		if($this->getRequestParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
		   	
		}
		
		$request->checkCSRFProtection();
		
		$this->forward404Unless($asamblea = Doctrine::getTable('Asamblea')->find($request->getParameter('id')), sprintf('Object asamblea does not exist (%s).', $request->getParameter('id')));

                $agenda = AgendaTable::getDeleteAgendaConvocatoria($asamblea->getId());
		$aviso = NotificacionTable::getDeleteEntidad($asamblea->getId(),$asamblea->getTitulo());

                $agenda->delete();
		$aviso->delete();
		$asamblea->delete();
		
		$this->redirect('asambleas/lista?'.$this->DAtos['get']);
	}
	
	public function executeAnular(sfWebRequest $request)
	{
		if($this->getRequestParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($this->getRequestParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($this->getRequestParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		if($this->getRequestParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva(); 
		   	
		}
		if($this->getRequestParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
		   	
		}
		
		$request->checkCSRFProtection();
		
		$this->forward404Unless($asamblea = Doctrine::getTable('Asamblea')->find($request->getParameter('id')), sprintf('Object asamblea does not exist (%s).', $request->getParameter('id')));
		$asamblea->setEstado('anulada');
		$asamblea->save();
		
		$this->redirect('asambleas/lista?'.$this->DAtos['get']);
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		if($request->getParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($request->getParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($request->getParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($this->getRequestParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		if($request->getParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva(); 
		   	
		}
		if($request->getParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
		   	
		}
		
		
		$usu = $request->getParameter($form->getName());		
		
		$form->bind($request->getParameter($form->getName()));
						
		if ($form->isValid()) {
				
			$asamblea = $form->save();
						
			if(!empty($usu['usu']))
			{	
				$direcId = UsuarioAsamblea::getRepository()->getUsuByAsam($asamblea->getId());
				foreach($direcId AS $d)
				{
					$d->Delete();	
				}			
				## cargar usuarios directores en la asamblea				
				foreach ($usu['usu'] AS $dir=>$d)
				{
						$asmbleaDirecoteres = new UsuarioAsamblea();
						$asmbleaDirecoteres->setUsuarioId($d);
						$asmbleaDirecoteres->setAsambleaId($asamblea->getId());
						$asmbleaDirecoteres->save();	
				}
				
			}	
			
			## Comprobar acta
			$acta = Doctrine::getTable('Acta')->findOneByAsambleaId($asamblea->getId());
			if (!$acta) {
				$acta = new Acta();
				$acta->setOwnerId($this->getUser()->getAttribute('userId'));
				$acta->setAsambleaId($asamblea->getId());
				$acta->save();
			}
			
			if($_POST['convocar']) {
				$this->redirect('asambleas/convocar?id='.$asamblea->getId().'&'.$this->DAtos['get']);
			} else if ($form->getValue('estado') == 'anulada') {
				$this->getUser()->setFlash('notice', 'La asamblea ha sido anulada');
				$this->redirect('asambleas/lista?'.$this->DAtos['get']);
			} else {
				$this->getUser()->setFlash('notice', 'La asamblea ha sido actualizada correctamente');
				$this->redirect('asambleas/lista?'.$this->DAtos['get']);
			}
		}
	}
	
	public function executeActa(sfWebRequest $request)
	{
		if($this->getRequestParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($this->getRequestParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($this->getRequestParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		if($this->getRequestParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva(); 
		   	
		}
		if($this->getRequestParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
		   	
		}
		
		$this->forward404Unless($this->acta = Doctrine::getTable('Acta')->findOneByAsambleaId($request->getParameter('id')), sprintf('Object asamblea does not exist (%s).', $request->getParameter('id')));
	}
	
	public function executeConvocar(sfWebRequest $request)
	{
		if($request->getParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($request->getParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($request->getParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($request->getParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		if($request->getParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva(); 
		   	
		}
		if($request->getParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
		   	
		}
		
		## Obtener el id de la asamblea
		if(!$this->asambleaId = $this->getRequestParameter('id'))
			$this->forward404('La asamblea solicitada no existe');
		
		$asamblea = AsambleaTable::getAsambleaId($this->asambleaId,$this->DAtos['where']);
		$asamblea->setEstado('activa');
		$asamblea->save();

		## Obtener los usuarios de ese grupo
		$usuarios = $this->DAtos['usuarios'];

		sfLoader::loadHelpers(array('Tag', 'Asset'));
		$iPh = image_path('/images/logo_email.jpg', true);
		
		foreach ($usuarios as $usuario) {
			
		if($usuario->getUsuario()->getId() && $this->asambleaId)
			{
				$convocatoria = new Convocatoria();
				$convocatoria->setAsambleaId($this->asambleaId);
				$convocatoria->setUsuarioId($usuario->getUsuario()->getId());
				$convocatoria->setOwnerId($this->getUser()->getAttribute('userId'));
				if ($this->getUser()->getAttribute('userId') == $usuario->Usuario->getId()) $convocatoria->setEstado('aceptada');
				else $convocatoria->setEstado('pendiente');
				
				$convocatoria->save();
				
			
			ServiceAgenda::AgendaSave($asamblea->getFecha(),$asamblea->getTitulo(),$this->getUser()->getAttribute('nombre').','.$this->getUser()->getAttribute('apellido'),'asambleas/ver?id='.$asamblea->getId().'&'.$this->DAtos['get'],'0',$asamblea->getId(),$usuario->getUsuario()->getId());
			
			if($usuario->getUsuario()->getEmail())	
			{	
                                $nombreEvento =  $asamblea->getTitulo() ;
                                $descripcion = $asamblea->getContenido();

				$mailer = new Swift(new Swift_Connection_NativeMail());
				$message = new Swift_Message('Contacto desde Extranet de Asociados AMAT');

				$mailContext = array('tema'   => 'Convocatoria a asamblea:'.$asamblea->getTitulo(),
				                     'evento' => $nombreEvento,  
														 'descripcio' => $descripcion,
														 'head_image' => $iPh
														);
				$message->attach(new Swift_Message_Part($this->getPartial('asambleas/mailHtmlBody', $mailContext), 'text/html'));
				$message->attach(new Swift_Message_Part($this->getPartial('asambleas/mailTextBody', $mailContext), 'text/plain'));

				$mailer->send($message, $usuario->getUsuario()->getEmail(), sfConfig::get('app_default_from_email'));
				$mailer->disconnect();		
		   }
		  }  
		}

		## Notificar
		if(!isset($_POST['sf_method']) && $asamblea->getEstado() == 'activa') {
			ServiceNotificacion::send('lectura', 'Asamblea', $asamblea->getId(), $asamblea->getTitulo(),$this->DAtos);
		}
		$this->getUser()->setFlash('notice', 'La convocatoria se ha realizado correctamente');
		$this->redirect('asambleas/lista?'.$this->DAtos['get']);
	}
	
	public function executeConvocados(sfWebRequest $request)
	{
		if($this->getRequestParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($this->getRequestParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($this->getRequestParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		if($this->getRequestParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva(); 
		   	
		}
		if($this->getRequestParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
		   	
		}
		
		
		## Obtener asamblea
		if(!$this->asambleaId = $this->getRequestParameter('id'))
			$this->forward404('La asamblea solicitada no existe');
		
		$this->asamblea = Doctrine::getTable('Asamblea')->find($this->asambleaId);
		
		## Grupos y Consejos
		$this->convocados = Doctrine::getTable('Convocatoria')->getConvocadosByAsamblea($this->asambleaId);
	}
	
	public function executeAceptar(sfWebRequest $request)
	{
		if ($this->getRequestParameter('DirectoresGerente')==1) {
			$this->DAtos = $this->setDirectoresGerente();
		}
		if ($this->getRequestParameter('GrupodeTrabajo')==2) {
			$this->DAtos =$this->setGruposdeTrabajo();
		}
		if ($this->getRequestParameter('ConsejoTerritorial')==3) {
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if ($this->getRequestParameter('Organismo')==4) {
			$this->DAtos = $this->setOrganismo();
		}
		if($this->getRequestParameter('Junta_directiva')==5) { 
			$this->DAtos = $this->setJuntadirectiva();
		}
		if($this->getRequestParameter('Otros')==6) {
			$this->DAtos = $this->setOtros();
		}
		## Obtener el id de la asamblea
		if (!$this->convocatoriaId = $this->getRequestParameter('convocatoria')) {
			$this->forward404('La convocatoria solicitada no existe');
		}
		$convocatoria = Doctrine::getTable('Convocatoria')->find($this->convocatoriaId);
		$convocatoria->setEstado('aceptada');
		$convocatoria->save();
		$userConvocador = UsuarioTable::getUsuarioByid($convocatoria->getOwnerId());

		if ($userConvocador->getEmail()) {
			sfLoader::loadHelpers(array('Tag', 'Asset'));
			$iPh = image_path('/images/logo_email.jpg', true);

			$temaTi  = 'Convocatoria a asamblea aceptada por parte de '.$convocatoria->Usuario->getNombre().', '.$convocatoria->Usuario->getApellido();
			$mailer  = new Swift(new Swift_Connection_NativeMail());
			$message = new Swift_Message('Contacto desde Extranet de Asociados AMAT');

			$mailContext = array('tema'  => $temaTi,
			                    'evento' => $convocatoria->Asamblea->getTitulo(),
													'descripcio' => $convocatoria->Asamblea->getContenido(),
													'head_image' => $iPh
			);
			$message->attach(new Swift_Message_Part($this->getPartial('asambleas/mailHtmlBody', $mailContext), 'text/html'));
			$message->attach(new Swift_Message_Part($this->getPartial('asambleas/mailTextBody', $mailContext), 'text/plain'));

			$mailer->send($message, $userConvocador->getEmail(), sfConfig::get('app_default_from_email'));
			$mailer->disconnect();
		}
		$this->getUser()->setFlash('notice', 'La convocatoria ha sido aceptada');
		$this->redirect('asambleas/index?'.$this->DAtos['get']);
	}
	
	public function executeRechazar(sfWebRequest $request)
	{
		if($this->getRequestParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($this->getRequestParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($this->getRequestParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		if($this->getRequestParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva(); 
		   	
		}
		if($this->getRequestParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
		   	
		}
		
		## Obtener el id de la asamblea
		if(!$this->convocatoriaId = $this->getRequestParameter('convocatoria'))
			$this->forward404('La convocatoria solicitada no existe');
		
		$convocatoria = Doctrine::getTable('Convocatoria')->find($this->convocatoriaId);
		$convocatoria->setEstado('rechazada');
		$convocatoria->save();
		

		$this->getUser()->setFlash('notice', 'La convocatoria ha sido rechazada');
		$this->redirect('asambleas/index?'.$this->DAtos['get']);
	}
	
	public function executeVer(sfWebRequest $request)
	{    
		
		if($this->getRequestParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($this->getRequestParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($this->getRequestParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		if($this->getRequestParameter('Junta_directiva')==5)
		{  
	   		$this->DAtos = $this->setJuntadirectiva(); 
		   	
		}
		if($this->getRequestParameter('Otros')==6)
		{  
	   		$this->DAtos = $this->setOtros(); 
		   	
		}
		
		
		 $IDcon = ''; 
		 if($this->getRequestParameter('idCon')){$IDcon = $this->getRequestParameter('idCon');}
	     else 
	     {
			## Obtener asamblea
			if(!$this->asambleaId = $this->getRequestParameter('id'))
				$this->forward404('La asamblea solicitada no existe');
	     }		
		   $this->asamblea = AsambleaTable::getConvocotatiaId($this->asambleaId,$this->getUser()->getAttribute('userId'),$IDcon);
		   
		   $this->user = UsuarioTable::getUsuarioByid($this->asamblea->getOwnerId());
		   
		   
		   
	}
	public function executeComentar(sfWebRequest $request)
	{    
			
			if($request->getParameter('DirectoresGerente')==1)
			{  
		   		$this->DAtos = $this->setDirectoresGerente(); 
			   	
			}
			if($request->getParameter('GrupodeTrabajo')==2)
			{  
				$this->DAtos =$this->setGruposdeTrabajo();
				
			}
			if($request->getParameter('ConsejoTerritorial')==3)
			{  
				$this->DAtos = $this->setConsejosTerritoriales();
			}	
			if($request->getParameter('Organismo')==4)
			{  
				$this->DAtos = $this->setOrganismo();
			}
			if($request->getParameter('Junta_directiva')==5)
			{  
		   		$this->DAtos = $this->setJuntadirectiva(); 
			   	
			}
			if($request->getParameter('Otros')==6)
			{  
		   		$this->DAtos = $this->setOtros(); 
			   	
			}
		   $IDcon = '';
                   $id = '';
		   if($this->getRequestParameter('idCon')){$IDcon = $this->getRequestParameter('idCon');}
                   if($this->getRequestParameter('id')){$id = $this->getRequestParameter('id');}
		   $this->asamblea = AsambleaTable::getConvocotatiaId($this->asambleaId,$this->getUser()->getAttribute('userId'),$IDcon);
		   
		   $this->asamblea->setDetalle($this->getRequestParameter('comentario'));
		   $this->asamblea->save();
		   
		 
		 $this->redirect('asambleas/ver?id='.$id.'&idCon='.$IDcon.'&'.$this->DAtos['get']);
	}
	
	 protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');
  	$parcial = '';
  	$modulo  = $this->getModuleName();
  	$this->modulo = $modulo;

		$this->tipoasambleaBsq = $this->getRequestParameter('tipoasamblea');
		$this->tituloBsq = $this->getRequestParameter('titulo');
		$this->grupodetrabajoBsq = $this->getRequestParameter('grupodetrabajo');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda');
		
		if(!empty($this->tipoasambleaBsq))
		{
			$parcial = " AND a.estado ='$this->tipoasambleaBsq'";
				$this->getUser()->setAttribute($modulo.'_nowtipoasamblea', $this->tipoasambleaBsq);
		}
		if(!empty($this->tituloBsq))
		{
			$parcial.="AND (a.titulo LIKE '%$this->tituloBsq%')";
				$this->getUser()->setAttribute($modulo.'_nowtitulo', $this->tituloBsq);
		}
    if(!empty($this->grupodetrabajoBsq))
		{
			$parcial.=" AND a.entidad ='$this->grupodetrabajoBsq'";
			$this->getUser()->setAttribute($modulo.'_nowentidad', $this->grupodetrabajoBsq);
		}
    if (!empty($this->desdeBsq)) {
			$parcial .= " AND a.fecha >= '".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowdesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND a.fecha <= '".format_date($this->hastaBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowhasta', $this->hastaBsq);
		}
		
		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowtipo');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowtipoasamblea');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowtitulo');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowentidad');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->tipoasambleaBsq = $this->getUser()->getAttribute($modulo.'_nowtipoasamblea');
				$this->tituloBsq = $this->getUser()->getAttribute($modulo.'_nowtitulo');
				$this->grupodetrabajoBsq = $this->getUser()->getAttribute($modulo.'_nowentidad');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowdesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowhasta');
			}
		} 
   
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowtipo');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowtipoasamblea');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowtitulo');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowentidad');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			$parcial="";
			$this->tipobqd = "";
			$this->tipoasambleaBsq = '';
			$this->tituloBsq = '';
			$this->grupodetrabajoBsq = '';
			$this->desdeBsq = '';
			$this->hastaBsq = '';
		}
		
		return $parcial;
  }
  
  protected function setOrdenamiento()
  {
		$modulo = $this->getModuleName();
		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
		}else {
                    if($this->getUser()->getAttribute($modulo.'_noworderBY'))
                    {
                       $this->orderBYSql = $this->getUser()->getAttribute($modulo.'_noworderBY');
                       $ordenacion = explode(' ', $this->orderBYSql);
                       $this->orderBy = $ordenacion[0];
                       $this->sortType = $ordenacion[1];
                    }
                    else
                    {
                        $this->orderBy = 'a.fecha';
                        $this->sortType = 'desc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }
  
  protected function setDirectoresGerente()
  {
		    $arraDAtos['tipo'] = 'Directores Gerentes';
			$arraDAtos['titulo'] = 'Asamblea';
			$arraDAtos['busqueda'] = '';
			$arraDAtos['get'] = 'DirectoresGerente=1' ;
			$arraDAtos['campo']= 'DirectoresGerente' ;
			$arraDAtos['valor']= '1' ;
			$arraDAtos['where']= "entidad = 'DirectoresGerentes_0'" ;
			if($this->getRequestParameter('id'))
			{
			 $arraDAtos['usuarios'] =  UsuarioAsambleaTable::getUsuByAsam($this->getRequestParameter('id'));	
			 $arraDAtos['Entidad']='';
			}
			
	return $arraDAtos;		 
  } 
  protected function setGruposdeTrabajo()
  {
		    $arraDAtos['tipo'] = 'Grupos de Trabajo';
			$arraDAtos['titulo'] = 'Convocatoria';
			$arraDAtos['busqueda'] = 'Grupos de Trabajo';
			$arraDAtos['get'] = 'GrupodeTrabajo=2' ;
			$arraDAtos['campo']= 'GrupodeTrabajo' ;
			$arraDAtos['valor']= '2' ;
			$arraDAtos['where']= "entidad LIKE '%GrupoTrabajo%'" ;
			if($this->getRequestParameter('id'))
			{  
			    $idGrupo =explode('_', AsambleaTable::getAsambleaId($this->getRequestParameter('id'),$arraDAtos['where'])->getEntidad());
			    
				$arraDAtos['usuarios'] =  UsuarioGrupoTrabajoTable::getUsreByGrupo($idGrupo[1],1);

				$arraDAtos['Entidad'] = GrupoTrabajoTable::getGrupoTrabajo($idGrupo[1])->getNombre();	
				
			}
			
	return $arraDAtos;		
  }
  protected function setConsejosTerritoriales()
  {
		    $arraDAtos['tipo'] = 'Consejos Territoriales';
			$arraDAtos['titulo'] = 'Convocatoria';
			$arraDAtos['busqueda'] = 'Consejos Territoriales';
			$arraDAtos['get'] = 'ConsejoTerritorial=3' ;
			$arraDAtos['campo']= 'ConsejoTerritorial' ;
			$arraDAtos['valor']= '3' ;
			$arraDAtos['where']= "entidad LIKE '%ConsejoTerritorial%'";
			if($this->getRequestParameter('id'))
			{  
			    $idGrupo =explode('_', AsambleaTable::getAsambleaId($this->getRequestParameter('id'))->getEntidad());
				$arraDAtos['usuarios'] =  UsuarioConsejoTerritorialTable::getUsreByConse($idGrupo[1],1);
				$arraDAtos['Entidad'] = ConsejoTerritorialTable::getConsejo($idGrupo[1])->getNombre();		
			}
			
	return $arraDAtos;			
  }
   protected function setOrganismo()
  {
		    $arraDAtos['tipo'] = 'Organismo';
			$arraDAtos['titulo'] = 'Convocatoria';
			$arraDAtos['busqueda'] = 'Organismo';
			$arraDAtos['get'] = 'Organismo=4' ;
			$arraDAtos['campo']= 'Organismo' ;
			$arraDAtos['valor']= '4' ;
			$arraDAtos['where']= "entidad LIKE '%Organismo%'" ;
			if($this->getRequestParameter('id'))
			{  
			    $idGrupo =explode('_', AsambleaTable::getAsambleaId($this->getRequestParameter('id'))->getEntidad());
			    
				$arraDAtos['usuarios'] =  UsuarioTable::getUsuarioByOrganismoAsn($idGrupo[1],1);
				

				$arraDAtos['Entidad'] = OrganismoTable::getOrganismo($idGrupo[1])->getNombre();	
				
			}
			
	return $arraDAtos;		
  }
	protected function setJuntadirectiva()
  {
		    $arraDAtos['tipo'] = 'Junta Directiva';
			$arraDAtos['titulo'] = 'Junta Directiva';
			$arraDAtos['busqueda'] = '';
			$arraDAtos['get'] = 'Junta_directiva=5' ;
			$arraDAtos['campo']= 'Junta_directiva' ;
			$arraDAtos['valor']= '5' ;
			$arraDAtos['where']= "entidad = 'Junta_directiva_5'" ;
			if($this->getRequestParameter('id'))
			{
			 $arraDAtos['usuarios'] =  UsuarioRolTable::getUserByRol(3);	
			 $arraDAtos['Entidad']='';
			}
			
	return $arraDAtos;		 
  } 
  protected function setOtros()
  {
		    $arraDAtos['tipo'] = 'Otros';
			$arraDAtos['titulo'] = 'Otros';
			$arraDAtos['busqueda'] = '';
			$arraDAtos['get'] = 'Otros=6' ;
			$arraDAtos['campo']= 'Otros' ;
			$arraDAtos['valor']= '6' ;
			$arraDAtos['where']= "entidad = 'Otros_6'" ;
			if($this->getRequestParameter('id'))
			{
			 $arraDAtos['usuarios'] =  UsuarioRolTable::getUserByRol(3);	
			 $arraDAtos['Entidad']='';
			}
			
	return $arraDAtos;		 
  } 
	
}
