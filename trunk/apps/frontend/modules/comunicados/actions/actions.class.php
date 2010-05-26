<?php

/**
 * comunicados actions.
 *
 * @package    extranet
 * @subpackage comunicados
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class comunicadosActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$this->paginaActual = $this->getRequestParameter('page', 1);

	if (is_numeric($this->paginaActual)) {
		$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
	}
	
	
	
	$this->pager = new sfDoctrinePager('Comunicado', 20);
	$this->pager->getQuery()
	->from('Comunicado')
	->where($this->setFiltroBusqueda())
	->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->comunicado_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
  	
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->comunicado = Doctrine::getTable('Comunicado')->find($request->getParameter('id'));
    $this->forward404Unless($this->comunicado);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new ComunicadoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new ComunicadoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($comunicado = Doctrine::getTable('Comunicado')->find($request->getParameter('id')), sprintf('Object comunicado does not exist (%s).', $request->getParameter('id')));
    $this->form = new ComunicadoForm($comunicado);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($comunicado = Doctrine::getTable('Comunicado')->find($request->getParameter('id')), sprintf('Object comunicado does not exist (%s).', $request->getParameter('id')));
    $this->form = new ComunicadoForm($comunicado);

    $this->processForm($request, $this->form);

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');

    $this->forward404Unless($comunicado = Doctrine::getTable('Comunicado')->find($request->getParameter('id')), sprintf('Object comunicado does not exist (%s).', $request->getParameter('id')));
    $comunicado->delete();

    $this->redirect('comunicados/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $comunicado = $form->save();

      $this->redirect('comunicados/index');
    }
  }
  
    protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->cajaFecBsq = $this->getRequestParameter('desde_busqueda');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->cajaFecBsq)) {
			
			$fecha = explode('/',$this->cajaFecBsq);
			$ymd = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
			$parcial .= " AND created_at  LIKE '%".$ymd."%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja_fech', $this->cajaFecBsq);
		}


		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_fech');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->cajaFecBsq = $this->getUser()->getAttribute($modulo.'_nowcaja_fech');
			}
		} 
		
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja_fech');
			$parcial="";
			$this->cajaBsq = "";
			$this->cajaFecBsq = "";
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
                        $this->orderBy = 'nombre';
                        $this->sortType = 'asc';
                        $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                        $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
                    }

                }

		return $this->orderBYSql;
  }
}
