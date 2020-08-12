<?php
/**
 * Archivo de conexión a la base de datos
 */
require_once('../persistencia/util/Conexion.php');

/**
 * Archivo de entidad
 */
require_once('../negocio/DetalleListado.php');

/**
 * Interfaz DAO
 */
require_once('DAO.php');

/**
 * Dao para los detallelistadoes
 */
class DetalleListadoDAO implements DAO
{
	/**
	 * Conexión a la base de datos
	 * @var [Object]
	 */
	private $conexion;

	/**
	 * Objeto de la clase detallelistadoDAO
	 * @var [detallelistadoDAO]
	 */
	private static $detallelistadoDAO;


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
	 * @return [detallelistado]         detallelistado encontrado
	 */
	public function consultar($codigo){
		$sentencia="SELECT * FROM COMPRADOR WHERE cod_detallelistado=".$codigo;
		if(!$result=mysqli_query($this->conexion,$sentencia))die();
			$row=mysqli_fetch_array($result);
			$detallelistado=new DetalleListado();
			$detallelistado->setCodListado($row["cod_listado"]);
			$detallelistado->setCodOrganismo($row["cod_producto"]);
			$detallelistado->setNomOrganismo($row["cantidad"]);
			return $detallelistado;

	}

	/**
	 * Lista todos los objetos que se están en la tabla de detallelistado
	 * @return [detallelistadoes]
	 */
	public function listarTodo(){
		$sentencia="SELECT * FROM COMPRADOR";
		if(!$result = mysqli_query($this->conexion, $sentencia)) die();
		$detallelistados = array();

		while ($row = mysqli_fetch_array($result)) {
			$detallelistado=new DetalleListado();

			$detallelistado->setCodDetalleListado($row["cod_detallelistado"]);
			$detallelistado->setNomDetalleListado($row["nom_detallelistado"]);
			$detallelistado->setCodOrganismo($row["cod_organismo"]);
			$detallelistado->setNomOrganismo($row["nom_organismo"]);


			array_push($detallelistados,$detallelistado);
		}
		return $detallelistados;
	}

	/*
	*Obtiene el objeto de esta clase
	*
	*@param $conexion
	*@return void
	*/
	public static function obtenerdetallelistadoDAO($conexion_bd) {
			if(self::$detallelistadoDAO == null) {
				self::$detallelistadoDAO = new detallelistadoDAO($conexion_bd);
			}

			return self::$detallelistadoDAO;
		}

}


?>
