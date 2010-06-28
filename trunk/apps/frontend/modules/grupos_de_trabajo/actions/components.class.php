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
                $this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);

		if (Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles)) {
                 $rol = 1;
                }else{
                 $rol = 0;
                }


		if ($this->getRequestParameter('ConsejoTerritorial')==3 )
		{
                   if($rol == 1){
                    $this->arrayGrupodeTrabajo = ConsejoTerritorial::ArrayDeconsejo(); 
                   }else {
                    $this->arrayGrupodeTrabajo = ConsejoTerritorial::ArrayDeconsejo($this->getUser()->getAttribute('userId'));
                   }
		}
		if($this->getRequestParameter('GrupodeTrabajo')==2)
		{
                   if($rol == 1){
		   $this->arrayGrupodeTrabajo = GrupoTrabajo::ArrayDegrupo();
                   }else{
                   $this->arrayGrupodeTrabajo = GrupoTrabajo::ArrayDegrupo($this->getUser()->getAttribute('userId'));
                   }
		}
		if($this->getRequestParameter('Organismo')==4)
		{
                   if($rol == 1){
		   $this->arrayGrupodeTrabajo = GrupoTrabajo::ArrayDeOrganismo();
                   }else{
                   $this->arrayGrupodeTrabajo = GrupoTrabajo::ArrayDeOrganismo($this->getUser()->getAttribute('userId'));
                   }
                   
		}
		$this->grupo_selected = $this->grupodetrabajoBsq; 
		
		
		
	}
}