<?php
/**
 * noticias components.
 *
 * @package    extranet
 * @subpackage subcategoria_organismos
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class organismos_listaComponents extends sfComponents
{
	public function executeListaorganismos(sfWebRequest $request)
	{
	$this->roles = UsuarioRol::getRepository()->getRolesByUser($this->getUser()->getAttribute('userId'),1);

		if (Common::array_in_array(array('1'=>'1', '2'=>'2'), $this->roles)) {
                 $rol = 1;
                }else{
                 $rol = 0;
                }

               if($rol == 1){
               $this->arrayGrupodeTrabajo = GrupoTrabajo::ArrayDeOrganismo();
               }else{
               $this->arrayGrupodeTrabajo = GrupoTrabajo::ArrayDeOrganismo($this->getUser()->getAttribute('userId'));
               }


		$this->grupo_selected = $this->grupodetrabajoBsq;
	}
}