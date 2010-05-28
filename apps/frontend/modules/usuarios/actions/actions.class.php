<?php
/**
 * usuarios actions.
 *
 * @package    extranet
 * @subpackage usuarios
 * @author     Matias Gentiletti
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class usuariosActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		## Nota: el filtro id>1 es para que no se muestre el super admin
		$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		
		$this->pager = new sfDoctrinePager('Usuario', 10);
		$this->pager->getQuery()
	    ->from('Usuario u')
	    ->leftJoin('u.UsuarioGrupoTrabajo ug') 
	    ->leftJoin('u.UsuarioConsejoTerritorial uc') 
	    ->leftJoin('u.UsuarioRol ur') 
		->Where($this->setFiltroBusqueda())
		->orderBy($this->setOrdenamiento());
		
		
		$this->pager->setPage($this->getRequestParameter('page', 1));
		$this->pager->init();

		$this->usuario_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
	}

	public function executeNuevo(sfWebRequest $request)
	{
		$this->form = new UsuarioForm();
	}

	public function executeCreate(sfWebRequest $request)
	{		
		$this->forward404Unless($request->isMethod('post'));

		$this->form = new UsuarioForm();
		$this->processForm($request, $this->form, 'creado');

		$this->setTemplate('nuevo');
	}
	
	public function executeEditar(sfWebRequest $request)
	{
		$this->forward404Unless($usuario = Doctrine::getTable('Usuario')->find(array($request->getParameter('id'))), sprintf('Object usuario does not exist (%s).', array($request->getParameter('id'))));
		$this->form = new UsuarioForm($usuario);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($usuario = Doctrine::getTable('Usuario')->find(array($request->getParameter('id'))), sprintf('Object usuario does not exist (%s).', array($request->getParameter('id'))));

		$this->form = new UsuarioForm($usuario);
		$this->processForm($request, $this->form, 'actualizado');
		$this->setTemplate('editar');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$toDelete = $request->getParameter('id');
		
		if (!empty($toDelete)) {
			$request->checkCSRFProtection();
			
			$IDs = is_array($toDelete) ? $toDelete : array($toDelete);
			
			foreach ($IDs as $id) {
				$this->forward404Unless($usuario = Doctrine::getTable('Usuario')->find($id), sprintf('Object usuario does not exist (%s).', $id));
				
				sfLoader::loadHelpers('Security');
				if (!validate_action('baja')) $this->redirect('seguridad/restringuido');

				$usuario->delete();
			}
			$fixMsg = count($toDelete) > 1 ? 'Los usuarios han sido eliminados' : 'El usuario ha sido eliminado';

			$this->getUser()->setFlash('notice', "$fixMsg del sistema");
		}
		$this->redirect('usuarios/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
	{
		$form->bind($request->getParameter($form->getName()));
		
		if ($form->isValid()) {
			## Verificar que el login del usuario no se repita
			$postValues = $request->getPostParameters();
			$exceptUser = $accion=='creado' ? '' : 'AND u.id != '.$request->getParameter('id');
			$rVerificar = Doctrine_Query::create()->select('u.id AS u_id')->from('usuario u')->where("u.deleted = 0 AND u.login = '".$postValues['usuario']['login']."' $exceptUser");
			$aVerificar = $rVerificar->fetchArray();

			if (empty($aVerificar)) {
				## Si existe el usuario... Obtengo el usuario actual
				if ($form->getValue('id')) {
					$usuario = Doctrine::getTable('Usuario')->find($form->getValue('id'));
					$password = $usuario->getCryptedPassword();
				}
				## Sobreescribo el usuario actual en la db
				$usuarioForm = $form->save();

				## Si insertó un password...
				if ($form['password']->getValue()) {
					$usuario = ServiceSecurity::modifyCredentials($usuarioForm->getLogin(), $form['password']->getValue(),$usuarioForm->getId());
				} else {
					$usuario->save();
				}
				if ($usuarioForm->getEmail() && $this->hasRequestParameter('btn_enviar_email')) {
					sfLoader::loadHelpers(array('Tag', 'Asset'));
					$iPh = image_path('/images/logo_email.jpg', true);

					$mailer = new Swift(new Swift_Connection_NativeMail());
					$message = new Swift_Message('Datos de accesos a Extranet de Asociados AMAT');

					$mailContext = array('nombre'    => $usuarioForm->getNombre(),
															 'apellido'  => $usuarioForm->getApellido(),
															 'login'     => $usuarioForm->getLogin(),
															 'password'  => $form['password']->getValue(),
															 'host'      => $_SERVER["SERVER_NAME"],
															 'head_image'=> $iPh
					);
					$message->attach(new Swift_Message_Part($this->getPartial('usuarios/mailHtmlBody', $mailContext), 'text/html'));
					$message->attach(new Swift_Message_Part($this->getPartial('usuarios/mailTextBody', $mailContext), 'text/plain'));

					$mailer->send($message, $usuarioForm->getEmail(), sfConfig::get('app_default_from_email'));
					$mailer->disconnect();
				}
				$strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';

				$this->getUser()->setFlash('notice', "El usuario ha sido $accion correctamente");
				$this->redirect('usuarios/index'.$strPaginaVolver);
			} else {
				$this->getUser()->setFlash('login_repetido', "El Login de Usuario ya se encuentra registrado");
			}
		}
	}

	## perfil de usuario
	public function executePerfil(sfWebRequest $request)
	{
	$oUsuario = Doctrine::getTable('Usuario')->find($this->getUser()->getAttribute('userId'));
    $this->grupos = GrupoTrabajo::ArrayDeMigrupo($this->getUser()->getAttribute('userId')); 
    $this->consejo = ConsejoTerritorial::ArrayDeMiconsejo($this->getUser()->getAttribute('userId')); 
		if ($this->getRequestParameter('btn_action')) {
			$this->usuNombre  = $this->getRequestParameter('usu_nombre');
			$this->usuApellido= $this->getRequestParameter('usu_apellido');
			$this->usuEmail   = $this->getRequestParameter('usu_email');
			$this->usuTelefono= $this->getRequestParameter('usu_telefono');
			$auxiClave = $this->getRequestParameter('usu_clave');

			$oUsuario->setNombre  ($this->usuNombre);
			$oUsuario->setApellido($this->usuApellido);
			$oUsuario->setEmail   ($this->usuEmail);
			$oUsuario->setTelefono($this->usuTelefono);

			$oUsuario->save();

			if (!empty($auxiClave)) {
				ServiceSecurity::modifyCredentials($oUsuario->getLogin(), $auxiClave);
			}
			$this->getUser()->setFlash('updatePerfil', "Sus datos fueron actualizados correctamente");
		}
		$this->usuNombre  = $oUsuario->getNombre();
		$this->usuApellido= $oUsuario->getApellido();
		$this->usuEmail   = $oUsuario->getEmail();
		$this->usuTelefono= $oUsuario->getTelefono();
		$this->mutuas = $this->getUser()->getAttribute('mutua');
	}

	protected function setFiltroBusqueda()
	{
		$parcial = '';
		$modulo  = $this->getModuleName();
	
		$this->cajaNomBsq = $this->getRequestParameter('caja_busqueda_nombre');
		$this->cajaApeBsq = $this->getRequestParameter('caja_busqueda_apellido');
                $this->cajaUsuBsq = $this->getRequestParameter('caja_busqueda_usuario');
		$this->cajaMuBsq  = $this->getRequestParameter('mutuas');
		$this->cajaRolBsq = $this->getRequestParameter('cajaRolBsq');
		$this->cajaGruBsq = $this->getRequestParameter('grupo');
		$this->cajaConBsq = $this->getRequestParameter('consejo');
	
	
		if (!empty($this->cajaNomBsq)) {
			$parcial .= " AND u.nombre LIKE '%$this->cajaNomBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja_nom', $this->cajaNomBsq);
		}
		if (!empty($this->cajaApeBsq)) {
			$parcial .= " AND u.apellido LIKE '%$this->cajaApeBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja_ape', $this->cajaApeBsq);
		}
                if(!empty ($this->cajaUsuBsq)){
                    $parcial .= " AND u.login LIKE '%$this->cajaUsuBsq%'";
		    $this->getUser()->setAttribute($modulo.'_nowcaja_login', $this->cajaUsuBsq);
                }
		if (!empty($this->cajaMuBsq)) {
			$parcial .= " AND u.mutua_id = $this->cajaMuBsq";
			$this->getUser()->setAttribute($modulo.'_nowcaja_mu', $this->cajaMuBsq);
		}
		if (!empty($this->cajaRolBsq)) {
			$parcial .= " AND ur.rol_id = $this->cajaRolBsq";
			$this->getUser()->setAttribute($modulo.'_nowcajaRolBsq', $this->cajaRolBsq);
		}
		if (!empty($this->cajaGruBsq)) {
			$parcial .= " AND ug.grupo_trabajo_id = $this->cajaGruBsq";
			$this->getUser()->setAttribute($modulo.'_nowcaja_gru', $this->cajaGruBsq);
		}
		if (!empty($this->cajaConBsq)) {
			$parcial .= " AND uc.consejo_territorial_id = $this->cajaConBsq";
			$this->getUser()->setAttribute($modulo.'_nowcaja_con', $this->cajaConBsq);
		}
		if ($this->hasRequestParameter('btn_buscar'))
		{
			$this->activoBsq = $this->getRequestParameter('activoBsq');

			if (!empty($this->activoBsq)) 
			{
				$parcial .= " AND u.activo = $this->activoBsq ";
				$this->getUser()->setAttribute($modulo.'_nowactivoBsq', $this->activoBsq);
			}
			else 
			{
				$parcial .= " AND u.activo = 0 ";
				$this->getUser()->setAttribute($modulo.'_nowactivoBsq', $this->activoBsq);
			}
		} 
		
		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_nom');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_ape');
                                $this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_login');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowactivoBsq');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_mu');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajaRolBsq');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_gru');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_con');
			} else {
				
				if(strpos($this->getUser()->getAttribute($modulo.'_nowfilter'),'u.activo')!== false)
				{
					$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
					$this->cajaNomBsq = $this->getUser()->getAttribute($modulo.'_nowcaja_nom');
					$this->cajaApeBsq = $this->getUser()->getAttribute($modulo.'_nowcaja_ape');
                                        $this->cajaUsuBsq = $this->getUser()->getAttribute($modulo.'_nowcaja_login');
					$this->activoBsq = $this->getUser()->getAttribute($modulo.'_nowactivoBsq');
					$this->cajaMuBsq = $this->getUser()->getAttribute($modulo.'_nowcaja_mu');
					$this->cajaRolBsq = $this->getUser()->getAttribute($modulo.'_nowcajaRolBsq');
					$this->cajaGruBsq = $this->getUser()->getAttribute($modulo.'_nowcaja_gru');
					$this->cajaConBsq = $this->getUser()->getAttribute($modulo.'_nowcaja_con');
				}
				else 
				{
					$parcial .= " AND u.activo = 1 ";
					$this->activoBsq = 1;
				}
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_nom');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_ape');
                        $this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_login');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowactivoBsq');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_mu');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajaRolBsq');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_gru');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_con');
			$parcial="";
			$this->cajaNomBsq = "";
			$this->cajaApeBsq = "";
                        $this->cajaUsuBsq = "";
			$this->activoBsq = "";
			$this->cajaMuBsq = "";
			$this->cajaRolBsq = "";
			$this->cajaGruBsq = "";
			$this->cajaConBsq = "";
		}
			
		return 'deleted=0'.$parcial;
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
                        $this->orderBy = 'u.nombre';
                        $this->sortType = 'asc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
	}
}