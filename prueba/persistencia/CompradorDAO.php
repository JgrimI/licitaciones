<?php
/**
 * Archivo de conexión a la base de datos
 */
require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/persistencia/util/Conexion.php';

/**
 * Archivo de entidad
 */

require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/negocio/Comprador.php';

/**
 * Interfaz DAO
 */
require_once('DAO.php');

/**
 * Dao para los compradores
 */
class CompradorDAO implements DAO
{
	/**
	 * Conexión a la base de datos
	 * @var [Object]
	 */
	private $conexion;

	/**
	 * Objeto de la clase compradorDAO
	 * @var [compradorDAO]
	 */
	private static $compradorDAO;


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
	 * @return [comprador]         comprador encontrado
	 */
	public function consultar($codigo){
		$sentencia="SELECT * FROM comprador WHERE cod_comprador=".$codigo;
		if(!$result=mysqli_query($this->conexion,$sentencia))die();
			$row=mysqli_fetch_array($result);
			$comprador=new Comprador();
			$comprador->setNomComprador($row["nom_comprador"]);
			$comprador->setCodOrganismo($row["cod_organismo"]);
			$comprador->setNomOrganismo($row["nom_organismo"]);
			return $comprador;

	}

	/**
	 * Lista todos los objetos que se están en la tabla de comprador
	 * @return [compradores]
	 */
	public function listarTodo(){
		$sentencia="SELECT * FROM comprador";
		if(!$result = mysqli_query($this->conexion, $sentencia)) die();
		$compradores = array();

		while ($row = mysqli_fetch_array($result)) {
			$comprador=new Comprador();

			$comprador->setCodComprador($row["cod_comprador"]);
			$comprador->setNomComprador($row["nom_comprador"]);
			$comprador->setCodOrganismo($row["cod_organismo"]);
			$comprador->setNomOrganismo($row["nom_organismo"]);


			array_push($compradores,$comprador);
		}
		return $compradores;
	}

	/*
	*Obtiene el objeto de esta clase
	*
	*@param $conexion
	*@return void
	*/
	public static function obtenercompradorDAO($conexion_bd) {
			if(self::$compradorDAO == null) {
				self::$compradorDAO = new compradorDAO($conexion_bd);
			}

			return self::$compradorDAO;
		}

}


?>
