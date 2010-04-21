<?php
/**
 * eventos actions.
 *
 * @package    extranet
 * @subpackage eventos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class eventosActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$modulo  = $this->getModuleName();
		$guardados = Common::getCantidaDEguardados('Evento e',$this->getUser()->getAttribute('userId'),$this->setFiltroBusqueda(),$modulo);
		
		$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	$this->pager = new sfDoctrinePager('Evento', 10);
		$this->pager->getQuery()
		->from('Evento e')
		->leftJoin('e.UsuarioEvento ue')
		->where($this->setFiltroBusqueda())
		->orderBy($this->setOrdenamiento());
		
//		echo $this->pager->getQuery()->getSql();
//		exit();

		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->evento_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults() - $guardados->count();
  }

	public function executeShow(sfWebRequest $request)
	{
		$this->evento = Doctrine::getTable('Evento')->find($request->getParameter('id'));
		$this->forward404Unless($this->evento);
	}

	public function executeNuevo(sfWebRequest $request)
	{
		$this->form = new EventoForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new EventoForm();

		$this->processForm($request, $this->form, 'creado');
		
		$this->setTemplate('nuevo');
	}

	public function executeEditar(sfWebRequest $request)
	{
		$this->forward404Unless($evento = Doctrine::getTable('Evento')->find($request->getParameter('id')), sprintf('Object evento does not exist (%s).', $request->getParameter('id')));
		$this->form = new EventoForm($evento);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($evento = Doctrine::getTable('Evento')->find($request->getParameter('id')), sprintf('Object evento does not exist (%s).', $request->getParameter('id')));
		$this->form = new EventoForm($evento);
		
		$this->processForm($request, $this->form, 'actualizado');
		
		$this->setTemplate('editar');
	}
	
	public function executePublicar(sfWebRequest $request)
	{
		$this->processSelectedRecords($request, 'publicar');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$this->processSelectedRecords($request, 'baja');
	}

	protected function processSelectedRecords(sfWebRequest $request, $accion)
	{
		$toProcess = $request->getParameter('id');
		
		if (!empty($toProcess)) {
			$IDs = is_array($toProcess) ? $toProcess : array($toProcess);
			
			foreach ($IDs as $id) {
				$request->checkCSRFProtection();
				$this->forward404Unless($evento = Doctrine::getTable('Evento')->find($id), sprintf('Object evento does not exist (%s).', $id));
				if ($accion == 'publicar') {
					sfLoader::loadHelpers(array('Security', 'Url', 'Tag', 'Asset'));
					if (!validate_action('publicar')) $this->redirect('seguridad/restringuido');	
					
					$evento->setEstado('publicado');
					$evento->save();
					
					$email = $evento->getAmbito() == 'intranet' ? UsuarioTable::getUsuarioByEventos($evento->getId()) : UsuarioTable::getEmailEvento($evento->getOwnerId());
					
					## Notificar
					ServiceNotificacion::send('creacion', 'Evento', $evento->getId(), $evento->getTitulo());
                                        if($evento->getAmbito() != 'intranet')
                                        {
                                         ServiceAgenda::AgendaSave($evento->getFecha(),$evento->getTitulo(),$evento->getOrganizador(),'eventos/show?id='.$evento->getId(),$evento->getId(),0,0,1);
                                        }
					
					if ($email) {
						$url = url_for('eventos/show?id='.$evento->getId(), true);
						$iPh = image_path('/images/logo_email.jpg',true);

						$agenda = AgendaTable::getDeleteAgenda($evento->getId());	    						
						$agenda->delete();

						$nombreEvento = $evento->getTitulo();
						$organizador  = $evento->getOrganizador();
						$descripcion  = $evento->getDescripcion();

                                                $coneccion = new Swift_Connection_SMTP('smtp.extranet.amat.es', 25, Swift_Connection_SMTP::ENC_SSL);
                                                $coneccion->setUsername('alertas.extranet.amat.es');
                                                $coneccion->setPassword('4oddF=dohm(F');

                                                $mailer  = new Swift($coneccion);

                                                $message = new Swift_Message('Contacto desde Extranet Sectorial AMAT');

                                                $mailContext = array('tema'   => 'Evento publicado',
                                                                 'evento' => $nombreEvento,
                                                                 'url'    => $url,
                                                                 'head_image'  => $iPh,
                                                                 'organizador' => $organizador,
                                                                 'descripcio'  => $descripcion,
                                                );
                                                $message->attach(new Swift_Message_Part($this->getPartial('eventos/mailHtmlBody', $mailContext), 'text/html'));
                                                $message->attach(new Swift_Message_Part($this->getPartial('eventos/mailTextBody', $mailContext), 'text/plain'));
						foreach ($email AS $emailPublic) {
							 if($evento->getAmbito() == 'intranet') {
                                                             ServiceAgenda::AgendaSave($evento->getFecha(),$evento->getTitulo(),$evento->getOrganizador(),'eventos/show?id='.$evento->getId(),$evento->getId(),0,$emailPublic->getId(),0);
                                                            }
							if ($emailPublic->getEmail() && preg_match('#^(((([a-z\d][\.\-\+_]?)*)[a-z0-9])+)\@(((([a-z\d][\.\-_]?){0,62})[a-z\d])+)\.([a-z\d]{2,6})$#i', $emailPublic->getEmail())) {
								$mailer->send($message, $emailPublic->getEmail(), sfConfig::get('app_default_from_email'));
							}
						}
                                                $mailer->disconnect();
					}
				} else {
					sfLoader::loadHelpers('Security'); // para usar el helper

					if (!validate_action('baja', 'eventos', $evento->getId())) $this->redirect('seguridad/restringuido');

					$agenda = AgendaTable::getDeleteAgenda($evento->getId());
					$aviso = NotificacionTable::getDeleteEntidad2($evento->getId(),$evento->getTitulo());
					$agenda->delete();
					$evento->delete();
				}
			}
		}
		$this->redirect('eventos/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
	{

                $enviar = false;
		$estado = $request->getParameter($form->getName());

		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		if ($form->isValid()) {
			$evento = $form->save();
			$strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';

			if($evento->getEstado() != 'guardado')
			{
				## Notificar y enviar email a los destinatarios
				if($evento->getEstado() == 'publicado') {
					$enviar  = true;
					$tema    = 'Evento publicado';
					$publico = 'si';
                                       
					NotificacionTable::getDeleteEntidad2($evento->getId(),$evento->getTitulo());

					if ($evento->getAmbito() == 'intranet' && !empty($estado['usuarios_list'])) {
						$email = UsuarioTable::getEmailEvento2($estado['usuarios_list']);
					}
                                        elseif($evento->getAmbito() == 'ambos'){
						$email = UsuarioTable::getEmailEvento2($evento->getOwnerId());
					}
                                        else
                                        {
                                                $email = '';
                                        }
				}
				## enviar email a los responsables 
				if ($evento->getEstado() == 'pendiente')
				{
					$enviar = true;
					$email  = AplicacionRolTable::getEmailEventoPublicar(2);
                                        $tema   = 'Evento pendiente de publicar';
					$publico= '';
					$agenda = AgendaTable::getDeleteAgenda($evento->getId());
          
					if (isset($agenda)) {
					$agenda->delete();
					}
					NotificacionTable::getDeleteEntidad2($evento->getId(),$evento->getTitulo());
				}
				## envia el email
				if ($enviar && $email!='') {
                                        $agenda = AgendaTable::getDeleteAgenda($evento->getId());
                                        if (isset($agenda)) {
                                                $agenda->delete();      
                                        }
             
                                        sfLoader::loadHelpers(array('Url', 'Tag', 'Asset'));
                                        $url = url_for('eventos/show?id='.$evento->getId(), true);
                                        $iPh = image_path('/images/logo_email.jpg', true);
          
                                        $mailer  = new Swift(new Swift_Connection_NativeMail());
                                        $message = new Swift_Message('Contacto desde Extranet Sectorial AMAT');
                                        $mailContext = array('tema'   => $tema,
                                                           'evento' => $estado['titulo'],
                                                           'url'    => $url,
                                                           'head_image'  => $iPh,
                                                           'organizador' => $estado['organizador'],
                                                           'descripcio'  => $estado['descripcion'],
                                         );
                                        $message->attach(new Swift_Message_Part($this->getPartial('eventos/mailHtmlBody', $mailContext), 'text/html'));
                                        $message->attach(new Swift_Message_Part($this->getPartial('eventos/mailTextBody', $mailContext), 'text/plain'));
                                     if ($publico != ''){
                                        if($evento->getAmbito() != 'intranet' && empty($estado['usuarios_list'])) {
                                         ServiceAgenda::AgendaSave($evento->getFecha(),$evento->getTitulo(),$evento->getOrganizador(),'eventos/show?id='.$evento->getId(),$evento->getId(),0,0,1);
                                        }
                                     }

                                      foreach ($email AS $emailPublic) {
                                        if ($publico != ''){
                                            if($evento->getAmbito() == 'intranet' && !empty($estado['usuarios_list'])) {
                                             ServiceAgenda::AgendaSave($evento->getFecha(),$evento->getTitulo(),$evento->getOrganizador(),'eventos/show?id='.$evento->getId(),$evento->getId(),0,$emailPublic['id'],0);     
                                            }
                                        }


                                        if ($emailPublic['email'] && preg_match('#^(((([a-z\d][\.\-\+_]?)*)[a-z0-9])+)\@(((([a-z\d][\.\-_]?){0,62})[a-z\d])+)\.([a-z\d]{2,6})$#i', $emailPublic['email'])) {
                                        $mailer->send($message, $emailPublic['email'], sfConfig::get('app_default_from_email'));                          
                                         }
                                        }
                                      $mailer->disconnect();
                                      }
                                      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");

                                      if($evento->getAmbito() == 'intranet' && empty($estado['usuarios_list'])) {
                                            $this->redirect('eventos/editar?id='.$evento->getId());
                                      } else {
                                            if(NotificacionTable::getDeleteEntidad($evento->getId())->count() == 0 && $evento->getEstado() != 'pendiente') {
                                                ServiceNotificacion::send('creacion', 'Evento', $evento->getId(), $evento->getTitulo());
                                            }
                                            $this->redirect('eventos/index'.$strPaginaVolver);
                                      }
                              }
                            $this->redirect('eventos/index'.$strPaginaVolver);
		}
	}
		
	public function executeDelete_selected(sfWebRequest $request)
	{
		if($this->getRequestParameter('checks')){
			foreach ($this->getRequestParameter('checks') as $name => $value) {
				$aux = explode('_', $name);
				$evento = Doctrine::getTable('Evento')->find($aux[1]);
				$evento->delete();
			}
			
			$this->getUser()->setFlash('notice', 'Los eventos seleccionados se han eliminado correctamente');
		} else {
			$this->getUser()->setFlash('error', 'Debes seleccionar al menos un evento');
		}
		$this->redirect($this->getRequestParameter('goto'));
	}
	
	public function executeVer(sfWebRequest $request)
	{
		if(!$this->eventoId = $this->getRequestParameter('id'))
			$this->forward404('El evento solicitado no existe');
			
		$this->evento = Doctrine::getTable('Evento')->find($this->eventoId);
	}
	
	protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');

  	$parcial = '';
  	$modulo = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda');
		$this->ambitoBQ = $this->getRequestParameter('ambito');
		$this->estadoBq = $this->getRequestParameter('estado');
		$this->contenidoBsq = $this->getRequestParameter('contenido_busqueda');

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND e.titulo LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->desdeBsq)) {
			$parcial .= " AND e.fecha >= '".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowdesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND e.fecha <= '".format_date($this->hastaBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowhasta', $this->hastaBsq);
		}
		if (!empty($this->ambitoBQ)) {
			$parcial .= " AND e.ambito = '".$this->ambitoBQ."'";
			$this->getUser()->setAttribute($modulo.'_nowambito', $this->ambitoBQ);
		}
		if (!empty($this->estadoBq)) {
			$parcial .= " AND e.estado = '".$this->estadoBq."'";
			$this->getUser()->setAttribute($modulo.'_nowestado', $this->estadoBq);
		}
		if (!empty($this->contenidoBsq)) {
			$parcial .= " AND e.mas_info LIKE '%$this->contenidoBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcontenido', $this->contenidoBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowambito');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowdesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowhasta');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowambito');
				$this->estadoBq = $this->getUser()->getAttribute($modulo.'_nowestado');
				$this->contenidoBsq = $this->getUser()->getAttribute($modulo.'_nowcontenido');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowdesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowhasta');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowambito');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			$parcial="";
			$this->cajaBsq = "";
			$this->desdeBsq = '';
			$this->hastaBsq = '';
			$this->ambitoBQ = '';
			$this->estadoBq = '';
			$this->contenidoBsq = '';
		}
		$this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
		
		if(Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles)) {
			return "e.deleted=0".$parcial;
		} else {
			return "e.deleted=0 AND (e.fecha_caducidad >= NOW() OR e.fecha_caducidad IS NULL ) AND ( ue.usuario_id = ".$this->getUser()->getAttribute('userId')." OR e.ambito = 'ambos' OR e.estado = 'guardado')".$parcial;
		}	
  }

  protected function setOrdenamiento()
  {
		$this->orderBy = 'fecha';
		$this->sortType = 'desc';

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
		
  }
  
 /* public function executeLimpiar(sfWebRequest $request)
	{
	   $evento =  Doctrine::getTable('Evento')->findAll();
	   
	   foreach ($evento as $e)
	   {
	   	  $entardilla = $e->getDescripcion(); 
                  $entradillaLimpia = strip_tags($entardilla);
                  $e->setDescripcion($entradillaLimpia);
                  $e->save();

	   }
		
	  echo 'listo';
          exit();
		
	}*/
}
