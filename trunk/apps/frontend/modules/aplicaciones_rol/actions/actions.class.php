<?php
/**
 * aplicaciones_rol actions.
 *
 * @package    extranet
 * @subpackage aplicaciones_rol
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */

class aplicaciones_rolActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		$this->pager = new sfDoctrinePager('AplicacionRol', 20);
		$this->pager->getQuery()
                          ->from('AplicacionRol ar')
                          ->leftJoin('ar.Rol r')
                          ->leftJoin('ar.Aplicacion a')
                          ->where($this->setFiltroBusqueda())
                          ->addWhere('r.excepcion = 0')
                          ->andWhere('a.id != 46 AND a.id != 44')
                          ->orderBy($this->setOrdenamiento());

		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->aplicacion_rol_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
	}

	public function executeNuevo(sfWebRequest $request)
	{
		$this->form = new AplicacionRolForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new AplicacionRolForm();
		
		$this->processForm($request, $this->form, 'creado');

		$this->setTemplate('nuevo');
	}

	public function executeEditar(sfWebRequest $request)
	{
		$this->forward404Unless($aplicacion_rol = Doctrine::getTable('AplicacionRol')->find($request->getParameter('id')), sprintf('Object aplicacion_rol does not exist (%s).', $request->getParameter('id')));
		$this->form = new AplicacionRolForm($aplicacion_rol);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		
		
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($aplicacion_rol = Doctrine::getTable('AplicacionRol')->find($request->getParameter('id')), sprintf('Object aplicacion_rol does not exist (%s).', $request->getParameter('id')));
		$this->form = new AplicacionRolForm($aplicacion_rol);
		
		$this->processForm($request, $this->form, 'actualizado');
		
		$this->setTemplate('editar');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		
		$this->forward404Unless($aplicacion_rol = Doctrine::getTable('AplicacionRol')->find($request->getParameter('id')), sprintf('Object aplicacion_rol does not exist (%s).', $request->getParameter('id')));
		
		
		sfLoader::loadHelpers('Security'); // para usar el helper
		if (!validate_action('baja')) $this->redirect('seguridad/restringuido');
		
		if($aplicacion_rol->getAplicacionId() == 4 || $aplicacion_rol->getAplicacionId() == 42 || $aplicacion_rol->getAplicacionId()==43 || $aplicacion_rol->getAplicacionId() == 48 || $aplicacion_rol->getAplicacionId() == 55 || $aplicacion_rol->getAplicacionId() == 56)
					{
						$id = $aplicacion_rol->getId();
						$idA = $id+1;
						$aplicacion_ASm = Doctrine::getTable('AplicacionRol')->find($idA);
						$aplicacion_ASm->delete();
						//accion_alta 	accion_baja 	accion_modificar 	accion_listar 	accion_publicar 	aplicacion_id 	rol_id
					}
	  if($aplicacion_rol->getAplicacionId() == 16 || $aplicacion_rol->getAplicacionId() == 45 || $aplicacion_rol->getAplicacionId() == 49)
					{
						$id = $aplicacion_rol->getId();
						$idA = $id+1;
						$aplicacion_ASm = Doctrine::getTable('AplicacionRol')->find($idA);
						$aplicacion_ASm->delete();
						//accion_alta 	accion_baja 	accion_modificar 	accion_listar 	accion_publicar 	aplicacion_id 	rol_id
					}
		
	
		$aplicacion_rol->delete();

		$this->getUser()->setFlash('notice', "El registro ha sido eliminado del sistema");
		$this->redirect('aplicaciones_rol/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
	{
		$form->bind($request->getParameter($form->getName()));
		
		if ($form->isValid())
		{
			$aplicacion_rol = $form->save();
			if( $this->getActionName() == 'update')
			{
					if($aplicacion_rol->getAplicacionId() == 4 || $aplicacion_rol->getAplicacionId() == 42 || $aplicacion_rol->getAplicacionId()==43 || $aplicacion_rol->getAplicacionId() == 48 || $aplicacion_rol->getAplicacionId() == 55 || $aplicacion_rol->getAplicacionId() == 56)
					{
						$id = $aplicacion_rol->getId();
						$idA = $id+1;
						$aplicacion_ASm = Doctrine::getTable('AplicacionRol')->find($idA);
						$aplicacion_ASm->setAccionAlta($aplicacion_rol->getAccionAlta());
						$aplicacion_ASm->setAccionBaja($aplicacion_rol->getAccionBaja());
						$aplicacion_ASm->setAccionModificar($aplicacion_rol->getAccionModificar());
						$aplicacion_ASm->setAccionListar($aplicacion_rol->getAccionListar());
						$aplicacion_ASm->setAccionPublicar($aplicacion_rol->getAccionPublicar());
						$aplicacion_ASm->setAplicacionId(44);
						$aplicacion_ASm->setRolId($aplicacion_rol->getRolId());
						$aplicacion_ASm->save();
						//accion_alta 	accion_baja 	accion_modificar 	accion_listar 	accion_publicar 	aplicacion_id 	rol_id
					}
					if($aplicacion_rol->getAplicacionId() == 16 || $aplicacion_rol->getAplicacionId() == 45 || $aplicacion_rol->getAplicacionId() == 49)
					{
						$id = $aplicacion_rol->getId();
						$idA = $id+1;
						$aplicacion_ASm = Doctrine::getTable('AplicacionRol')->find($idA);
						$aplicacion_ASm->setAccionAlta($aplicacion_rol->getAccionAlta());
						$aplicacion_ASm->setAccionBaja($aplicacion_rol->getAccionBaja());
						$aplicacion_ASm->setAccionModificar($aplicacion_rol->getAccionModificar());
						$aplicacion_ASm->setAccionListar($aplicacion_rol->getAccionListar());
						$aplicacion_ASm->setAccionPublicar($aplicacion_rol->getAccionPublicar());
						$aplicacion_ASm->setAplicacionId(46);
						$aplicacion_ASm->setRolId($aplicacion_rol->getRolId());
						$aplicacion_ASm->save();
						//accion_alta 	accion_baja 	accion_modificar 	accion_listar 	accion_publicar 	aplicacion_id 	rol_id
					}
			}
			if($this->getActionName() == 'create')
			{
				if($aplicacion_rol->getAplicacionId() == 4 || $aplicacion_rol->getAplicacionId() == 42 || $aplicacion_rol->getAplicacionId()==43 || $aplicacion_rol->getAplicacionId() == 48 || $aplicacion_rol->getAplicacionId() == 55 || $aplicacion_rol->getAplicacionId() == 56)
				{
					$aplicacion_ASm = new AplicacionRol();
					$aplicacion_ASm->setAccionAlta($aplicacion_rol->getAccionAlta());
					$aplicacion_ASm->setAccionBaja($aplicacion_rol->getAccionBaja());
					$aplicacion_ASm->setAccionModificar($aplicacion_rol->getAccionModificar());
					$aplicacion_ASm->setAccionListar($aplicacion_rol->getAccionListar());
					$aplicacion_ASm->setAccionPublicar($aplicacion_rol->getAccionPublicar());
					$aplicacion_ASm->setAplicacionId(44);
					$aplicacion_ASm->setRolId($aplicacion_rol->getRolId());
					$aplicacion_ASm->save();
					//accion_alta 	accion_baja 	accion_modificar 	accion_listar 	accion_publicar 	aplicacion_id 	rol_id
				}
				if($aplicacion_rol->getAplicacionId() == 16 || $aplicacion_rol->getAplicacionId() == 45 || $aplicacion_rol->getAplicacionId() == 49 )
				{
					$aplicacion_ASm = new AplicacionRol();
					$aplicacion_ASm->setAccionAlta($aplicacion_rol->getAccionAlta());
					$aplicacion_ASm->setAccionBaja($aplicacion_rol->getAccionBaja());
					$aplicacion_ASm->setAccionModificar($aplicacion_rol->getAccionModificar());
					$aplicacion_ASm->setAccionListar($aplicacion_rol->getAccionListar());
					$aplicacion_ASm->setAccionPublicar($aplicacion_rol->getAccionPublicar());
					$aplicacion_ASm->setAplicacionId(46);
					$aplicacion_ASm->setRolId($aplicacion_rol->getRolId());
					$aplicacion_ASm->save();
					//accion_alta 	accion_baja 	accion_modificar 	accion_listar 	accion_publicar 	aplicacion_id 	rol_id
				}
			}
			
			$strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';
			
			$this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");
			
			$this->redirect('aplicaciones_rol/index'.$strPaginaVolver);
		}
	}
	
	public function executeListausuario(sfWebRequest $request)
  {
  	$this->usuario = Usuario::getRepository()->findOneById($request->getParameter('id'));
		$this->arrayPeApliAcci = AplicacionRol::getArraPerfilAplicacionAccionBYusuario($request->getParameter('id')); 
  }

	protected function setFiltroBusqueda()
    {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->cajaRolBsq = $this->getRequestParameter('rol');

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND a.nombre LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->cajaRolBsq)) {
			$parcial .= " AND r.id = $this->cajaRolBsq";
			$this->getUser()->setAttribute($modulo.'_nowcajarol', $this->cajaRolBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajarol');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->cajaRolBsq = $this->getUser()->getAttribute($modulo.'_nowcajarol');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajarol');
			$parcial="";
			$this->cajaBsq = "";
			$this->cajaRolBsq = "";
		}
		return 'ar.deleted=0'.$parcial;
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
                        $this->orderBy = 'r.nombre';
                        $this->sortType = 'asc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }
}