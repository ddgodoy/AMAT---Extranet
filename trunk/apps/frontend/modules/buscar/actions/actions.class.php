<?php

/**
 * asambleas actions.
 *
 * @package    extranet
 * @subpackage asambleas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class buscarActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{

	}
	
	public function executeBuscar(sfWebRequest $request)
	{
		$word = $request->getParameter('q');
		
		if ($request->getParameter('categoria')) {
			$this->categoria = $request->getParameter('categoria');
		}
		$this->word = $word;

		$q = Doctrine_Query::create();

		/* AGENDA EVENTOS */
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "agenda") {
			$q->from('Evento');
			$q->where('deleted = 0');
			$q->andWhere("titulo like '%".$word."%' OR descripcion like '%".$word."%' OR mas_info like '%".$word."%'");
			$q->orderBy('titulo ASC');
			$resAgenda = $q->execute();

			$this->resAgenda = $resAgenda;
			$this->resCategoria = $resAgenda;
			$this->path='eventos/show?id=';
			$this->labelCategoria='Agenda';
		}
		/* NOTICIA */
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "noticias") {
			$q->from('Noticia');
			$q->where('deleted = 0');
			$q->andWhere("titulo like '%".$word."%' OR entradilla like '%".$word."%' OR contenido like '%".$word."%'");
			$q->orderBy('titulo ASC');
			
			
			$resNoticias = $q->execute();
			
			

			$this->resNoticias = $resNoticias;
			$this->resCategoria = $resNoticias;
			$this->path='noticias/show?id=';
			$this->labelCategoria='Noticias';
		}
		/* APLICACIONES */
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "aplicaciones_externas") {
			$q->from('AplicacionExterna');
			$q->where('deleted = 0');
			$q->andWhere("nombre like '%".$word."%' OR detalle like '%".$word."%'");
			$q->orderBy('nombre ASC');
			$resAplicaciones = $q->execute();

			$this->resAplicaciones = $resAplicaciones;
			$this->resCategoria = $resAplicaciones;
			$this->path='aplicaciones_externas/editar?id=';
			$this->labelCategoria='Aplicaciones';
		}		
		/* cifras y datos */
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "cifras_datos") {
			$q->from('CifraDato');
			$q->where('deleted = 0');
			$q->andWhere("titulo like '%".$word."%' OR contenido like '%".$word."%'");
			$q->orderBy('titulo ASC');
			$resCifraDato = $q->execute();

			$this->resCifraDato = $resCifraDato;
			$this->resCategoria = $resCifraDato;
			$this->path='cifras_datos/show?id=';
			$this->labelCategoria='Cifras y Datos';
		}
		/* Actividades */
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "actividades") {
			$q->from('Actividad');
			$q->where('deleted = 0');
			$q->andWhere("titulo like '%".$word."%' OR contenido like '%".$word."%'");
			$q->orderBy('titulo ASC');
			$resActividades = $q->execute();

			$this->resActividades = $resActividades;
			$this->resCategoria = $resActividades;
			$this->path='actividades/show?id=';
			$this->labelCategoria='Actividades';
		}
		/* Publicaciones */
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "publicaciones") {
			$q->from('Publicacion');
			$q->where('deleted = 0');
			$q->andWhere("titulo like '%".$word."%' OR contenido like '%".$word."%'");
			$q->orderBy('titulo ASC');
			$resPublicacion = $q->execute();

			$this->resPublicacion = $resPublicacion;
			$this->resCategoria = $resPublicacion;
			$this->path='publicaciones/show?id=';
			$this->labelCategoria='Publicaciones';
		}
		/* Normativas */
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "normativas") {
			$q->from('Normativa');
			$q->where('deleted = 0');
			$q->andWhere("nombre like '%".$word."%' OR contenido like '%".$word."%'");
			$q->orderBy('nombre ASC');
			$resNormativas = $q->execute();

			$this->resNormativas = $resNormativas;
			$this->resCategoria = $resNormativas;
			$this->path='normativas/show?id=';
			$this->labelCategoria='Normativas';
		}
		/* Iniciativa */
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "iniciativas") {
			$q->from('Iniciativa');
			$q->where('deleted = 0');
			$q->andWhere("nombre like '%".$word."%' OR contenido like '%".$word."%'");
			$q->orderBy('nombre ASC');
			$resIniciativas = $q->execute();

			$this->resIniciativas = $resIniciativas;
			$this->resCategoria = $resIniciativas;
			$this->path='iniciativas/show?id=';
			$this->labelCategoria='Iniciativa';
		}
		/* Circulares */
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "circulares") {
			$q->from('Circular');
			$q->where('deleted = 0');
			$q->andWhere("nombre like '%".$word."%' OR contenido like '%".$word."%'");
			$q->orderBy('nombre ASC');
			$resCirculares = $q->execute();

			$this->resCirculares = $resCirculares;
			$this->resCategoria = $resCirculares;
			$this->path='circulares/show?id=';
			$this->labelCategoria='Circulares';
		}
		/* DOCUMENTACION */
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "documentacion") {
		$con = Doctrine_Manager::getInstance()->connection();
		$SQL = "SELECT n.id, n.nombre, 'normativas' as modulo FROM `normativa` n WHERE (n.nombre like '%".$word."%' OR n.contenido like '%".$word."%') AND (n.deleted = 0)
				UNION
				SELECT i.id, i.nombre, 'iniciativas' as modulo FROM `iniciativa` i WHERE (i.nombre like '%".$word."%' OR i.contenido like '%".$word."%') AND (i.deleted = 0)
				UNION
				SELECT c.id, c.nombre, 'circulares' as modulo FROM `circular` c WHERE (c.nombre like '%".$word."%' OR c.contenido like '%".$word."%') AND (c.deleted = 0)";
	
		$st = $con->execute($SQL);		
		$results = $st->fetchAll();		
		$resDocumentacion = array();
		foreach ($results as $n) { $resDocumentacion[] = array('id' => $n['id'], 'modulo' => $n['modulo'], 'nombre' => $n['nombre']); }
		$this->resDocumentacion = $resDocumentacion;
		$this->resCategoria = $resDocumentacion;
		$this->labelCategoria='Documentación';
		}

		/* Asamblea Directores Gerentes*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "asambleas_director") {
			$q->from('UsuarioAsamblea ua');
			$q->leftJoin('ua.Asamblea a');
			$q->where('a.deleted = 0');
			$q->andWhere("a.entidad like 'DirectoresGerentes%'");
			$q->andWhere("ua.usuario_id =".$this->getUser()->getAttribute('userId'));
			$q->andWhere("a.titulo like '%".$word."%' OR a.contenido like '%".$word."%'");
			$q->orderBy('a.titulo ASC');		
			$resAsambleaDirectores = $q->execute();

			$this->resAsambleaDirectores = $resAsambleaDirectores;
			$this->resCategoria = $resAsambleaDirectores;
			$this->asambleas = 'asambleas';
		  $this->tipo = 'DirectoresGerente=1';
			$this->path='asambleas/ver?id=';
			$this->labelCategoria='Directores Gerentes <span> (Asamblea)</span>';
		}
		/* Asamblea GRUPO TRABAJO*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "asambleas_grupo") {
			$q->from('Convocatoria c');
			$q->leftJoin('c.Asamblea a');
			$q->where('a.deleted = 0');
			$q->andWhere("a.entidad like 'GrupoTrabajo%'");
			$q->andWhere("a.titulo like '%".$word."%' OR a.contenido like '%".$word."%'");
			$q->addWhere('c.usuario_id=' . $this->getUser()->getAttribute('userId'));
			$q->orderBy('a.titulo ASC');
			$resAsambleaGrupoTrabajo = $q->execute();

			$this->resAsambleaGrupoTrabajo = $resAsambleaGrupoTrabajo;
			$this->resCategoriao = $resAsambleaGrupoTrabajo;
			$this->asambleas = 'asambleas';
			$this->tipo = 'GrupodeTrabajo=2';
			$this->path='asambleas/ver?id=';
			$this->labelCategoria='Grupos de trabajo <span> (Convocatoria)</span>';
		}
		/* Asamblea CONSEJO TERRITORIAL*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "asambleas_consejo") {
			$q->from('Convocatoria c');
			$q->leftJoin('c.Asamblea a');
			$q->where('a.deleted = 0');
			$q->andWhere("a.entidad like 'ConsejoTerritorial%'");
			$q->andWhere("a.titulo like '%".$word."%' OR a.contenido like '%".$word."%'");
			$q->addWhere('c.usuario_id=' . $this->getUser()->getAttribute('userId'));
			$q->orderBy('a.titulo ASC');
			$resAsambleaConsejoTerritorial = $q->execute();

			$this->resAsambleaConsejoTerritorial = $resAsambleaConsejoTerritorial;
			$this->resCategoria = $resAsambleaConsejoTerritorial;
			$this->asambleas = 'asambleas';
			$this->tipo = 'ConsejoTerritorial=3';
			$this->path='asambleas/ver?id=';
			$this->labelCategoria='Consejo Territorial <span> (Convocatoria)</span>';
		}
		/* Asamblea Organismos*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "asambleas_organismos") {
			$q->from('Convocatoria c');
			$q->leftJoin('c.Asamblea a');
			$q->where('a.deleted = 0');
			$q->andWhere("a.entidad like '%Organismo%'");
			$q->andWhere("a.titulo like '%".$word."%' OR a.contenido like '%".$word."%'");
			$q->addWhere('c.usuario_id=' . $this->getUser()->getAttribute('userId'));
			$q->orderBy('a.titulo ASC');
			$resAsambleaOrganismo = $q->execute();

			$this->resAsambleaOrganismo = $resAsambleaOrganismo;
			$this->resCategoria = $resAsambleaOrganismo;
			$this->asambleas = 'asambleas';
			$this->tipo = 'Organismo=4';
			$this->path='asambleas/ver?id=';
			$this->labelCategoria='Organismos <span> (Convocatoria)</span>';
		}
		/* Asamblea Junta*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "asambleas_junta") {
			$q->from('Convocatoria c');
			$q->leftJoin('c.Asamblea a');
			$q->where('a.deleted = 0');
			$q->andWhere("a.entidad like 'Junta_directiva%'");
			$q->andWhere("a.titulo like '%".$word."%' OR a.contenido like '%".$word."%'");
			$q->addWhere('c.usuario_id=' . $this->getUser()->getAttribute('userId'));
			$q->orderBy('a.titulo ASC');
			$resAsambleaJunta = $q->execute();

			$this->resAsambleaJunta = 	$resAsambleaJunta;
			$this->resCategoria = 	$resAsambleaJunta;
			$this->asambleas = 'asambleas';
			$this->tipo = 'Junta_directiva=5';
			$this->path='asambleas/ver?id=';
			$this->labelCategoria='Junta directiva <span> (Asamblea)</span>';
		}
		/* Asamblea Otros*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "asambleas_otros") {
			$q->from('Convocatoria c');
			$q->leftJoin('c.Asamblea a');
			$q->where('a.deleted = 0');
			$q->andWhere("a.entidad like 'Otros%'");
			$q->andWhere("a.titulo like '%".$word."%' OR a.contenido like '%".$word."%'");
			$q->addWhere('c.usuario_id=' . $this->getUser()->getAttribute('userId'));
			$q->orderBy('a.titulo ASC');
			$resAsambleaOtros = $q->execute();

			$this->resAsambleaOtros = $resAsambleaOtros;
			$this->resCategoria = $resAsambleaOtros;
			$this->asambleas = 'asambleas';
			$this->tipo = 'Otros=6';
			$this->path='asambleas/ver?id=';
			$this->labelCategoria='Otras <span> (Asamblea)</span>';
		}
		/*Grupo de Trabajo*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "grupos_de_trabajo") {
			$q->from('GrupoTrabajo gt');
		  $q->leftJoin('gt.UsuarioGrupoTrabajo ugt');
			$q->where('gt.deleted = 0');
			$q->andWhere("gt.nombre like '%".$word."%' OR gt.detalle like '%".$word."%'");
			$q->addWhere('ugt.usuario_id ='.$this->getUser()->getAttribute('userId'));
			$q->orderBy('gt.nombre ASC');
			$resGruposdetrabajo = $q->execute();

			$this->resGruposdetrabajo = $resGruposdetrabajo;
			$this->resCategoria = $resGruposdetrabajo;
			$this->path='miembros_grupo?grupo=';
			$this->labelCategoria='Grupos de trabajo';
		}
		/*Consejos Territoriales*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "consejos_territoriales") {
			$q->from('ConsejoTerritorial ct');
			$q->leftJoin('ct.UsuarioConsejoTerritorial uct');
			$q->where('ct.deleted = 0');
			$q->andWhere("ct.nombre like '%".$word."%' OR ct.detalle like '%".$word."%'");
			$q->addWhere('uct.usuario_id ='.$this->getUser()->getAttribute('userId'));
			$q->orderBy('ct.nombre ASC');
			$ConsejosTerritoriales = $q->execute();

			$this->ConsejosTerritoriales = $ConsejosTerritoriales;
			$this->resCategoria = $ConsejosTerritoriales;
			$this->path='miembros_consejo?consejo=';
			$this->labelCategoria='Grupos de trabajo';
		}
		/*Organismos*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "organismos") {
			$q->from('Organismo o');
			$q->where('o.deleted = 0');
			$q->andWhere("o.nombre like '%".$word."%' OR o.detalle like '%".$word."%'");
			$q->orderBy('o.nombre ASC');
			$Organismo = $q->execute();

			$this->Organismo = $Organismo;
			$this->resCategoria = $Organismo;
			$this->path='miembros_consejo?consejo=';
			$this->labelCategoria='Grupos de trabajo';
		}
		/* Documentacion GRUPO TRABAJO*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "documentacion_grupo") {
			$q->from('DocumentacionGrupo');
			$q->where('deleted = 0');
			$q->andWhere("estado = 'publicado'");
			$q->andWhere("nombre like '%".$word."%' OR contenido like '%".$word."%'");
			$q->orderBy('nombre ASC');
			$resDocumentacionGrupoTrabajo = $q->execute();

			$this->resDocumentacionGrupoTrabajo = $resDocumentacionGrupoTrabajo;
			$this->resCategoria = $resDocumentacionGrupoTrabajo;
			$this->path='documentacion_grupos/show?id=';
			$this->labelCategoria='Grupos de trabajo <span> (Documentaci&oacute;n)</span>';
		}
		/* Documentacion CONSEJO TERRITORIAL*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "documentacion_consejo") {
			$q->from('DocumentacionConsejo');
			$q->where('deleted = 0');
			$q->andWhere("estado = 'publicado'");
			$q->andWhere("nombre like '%".$word."%' OR contenido like '%".$word."%'");
			$q->orderBy('nombre ASC');
			$resDocumentacionConsejoTerritorial = $q->execute();

			$this->resDocumentacionConsejoTerritorial = $resDocumentacionConsejoTerritorial;
			$this->resCategoria = $resDocumentacionConsejoTerritorial;
			$this->path='documentacion_consejos/show?id=';
			$this->labelCategoria='Area Territorial <span> (Documentaci&oacute;n)</span>';
		}
		/* Documentacion Organismos*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "documentacion_organismo") {
			$q->from('DocumentacionOrganismo');
			$q->where('deleted = 0');
			$q->andWhere("estado = 'publicado'");
			$q->andWhere("nombre like '%".$word."%' OR contenido like '%".$word."%'");
			$q->orderBy('nombre ASC');	
			$resDocumentacionOrganismo = $q->execute();

			$this->resDocumentacionOrganismo = $resDocumentacionOrganismo;
			$this->resCategoria = $resDocumentacionOrganismo;
			$this->path='documentacion_organismos/show?id=';
			$this->labelCategoria='Organismos <span> (Documentaci&oacute;n)</span>';
		}
		
		/*Aplicaciones*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "aplicaciones") {
			$q->from('Aplicacion');
			$q->where('deleted = 0');
			$q->andWhere("nombre like '%".$word."%'");
			$q->orderBy('nombre ASC');	
			$resAplicaciones1 = $q->execute();

			$this->resAplicaciones1 = $resAplicaciones1;
			$this->resCategoria = $resAplicaciones1;
			$this->path='aplicaciones/show?id=';
			$this->labelCategoria='Aplicaciones';
		}
		
		/*ArchivoCT*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "archivos_c_t") {
			$q->from('ArchivoCT');
			$q->where('deleted = 0');
			$q->andWhere("nombre like '%".$word."%' OR contenido like '%".$word."%'");
			$q->orderBy('nombre ASC');	
			$ArchivoCT = $q->execute();

			$this->resArchivoCT = $ArchivoCT; 
			$this->resCategoria =$ArchivoCT;
			$this->path='archivos_c_t/show?id=';
			$this->labelCategoria='<span>Archivos Consejo Territorial</span>';
		}
		
		/*ArchivoDG*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "archivos_d_g") {
			$q->from('ArchivoDG');
			$q->where('deleted = 0');
			$q->andWhere("nombre like '%".$word."%' OR contenido like '%".$word."%'");
			$q->orderBy('nombre ASC');	
			$ArchivoDG = $q->execute();

			$this->resArchivoDG = $ArchivoDG;
			$this->resCategoria = $ArchivoDG;
			$this->path='archivos_d_g/show?id=';
			$this->labelCategoria='<span>Archivos Grupo de Trabajo</span>';
		}
		
		/*ArchivoDO*/
		if (!$request->getParameter('categoria') || $request->getParameter('categoria') == "archivos_d_o") {
			$q->from('ArchivoDO');
			$q->where('deleted = 0');
			$q->andWhere("nombre like '%".$word."%' OR contenido like '%".$word."%'");
			$q->orderBy('nombre ASC');	
			$ArchivoDO = $q->execute();

			$this->resArchivoDO = $ArchivoDO;
			$this->resCategoria = $ArchivoDO;
			$this->path='archivos_d_o/show?id=';
			$this->labelCategoria='<span>Archivos de Organismos</span>';
		}
		
		
		
	}
}