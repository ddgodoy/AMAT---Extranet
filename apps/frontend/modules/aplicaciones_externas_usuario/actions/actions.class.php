<?php
/**
 * aplicaciones_rol actions.
 *
 * @package    extranet
 * @subpackage aplicaciones_rol
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */

class aplicaciones_externas_usuarioActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{		
		$this->forward404Unless($usuario = Doctrine::getTable('Usuario')->find(sfContext::getInstance()->getUser()->getAttribute('userId')), sprintf('Object usuario does not exist (%s).', sfContext::getInstance()->getUser()->getAttribute('userId')));		
		
		$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual); // recordar pagina actual
		}
		$this->pager = new sfDoctrinePager('UsuarioAplicacionExterna', 20);
		$this->pager->getQuery()
							  ->from('UsuarioAplicacionExterna aeu')
							  ->leftJoin('aeu.AplicacionExterna ae')
							  ->where($this->setFiltroBusqueda())
							  ->andWhere('aeu.usuario_id = '.$usuario->getId())
							  ->orderBy($this->setOrdenamiento());

		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->aplicacion_externa_usuario_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
	}


	public function executeEditar(sfWebRequest $request)
	{
		$userId = $request->getParameter('uid');
		$aplicacionExternaId = $request->getParameter('aeid');
		
		
		$q = Doctrine_Query::create();
		$q->from('UsuarioAplicacionExterna uae');
		$q->where('uae.usuario_id = ' . $userId);
		$q->andWhere('uae.aplicacion_externa_id = ' . $aplicacionExternaId);
		$q->addWhere('uae.deleted = 0');
		
		$this->forward404Unless($usuario_aplicacion_externa = $q->fetchOne(), sprintf('Object usuario_aplicacion_externa does not exist (%s).', $request->getParameter('id')));
		
		$this->form = new UsuarioAplicacionExternaForm($usuario_aplicacion_externa);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$userId = $request->getParameter('uid');
		$aplicacionExternaId = $request->getParameter('aeid');
		
		
		$q = Doctrine_Query::create();
		$q->from('UsuarioAplicacionExterna uae');
		$q->where('uae.usuario_id = ' . $userId);
		$q->andWhere('uae.aplicacion_externa_id = ' . $aplicacionExternaId);
		$q->addWhere('uae.deleted = 0');
		
		$this->forward404Unless($usuario_aplicacion_externa = $q->fetchOne(), sprintf('Object usuario_aplicacion_externa does not exist (%s).', $request->getParameter('id')));
		
		$this->form = new UsuarioAplicacionExternaForm($usuario_aplicacion_externa);
		
		$this->processForm($request, $this->form, 'actualizado');
		
		$this->setTemplate('editar');
	}


	protected function processForm(sfWebRequest $request, sfForm $form, $accion='')
	{
		$form->bind($request->getParameter($form->getName()));
		if ($form->isValid())
		{
			$usuario_aplicacion_externa = $form->save();
			$strPaginaVolver = $accion=='actualizado' ? '?page='.$this->getUser()->getAttribute($this->getModuleName().'_nowpage') : '';
			
			if ($accion=='actualizado') 
			{
				$usuario_aplicacion_externa->generarSalt();
				$usuario_aplicacion_externa->save();
			}
			
			$this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");
			
			$this->redirect('aplicaciones_externas_usuario/index'.$strPaginaVolver);
		}
	}

	protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND ae.nombre LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$parcial="";
			$this->cajaBsq = "";
		}
		return 'aeu.deleted=0'.$parcial;
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
}