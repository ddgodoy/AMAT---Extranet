<?php
/**
 * noticias components.
 *
 * @package    extranet
 * @subpackage subcategoria_organismos
 * @author     Your name here
 * @version    SVN: $Id: components.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class tipos_comunicadoComponents extends sfComponents
{
	public function executeListadetipocomunicados (sfWebRequest $request)
	{
		
		$this->arrayTiposdeComunicados = TipoComunicadoTable::AllTiposComunicados() ;
		$this->Tipos_selected = $this->getUser()->getAttribute('envio_comunicados_nowtipo'); 
	}
}