<?php

/**
 * normas_de_funcionamientos actions.
 *
 * @package    extranet
 * @subpackage normas_de_funcionamientos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class normas_de_funcionamientosActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	    $arraDAtos = array();
  	    $arraDAtos['busqueda'] = 'Grupos de Trabajo'; 
  	    $this->DAtos = $arraDAtos;
  	       
  	 
     	$this->paginaActual = $this->getRequestParameter('page', 1);
 
		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
		$this->pager = new sfDoctrinePager('NormasDeFuncionamiento', 10);
		$this->pager->getQuery()
		->from('NormasDeFuncionamiento')
		->where($this->setFiltroBusqueda())
		->orderBy($this->setOrdenamiento());
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();
  	    
		$this->normas_de_funcionamiento_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
  	
		if($this->grupo)
			{
			  $this->Grupo = GrupoTrabajoTable::getGrupoTrabajo($this->grupo);
			}
			else 
			{
			  $this->Grupo = '';
			}
   }
   public function executeShow(sfWebRequest $request)
	{
		
		$this->modulo = $this->getModuleName();
		
		$this->Normas = Doctrine::getTable('NormasDeFuncionamiento')->find($request->getParameter('id'));
		$this->forward404Unless($this->Normas);
		
		if($this->Normas->getGrupoTrabajoId())
			{
			  $this->Grupo = GrupoTrabajoTable::getGrupoTrabajo($this->Normas->getGrupoTrabajoId());
			}
			else 
			{
			  $this->Grupo = '';
			}
		
	}

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new NormasDeFuncionamientoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new NormasDeFuncionamientoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($normas_de_funcionamiento = Doctrine::getTable('NormasDeFuncionamiento')->find($request->getParameter('id')), sprintf('Object normas_de_funcionamiento does not exist (%s).', $request->getParameter('id')));
    $this->form = new NormasDeFuncionamientoForm($normas_de_funcionamiento);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($normas_de_funcionamiento = Doctrine::getTable('NormasDeFuncionamiento')->find($request->getParameter('id')), sprintf('Object normas_de_funcionamiento does not exist (%s).', $request->getParameter('id')));
    $this->form = new NormasDeFuncionamientoForm($normas_de_funcionamiento);

    $this->processForm($request, $this->form);

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($normas_de_funcionamiento = Doctrine::getTable('NormasDeFuncionamiento')->find($request->getParameter('id')), sprintf('Object normas_de_funcionamiento does not exist (%s).', $request->getParameter('id')));
    $normas_de_funcionamiento->delete();

    $this->redirect('normas_de_funcionamientos/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $normas_de_funcionamiento = $form->save();
      
      $this->getUser()->setFlash('notice', "El registro ha sido registrado correctamente");

      $this->redirect('normas_de_funcionamientos/index');
    }
  }
  protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');

  	$parcial = '';
  	$modulo = $this->getModuleName();
  	$this->modulo = $modulo;

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->grupo = $this->getRequestParameter('grupo');

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND titulo LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		 if(!empty($this->grupo))
		{
			$parcial.=" AND  grupo_trabajo_id =$this->grupo";
			$this->getUser()->setAttribute($modulo.'_nowentidad', $this->grupo);
		}
		

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowentidad');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->grupo = $this->getUser()->getAttribute($modulo.'_nowentidad');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowentidad');
			$parcial="";
			$this->cajaBsq = "";
			$this->grupo = '';
		}
		return 'deleted=0'.$parcial;
  }
  
  protected function setOrdenamiento()
  {
		$this->orderBy = 'titulo';
		$this->sortType = 'desc';

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }	

}
