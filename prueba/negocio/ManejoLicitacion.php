<?php
    /**
     * Importe de clases
     */
    require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/persistencia/util/Conexion.php';
    require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/persistencia/LicitacionDAO.php';

    class ManejoLicitacion{


    /**
     * Atributo para la conexión a la base de datos
     */
        private static $conexionBD;

        function __construct(){

        }

    /**
     * Obtiene un licitacion
    * @param  [int] $codigo [Código del licitacion a buscar]
    * @return [Licitacion] Licitacion encontrado
    */
    public static function buscarLicitacion($codigo){

        $licitacionDAO=LicitacionDAO::obtenerLicitacionDAO(self::$conexionBD);
        $licitacion=$licitacionDAO->consultar($codigo);
        return $licitacion;

    }


    /**
     * Crea un nuevo licitacion 
     * @param Licitacion Licitacion a ingresar
     * @return void
     */
        public static function crearLicitacion($licitacion){
            $licitacionDAO=LicitacionDAO::obtenerLicitacionDAO(self::$conexionBD);
            $licitacionDAO->crear($licitacion);

        }

        /**
         * Lista todos los licitacions  
         * @return Licitacion[] Lista de todos los licitacions de la base de datos
         */
        public  static function listarLicitacions(){
            $licitacionDAO=LicitacionDAO::obtenerLicitacionDAO(self::$conexionBD);
            $licitacions=$licitacionDAO->listarTodo();
            return $licitacions;
        }
         /**
         * Lista todos los licitacions  
         * @return Licitacion[] Lista de todos los licitacions de la base de datos
         */
        public  static function listarPorNombreDado($nombre){
            $licitacionDAO=LicitacionDAO::obtenerLicitacionDAO(self::$conexionBD);
            $licitacions=$licitacionDAO->listarLicitacionesPorNombreDado($nombre);
            return $licitacions;
        }
         /**
         * Lista todos los licitacions  
         * @return Licitacion[] Lista de todos los licitacions de la base de datos
         */
        public  static function listarPorCategoriaDada($codigo){
            $licitacionDAO=LicitacionDAO::obtenerLicitacionDAO(self::$conexionBD);
            $licitacions=$licitacionDAO->listarLicitacionesPorCategoriaDada($codigo);
            return $licitacions;
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