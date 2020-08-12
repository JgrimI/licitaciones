<?php
/*
clase que representa a la entidad Licitacion
*/
class Licitacion{
//-------------------------
//Atributos
//-------------------------


/*
Representa el código de la licitacion
*/
private $cod_licitacion;
/*
Representa el nombre de la licitacion
*/
private $nom_licitacion;
/*
Representa el código de identificaicon de la comprador de la licitacion
*/
private $cod_comprador;
/*
Representa el código de identificacion de la tipo de licitacion
*/
private $fecha_cierre;
/*
Representa la pais de la licitacion
*/
private $pais;
/*
Representa la categoria de la licitacion
*/
private $categoria;
/*
Representa la descripcion de la licitacion
*/
private $descripcion;

//----------------------------
//Constructor
//----------------------------


/**
 * @param [String]cod_licitacion : Código de la licitacion
 * @param [String]nom_licitacion : Nombre de la licitacion
 * @param [integer]cod_comprador : Código de la comprador de la licitacion
 * @param [datetime]fecha_cierre : Código de la tipo de la licitacion
 * @param [String]pais : Pais de la licitacion
 * @param [String]categoria : Categoria de la licitacion
 * @param [String]descripcion : Descripcion de la licitacion
 */

public function __construct(){

}
 /**
  * Método para obtener el código de la licitacion
  * @return [String] código licitacion
  */
public function getCodLicitacion(){
	return 	$this->cod_licitacion;
}

/**
 * Método para cambiar el código de la licitacion
 * @param [String] código licitacion
 */
public function setCodLicitacion($cod_licitacion){
	$this->cod_licitacion=$cod_licitacion;
	return $this;
}

/**
 * Método para obtener el nombre de la licitacion
 * @return [String] nombre de la licitacion
 */
public function getNomLicitacion(){
	return $this->nom_licitacion;
}

/**
 * Método para cambiar el nombre de la licitacion
* @param [String] nombre de la licitacion
 */
public function setNomLicitacion($nom_licitacion){
	$this->nom_licitacion=$nom_licitacion;
	return $this;
}

 /**
 * Método para obtener el código del comprador de la licitacion
  * @return [Integer] código del comprador
  */
  public function getCodComprador(){
	return 	$this->cod_comprador;

}

/**
 * Método para obtener el código de la comprador de la licitacion
 * @param [integer]código del comprador de la licitacion
 */
public function setCodComprador($cod_comprador){
	$this->cod_comprador=$cod_comprador;
	return $this;
}

 /**
  * Método para obtener el código de la tipo de la licitacion
  * @return [Integer] código de la tipo de la licitacion
  */
  public function getFechaCierre(){
	return 	$this->fecha_cierre;

}

/**
  * Método para cambiar el código de la tipo de la licitacion
 * @param [Integer] código de la tipo de la licitacion
 */
public function setFechaCierre($fecha_cierre){
	$this->fecha_cierre=$fecha_cierre;
	return $this;
}

/**
 * Método para obtener la pais de la licitacion
 * @return [String] pais de la licitacion
 */
public function getPais(){
	return $this->pais;
}

/**
 * Método para cambiar la pais de la licitacion
* @param [String] nombre de la licitacion
 */
public function setPais($pais){
	$this->pais=$pais;
	return $this;
}

/**
 * Método para obtener la categoria de la licitacion
 * @return [Decimal] categoria de la licitacion
 */
public function getCategoria(){
	return $this->categoria;
}

/**
 * Método para cambiar la categoria de la licitacion
* @param [Decimal] categoria de la licitacion
 */
public function setCategoria($categoria){
	$this->categoria=$categoria;
	return $this;
}
/**
 * Método para obtener la descripcion de la licitacion
 * @return [Decimal] descripcion de la licitacion
 */
public function getDescripcion(){
	return $this->descripcion;
}

/**
 * Método para cambiar la descripcion de la licitacion
* @param [Decimal] descripcion de la licitacion
 */
public function setDescripcion($descripcion){
	$this->descripcion=$descripcion;
	return $this;
}



}
 ?>
