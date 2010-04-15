<?php

/**
 * acta actions.
 *
 * @package    extranet
 * @subpackage acta
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class actaActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		if ($this->getRequestParameter('DirectoresGerente')==1) {
			$this->DAtos = $this->setDirectoresGerente();
		}
		if ($this->getRequestParameter('GrupodeTrabajo')==2) {
			$this->DAtos =$this->setGruposdeTrabajo();
			$this->Grupo = '';
		}
		if ($this->getRequestParameter('ConsejoTerritorial')==3) {
			$this->DAtos = $this->setConsejosTerritoriales();
			$this->Consejo = '';
		}
		if($this->getRequestParameter('Organismo')==4) {
			$this->DAtos = $this->setOrganismo();
			$this->Organismo = '';
		}
		$this->paginaActual = $this->getRequestParameter('page', 1);

		if (is_numeric($this->paginaActual)) {
			$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
		}
                if($this->DAtos['grupousuario'] == '(0)')
                {
                   $datoUsuario =   '';
                }
                else
                {
                  $datoUsuario = $this->DAtos['grupousuario'];
                }

		$this->pager = new sfDoctrinePager('Acta', 10);
		$this->pager->getQuery()
				->from('Acta a')
				->leftJoin('a.Asamblea am')
				->where($this->setFiltroBusqueda().' AND  am.'.$this->DAtos['where'].' '.$datoUsuario)->orderBy($this->setOrdenamiento());
                
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();

                

                

		$this->acta_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
		$busqueda = explode('_',$this->grupodetrabajoBsq);
		
		if ($busqueda[0] == 'GrupoTrabajo') {
			$this->Grupo = GrupoTrabajoTable::getGrupoTrabajo($busqueda[1]);
		}
		elseif($busqueda[0] == 'ConsejoTerritorial') {
			$this->Consejo = ConsejoTerritorialTable::getConsejo($busqueda[1]);
		}
		elseif($busqueda[0] == 'Organismo') {
			$this->Organismos = OrganismoTable::getOrganismo($busqueda[1]);
		}
	}
	
	public function executeEditar(sfWebRequest $request)
	{   
		if($this->getRequestParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($this->getRequestParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($this->getRequestParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		$ActasAsamblea = ActaTable::getActasByAsamblea($request->getParameter('asamblea'),$this->getUser()->getAttribute('userId'));
		
		$this->forward404Unless($acta = Doctrine::getTable('Acta')->find($ActasAsamblea->getId()), sprintf('Object asamblea does not exist (%s).', $ActasAsamblea->getId()));
		$this->form = new ActaForm($acta);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		if($request->getParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($request->getParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($request->getParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($request->getParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		
		
		
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($acta = Doctrine::getTable('Acta')->find($request->getParameter('id')), sprintf('Object acta does not exist (%s).', $request->getParameter('id')));
		$this->form = new ActaForm($acta);
		
		$this->processForm($request, $this->form);
		
		$this->setTemplate('edit');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		if($request->getParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($request->getParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($request->getParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($request->getParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
		$form->bind($request->getParameter($form->getName()));
		if ($form->isValid()) {
			$acta = $form->save();
			$this->getUser()->setFlash('notice', 'EL acta para la asamblea "'.$acta->Asamblea->getTitulo().'" ha sido actualizada correctamente');
			$this->redirect('asambleas/lista?'.$this->DAtos['get']);
		}
	}
public function executeVer(sfWebRequest $request)
	{    
		## Obtener Acta
			if(!$this->actaId = $this->getRequestParameter('id'))
				$this->forward404('El Acta solicitada no existe');		
		   $this->Actas = Doctrine::getTable('Acta')->find($this->actaId);
		   
		   $this->user = UsuarioTable::getUsuarioByid($this->Actas->getOwnerId());
		   
		   
		   
		if($this->getRequestParameter('DirectoresGerente')==1)
		{  
	   		$this->DAtos = $this->setDirectoresGerente(); 
		   	
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{  
			$this->DAtos =$this->setGruposdeTrabajo();
			
		}
		if($this->getRequestParameter('ConsejoTerritorial')==3)
		{  
			$this->DAtos = $this->setConsejosTerritoriales();
		}
		if($this->getRequestParameter('Organismo')==4)
		{  
			$this->DAtos = $this->setOrganismo();
		}
				   
		   
	}	
		
protected function setFiltroBusqueda()
  {
  	sfLoader::loadHelpers('Date');

  	$parcial = '';
  	$modulo = $this->getModuleName();
  	$this->modulo = $modulo;

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->grupodetrabajoBsq = $this->getRequestParameter('grupodetrabajo');

		if (!empty($this->cajaBsq)) {
			$parcial .= " AND a.nombre LIKE '%$this->cajaBsq%'";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		 if(!empty($this->grupodetrabajoBsq))
		{
			$parcial.=" AND  am.entidad ='$this->grupodetrabajoBsq'";
			$this->getUser()->setAttribute($modulo.'_nowentidad', $this->grupodetrabajoBsq);
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
				$this->grupodetrabajoBsq = $this->getUser()->getAttribute($modulo.'_nowentidad');
			}
		}
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowentidad');
			$parcial="";
			$this->cajaBsq = "";
			$this->grupodetrabajoBsq = '';
		}
		$this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
		if(Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles))
		{
			return "a.deleted=0 AND a.nombre != '' ".$parcial;
		}
		else 
		{
			return "a.deleted=0 AND am.fecha_caducidad >= NOW() AND a.nombre != '' ".$parcial;
		}	
  }
  
  protected function setOrdenamiento()
  {
		$this->orderBy = 'a.nombre';
		$this->sortType = 'desc';

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }	
	
	
  protected function setDirectoresGerente()
  {
		    $arraDAtos['tipo'] = 'Directores Gerentes';
			$arraDAtos['titulo'] = 'Asamblea';
			$arraDAtos['busqueda'] = '';
			$arraDAtos['get'] = 'DirectoresGerente=1' ;
			$arraDAtos['campo']= 'DirectoresGerente' ;
			$arraDAtos['valor']= '1' ;
			$arraDAtos['where']= "entidad = 'DirectoresGerentes_0'" ;
			
			
	return $arraDAtos;		 
  } 
  protected function setGruposdeTrabajo()
  {
		    $arraDAtos['tipo'] = 'Grupos de Trabajo';
			$arraDAtos['titulo'] = 'Convocatoria';
			$arraDAtos['busqueda'] = 'Grupos de Trabajo';
			$arraDAtos['get'] = 'GrupodeTrabajo=2' ;
			$arraDAtos['campo']= 'GrupodeTrabajo' ;
			$arraDAtos['valor']= '2' ;
			$arraDAtos['where']= "entidad LIKE '%GrupoTrabajo%'" ;
			$arraDAtos['grupousuario']= GrupoTrabajo::iddegrupos($this->getUser()->getAttribute('userId')) ;
			if($this->Actas)
			{  
			    $idGrupo =explode('_', AsambleaTable::getAsambleaId($this->Actas->Asamblea->getId(),$arraDAtos['where'])->getEntidad());
				$arraDAtos['usuarios'] =  UsuarioGrupoTrabajoTable::getUsreByGrupo($idGrupo[1]);	

				$arraDAtos['Entidad'] = GrupoTrabajoTable::getGrupoTrabajo($idGrupo[1])->getNombre();	
				
			}
			
	return $arraDAtos;		
  }
  protected function setConsejosTerritoriales()
  {
		    $arraDAtos['tipo'] = 'Consejos Territoriales';
			$arraDAtos['titulo'] = 'Convocatoria';
			$arraDAtos['busqueda'] = 'Consejos Territoriales';
			$arraDAtos['get'] = 'ConsejoTerritorial=3' ;
			$arraDAtos['campo']= 'ConsejoTerritorial' ;
			$arraDAtos['valor']= '3' ;
			$arraDAtos['where']= "entidad LIKE '%ConsejoTerritorial%'";
			$arraDAtos['grupousuario']= ConsejoTerritorial::IdDeconsejo($this->getUser()->getAttribute('userId')) ;
			if($this->Actas)
			{  
			    $idGrupo =explode('_', AsambleaTable::getAsambleaId($this->Actas->Asamblea->getId(),$arraDAtos['where'])->getEntidad());
				$arraDAtos['usuarios'] =  UsuarioConsejoTerritorialTable::getUsreByConse($idGrupo[1]);	
				$arraDAtos['Entidad'] = ConsejoTerritorialTable::getConsejo($idGrupo[1])->getNombre();		
			}
			
	return $arraDAtos;			
  }
		
	 protected function setOrganismo()
  {
		    $arraDAtos['tipo'] = 'Organismo';
			$arraDAtos['titulo'] = 'Convocatoria';
			$arraDAtos['busqueda'] = 'Organismo';
			$arraDAtos['get'] = 'Organismo=4' ;
			$arraDAtos['campo']= 'Organismo' ;
			$arraDAtos['valor']= '4' ;
			$arraDAtos['where']= "entidad LIKE '%Organismo%'" ;
                        $this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);
                        if (Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles)) {
			$arraDAtos['grupousuario']= Organismo::IdDeOrganismo();
                        }
                        else{
                        $arraDAtos['grupousuario']= Organismo::IdDeOrganismo($this->getUser()->getAttribute('userId')) ;
                        }

			if($this->getRequestParameter('id'))
			{  
			    $idGrupo =explode('_', AsambleaTable::getAsambleaId($this->asambleaId,$arraDAtos['where'])->getEntidad());
			    
				$arraDAtos['usuarios'] =  UsuarioTable::getUsuarioByOrganismoAsn($idGrupo[1]);	
				

				$arraDAtos['Entidad'] = OrganismoTable::getOrganismo($idGrupo[1])->getNombre();	
				
			}
			
	return $arraDAtos;		
  }

}
