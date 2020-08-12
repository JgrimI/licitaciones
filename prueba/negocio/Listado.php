<?php
/*
clase que representa a la entidad Listado
*/
class Listado{
//-------------------------
//Atributos
//-------------------------


/*
Representa el código de la listado
*/
private $cod_listado;
/*
Representa el nombre de la listado
*/
private $nom_listado;
/*
Representa el código de identificaicon de la listado de la listado
*/
private $cod_organismo;


//----------------------------
//Constructor
//----------------------------


/**
 * @param [Integer]cod_listado : Código de la listado
 * @param [Integer]nom_listado : Nombre de la listado
 * @param [Itteger]cod_listado : Código de la listado de la listado
 */

public function __construct(){

}
 /**
  * Método para obtener el código de la listado
  * @return [String] código listado
  */
public function getCodListado(){
	return 	$this->cod_listado;
}

/**
 * Método para cambiar el código de la listado
 * @param [String] código listado
 */
public function setCodListado($cod_listado){
	$this->cod_listado=$cod_listado;
	return $this;
}

/**
 * Método para obtener el nombre de la listado
 * @return [String] nombre de la listado
 */
public function getCodLicitacion(){
	return $this->nom_listado;
}

/**
 * Método para cambiar el nombre de la listado
* @param [String] nombre de la listado
 */
public function setCodLicitacion($nom_listado){
	$this->nom_listado=$nom_listado;
	return $this;
}

 /**
 * Método para obtener el código del listado de la listado
  * @return [Integer] código del listado
  */
  public function getCantidad(){
	return 	$this->cod_organismo;

}

/**
 * Método para obtener el código de la listado de la listado
 * @param [integer]código del listado de la listado
 */
public function setCantidad($cod_organismo){
	$this->cod_organismo=$cod_organismo;
	return $this;
}


}
 ?>
