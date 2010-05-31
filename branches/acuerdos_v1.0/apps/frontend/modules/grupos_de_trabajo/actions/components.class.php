<?php
/**
 * noticias components.
 *
 * @package    extranet
 * @subpackage subcategoria_organismos
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class grupos_de_trabajoComponents extends sfComponents
{
	public function executeListagrupodetrabajo(sfWebRequest $request)
	{
		if ($this->getRequestParameter('ConsejoTerritorial')==3 )
		{
		   $this->arrayGrupodeTrabajo = ConsejoTerritorial::ArrayDeconsejo($this->getUser()->getAttribute('userId'));
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{
		   $this->arrayGrupodeTrabajo = GrupoTrabajo::ArrayDegrupo($this->getUser()->getAttribute('userId'));
		}
		if($this->getRequestParameter('Organismo')==4)
		{
		   $this->arrayGrupodeTrabajo = GrupoTrabajo::ArrayDeOrganismo($this->getUser()->getAttribute('userId'));
		}
		$this->grupo_selected = $this->grupodetrabajoBsq; 
		
		
		
	}
}