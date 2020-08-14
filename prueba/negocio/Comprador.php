<?php
/*
clase que representa a la entidad Comprador
*/
class Comprador{
//-------------------------
//Atributos
//-------------------------


/*
Representa el código de la comprador
*/
private $cod_comprador;
/*
Representa el nombre de la comprador
*/
private $nom_comprador;
/*
Representa el código de identificacion de la tipo de comprador
*/
private $nom_organismo;


//----------------------------
//Constructor
//----------------------------


/**
 * @param [String]cod_comprador : Código de la comprador
 * @param [String]nom_comprador : Nombre de la comprador
 * @param [String]nom_organismo : Nombre del organismo del comprador
 */

public function __construct(){

}
 /**
  * Método para obtener el código de la comprador
  * @return [String] código comprador
  */
public function getCodComprador(){
	return 	$this->cod_comprador;
}

/**
 * Método para cambiar el código de la comprador
 * @param [String] código comprador
 */
public function setCodComprador($cod_comprador){
	$this->cod_comprador=$cod_comprador;
	return $this;
}

/**
 * Método para obtener el nombre de la comprador
 * @return [String] nombre de la comprador
 */
public function getNomComprador(){
	return $this->nom_comprador;
}

/**
 * Método para cambiar el nombre de la comprador
* @param [String] nombre de la comprador
 */
public function setNomComprador($nom_comprador){
	$this->nom_comprador=$nom_comprador;
	return $this;
}

 /**
  * Método para obtener el código de la tipo de la comprador
  * @return [Integer] código de la tipo de la comprador
  */
  public function getNomOrganismo(){
	return 	$this->nom_organismo;

}

/**
  * Método para cambiar el código de la tipo de la comprador
 * @param [Integer] código de la tipo de la comprador
 */
public function setNomOrganismo($nom_organismo){
	$this->nom_organismo=$nom_organismo;
	return $this;
}



}
 ?>
