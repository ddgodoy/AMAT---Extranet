<?php

/**
 * menu actions.
 *
 * @package    extranet
 * @subpackage menu
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class menuActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  { 	
	  $this->menu = Doctrine_Query::create();
		$this->menu->from('Menu')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
		
		$this->menu_list  = $this->menu->execute();
		$this->cantidadRegistros = $this->menu_list->count();
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new MenuForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new MenuForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($menu = Doctrine::getTable('Menu')->find($request->getParameter('id')), sprintf('Object menu does not exist (%s).', $request->getParameter('id')));
    $this->form = new MenuForm($menu);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($menu = Doctrine::getTable('Menu')->find($request->getParameter('id')), sprintf('Object menu does not exist (%s).', $request->getParameter('id')));
    $this->form = new MenuForm($menu);

    $this->processForm($request, $this->form);

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($menu = Doctrine::getTable('Menu')->find($request->getParameter('id')), sprintf('Object menu does not exist (%s).', $request->getParameter('id')));
    
    if (Menu::SetPosicionAeliminar($menu->getPosicion(),$menu->getPadreId())) {
	    $menu->delete();
	    $this->redirect('menu/index');
		}
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
           
    if ($form->isValid()) {
  	  $posicion = $request->getParameter($form->getName());
      $idPadre = $posicion['padre_id'] ? $posicion['padre_id'] : 0;
      
      if (MenuTable::getMenuPadre('0')->count() == 6 && $idPadre == 0 && $request->getParameter('action') != 'update') {
    	  $this->getUser()->setFlash('notice', 'No pueden registrarse mas de 6 grupos en el menu');
	      $this->redirect('menu/index');
      }

  	  if ($request->getParameter('action') != 'update') {
	      if (Menu::SetPosicionactual($posicion['posicion'],$idPadre)) {
	    	  $menu = $form->save();

		      $this->getUser()->setFlash('notice', 'El Elemento del menu ha sido registrado correctamente');
		      $this->redirect('menu/index');
	      }
  	  }

  	  if($request->getParameter('action') == 'update') {
  	  	if (Menu::EditarPosicion($posicion['posicion'],$idPadre,$posicion['id'])) {
					$menu = $form->save();

		      $this->getUser()->setFlash('notice', 'El Elemento del menu ha sido registrado correctamente');
		      $this->redirect('menu/index');  	  		
  	  	}
  	  }
    }
  }

  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->elementoBsq = $this->getRequestParameter('elementos_id');
		$this->subelementoBsq = $this->getRequestParameter('subElementos_id');
		
		if (!empty($this->cajaBsq) && empty($this->elementoBsq) && empty($this->subelementoBsq)) {
			$parcial .= " AND id = $this->cajaBsq ";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajaelemento');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajasubelemento');
		}

		if (!empty($this->cajaBsq) && !empty($this->elementoBsq) && empty($this->subelementoBsq)) {
			$parcial .= " AND id IN ($this->cajaBsq,$this->elementoBsq)";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
			$this->getUser()->setAttribute($modulo.'_nowcajaelemento', $this->elementoBsq);
		}
		
		if (!empty($this->cajaBsq) && !empty($this->elementoBsq) && !empty($this->subelementoBsq)) {
			$parcial .= " AND id IN ($this->cajaBsq,$this->elementoBsq,$this->subelementoBsq)";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
			$this->getUser()->setAttribute($modulo.'_nowcajaelemento', $this->elementoBsq);
			$this->getUser()->setAttribute($modulo.'_nowcajasubelemento', $this->subelementoBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajaelemento');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajasubelemento');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->elementoBsq = $this->getUser()->getAttribute($modulo.'_nowcajaelemento');
				$this->subelementoBsq = $this->getUser()->getAttribute($modulo.'_nowcajasubelemento');
			}
		} 
		
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajaelemento');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcajasubelemento');
			$parcial="";
			$this->cajaBsq = "";
		}
		
		return 'deleted = 0'.$parcial;
  }

  protected function setOrdenamiento()
  {
		$this->orderBy = 'posicion';
		$this->sortType = 'asc';

		if ($this->hasRequestParameter('sort')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }

  public function executeListElementos()
  {
  	return $this->renderComponent('menu','listarElementos');
  }

  public function executeSubElementos()
  {
  	return $this->renderComponent('menu','listarSubElementos');
  }
  
  public function executeUpdatePosicion(sfWebRequest $request)
  {
  	$menu_id = $request->getParameter('id');
  	$to_move = $request->getParameter('dir');
  	$dad_ref = $request->getParameter('dad');
  	$now_pos = Menu::getRepository()->orderElementsBeforeContinue($dad_ref, $menu_id);

  	if ($now_pos > 0) {
  		if ($now_pos == 1 && $to_move == 'up') {
  			$this->redirect('menu/index');
  		}
  		$cantItems = Menu::Cantidadelemetos($menu_id);

	  	if ($now_pos == $cantItems && $to_move == 'down') {
	  		$this->redirect('menu/index');
	  	}
	  	Menu::getRepository()->flipPositions($menu_id, $dad_ref, $to_move);
  	}
  	$this->redirect('menu/index');
  }

} // end class