<?php use_helper('Security') ?>

<script language="javascript" type="text/javascript">
function trim(stringToTrim)
{
        return stringToTrim.replace(/^\s+|\s+$/g,"");
}
function avoidNullSearch()
{
        var txtclave = trim($('key_search_gral').value);

        if (txtclave == '') {
                alert('Ingrese una clave para la b\u00fasqueda'); $('key_search_gral').focus(); return false;
        }
        return true;
}
function  Confirmar_acceso(url,usu,pass){
    var objectFrm = $('myAplicationFrom');
    var objetHIdden1 = $('userHidden');
    var objetHIdden2 = $('passHidden');

    objectFrm.action = url;
    objetHIdden1.value = usu;
    objetHIdden2.value = pass;
    objectFrm.submit();
}
</script>
<div class="head">
	<div class="img1">
		<?php echo image_tag('logo.png', array('width' => 249, 'height' => 66, 'alt' => 'Amat')) ?>
		<div class="buscador">
			<form action="<?php echo url_for('buscar/buscar') ?>" method="get">
				<input class="form_input" name="q" type="text" id="key_search_gral" />
				<input name="boton_buscar" type="submit" value="Buscar" class="boton" onclick="return avoidNullSearch();"/>
			</form>
		</div>
		<h1>Extranet Sectorial AMAT</h1>
		<div class="menu" style="z-index:1000;">
			<ul class="sf-menu">
			<?php
				foreach ($sf_user->getAttribute('menu') as $item) {
					$banderaInicio = 0;
					
					if (count($item['hijos']) >= 1) {
						foreach ($item['hijos'] as $verelmoduloInicial) {
							if (validate_action('listar', $verelmoduloInicial['modulo']) || validate_action('publicar', $verelmoduloInicial['modulo'])) {
								$banderaInicio = 1;
							}
						}
						if ($banderaInicio == 1) {
							$arrayMenuPadre = getArrayMenuElementsByConditions($item['hijos']);					

							if (!empty($arrayMenuPadre)) {
								echo '<li id="primerNivel" class="current" style="cursor:pointer;"><a>'.$item['nombre'].'</a><ul>';

								foreach ($arrayMenuPadre as $hijo) {
									$cssLinkHijo = $hijo['hijos'] ? ' class="current" ' : ' ';
									$hrfLinkHijo = $hijo['aplicacion'] ? 'aplicacion' : 'url';

									echo '<li><a'.$cssLinkHijo.'href="'.url_for($hijo[$hrfLinkHijo]).'">'.$hijo['nombre'].'</a>';

									if (count($hijo['hijos']) >= 1) {
										$banderahijo = 0;

										foreach ($hijo['hijos'] as $verelmodulo) {
											if (validate_action('listar', $verelmodulo['modulo']) || validate_action('publicar', $verelmodulo['modulo'])) {
												$banderahijo = 1;
											}
										}
										if ($banderahijo == 1) {
											echo '<ul>';
											
											foreach ($hijo['hijos'] as $nieto) {
												if (validate_action('listar', $nieto['modulo']) || validate_action('publicar', $nieto['modulo'])) {
													$hrfLinkNieto = $nieto['aplicacion'] ? 'aplicacion' : 'url';

													echo '<li><a href="'.url_for($nieto[$hrfLinkNieto]).'">'.$nieto['nombre'].'</a></li>';
												}
											}
											echo '</ul>';
										}
									}
									echo '</li>';
								}
								echo '</ul></li>';
							}
						}
					}
				}
			?>
			</ul>
		</div>
	</div>
</div>