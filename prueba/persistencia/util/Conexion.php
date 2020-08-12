<?php
	/**
	 * Clase que realiza la conexión a la base de datos
	 */
	class Conexion {

		/**
		 * Conecta con la base de datos
		 * @return Object $conexion Devuelve un objeto para conectar con la base de datos en caso de éxito y false en caso de error
		 */
		public function conectarBD(){
		
			$server = "remotemysql.com";
			$user = "6la5b2l945";
			$pass = "zppS1PyDVy";

			$bd = "6la5b2l945";
			$port = "3306";
			$conexion = mysqli_connect($server, $user, $pass,$bd,$port) 
			or die("Ha sucedido un error inesperado en la conexion de la base de datos");
			$conexion->set_charset("utf8");
		
			return $conexion;
		}

		/**
		 * Cierra la conexión a la base de datos
		 * @param  Object $conexion Conexión a la base de datos
		 * @return boolean $cerrar Devuelve true en caso de éxito y false en caso de error
		 */
		public function desconectarBD($conexion){

			$cerrar = mysqli_close($conexion)
			or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

			return $cerrar;
		}
	}
?>
