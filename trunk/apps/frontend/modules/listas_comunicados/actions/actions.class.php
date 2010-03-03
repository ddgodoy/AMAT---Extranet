<?php

/**
 * listas_comunicados actions.
 *
 * @package    extranet
 * @subpackage listas_comunicados
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class listas_comunicadosActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->paginaActual = $this->getRequestParameter('page', 1);

	if (is_numeric($this->paginaActual)) {
		$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
	}
	    $this->pager = new sfDoctrinePager('ListaComunicado', 20);
	$this->pager->getQuery()->from('ListaComunicado')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->lista_comunicado_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->lista_comunicado = Doctrine::getTable('ListaComunicado')->find($request->getParameter('id'));
    $this->forward404Unless($this->lista_comunicado);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new ListaComunicadoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new ListaComunicadoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($lista_comunicado = Doctrine::getTable('ListaComunicado')->find($request->getParameter('id')), sprintf('Object lista_comunicado does not exist (%s).', $request->getParameter('id')));
    $this->form = new ListaComunicadoForm($lista_comunicado);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($lista_comunicado = Doctrine::getTable('ListaComunicado')->find($request->getParameter('id')), sprintf('Object lista_comunicado does not exist (%s).', $request->getParameter('id')));
    $this->form = new ListaComunicadoForm($lista_comunicado);

    $this->processForm($request, $this->form);

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');

    $this->forward404Unless($lista_comunicado = Doctrine::getTable('ListaComunicado')->find($request->getParameter('id')), sprintf('Object lista_comunicado does not exist (%s).', $request->getParameter('id')));
    $lista_comunicado->delete();

    $this->redirect('listas_comunicados/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $lista_comunicado = $form->save();

      $this->redirect('listas_comunicados/index');
    }
  }
  
  
  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%')";
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
		
		return 'deleted=0'.$parcial;
  }
  
  protected function setOrdenamiento()
  {
		$this->orderBy = 'nombre';
		$this->sortType = 'asc';

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }
  
  public function executeLista(sfWebRequest $request)
  {
  	
  	$filtro = '';
  	
  	if($request->getParameter('excluir')!='')
  	{
  	 	$filtro .=' AND id NOT IN ('.$request->getParameter('excluir').')';
	}

  	if($request->getParameter('id_perfil')!='')
  	{
  		$filtro .=' AND ur.rol_id ='.$request->getParameter('id_perfil');	
	}
  		
  	if($request->getParameter('id_mutuas')!='')
  	{
  		$filtro .=' AND u.mutua_id ='.$request->getParameter('id_mutuas');	
  	}	
  		  			
  	if($request->getParameter('id_grupos')!='')
  	{
  		$filtro .=' AND ug.grupo_trabajo_id ='.$request->getParameter('id_grupos');	
	}
	if($request->getParameter('id_consejos')!='')
  	{
  		$filtro .=' AND uc.consejo_territorial_id ='.$request->getParameter('id_consejos');	
	}
	
	    $arrayUSer = Doctrine_Query::create()
  		->from('Usuario u')
	    ->leftJoin('u.UsuarioGrupoTrabajo ug') 
	    ->leftJoin('u.UsuarioConsejoTerritorial uc') 
	    ->leftJoin('u.UsuarioRol ur') 
		->where('u.id>1'.$filtro)
		->groupBy('u.id')
		->execute();
		
		
	
	    $arrUsuarios = array();
	    foreach ($arrayUSer as $r) {
		$arrUsuarios[$r->getId()] = $r->getApellido().", ".$r->getNombre();
	
	    }
	
  	return $this->renderPartial('listaUsuarios',array('arrUsuarios' => $arrUsuarios));
 
  }
  
}
