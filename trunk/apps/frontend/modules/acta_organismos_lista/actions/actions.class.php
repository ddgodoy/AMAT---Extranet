<?php

/**
 * actas_grupos_trabajo actions.
 *
 * @package    extranet
 * @subpackage actas_grupos_trabajo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class acta_organismos_listaActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		
                $this->DAtos = $this->setOrganismo();
	        $this->Organismo = '';
		
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
                ->where($this->setFiltroBusqueda().' AND  am.'.$this->DAtos['where'].' '.$datoUsuario)
                ->orderBy($this->setOrdenamiento());
                
		$this->pager->setPage($this->paginaActual);
		$this->pager->init();                

		$this->acta_list = $this->pager->getResults();
		$this->cantidadRegistros = $this->pager->getNbResults();
		$busqueda = explode('_',$this->grupodetrabajoBsq);

		if($busqueda[0] == 'Organismo') {
			$this->Organismos = OrganismoTable::getOrganismo($busqueda[1]);
                        $this->organismomenu = $busqueda[1];
		}
		
	}
	
public function executeVer(sfWebRequest $request)
	{    
		## Obtener Acta
		if(!$this->actaId = $this->getRequestParameter('id'))
		$this->forward404('El Acta solicitada no existe');		
		$this->Actas = Doctrine::getTable('Acta')->find($this->actaId);
		   
		$this->user = UsuarioTable::getUsuarioByid($this->Actas->getOwnerId());
		   
		  
		$this->DAtos =$this->setGruposdeTrabajo();
		   
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
		
	return "a.deleted=0 AND a.nombre != '' ".$parcial;	
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
                $this->orderBy = 'a.nombre';
                $this->sortType = 'desc';
                $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
            }

        }

        return $this->orderBYSql;
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
