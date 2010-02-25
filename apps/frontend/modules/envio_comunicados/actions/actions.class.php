<?php

/**
 * envio_comunicados actions.
 *
 * @package    extranet
 * @subpackage envio_comunicados
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class envio_comunicadosActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {  	
  	$this->paginaActual = $this->getRequestParameter('page', 1);

	if (is_numeric($this->paginaActual)) {
		$this->getUser()->setAttribute($this->getModuleName().'_nowpage', $this->paginaActual);// recordar pagina actual
	}
	
  $this->pager = new sfDoctrinePager('EnvioComunicado', 20);
	$this->pager->getQuery()->from('EnvioComunicado ec')->leftJoin('ec.Comunicado c')->where($this->setFiltroBusqueda())->orderBy($this->setOrdenamiento());
	$this->pager->setPage($this->paginaActual);
	$this->pager->init();

	$this->envio_comunicado_list = $this->pager->getResults();
	$this->cantidadRegistros = $this->pager->getNbResults();
	
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->envio_comunicado = Doctrine::getTable('EnvioComunicado')->find($request->getParameter('id'));
    $this->forward404Unless($this->envio_comunicado);
  }

  public function executeNueva(sfWebRequest $request)
  {
    $this->form = new EnvioComunicadoForm();
    $this->verComunicados = ComunicadoTable::getNoEnviados();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new EnvioComunicadoForm();
    $this->verComunicados = ComunicadoTable::getNoEnviados();
    $this->processForm($request, $this->form);

    $this->setTemplate('nueva');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $this->forward404Unless($envio_comunicado = Doctrine::getTable('EnvioComunicado')->find($request->getParameter('id')), sprintf('Object envio_comunicado does not exist (%s).', $request->getParameter('id')));
    $this->form = new EnvioComunicadoForm($envio_comunicado);
    $this->verComunicados = ComunicadoTable::getNoEnviados();
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($envio_comunicado = Doctrine::getTable('EnvioComunicado')->find($request->getParameter('id')), sprintf('Object envio_comunicado does not exist (%s).', $request->getParameter('id')));
    $this->form = new EnvioComunicadoForm($envio_comunicado);
    $this->verComunicados = ComunicadoTable::getNoEnviados();
    $this->processForm($request, $this->form);

    $this->setTemplate('editar');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    
    sfLoader::loadHelpers('Security'); // para usar el helper
	if (!validate_action('baja')) $this->redirect('seguridad/restringuido');

    $this->forward404Unless($envio_comunicado = Doctrine::getTable('EnvioComunicado')->find($request->getParameter('id')), sprintf('Object envio_comunicado does not exist (%s).', $request->getParameter('id')));
    $envio_comunicado->delete();

    $this->redirect('envio_comunicados/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $envio_comunicado = $form->save();
      
      	$comunicado = $envio_comunicado->getComunicado();
      	
		if (!$comunicado->getEnviado()) 
		{
			$envio_comunicado->enviarMails();
			$comunicado->setEnviado(1);			
			$comunicado->save();
		}
      
      $this->redirect('envio_comunicados/index');
    }
  }
  
  protected function setFiltroBusqueda()
  {
  	$parcial = '';
  	$modulo  = $this->getModuleName();

		$this->cajaBsq = $this->getRequestParameter('caja_busqueda');
		$this->tipoBsq = $this->getRequestParameter('tiposdecomunicadosId');
		
		if (!empty($this->cajaBsq)) {
			$parcial .= " AND (c.nombre LIKE '%$this->cajaBsq%')";
			$this->getUser()->setAttribute($modulo.'_nowcaja', $this->cajaBsq);
		}
		if (!empty($this->tipoBsq)) {
			$parcial .= " AND tipo_comunicado_id = $this->tipoBsq ";
			$this->getUser()->setAttribute($modulo.'_nowtipo', $this->tipoBsq);
		}
		
		if (!empty($parcial)) {
			$this->getUser()->setAttribute($modulo.'_nowfilter', $parcial);
		} else {
			if ($this->hasRequestParameter('btn_buscar')) {
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
				$this->getUser()->getAttributeHolder()->remove($modulo.'_nowtipo');
			} else {
				$parcial = $this->getUser()->getAttribute($modulo.'_nowfilter');
				$this->cajaBsq = $this->getUser()->getAttribute($modulo.'_nowcaja');
				$this->tipoBsq = $this->getUser()->getAttribute($modulo.'_nowtipo');
			}
		} 
		
		if ($this->hasRequestParameter('btn_quitar')){
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowfilter');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowcaja');
			$this->getUser()->getAttributeHolder()->remove($modulo.'_nowtipo');
			$parcial="";
			$this->cajaBsq = "";
			$this->tipoBsq ="";
			
		}
		
		return 'deleted=0'.$parcial;
  }
  
  protected function setOrdenamiento()
  {
		$this->orderBy = 'c.nombre';
		$this->sortType = 'asc';

		if ($this->hasRequestParameter('orden')) {
			$this->orderBy = $this->getRequestParameter('sort');
			$this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
		}
		return $this->orderBy . ' ' . $this->sortType;
  }
//########################################################################################################################  
  public function executeLeeremails(sfWebRequest $request)
  {
//  	217.116.20.132
//  	
//	$mbox = imap_open("{69.64.32.235:110}/pop", "mauro@icox.com", "practico");
//	
//	echo "<h1>Mailboxes</h1>\n";
//	$folders = imap_listmailbox($mbox, "{69.64.32.235:110}/pop", "*");
//	
//	if ($folders == false) {
//	    echo "Call failed<br />\n";
//	} else {
//	    foreach ($folders as $val) {
//	        echo $val . "<br />\n";
//	    }
//	}
//	
//	echo "<h1>Headers in INBOX</h1>\n";
//	$headers = imap_headers($mbox);
//	
//	if ($headers == false) {
//	    echo "Call failed<br />\n";
//	} else {
//	    foreach ($headers as $val) {
//	        echo $val . "<br />\n";
//	    }
//	}
//	
//	imap_close($mbox);
//
//  	exit();

  $socket = '';
  $connect = '';
  
  $pop = $this->pop3php('mauro@icox.com','practico');
  
  if ($pop) {
  	echo 'ok <br>';
  	echo $this->get_total_msg().'<br>';
  	
  	for ($i=149;$i<=$this->get_total_msg();$i++)
  	{
//  		echo '<pre>';
//  		print_r($this->get_msg($i));
//  		echo '</pre>';	 

			echo '['.$this->get_msgTo($i).']:   ';
  			echo strip_tags($this->get_msgSubject($i)).'  ';
  			echo strip_tags($this->get_msgMessageID($i)).' = <20100225190803.3451.149862886.swift@stageintranet.amat.es> <br><br><br>';
  			
  
  	} 
  	exit();
  }
 }
 
 
    function pop3php($username, $password)
    {
        $this->pop3_connect();

        if($this->socket)
        {    
            $username = $username;
            if($this->validate_user($username))
            {
                if($this->validate_pass($password))
                {
                    $this->connect = 1;
                    return true;
                }
                else
                {
                    echo "pass fail";
                    exit();
                }
            }
            else
            {
                echo "user fail";
                exit();
            }
        }
    }

    function pop3_connect()
    {
        //$this->socket = fsockopen("10.100.101.119", "110");
        $this->socket = fsockopen("69.64.32.235", "110");
            
        if(!$this->socket)
        {
            echo "Socket connection fail<br/>";
            exit();
        }
        else
        {
            $line = $this->pop3_reply();
            $status = $this->is_ok($line);

            if(!$status)
            {
                fclose($this->socket);
                $this->socket = -1;
                echo "Socket connection fail<br/>";
                exit();
            }
        }
    }

    protected function pop3_command($command)
    {
        fputs($this->socket, $command);

        $line = $this->pop3_reply();

        return $line;
    }

    protected function pop3_reply()
    {
        $line = fgets($this->socket, 1024);

        return $line;
    }

    protected function is_ok($cmd)
    {	
        $status = substr($cmd, 0, 1);

        if($status != "+")
        {
            return 0;
        }
        
        return 1;
    }

    protected function validate_user($username)
    {
        $command = "USER ".$username."\r\n";
        $reply = $this->pop3_command($command);
        $rtn = $this->is_ok($reply);
        
        if(!$rtn)
        {
            fclose($this->socket);
            $this->socket = -1;
        }
        
        return $rtn;
    }

    protected function validate_pass($password)
    {
        $command = "PASS ".$password."\r\n";
        //    echo "$command<br/>";
        $reply = $this->pop3_command($command);
        $rcc = $this->is_ok($reply);
        
        if(!$rcc)
        {
            fclose($this->socket);
            $this->socket = -1;
        }
    
        return $rcc;
    }

    protected function is_connect()
    {
        return $this->connect;
    }

    protected function get_total_msg()
    {
        $reply = $this->pop3_command("STAT\r\n");

        $mail = explode(" ", $reply);
        $this->total = $mail[1];

        return $this->total;
    }

    protected function get_msgSubject($msgNum)
    {	
        $command = "RETR ".$msgNum."\r\n";
        $reply = $this->pop3_command($command);
        $rtn = $this->is_ok($reply);
 
        if($rtn)
        {
            $count = 0;
            $header = array();

            while(!ereg("^\.\r\n", $reply))
            {
                $reply = $this->pop3_reply();
                $header[$count] = $reply;
                $count++;
            }	
            
            while(list($lineNum, $line) = each($header))
            {	
                if(eregi("^Subject:(.*)", $line, $match))
                {
                    $subject = trim($match[1]);
                    $subject = htmlspecialchars($subject);
                }
            }
            if(empty($subject))
            {
                $subject = "None";
            }
        }
    
        return $subject;
    }
    
    protected function get_msgMessageID($msgNum)
    {	
        $command = "RETR ".$msgNum."\r\n";
        $reply = $this->pop3_command($command);
        $rtn = $this->is_ok($reply);
 
        if($rtn)
        {
            $count = 0;
            $header = array();

            while(!ereg("^\.\r\n", $reply))
            {
                $reply = $this->pop3_reply();
                $header[$count] = $reply;
                $count++;
            }	
            
            while(list($lineNum, $line) = each($header))
            {	 
                if(eregi("^Message-ID:(.*)", $line, $match))
                {
                    $subject = trim($match[1]);
                    $subject = htmlspecialchars($subject);
                }
            }
            if(empty($subject))
            {
                $subject = "None";
            }
        }
    
        return $subject;
    }
   
    protected function get_msgTo($msgNum)
    {	
        $command = "RETR ".$msgNum."\r\n";
        $reply = $this->pop3_command($command);
        $rtn = $this->is_ok($reply);
 
        if($rtn)
        {
            $count = 0;
            $header = array();

            while(!ereg("^\.\r\n", $reply))
            {
                $reply = $this->pop3_reply();
                $header[$count] = $reply;
                $count++;
            }	
            
            while(list($lineNum, $line) = each($header))
            {	
                if(eregi("^To:(.*)", $line, $match))
                {
                    $subject = trim($match[1]);
                    $subject = htmlspecialchars($subject);
                }
            }
            if(empty($subject))
            {
                $subject = "None";
            }
        }
    
        return $subject;
    }
    
   protected  function get_msg($msgNum = '')
    {
        $command = "RETR ".$msgNum."\r\n";
        
        $reply = $this->pop3_command($command);
        $rtn = $this->is_ok($reply);

        if($rtn)
        {
            $count = 0;
            $msg = array();
            $temp = array();

            while(!ereg("^\.\r\n", $reply))
            {
                $reply = $this->pop3_reply();
                $temp[$count] = $reply;
                $count++;
            }
        }
        return $temp;
    }

    protected function delete_msg($msgNum)
    {
        if(empty($msgNum))
        {
            $sessid = session_id();
            echo "$sessid";
            exit();        
        }
        else
        {
            $command = "DELE ".$msgNum."\r\n";
            $reply = $this->pop3_command($command);
            $status = $this->is_ok($reply);

            if(!$status)
            {
                fclose($this->socket);
                $this->socket = -1;
                $sessid = session_id();
                echo "$sessid";
                exit();
            }
        }
    }

    protected function pop3_quit()
    {
        $reply = $this->pop3_command("QUIT\r\n");
        $rtn = $this->is_ok($reply);

        if($rtn)
        {
            fclose($this->socket);
            $this->socket = -1;
        }
    } 
//#####################################################################################################################################    
}
