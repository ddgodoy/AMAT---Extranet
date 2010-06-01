<?php

/**
 * acuerdo actions.
 *
 * @package    extranet
 * @subpackage acuerdo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class acuerdoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
                $this->acurdosCant = AcuerdoTable::getAll()->count();

                $this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
                $this->pager = new sfDoctrinePager('Acuerdo', 15);
		$this->pager->getQuery()->from('Acuerdo')
		->where($this->setFiltroBusqueda())
		->orderBy($this->setOrdenamiento());


		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

		$this->Acuerdo = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();

		############ navegacion giada años #################
		$this->months = '';
	  	$this->year = '';

		$this->modulo = $this->getModuleName();

	  	$this->FEcha_circulares = Common::getListFechas($this->getModuleName());


	  	if($this->desdeBsq &&  $this->hastaBsq)
	  	{
	  		$desdeBsq = explode('/',$this->desdeBsq);
	  		$hastaBsq = explode('/',$this->hastaBsq);
	  		if($desdeBsq[1] == $hastaBsq[1])
	  		{
	  			$this->months = $desdeBsq[1];
	  		}
	  		$this->year = $desdeBsq[2];
	  	}
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->acuerdo = Doctrine::getTable('Acuerdo')->find($request->getParameter('id'));
    $this->forward404Unless($this->acuerdo);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new AcuerdoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new AcuerdoForm();

    $this->processForm($request, $this->form, 'creado');

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($acuerdo = Doctrine::getTable('Acuerdo')->find($request->getParameter('id')), sprintf('Object acuerdo does not exist (%s).', $request->getParameter('id')));
    $this->form = new AcuerdoForm($acuerdo);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($acuerdo = Doctrine::getTable('Acuerdo')->find($request->getParameter('id')), sprintf('Object acuerdo does not exist (%s).', $request->getParameter('id')));
    $this->form = new AcuerdoForm($acuerdo);

    $this->processForm($request, $this->form, 'actualizar');

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $toDelete = $request->getParameter('id');

  	if (!empty($toDelete)) {
  		$request->checkCSRFProtection();

  		$IDs = is_array($toDelete) ? $toDelete : array($toDelete);

  		foreach ($IDs as $id) {
  			$this->forward404Unless($acuerdo = Doctrine::getTable('Acuerdo')->find($id), sprintf('Object iniciativa does not exist (%s).', $id));

		    sfLoader::loadHelpers('Security');
				if (!validate_action('baja')) $this->redirect('seguridad/restringuido');

		    $acuerdo->delete();
  		}
  	}
    $this->redirect('acuerdo/index');
  }
  protected function processForm(sfWebRequest $request, sfForm $form, $action='')
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $acuerdo = $form->save();

      $this->getUser()->setFlash('notice', "El registro ha sido $action correctamente");

      $this->redirect('acuerdo/index');
    }
  }
  protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->desdeBsq = $this->getRequestParameter('desde_busqueda')?$this->getRequestParameter('desde_busqueda'):$this->getUser()->getAttribute($modulo.'_nowfechadesde');
		$this->hastaBsq = $this->getRequestParameter('hasta_busqueda')?$this->getRequestParameter('hasta_busqueda'):$this->getUser()->getAttribute($modulo.'_nowfechahasta');
		$this->CatInicBsq = $this->getRequestParameter('select_cat_tema')?$this->getRequestParameter('select_cat_tema'):$this->getUser()->getAttribute($modulo.'_nowcatiniciativa');
		$this->SubIniBsq = $this->getRequestParameter('acuerdo[subcategoria_acuerdo_id]')?$this->getRequestParameter('acuerdo[subcategoria_acuerdo_id]'):$this->getUser()->getAttribute($modulo.'_nowsubcatiniciativa');
		$this->contenidoBsq = $this->getRequestParameter('contenido_busqueda')?$this->getRequestParameter('contenido_busqueda'):$this->getUser()->getAttribute($modulo.'_nowcontenido');;

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND nombre LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->desdeBsq)) {
			$parcial .= " AND fecha >='".format_date($this->desdeBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowfechadesde', $this->desdeBsq);
		}
		if (!empty($this->hastaBsq)) {
			$parcial .= " AND fecha <= '".format_date($this->hastaBsq,'d')."'";
			$this->getUser()->setAttribute($modulo.'_nowfechahasta', $this->hastaBsq);
		}
		if (!empty($this->CatInicBsq)) {
			$parcial .= " AND categoria_acuerdo_id = $this->CatInicBsq";
			$this->getUser()->setAttribute($modulo.'_nowcatiniciativa', $this->CatInicBsq);
		}
		if (!empty($this->SubIniBsq)) {
			$parcial .= " AND subcategoria_acuerdo_id = $this->SubIniBsq";
			$this->getUser()->setAttribute($modulo.'_nowsubcatiniciativa', $this->SubIniBsq);
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
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechadesde');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechahasta');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcatiniciativa');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcatiniciativa');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->desdeBsq = $this->getUser()->getAttribute($modulo.'_nowfechadesde');
				$this->hastaBsq = $this->getUser()->getAttribute($modulo.'_nowfechahasta');
				$this->CatInicBsq = $this->getUser()->getAttribute($modulo.'_nowcatiniciativa');
				$this->SubIniBsq = $this->getUser()->getAttribute($modulo.'_nowsubcatiniciativa');
				$this->contenidoBsq = $this->getUser()->getAttribute($modulo.'_nowcontenido');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechadesde');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfechahasta');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcatiniciativa');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowsubcatiniciativa');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcontenido');
			$parcial="";
			$this->cajaBsq = "";
			$this->desdeBsq = '';
			$this->hastaBsq = '';
			$this->CatInicBsq = '';
			$this->SubIniBsq = '';
			$this->contenidoBsq = '';
		}
		return 'deleted=0'.$parcial;
  }

  protected function setOrdenamiento()
  {
  	if($this->getRequestParameter('sort'))
  	{
		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		else
		{
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type');
		}
		return $this->orderBy . ' ' . $this->sortType;
  	}
  	else
  	{
  		$this->orderBy = '';
		$this->sortType = 'asc';

  		return 'fecha desc, nombre asc ';
  	}

  }

  public function executeSubcategorias(sfWebRequest $request)
  {
    sfLoader::loadHelpers('Object');
    $subcategoria = SubCategoriaAcuerdoTable::getSubcategiriaBycategoria($request->getParameter('id_categoria'));

    $witSub = new AcuerdoForm();
    $witSub->setWidget('subcategoria_acuerdo_id', new sfWidgetFormChoice(array('choices' => array('0'=>'--seleccionar--')+_get_options_from_objects($subcategoria))));

    return $this->renderPartial('subcategorias',array('witSub' => $witSub));

  }
}
