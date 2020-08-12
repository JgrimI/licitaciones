<?php
/**
 * Archivo de conexión a la base de datos
 */
require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/persistencia/util/Conexion.php';

/**
 * Archivo de entidad
 */
require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/negocio/Licitacion.php';

/**
 * Interfaz DAO
 */
require_once('DAO.php');

/**
 * Dao para los licitacions
 */
class LicitacionDAO implements DAO
{
	/**
	 * Conexión a la base de datos
	 * @var [Object]
	 */
	private $conexion;

	/**
	 * Objeto de la clase licitacionDAO
	 * @var [licitacionDAO]
	 */
	private static $licitacionDAO;


	/**
	 * Constructor de la clase
	 */

	private function __construct($conexion)
	{
		$this->conexion=$conexion;
		mysqli_set_charset($this->conexion, "utf8");
	}


	/**
	 * Crea una nuevo licitacion en la base de datos
	 * @param  Licitacion $licitacionNuevo
	 * @return void
	 */
	public function crear ($licitacionNuevo){
		// orden de insercion cedula, nombre, email, contaseña, tarjeta, estado, puntos, intentos
		$sentencia="INSERT INTO licitacion 
		VALUES('".$licitacionNuevo->getCodLicitacion()."','".$licitacionNuevo->getNomLicitacion()."',".$licitacionNuevo->getCodComprador().",'".$licitacionNuevo->getFechaCierre()."','".$licitacionNuevo->getCategoria()."','".$licitacionNuevo->getDescripcion()."')";
		mysqli_query($this->conexion, $sentencia);

	}

	/**
	 * Realiza la consulta de un objeto
	 * @param  [int] $codigo [Código del objeto a consultar]
	 * @return [licitacion]         licitacion encontrado
	 */
	public function consultar($codigo){
		$sentencia="SELECT * FROM licitacion WHERE cod_licitacion='".$codigo."'";
		if(!$result=mysqli_query($this->conexion,$sentencia))die();
			$row=mysqli_fetch_array($result);
			$licitacion=new Licitacion();
			$licitacion->setNomLicitacion($row["nom_licitacion"]);
			$licitacion->setCodComprador($row["cod_comprador"]);
			$licitacion->setFechaCierre($row["fecha_cierre"]);
			$licitacion->setPais($row["pais"]);
			$licitacion->setCategoria($row["categoria"]);
			$licitacion->setDescripcion($row["descripcion"]);

			return $licitacion;

	}



	/**
	 * Lista todos los objetos que se están en la tabla de licitacion
	 * @return [licitaciones]
	 */
	public function listarTodo(){
		$sentencia="SELECT * FROM licitacion";
		if(!$result = mysqli_query($this->conexion, $sentencia)) die();
		$licitacions = array();

		while ($row = mysqli_fetch_array($result)) {
			$licitacion=new Licitacion();
			$licitacion->setCodLicitacion($row["cod_licitacion"]);
			$licitacion->setNomLicitacion($row["nom_licitacion"]);
			$licitacion->setCodComprador($row["cod_comprador"]);
			$licitacion->setFechaCierre($row["fecha_cierre"]);
			$licitacion->setPais($row["pais"]);
			$licitacion->setCategoria($row["cod_categoria"]);
			$licitacion->setDescripcion($row["descripcion"]);
			array_push($licitacions,$licitacion);
		}
		return $licitacions;
	}

	/*
	*Obtiene el objeto de esta clase
	*
	*@param $conexion
	*@return void
	*/
	public static function obtenerlicitacionDAO($conexion_bd) {
			if(self::$licitacionDAO == null) {
				self::$licitacionDAO = new licitacionDAO($conexion_bd);
			}

			return self::$licitacionDAO;
		}

}


?>
