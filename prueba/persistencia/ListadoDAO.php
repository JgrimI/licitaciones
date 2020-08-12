<?php
/**
 * Archivo de conexión a la base de datos
 */
require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/persistencia/util/Conexion.php';

/**
 * Archivo de entidad
 */
require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/negocio/Listado.php';
/**
 * Interfaz DAO
 */
require_once('DAO.php');

/**
 * Dao para los listadoes
 */
class ListadoDAO implements DAO
{
	/**
	 * Conexión a la base de datos
	 * @var [Object]
	 */
	private $conexion;

	/**
	 * Objeto de la clase listadoDAO
	 * @var [listadoDAO]
	 */
	private static $listadoDAO;


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
	 * @return [listado] listado encontrado
	 */
	public function consultar($codigo){
		$sentencia="SELECT * FROM listado WHERE cod_licitacion='".$codigo."'";
		if(!$result=mysqli_query($this->conexion,$sentencia))die();
			$row=mysqli_fetch_array($result);
			$listado=new Listado();
			$listado->setCodListado($row["cod_listado"]);
			$listado->setCodLicitacion($row["cod_licitacion"]);
			$listado->setCantidad($row["cantidad"]);
			return $listado;

	}
	/**
	 * Realiza la consulta de un objeto
	 * @param  [int] $codigo [Código del objeto a consultar]
	 * @return [listado]    listado encontrado
	 */
	public function listarProductosPorListado($codigo){
		$sentencia="SELECT nom_producto, SUM(detalle_listado.cantidad) AS total
		FROM licitacion, listado, detalle_listado, producto
		WHERE listado.cod_listado = ".$codigo." AND
				licitacion.cod_licitacion = listado.cod_licitacion AND
				listado.cod_listado = detalle_listado.cod_listado AND
				detalle_listado.cod_producto = producto.cod_producto
		GROUP BY nom_producto";
		if(!$result=mysqli_query($this->conexion,$sentencia))die();
			return $result;
	}

	/**
	 * Lista todos los objetos que se están en la tabla de listado
	 * @return [listadoes]
	 */
	public function listarTodo(){
		$sentencia="SELECT * FROM listado";
		if(!$result = mysqli_query($this->conexion, $sentencia)) die();
		$listadoes = array();

		while ($row = mysqli_fetch_array($result)) {
			$listado=new Listado();

			$listado->setCodListado($row["cod_listado"]);
			$listado->setCodLicitacion($row["cod_licitacion"]);
			$listado->setCantidad($row["cantidad"]);

			array_push($listadoes,$listado);
		}
		return $listadoes;
	}

	/*
	*Obtiene el objeto de esta clase
	*
	*@param $conexion
	*@return void
	*/
	public static function obtenerlistadoDAO($conexion_bd) {
			if(self::$listadoDAO == null) {
				self::$listadoDAO = new listadoDAO($conexion_bd);
			}

			return self::$listadoDAO;
		}

}


?>
