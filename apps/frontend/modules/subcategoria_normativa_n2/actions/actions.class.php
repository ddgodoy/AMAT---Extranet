<?php

/**
 * subcategoria_normativa_n2 actions.
 *
 * @package    extranet
 * @subpackage subcategoria_normativa_n2
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class subcategoria_normativa_n2Actions extends sfActions
{
public function executeIndex(sfWebRequest $request)
  {
    $this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
  	$this->pager = new sfDoctrinePager('SubCategoriaNormativaN2', 10);  	    
	$this->pager->getQuery()->from('SubCategoriaNormativaN2')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->SubCategoriaNormativaN2 = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();  
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new SubCategoriaNormativaN2Form();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new SubCategoriaNormativaN2Form();

    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($sub_categoria_normativa_n2 = Doctrine::getTable('SubCategoriaNormativaN2')->find($request->getParameter('id')), sprintf('Object sub_categoria_normativa_n2 does not exist (%s).', $request->getParameter('id')));
    $this->form = new SubCategoriaNormativaN2Form($sub_categoria_normativa_n2);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($sub_categoria_normativa_n2 = Doctrine::getTable('SubCategoriaNormativaN2')->find($request->getParameter('id')), sprintf('Object sub_categoria_normativa_n2 does not exist (%s).', $request->getParameter('id')));
    $this->form = new SubCategoriaNormativaN2Form($sub_categoria_normativa_n2);

    $this->processForm($request, $this->form, 'editar');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($sub_categoria_normativa_n2 = Doctrine::getTable('SubCategoriaNormativaN2')->find($request->getParameter('id')), sprintf('Object sub_categoria_normativa_n2 does not exist (%s).', $request->getParameter('id')));
    $sub_categoria_normativa_n2->delete();

    $this->redirect('subcategoria_normativa_n2/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $accion = '')
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $sub_categoria_normativa_n2 = $form->save();

      $this->getUser()->setFlash('notice', "El registro ha sido $accion correctamente");
      $this->redirect('subcategoria_normativa_n2/index');		      
    }
  }
  
  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->categoriaBsq = $this->getRequestParameter('categoria');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->categoriaBsq)) {
			$parcial .= " AND categoria_normativa_id = $this->categoriaBsq ";
			$this->getUser()->setAttribute($modulo.'_nowcategoria', $this->categoriaBsq);
		}

		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->categoriaBsq = $this->getUser()->getAttribute($modulo.'_nowcategoria');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcategoria');
			$parcial="";
			$this->cajaBsq = "";
			$this->categoriaBsq = '';
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
  public function executeSubcategorias(sfWebRequest $request)
  {
    $subcategoria = SubCategoriaNormativaN1::getArraySubCategoria($request->getParameter('id_categoria'));
    
    if(!$request->getParameter('normativa'))
    {
	    $witSub = new SubCategoriaNormativaN2Form();
	    
	    $witSub->setWidget('subcategoria_normativa_id', new sfWidgetFormChoice(array('choices' => $subcategoria)));
    }
    else 
    {
       $witSub = new NormativaForm();
	    
	   $witSub->setWidget('subcategoria_normativa_uno_id', new sfWidgetFormChoice(array('choices' => $subcategoria)));    	
    	
    }
    
    return $this->renderPartial('subcategorias',array('witSub' => $witSub, 'normativa'=>$request->getParameter('normativa')));
    
  }
}
