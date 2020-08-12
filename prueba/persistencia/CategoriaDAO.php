<?php
/**
 * Archivo de conexión a la base de datos
 */
require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/persistencia/util/Conexion.php';

/**
 * Archivo de entidad
 */

require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/negocio/Categoria.php';

/**
 * Interfaz DAO
 */
require_once('DAO.php');

/**
 * Dao para los categorias
 */
class CategoriaDAO implements DAO
{
	/**
	 * Conexión a la base de datos
	 * @var [Object]
	 */
	private $conexion;

	/**
	 * Objeto de la clase categoriaDAO
	 * @var [categoriaDAO]
	 */
	private static $categoriaDAO;


	/**
	 * Constructor de la clase
	 */

	private function __construct($conexion)
	{
		$this->conexion=$conexion;
		mysqli_set_charset($this->conexion, "utf8");
	}

	/**
	 * Realiza la consulta de un objeto
	 * @param  [int] $codigo [Código del objeto a consultar]
	 * @return [categoria]         categoria encontrado
	 */
	public function consultar($codigo){
		$sentencia="SELECT * FROM categoria WHERE cod_categoria=".$codigo;
		if(!$result=mysqli_query($this->conexion,$sentencia))die();
			$row=mysqli_fetch_array($result);
			$categoria=new Categoria();
			$categoria->setNomCategoria($row["nom_categoria"]);
			$categoria->setKeywordsCategoria($row["keywords_categoria"]);
			return $categoria;

	}

	/**
	 * Lista todos los objetos que se están en la tabla de categoria
	 * @return [categoriaes]
	 */
	public function listarTodo(){
		$sentencia="SELECT * FROM categoria";
		if(!$result = mysqli_query($this->conexion, $sentencia)) die();
		$categoriaes = array();

		while ($row = mysqli_fetch_array($result)) {
			$categoria=new Categoria();

			$categoria->setCodCategoria($row["cod_categoria"]);
			$categoria->setNomCategoria($row["nom_categoria"]);
			$categoria->setKeywordsCategoria($row["keywords_categoria"]);


			array_push($categoriaes,$categoria);
		}
		return $categoriaes;
	}

	/*
	*Obtiene el objeto de esta clase
	*
	*@param $conexion
	*@return void
	*/
	public static function obtenercategoriaDAO($conexion_bd) {
			if(self::$categoriaDAO == null) {
				self::$categoriaDAO = new categoriaDAO($conexion_bd);
			}

			return self::$categoriaDAO;
		}

}


?>
