<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Actividad extends BaseActividad
{
	
	public function eliminarImagen(){
		@unlink(sfConfig::get('sf_upload_dir').'/actividades/images/'.$this->getImagen());
	    @unlink(sfConfig::get('sf_upload_dir').'/actividades/images/'.'s_'.$this->getImagen());
	}
	
	public function eliminarDocumento(){
		@unlink(sfConfig::get('sf_upload_dir').'/actividades/docs/'.$this->getDocumento());
	}
	public function __toString()
	{
		return $this->titulo;
	}

	public function save(Doctrine_Connection $conn = null)
  {        
  	
 								$request  = sfContext::getInstance()->getRequest();
                $stAction = $request->getParameter('action'); 	
                $userid = sfContext::getInstance()->getUser()->getAttribute('userId'); 	
                if ($this->isNew())
                {
                        $this->setUserIdCreador($userid);
                }
                else 
                {
                	      $this->setUserIdModificado($userid) ;
                	
                }
                if($stAction == 'publicar') 
                
                {
                	       $this->setUserIdPublicado($userid);
                	       $this->setFechaPublicado(date('Y-m-d H:i:s'));
                }
                                
                return parent::save($conn);
    }
	
	
}