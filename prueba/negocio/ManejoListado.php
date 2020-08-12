<?php
    /**
     * Importe de clases
     */
    require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/persistencia/util/Conexion.php';
    require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/persistencia/ListadoDAO.php';

    class ManejoListado{


    /**
     * Atributo para la conexión a la base de datos
     */
        private static $conexionBD;

        function __construct(){

        }

    /**
     * Obtiene un listado
    * @param  [int] $codigo [Código del listado a buscar]
    * @return [Listado] Listado encontrado
    */
    public static function buscarListado($codigo){

        $listadoDAO=ListadoDAO::obtenerListadoDAO(self::$conexionBD);
        $listado=$listadoDAO->consultar($codigo);
        return $listado;

    }


    /**
     * Crea un nuevo listado 
     * @param Listado Listado a ingresar
     * @return void
     */
        public static function crearListado($listado){
            $listadoDAO=ListadoDAO::obtenerListadoDAO(self::$conexionBD);
            $listadoDAO->crear($listado);

        }
        
        /**
         * Lista todos los listados  
         * @return Listado[] Lista de todos los listados de la base de datos
         */
        public  static function listarListados(){
            $listadoDAO=ListadoDAO::obtenerListadoDAO(self::$conexionBD);
            $listados=$listadoDAO->listarTodo();
            return $listados;
        }  
         /**
        * Lista todos los listados  
        * @return Listado[] Lista de todos los listados de la base de datos
        */
       public  static function listarProductosPorListado($codigo){
           $listadoDAO=ListadoDAO::obtenerListadoDAO(self::$conexionBD);
           $listados=$listadoDAO->listarProductosPorListado($codigo);
           return $listados;
       }
    
    /**
     * Cambia la conexión 
     */
        public static function setConexionBD($conexionBD)
            {
                self::$conexionBD = $conexionBD;
            }

    }

    ?>