<?php
/*
clase que representa a la entidad Categoria
*/
class Categoria{
//-------------------------
//Atributos
//-------------------------


/*
Representa el código de la categoria
*/
private $cod_categoria;
/*
Representa el nombre de la categoria
*/
private $nom_categoria;
/*
Representa el nombre de la categoria
*/
private $keywords_categoria;

//----------------------------
//Constructor
//----------------------------


/**
 * @param [String]cod_categoria : Código de la categoria
 * @param [String]nom_categoria : Nombre de la categoria
 * @param [String]keywords_categoria : Keywords de la categoria
 */

public function __construct(){

}
 /**
  * Método para obtener el código de la categoria
  * @return [String] código categoria
  */
public function getCodCategoria(){
	return 	$this->cod_categoria;
}

/**
 * Método para cambiar el código de la categoria
 * @param [String] código categoria
 */
public function setCodCategoria($cod_categoria){
	$this->cod_categoria=$cod_categoria;
	return $this;
}

/**
 * Método para obtener el nombre de la categoria
 * @return [String] nombre de la categoria
 */
public function getNomCategoria(){
	return $this->nom_categoria;
}

/**
 * Método para cambiar el nombre de la categoria
* @param [String] nombre de la categoria
 */
public function setNomCategoria($nom_categoria){
	$this->nom_categoria=$nom_categoria;
	return $this;
}

 /**
 * Método para obtener el código del comprador de la categoria
  * @return [Integer] código del comprador
  */
  public function getKeywordsCategoria(){
	return 	$this->keywords_categoria;

}

/**
 * Método para obtener el código de la comprador de la categoria
 * @param [integer]código del comprador de la categoria
 */
public function setKeywordsCategoria($keywords_categoria){
	$this->keywords_categoria=$keywords_categoria;
	return $this;
}

}
 ?>
