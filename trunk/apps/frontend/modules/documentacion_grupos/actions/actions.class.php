<?php

/**
 * documentacion_grupos actions.
 *
 * @package    extranet
 * @subpackage documentacion_grupos
 * @author     Pablo Peralta
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class documentacion_gruposActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$modulo  = $this->getModuleName();
  	//$guardados = Common::getCantidaDEguardados('DocumentacionGrupo',$this->getUser()->getAttribute('userId'),$this->setFiltroBusqueda(),$modulo);

  	  	$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
	        $this->pager = new sfDoctrinePager('DocumentacionGrupo', 10);

		$this->pager->getQuery()
		->from('DocumentacionGrupo')
		->where($this->setFiltroBusqueda())
		->orderBy($this->setOrdenamiento());

         //       echo $this->pager->getQuery()->getSql();
         //       exit();

		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->documentacion_grupo_list = $this->pager->getResults();
	//	$this->cantidadRegistros = $this->pager->getNbResults() - $guardados->count();
                $this->cantidadRegistros = $this->pager->getNbResults();


		if ($this->grupoBsq) {
		  $this->Grupo = GrupoTrabajoTable::getGrupoTrabajo($this->grupoBsq);
		} else {
			$this->Grupo = '';
		}
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->documentacion_grupo = Doctrine::getTable('DocumentacionGrupo')->find($request->getParameter('id'));
    $this->forward404Unless($this->documentacion_grupo);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new DocumentacionGrupoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new DocumentacionGrupoForm();
    $this->processForm($request, $this->form);

    $this->setTemplate('nueva');
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
  		$request->checkCSRFProtection();
  		
  		$IDs = is_array($toProcess) ? $toProcess : array($toProcess);
  		
  		foreach ($IDs as $id) {
  			$this->forward404Unless($documentacion_grupo = Doctrine::getTable('DocumentacionGrupo')->find($id), sprintf('Object documentacion_grupo does not exist (%s).', $id));
  			
  			sfLoader::loadHelpers('Security');
				if (!validate_action($accion)) $this->redirect('seguridad/restringuido');

				if ($accion == 'publicar') {
					$documentacion_grupo->setEstado('publicado');
					$documentacion_grupo->save();
                                        if ($documentacion_grupo->getEstado()=='publicado') {
                                                if ($documentacion_grupo->getGrupoTrabajoId()) {
                                                        $enviar= true;
                                                        $grupo = Doctrine::getTable('GrupoTrbajo')->findOneById($documentacion_grupo->getGrupoTrabajoId());
                                                        $email = UsuarioTable::getUsuariosByGrupoTrabajoArray($documentacion_grupo->getGrupoTrabajoId());
                                                        $tema  = 'Documentacón publicada para el Grupo de Trabajo: '.$grupo->getNombre();
                                                }
                                                if($documentacion_grupo->getEstado()=='publicado') {
                                                        ServiceNotificacion::send('creacion', 'Grupo', $documentacion_grupo->getId(), $documentacion_grupo->getNombre(),'',$documentacion_grupo->getGrupoTrabajoId());
                                                }
                                        }
                                        if (!empty($enviar)) {
                                                sfLoader::loadHelpers(array('Url', 'Tag', 'Asset', 'Partial'));

                                                $iPh = image_path('/images/logo_email.jpg', true);

                                                $url = url_for('documentacion_grupos/show?id='.$documentacion_grupo->getId(), true);

                                                $organizador = $this->getUser()->getAttribute('apellido').', '.$this->getUser()->getAttribute('nombre');

                                                $mailer = new Swift(new Swift_Connection_NativeMail());

                                                $message = new Swift_Message('Contacto desde Extranet de Asociados AMAT');

                                                $mailContext = array('tema'   => $tema,
                                                                     'evento' => $documentacion_grupo->getNombre(),
                                                                     'url'    => $url,
                                                                     'head_image'  => $iPh,
                                                                     'organizador' => $organizador,
                                                                     'descripcio'  => $documentacion_grupo->getContenido()?$documentacion_grupo->getContenido():'',
                                                );
                                                $message->attach(new Swift_Message_Part(get_partial('eventos/mailHtmlBody', $mailContext), 'text/html'));
                                                $message->attach(new Swift_Message_Part(get_partial('eventos/mailTextBody', $mailContext), 'text/plain'));

                                                foreach ($email AS $emailPublic) {
                                                        if ($emailPublic['email']) {
                                                                $mailer->send($message, $emailPublic['email'], sfConfig::get('app_default_from_email'));

                                                        }
                                                }
                                                $mailer->disconnect();
                                        }
		
					ServiceNotificacion::send('creacion', 'Grupo', $documentacion_grupo->getId(), $documentacion_grupo->getNombre(),'',$documentacion_grupo->getGrupoTrabajoId());	
				} else {
					$documentacion_grupo->delete();
				}		
  		}
  	}
  	$this->redirect('documentacion_grupos/index');
  }
	
  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($documentacion_grupo = Doctrine::getTable('DocumentacionGrupo')->find($request->getParameter('id')), sprintf('Object documentacion_grupo does not exist (%s).', $request->getParameter('id')));
    $this->form = new DocumentacionGrupoForm($documentacion_grupo);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($documentacion_grupo = Doctrine::getTable('DocumentacionGrupo')->find($request->getParameter('id')), sprintf('Object documentacion_grupo does not exist (%s).', $request->getParameter('id')));
    $this->form = new DocumentacionGrupoForm($documentacion_grupo);
   
    $this->processForm($request, $this->form);

    $this->setTemplate('editar');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
		$form->bind($request->getParameter($form->getName()));
		if ($form->isValid()) {
			$documentacion_grupo = $form->save();

			## Notificar y enviar email a los destinatarios 
			if ($documentacion_grupo->getEstado()=='publicado') {
				if ($documentacion_grupo->getGrupoTrabajoId()) {
					$enviar= true;
                                        $grupo = Doctrine::getTable('GrupoTrbajo')->findOneById($documentacion_grupo->getGrupoTrabajoId());
					$email = UsuarioTable::getUsuariosByGrupoTrabajoArray($documentacion_grupo->getGrupoTrabajoId());
					$tema  = 'Documento registrado para Grupo de Trabajo: '.$grupo->getNombre();
				}
				if($documentacion_grupo->getEstado()=='publicado') {
					ServiceNotificacion::send('creacion', 'Grupo', $documentacion_grupo->getId(), $documentacion_grupo->getNombre(),'',$documentacion_grupo->getGrupoTrabajoId());
				}
			}
			if ($documentacion_grupo->getEstado() == 'pendiente') {
				$enviar= true;
                                $grupo = Doctrine::getTable('GrupoTrbajo')->findOneById($documentacion_grupo->getGrupoTrabajoId());
				$email = AplicacionRolTable::getEmailPublicarArray('24',$documentacion_grupo->getGrupoTrabajoId());
				$tema  = 'Documentacón pendiente de publicar para Grupo de Trabajo: '.$grupo->getNombre();
			}				
			## envia el email  	
			if (!empty($enviar)) {
				sfLoader::loadHelpers(array('Url', 'Tag', 'Asset', 'Partial'));
                                
				$iPh = image_path('/images/logo_email.jpg', true);
                             
				$url = url_for('documentacion_grupos/show?id='.$documentacion_grupo->getId(), true);
                             
				$organizador = $this->getUser()->getAttribute('apellido').', '.$this->getUser()->getAttribute('nombre');
                              
                                $mailer = new Swift(new Swift_Connection_NativeMail());
                              
                                $message = new Swift_Message('Contacto desde Extranet de Asociados AMAT');
                           
                                $mailContext = array('tema'   => $tema,
                                                     'evento' => $documentacion_grupo->getNombre(),
                                                     'url'    => $url,
                                                     'head_image'  => $iPh,
                                                     'organizador' => $organizador,
                                                     'descripcio'  => $documentacion_grupo->getContenido()?$documentacion_grupo->getContenido():'',
                                );
                                $message->attach(new Swift_Message_Part(get_partial('eventos/mailHtmlBody', $mailContext), 'text/html'));
                                $message->attach(new Swift_Message_Part(get_partial('eventos/mailTextBody', $mailContext), 'text/plain'));
                                
				foreach ($email AS $emailPublic) {
					if ($emailPublic['email']) {
						$mailer->send($message, $emailPublic['email'], sfConfig::get('app_default_from_email'));
						
					}
				}
                                $mailer->disconnect();
			}
			$this->redirect('documentacion_grupos/show?id='.$documentacion_grupo->getId());
		}
  }
  
	/* Metodos para busqueda y ordenamiento */
  
  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();
  	$this->modulo = $modulo;

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->grupoBsq = $this->getRequestParameter('grupo');
		$this->categoriaBsq = $this->getRequestParameter('categoria_busqueda');
		$this->estadoBsq = $this->getRequestParameter('estado_busqueda');
		$this->contenidoBsq = $this->getRequestParameter('contenido_busqueda')?$this->getRequestParameter('contenido_busqueda'):$this->getUser()->getAttribute($modulo.'_nowcontenido');;
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
    if (!empty($this->grupoBsq)) {
			$parcial .= " AND grupo_trabajo_id = $this->grupoBsq ";
			$this->getUser()->setAttribute($modulo.'_nowgrupo', $this->grupoBsq);
		}
		if (!empty($this->categoriaBsq)) {
			$parcial .= " AND categoria_d_g_id = '$this->categoriaBsq' ";
			$this->getUser()->setAttribute($modulo.'_nowcategoria', $this->categoriaBsq);
		}
		if (!empty($this->estadoBsq)) {
			$parcial .= " AND estado = '$this->estadoBsq' ";
			$this->getUser()->setAttribute($modulo.'_nowestado', $this->estadoBsq);
		}
		if (!empty($this->contenidoBsq)) {
			$parcial .= " AND contenido LIKE '%$this->contenidoBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcontenido', $this->contenidoBsq);
		}
		
    if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowgrupo');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->grupoBsq = $this->getUser()->getAttribute($modulo.'_nowgrupo');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowcategoria');
				$this->estadoBsq = $this->getUser()->getAttribute($modulo.'_nowestado');
				$this->contenidoBsq = $this->getUser()->getAttribute($modulo.'_nowcontenido');
			}
		} 
		
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowgrupo');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowestado');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			$parcial="";
			$this->cajaBsq = "";
			$this->grupoBsq = '';
			$this->categoriaBsq = '';
			$this->estadoBsq = '';
			$this->contenidoBsq = '';
		}
		$gruposdetrabajo = GrupoTrabajo::iddegrupos($this->getUser()->getAttribute('userId'),1); 
		$this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);

		if (Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles)) {
			return "deleted=0 ".$parcial." AND (owner_id = ".$this->getUser()->getAttribute('userId')." OR estado != 'guardado')";
		} else {
			return "deleted=0".$parcial." AND grupo_trabajo_id IN ".$gruposdetrabajo." AND (owner_id = ".$this->getUser()->getAttribute('userId')." OR estado != 'guardado')";
		}
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
                        $this->orderBy = 'nombre';
                        $this->sortType = 'asc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }
  
  ## ajax listar por categoria
  public function executeListByGrupoTrabajo()
	{
		$this->documentacion_selected = 0;
		$this->arrayDocumentacion = DocumentacionGrupoTable::doSelectByGrupoTrabajo($this->getRequestParameter('id_grupo_trabajo'),1);

		return $this->renderPartial('documentacion_grupos/selectByGrupoTrabajo');
	}
}