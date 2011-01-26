CREATE TABLE actividad (id BIGINT AUTO_INCREMENT, titulo LONGTEXT, autor VARCHAR(100) NOT NULL, contenido LONGTEXT, imagen VARCHAR(255), documento VARCHAR(255), fecha DATE NOT NULL, fecha_publicacion DATE NOT NULL, ambito VARCHAR(255), estado VARCHAR(255), destacada TINYINT(1), mutua_id BIGINT, owner_id BIGINT, user_id_creador BIGINT, user_id_modificado BIGINT, user_id_publicado BIGINT, fecha_publicado DATETIME, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX mutua_id_idx (mutua_id), INDEX owner_id_idx (owner_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sub_categoria_acuerdo (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, categoria_acuerdo_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX categoria_acuerdo_id_idx (categoria_acuerdo_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE notificacion (id BIGINT AUTO_INCREMENT, url VARCHAR(255), nombre LONGTEXT, contenido_notificacion_id BIGINT, usuario_id BIGINT, entidad_id BIGINT, tipo VARCHAR(255), visto BIGINT, publico BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX contenido_notificacion_id_idx (contenido_notificacion_id), INDEX usuario_id_idx (usuario_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE contenido (id BIGINT AUTO_INCREMENT, titulo LONGTEXT, contenido LONGTEXT, permalink VARCHAR(255), created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE accion (id BIGINT AUTO_INCREMENT, entidad_creadora VARCHAR(255), entidad_creadora_id BIGINT, entidad VARCHAR(255), entidad_id BIGINT, accion VARCHAR(255), created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE archivo_c_t (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, fecha DATE NOT NULL, fecha_caducidad DATE, contenido LONGTEXT, archivo VARCHAR(255), owner_id BIGINT, disponibilidad VARCHAR(255), consejo_territorial_id BIGINT, documentacion_consejo_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX consejo_territorial_id_idx (consejo_territorial_id), INDEX documentacion_consejo_id_idx (documentacion_consejo_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE lista_comunicado_envio (envio_comunicado_id BIGINT, lista_comunicado_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(envio_comunicado_id, lista_comunicado_id)) ENGINE = INNODB;
CREATE TABLE categoria_c_t (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE acta (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, detalle LONGTEXT, asamblea_id BIGINT, owner_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX asamblea_id_idx (asamblea_id), INDEX owner_id_idx (owner_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE usuario_aplicacion_externa (usuario_id BIGINT, aplicacion_externa_id BIGINT, login VARCHAR(255), pass VARCHAR(255), number_access BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(usuario_id, aplicacion_externa_id)) ENGINE = INNODB;
CREATE TABLE documentacion_consejo (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, fecha DATE NOT NULL, consejo_territorial_id BIGINT NOT NULL, categoria_c_t_id BIGINT NOT NULL, estado VARCHAR(255), owner_id BIGINT, modificador_id BIGINT, publicador_id BIGINT, fecha_publicacion DATE, user_id_creador BIGINT, user_id_modificado BIGINT, user_id_publicado BIGINT, fecha_publicado DATETIME, fecha_desde DATE, fecha_hasta DATE, confidencial TINYINT(1) DEFAULT '1' NOT NULL, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX consejo_territorial_id_idx (consejo_territorial_id), INDEX categoria_c_t_id_idx (categoria_c_t_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE contenido_notificacion (id BIGINT AUTO_INCREMENT, titulo LONGTEXT, mensaje VARCHAR(255), accion VARCHAR(255), entidad VARCHAR(255), created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE noticia (id BIGINT AUTO_INCREMENT, titulo LONGTEXT NOT NULL, autor VARCHAR(100) NOT NULL, entradilla LONGTEXT, contenido LONGTEXT, imagen VARCHAR(255), documento VARCHAR(255), fecha DATE NOT NULL, fecha_publicacion DATE, fecha_caducidad DATE, ambito VARCHAR(255), estado VARCHAR(255), destacada TINYINT(1), novedad TINYINT(1), mas_imagen TINYINT(1), mutua_id BIGINT, owner_id BIGINT, user_id_creador BIGINT, user_id_modificado BIGINT, user_id_publicado BIGINT, fecha_publicado DATETIME, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX mutua_id_idx (mutua_id), INDEX owner_id_idx (owner_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE novedad (id BIGINT AUTO_INCREMENT, titulo LONGTEXT NOT NULL, autor VARCHAR(100) NOT NULL, entradilla LONGTEXT, contenido LONGTEXT, imagen VARCHAR(255), documento VARCHAR(255), fecha DATE NOT NULL, fecha_publicacion DATE, fecha_caducidad DATE, ambito VARCHAR(255), estado VARCHAR(255), destacada TINYINT(1), novedad TINYINT(1), mas_imagen TINYINT(1), mutua_id BIGINT, owner_id BIGINT, user_id_creador BIGINT, user_id_modificado BIGINT, user_id_publicado BIGINT, fecha_publicado DATETIME, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX mutua_id_idx (mutua_id), INDEX owner_id_idx (owner_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE aplicacion_accion (id BIGINT AUTO_INCREMENT, accion VARCHAR(255), accion_del_modulo VARCHAR(128), aplicacion_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX aplicacion_id_idx (aplicacion_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE convocatoria (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, detalle LONGTEXT, asamblea_id BIGINT, owner_id BIGINT, usuario_id BIGINT, estado VARCHAR(255), created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX asamblea_id_idx (asamblea_id), INDEX usuario_id_idx (usuario_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE usuario (id BIGINT AUTO_INCREMENT, login VARCHAR(150), crypted_password VARCHAR(150), salt VARCHAR(255), nombre VARCHAR(150) NOT NULL, apellido VARCHAR(150) NOT NULL, email VARCHAR(150), activo TINYINT(1), telefono VARCHAR(150), remember_token VARCHAR(150), remember_token_expires VARCHAR(150), mutua_id BIGINT NOT NULL, active_at DATETIME, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX mutua_id_idx (mutua_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE organismo (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, detalle LONGTEXT, grupo_trabajo_id BIGINT NOT NULL, categoria_organismo_id BIGINT, subcategoria_organismo_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX grupo_trabajo_id_idx (grupo_trabajo_id), INDEX categoria_organismo_id_idx (categoria_organismo_id), INDEX subcategoria_organismo_id_idx (subcategoria_organismo_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE circular_sub_tema (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, circular_cat_tema_id BIGINT NOT NULL, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX circular_cat_tema_id_idx (circular_cat_tema_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sub_categoria_iniciativa (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, categoria_iniciativa_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX categoria_iniciativa_id_idx (categoria_iniciativa_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE circular (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, fecha DATE NOT NULL, fecha_caducidad DATE, numero BIGINT, documento VARCHAR(255), circular_tema_id BIGINT, circular_sub_tema_id BIGINT, categoria_organismo_id BIGINT, subcategoria_organismo_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX circular_tema_id_idx (circular_tema_id), INDEX circular_sub_tema_id_idx (circular_sub_tema_id), INDEX categoria_organismo_id_idx (categoria_organismo_id), INDEX subcategoria_organismo_id_idx (subcategoria_organismo_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE mutua (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, detalle LONGTEXT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE usuario_grupo_trabajo (usuario_id BIGINT, grupo_trabajo_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(usuario_id, grupo_trabajo_id)) ENGINE = INNODB;
CREATE TABLE evento (id BIGINT AUTO_INCREMENT, titulo LONGTEXT, descripcion LONGTEXT, mas_info LONGTEXT, fecha DATE, fecha_caducidad DATE, imagen VARCHAR(255), mas_imagen TINYINT(1), documento VARCHAR(255), organizador VARCHAR(255), estado VARCHAR(255), ambito VARCHAR(255), owner_id BIGINT, user_id_creador BIGINT, user_id_modificado BIGINT, user_id_publicado BIGINT, fecha_publicado DATETIME, mutua_id BIGINT NOT NULL, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX mutua_id_idx (mutua_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE aplicacion_externa (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, detalle LONGTEXT, imagen VARCHAR(100), url VARCHAR(255), requiere TINYINT(1), created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE categoria_acuerdo (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE usuario_rol (usuario_id BIGINT, rol_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(usuario_id, rol_id)) ENGINE = INNODB;
CREATE TABLE iniciativa (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, fecha DATE NOT NULL, categoria_iniciativa_id BIGINT, subcategoria_iniciativa_id BIGINT, documento VARCHAR(255), created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX categoria_iniciativa_id_idx (categoria_iniciativa_id), INDEX subcategoria_iniciativa_id_idx (subcategoria_iniciativa_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE agenda (id BIGINT AUTO_INCREMENT, fecha LONGTEXT, titulo LONGTEXT, organizador LONGTEXT, url LONGTEXT, evento_id BIGINT, convocatoria_id BIGINT, usuario_id BIGINT, publico BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX convocatoria_id_idx (convocatoria_id), INDEX evento_id_idx (evento_id), INDEX usuario_id_idx (usuario_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE archivo_d_g (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, fecha DATE NOT NULL, fecha_caducidad DATE, contenido LONGTEXT, archivo VARCHAR(255), owner_id BIGINT, disponibilidad VARCHAR(255), grupo_trabajo_id BIGINT, documentacion_grupo_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX grupo_trabajo_id_idx (grupo_trabajo_id), INDEX documentacion_grupo_id_idx (documentacion_grupo_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sub_categoria_organismo (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, categoria_organismo_id BIGINT NOT NULL, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX categoria_organismo_id_idx (categoria_organismo_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE categoria_asunto (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, email_1 VARCHAR(255), activo_1 BIGINT, email_2 VARCHAR(255), activo_2 BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE lista_comunicado (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE circular_cat_tema (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE tipo_comunicado (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, imagen VARCHAR(255), created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE documentacion_organismo (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, fecha DATE NOT NULL, categoria_organismo_id BIGINT, subcategoria_organismo_id BIGINT, organismo_id BIGINT, estado VARCHAR(255), owner_id BIGINT, modificador_id BIGINT, publicador_id BIGINT, fecha_publicacion DATE, user_id_creador BIGINT, user_id_modificado BIGINT, user_id_publicado BIGINT, fecha_publicado DATETIME, fecha_desde DATE, fecha_hasta DATE, confidencial TINYINT(1) DEFAULT '1' NOT NULL, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX organismo_id_idx (organismo_id), INDEX categoria_organismo_id_idx (categoria_organismo_id), INDEX subcategoria_organismo_id_idx (subcategoria_organismo_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE aplicacion (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, nombre_entidad VARCHAR(150), nombre_modulo VARCHAR(150), tipo VARCHAR(255), titulo VARCHAR(100), descripcion LONGTEXT, estado VARCHAR(255), created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE menu (id BIGINT AUTO_INCREMENT, padre_id BIGINT, nombre VARCHAR(100), descripcion VARCHAR(255), aplicacion_id BIGINT, url_externa VARCHAR(255), posicion BIGINT, habilitado TINYINT(1), habilitado_sa TINYINT(1), created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX aplicacion_id_idx (aplicacion_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE envio_error (id BIGINT AUTO_INCREMENT, envio_id BIGINT, usuario_id BIGINT, error LONGTEXT, estado BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX usuario_id_idx (usuario_id), INDEX envio_id_idx (envio_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE usuario_organismo (usuario_id BIGINT, organismo_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(usuario_id, organismo_id)) ENGINE = INNODB;
CREATE TABLE rol (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, detalle LONGTEXT, codigo VARCHAR(32) NOT NULL, excepcion TINYINT(1) DEFAULT '0', created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE normas_de_funcionamiento (id BIGINT AUTO_INCREMENT, titulo LONGTEXT, descripcion LONGTEXT, grupo_trabajo_id BIGINT NOT NULL, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX grupo_trabajo_id_idx (grupo_trabajo_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE usuario_asamblea (id BIGINT AUTO_INCREMENT, usuario_id BIGINT NOT NULL, asamblea_id BIGINT NOT NULL, created_at DATETIME, updated_at DATETIME, INDEX usuario_id_idx (usuario_id), INDEX asamblea_id_idx (asamblea_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE usuario_lista_comunicado (usuario_id BIGINT, lista_comunicado_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(usuario_id, lista_comunicado_id)) ENGINE = INNODB;
CREATE TABLE documentacion_grupo (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, fecha DATE NOT NULL, grupo_trabajo_id BIGINT NOT NULL, categoria_d_g_id BIGINT NOT NULL, estado VARCHAR(255), owner_id BIGINT, modificador_id BIGINT, publicador_id BIGINT, fecha_publicacion DATE, user_id_creador BIGINT, user_id_modificado BIGINT, user_id_publicado BIGINT, fecha_publicado DATETIME, fecha_desde DATE, fecha_hasta DATE, confidencial TINYINT(1) DEFAULT '1' NOT NULL, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX grupo_trabajo_id_idx (grupo_trabajo_id), INDEX categoria_d_g_id_idx (categoria_d_g_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE categoria_organismo (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE solicitud_clave (id BIGINT AUTO_INCREMENT, usuario_id BIGINT NOT NULL, codigo VARCHAR(255), created_at DATETIME, updated_at DATETIME, INDEX usuario_id_idx (usuario_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE usuario_consejo_territorial (usuario_id BIGINT, consejo_territorial_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(usuario_id, consejo_territorial_id)) ENGINE = INNODB;
CREATE TABLE sub_categoria_normativa_n2 (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, categoria_normativa_id BIGINT, subcategoria_normativa_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX categoria_normativa_id_idx (categoria_normativa_id), INDEX subcategoria_normativa_id_idx (subcategoria_normativa_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE usuario_evento (id BIGINT AUTO_INCREMENT, usuario_id BIGINT NOT NULL, evento_id BIGINT NOT NULL, created_at DATETIME, updated_at DATETIME, INDEX usuario_id_idx (usuario_id), INDEX evento_id_idx (evento_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE archivo_d_o (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, fecha DATE NOT NULL, fecha_caducidad DATE, contenido LONGTEXT, archivo VARCHAR(255), owner_id BIGINT, disponibilidad VARCHAR(255), categoria_organismo_id BIGINT, subcategoria_organismo_id BIGINT, organismo_id BIGINT, documentacion_organismo_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX categoria_organismo_id_idx (categoria_organismo_id), INDEX subcategoria_organismo_id_idx (subcategoria_organismo_id), INDEX organismo_id_idx (organismo_id), INDEX documentacion_organismo_id_idx (documentacion_organismo_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE cifra_dato_seccion (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE normativa (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, fecha DATE NOT NULL, publicacion_boe DATE, categoria_normativa_id BIGINT, subcategoria_normativa_uno_id BIGINT, subcategoria_normativa_dos_id BIGINT, documento VARCHAR(255), created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX categoria_normativa_id_idx (categoria_normativa_id), INDEX subcategoria_normativa_uno_id_idx (subcategoria_normativa_uno_id), INDEX subcategoria_normativa_dos_id_idx (subcategoria_normativa_dos_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE categoria_iniciativa (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE publicacion (id BIGINT AUTO_INCREMENT, titulo LONGTEXT, autor VARCHAR(100) NOT NULL, contenido LONGTEXT, imagen VARCHAR(255), documento VARCHAR(255), fecha DATE NOT NULL, fecha_publicacion DATE, fecha_caducidad DATE, ambito VARCHAR(255), estado VARCHAR(255), destacada TINYINT(1), mutua_id BIGINT, owner_id BIGINT, user_id_creador BIGINT, user_id_modificado BIGINT, user_id_publicado BIGINT, fecha_publicado DATETIME, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX mutua_id_idx (mutua_id), INDEX owner_id_idx (owner_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE asamblea (id BIGINT AUTO_INCREMENT, titulo LONGTEXT, direccion VARCHAR(255), fecha DATE, fecha_caducidad DATE, horario VARCHAR(255), contenido LONGTEXT, estado VARCHAR(255), entidad VARCHAR(255), owner_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX owner_id_idx (owner_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE cifra_dato (id BIGINT AUTO_INCREMENT, titulo LONGTEXT NOT NULL, autor VARCHAR(100) NOT NULL, contenido LONGTEXT, imagen VARCHAR(255), documento VARCHAR(255), link VARCHAR(255), fecha DATE NOT NULL, fecha_publicacion DATE NOT NULL, ambito VARCHAR(255), estado VARCHAR(255), destacada TINYINT(1), mutua_id BIGINT, owner_id BIGINT, seccion_id BIGINT, user_id_creador BIGINT, user_id_modificado BIGINT, user_id_publicado BIGINT, fecha_publicado DATETIME, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX mutua_id_idx (mutua_id), INDEX owner_id_idx (owner_id), INDEX seccion_id_idx (seccion_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE categoria_normativa (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE aplicacion_rol (id BIGINT AUTO_INCREMENT, accion_alta TINYINT(1), accion_baja TINYINT(1), accion_modificar TINYINT(1), accion_listar TINYINT(1), accion_publicar TINYINT(1), aplicacion_id BIGINT, rol_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX aplicacion_id_idx (aplicacion_id), INDEX rol_id_idx (rol_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE categoria_d_g (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE envios (id BIGINT AUTO_INCREMENT, envio_id BIGINT, usuario_id BIGINT, message_id LONGTEXT, created_at DATETIME, updated_at DATETIME, INDEX usuario_id_idx (usuario_id), INDEX envio_id_idx (envio_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE acuerdo (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, fecha DATE NOT NULL, categoria_acuerdo_id BIGINT, subcategoria_acuerdo_id BIGINT, documento VARCHAR(255), imagen VARCHAR(255), created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX categoria_acuerdo_id_idx (categoria_acuerdo_id), INDEX subcategoria_acuerdo_id_idx (subcategoria_acuerdo_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sub_categoria_normativa_n1 (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, contenido LONGTEXT, categoria_normativa_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX categoria_normativa_id_idx (categoria_normativa_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE grupo_trabajo (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, detalle LONGTEXT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE envio_comunicado (id BIGINT AUTO_INCREMENT, comunicado_id BIGINT, tipo_comunicado_id BIGINT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, INDEX comunicado_id_idx (comunicado_id), INDEX tipo_comunicado_id_idx (tipo_comunicado_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE consejo_territorial (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, detalle LONGTEXT, created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE comunicado (id BIGINT AUTO_INCREMENT, nombre LONGTEXT, detalle LONGTEXT, en_intranet TINYINT(1), enviado TINYINT(1), created_at DATETIME, updated_at DATETIME, deleted TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
ALTER TABLE actividad ADD FOREIGN KEY (owner_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE actividad ADD FOREIGN KEY (mutua_id) REFERENCES mutua(id) ON DELETE CASCADE;
ALTER TABLE sub_categoria_acuerdo ADD FOREIGN KEY (categoria_acuerdo_id) REFERENCES categoria_acuerdo(id) ON DELETE CASCADE;
ALTER TABLE notificacion ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE notificacion ADD FOREIGN KEY (contenido_notificacion_id) REFERENCES contenido_notificacion(id) ON DELETE CASCADE;
ALTER TABLE archivo_c_t ADD FOREIGN KEY (documentacion_consejo_id) REFERENCES documentacion_consejo(id) ON DELETE CASCADE;
ALTER TABLE archivo_c_t ADD FOREIGN KEY (consejo_territorial_id) REFERENCES consejo_territorial(id) ON DELETE CASCADE;
ALTER TABLE lista_comunicado_envio ADD FOREIGN KEY (lista_comunicado_id) REFERENCES lista_comunicado(id);
ALTER TABLE lista_comunicado_envio ADD FOREIGN KEY (envio_comunicado_id) REFERENCES envio_comunicado(id);
ALTER TABLE acta ADD FOREIGN KEY (owner_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE acta ADD FOREIGN KEY (asamblea_id) REFERENCES asamblea(id) ON DELETE CASCADE;
ALTER TABLE usuario_aplicacion_externa ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id);
ALTER TABLE usuario_aplicacion_externa ADD FOREIGN KEY (aplicacion_externa_id) REFERENCES aplicacion_externa(id);
ALTER TABLE documentacion_consejo ADD FOREIGN KEY (consejo_territorial_id) REFERENCES consejo_territorial(id) ON DELETE CASCADE;
ALTER TABLE documentacion_consejo ADD FOREIGN KEY (categoria_c_t_id) REFERENCES categoria_c_t(id) ON DELETE CASCADE;
ALTER TABLE noticia ADD FOREIGN KEY (owner_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE noticia ADD FOREIGN KEY (mutua_id) REFERENCES mutua(id) ON DELETE CASCADE;
ALTER TABLE novedad ADD FOREIGN KEY (owner_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE novedad ADD FOREIGN KEY (mutua_id) REFERENCES mutua(id) ON DELETE CASCADE;
ALTER TABLE aplicacion_accion ADD FOREIGN KEY (aplicacion_id) REFERENCES aplicacion(id) ON DELETE CASCADE;
ALTER TABLE convocatoria ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE convocatoria ADD FOREIGN KEY (asamblea_id) REFERENCES asamblea(id) ON DELETE CASCADE;
ALTER TABLE usuario ADD FOREIGN KEY (mutua_id) REFERENCES mutua(id) ON DELETE CASCADE;
ALTER TABLE organismo ADD FOREIGN KEY (subcategoria_organismo_id) REFERENCES sub_categoria_organismo(id) ON DELETE CASCADE;
ALTER TABLE organismo ADD FOREIGN KEY (grupo_trabajo_id) REFERENCES grupo_trabajo(id) ON DELETE CASCADE;
ALTER TABLE organismo ADD FOREIGN KEY (categoria_organismo_id) REFERENCES categoria_organismo(id) ON DELETE CASCADE;
ALTER TABLE circular_sub_tema ADD FOREIGN KEY (circular_cat_tema_id) REFERENCES circular_cat_tema(id) ON DELETE CASCADE;
ALTER TABLE sub_categoria_iniciativa ADD FOREIGN KEY (categoria_iniciativa_id) REFERENCES categoria_iniciativa(id) ON DELETE CASCADE;
ALTER TABLE circular ADD FOREIGN KEY (subcategoria_organismo_id) REFERENCES sub_categoria_organismo(id) ON DELETE CASCADE;
ALTER TABLE circular ADD FOREIGN KEY (circular_tema_id) REFERENCES circular_cat_tema(id) ON DELETE CASCADE;
ALTER TABLE circular ADD FOREIGN KEY (circular_sub_tema_id) REFERENCES circular_sub_tema(id) ON DELETE CASCADE;
ALTER TABLE circular ADD FOREIGN KEY (categoria_organismo_id) REFERENCES categoria_organismo(id) ON DELETE CASCADE;
ALTER TABLE usuario_grupo_trabajo ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id);
ALTER TABLE usuario_grupo_trabajo ADD FOREIGN KEY (grupo_trabajo_id) REFERENCES grupo_trabajo(id);
ALTER TABLE evento ADD FOREIGN KEY (mutua_id) REFERENCES mutua(id) ON DELETE CASCADE;
ALTER TABLE usuario_rol ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id);
ALTER TABLE usuario_rol ADD FOREIGN KEY (rol_id) REFERENCES rol(id);
ALTER TABLE iniciativa ADD FOREIGN KEY (subcategoria_iniciativa_id) REFERENCES sub_categoria_iniciativa(id) ON DELETE CASCADE;
ALTER TABLE iniciativa ADD FOREIGN KEY (categoria_iniciativa_id) REFERENCES categoria_iniciativa(id) ON DELETE CASCADE;
ALTER TABLE agenda ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE agenda ADD FOREIGN KEY (evento_id) REFERENCES evento(id) ON DELETE CASCADE;
ALTER TABLE agenda ADD FOREIGN KEY (convocatoria_id) REFERENCES convocatoria(id) ON DELETE CASCADE;
ALTER TABLE archivo_d_g ADD FOREIGN KEY (grupo_trabajo_id) REFERENCES grupo_trabajo(id) ON DELETE CASCADE;
ALTER TABLE archivo_d_g ADD FOREIGN KEY (documentacion_grupo_id) REFERENCES documentacion_grupo(id) ON DELETE CASCADE;
ALTER TABLE sub_categoria_organismo ADD FOREIGN KEY (categoria_organismo_id) REFERENCES categoria_organismo(id) ON DELETE CASCADE;
ALTER TABLE documentacion_organismo ADD FOREIGN KEY (subcategoria_organismo_id) REFERENCES sub_categoria_organismo(id) ON DELETE CASCADE;
ALTER TABLE documentacion_organismo ADD FOREIGN KEY (organismo_id) REFERENCES organismo(id) ON DELETE CASCADE;
ALTER TABLE documentacion_organismo ADD FOREIGN KEY (categoria_organismo_id) REFERENCES categoria_organismo(id) ON DELETE CASCADE;
ALTER TABLE menu ADD FOREIGN KEY (aplicacion_id) REFERENCES aplicacion(id) ON DELETE CASCADE;
ALTER TABLE envio_error ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE envio_error ADD FOREIGN KEY (envio_id) REFERENCES envio_comunicado(id) ON DELETE CASCADE;
ALTER TABLE usuario_organismo ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id);
ALTER TABLE usuario_organismo ADD FOREIGN KEY (organismo_id) REFERENCES organismo(id);
ALTER TABLE normas_de_funcionamiento ADD FOREIGN KEY (grupo_trabajo_id) REFERENCES grupo_trabajo(id) ON DELETE CASCADE;
ALTER TABLE usuario_asamblea ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE usuario_asamblea ADD FOREIGN KEY (asamblea_id) REFERENCES asamblea(id) ON DELETE CASCADE;
ALTER TABLE usuario_lista_comunicado ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id);
ALTER TABLE usuario_lista_comunicado ADD FOREIGN KEY (lista_comunicado_id) REFERENCES lista_comunicado(id) ON DELETE CASCADE;
ALTER TABLE documentacion_grupo ADD FOREIGN KEY (grupo_trabajo_id) REFERENCES grupo_trabajo(id) ON DELETE CASCADE;
ALTER TABLE documentacion_grupo ADD FOREIGN KEY (categoria_d_g_id) REFERENCES categoria_d_g(id) ON DELETE CASCADE;
ALTER TABLE solicitud_clave ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE usuario_consejo_territorial ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id);
ALTER TABLE usuario_consejo_territorial ADD FOREIGN KEY (consejo_territorial_id) REFERENCES consejo_territorial(id);
ALTER TABLE sub_categoria_normativa_n2 ADD FOREIGN KEY (subcategoria_normativa_id) REFERENCES sub_categoria_normativa_n1(id) ON DELETE CASCADE;
ALTER TABLE sub_categoria_normativa_n2 ADD FOREIGN KEY (categoria_normativa_id) REFERENCES categoria_normativa(id) ON DELETE CASCADE;
ALTER TABLE usuario_evento ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id);
ALTER TABLE usuario_evento ADD FOREIGN KEY (evento_id) REFERENCES evento(id);
ALTER TABLE archivo_d_o ADD FOREIGN KEY (subcategoria_organismo_id) REFERENCES sub_categoria_organismo(id) ON DELETE CASCADE;
ALTER TABLE archivo_d_o ADD FOREIGN KEY (organismo_id) REFERENCES organismo(id) ON DELETE CASCADE;
ALTER TABLE archivo_d_o ADD FOREIGN KEY (documentacion_organismo_id) REFERENCES documentacion_organismo(id) ON DELETE CASCADE;
ALTER TABLE archivo_d_o ADD FOREIGN KEY (categoria_organismo_id) REFERENCES categoria_organismo(id) ON DELETE CASCADE;
ALTER TABLE normativa ADD FOREIGN KEY (subcategoria_normativa_uno_id) REFERENCES sub_categoria_normativa_n1(id) ON DELETE CASCADE;
ALTER TABLE normativa ADD FOREIGN KEY (subcategoria_normativa_dos_id) REFERENCES sub_categoria_normativa_n2(id) ON DELETE CASCADE;
ALTER TABLE normativa ADD FOREIGN KEY (categoria_normativa_id) REFERENCES categoria_normativa(id) ON DELETE CASCADE;
ALTER TABLE publicacion ADD FOREIGN KEY (owner_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE publicacion ADD FOREIGN KEY (mutua_id) REFERENCES mutua(id) ON DELETE CASCADE;
ALTER TABLE asamblea ADD FOREIGN KEY (owner_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE cifra_dato ADD FOREIGN KEY (seccion_id) REFERENCES cifra_dato_seccion(id) ON DELETE CASCADE;
ALTER TABLE cifra_dato ADD FOREIGN KEY (owner_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE cifra_dato ADD FOREIGN KEY (mutua_id) REFERENCES mutua(id) ON DELETE CASCADE;
ALTER TABLE aplicacion_rol ADD FOREIGN KEY (rol_id) REFERENCES rol(id) ON DELETE CASCADE;
ALTER TABLE aplicacion_rol ADD FOREIGN KEY (aplicacion_id) REFERENCES aplicacion(id) ON DELETE CASCADE;
ALTER TABLE envios ADD FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE envios ADD FOREIGN KEY (envio_id) REFERENCES envio_comunicado(id) ON DELETE CASCADE;
ALTER TABLE acuerdo ADD FOREIGN KEY (subcategoria_acuerdo_id) REFERENCES sub_categoria_acuerdo(id) ON DELETE CASCADE;
ALTER TABLE acuerdo ADD FOREIGN KEY (categoria_acuerdo_id) REFERENCES categoria_acuerdo(id) ON DELETE CASCADE;
ALTER TABLE sub_categoria_normativa_n1 ADD FOREIGN KEY (categoria_normativa_id) REFERENCES categoria_normativa(id) ON DELETE CASCADE;
ALTER TABLE envio_comunicado ADD FOREIGN KEY (tipo_comunicado_id) REFERENCES tipo_comunicado(id) ON DELETE CASCADE;
ALTER TABLE envio_comunicado ADD FOREIGN KEY (comunicado_id) REFERENCES comunicado(id) ON DELETE CASCADE;
