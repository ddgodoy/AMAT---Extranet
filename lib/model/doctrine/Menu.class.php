<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Menu extends BaseMenu
{
	public function __toString()
	{
		return $this->nombre;
	}
	
	public static function getRepository()
	{
		return Doctrine::getTable(__CLASS__);
	}

	public static function Cantidadelemetos($idElemento)
	{
		$id_padre = MenuTable::getIdpadre($idElemento);

		$cantidadElementos = MenuTable::getMenuPadre($id_padre->getPadreId())->count();

		return $cantidadElementos;
	}
	
	public static function SetPosicionactual($posicion,$id_padre)
	{
		if (MenuTable::getExistPosicion($posicion,$id_padre)) {
			$MenusposicioIgual = MenuTable::getPosiscionIgualMayor($posicion, $id_padre);
      
			foreach ($MenusposicioIgual as $nombre) {
				$posicionActual = $nombre->getPosicion();
				$posicionActual++;

				$nombre->setPosicion($posicionActual);
				$nombre->save();
			}
			return true;
		}else {
      return true;
		}
	}
	
	public static function EditarPosicion($posicionfutura, $idpadre, $idelemento)
	{
		$elemtoAeditar  = MenuTable::getIdpadre($idelemento);
		$posicionActual = $elemtoAeditar->getPosicion();
		$elementoAcambiar = MenuTable::getPosiscionIgual($posicionfutura, $idpadre);

		$elementoAcambiar->setPosicion($posicionActual);
		$elementoAcambiar->save();
	
	  return true;
	}
	
	public static function SetPosicionAeliminar($posicion,$id_padre)
	{
		if (MenuTable::getExistPosicion($posicion,$id_padre)) {
			$MenusposicioIgual = MenuTable::getPosiscionIgualMayor($posicion,$id_padre);
      
			foreach ($MenusposicioIgual as $nombre) {
				$posicionActual = $nombre->getPosicion();
				$posicionActual--;

				$nombre->setPosicion($posicionActual);
				$nombre->save();
			}
			return true;
		} else {
      return true;
		}
	}

} // end class