<?php
/**
 * grupos_trabajo components.
 *
 * @package    extranet
 * @subpackage subcategoria_organismos
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class grupos_trabajoComponents extends sfComponents
{
	public function executeListagrupodetrabajo(sfWebRequest $request)
	{
		$this->arrayGrupodeTrabajo = GrupoTrabajo::ArrayDegrupo();
                
		$this->grupo_selected = $this->grupodetrabajoBsq; 	
	}
}