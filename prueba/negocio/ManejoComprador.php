<?php
    /**
     * Importe de clases
     */
    require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/persistencia/util/Conexion.php';
    require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/persistencia/CompradorDAO.php';

    class ManejoComprador{


    /**
     * Atributo para la conexión a la base de datos
     */
        private static $conexionBD;

        function __construct(){

        }

    /**
     * Obtiene un comprador
    * @param  [int] $codigo [Código del comprador a buscar]
    * @return [Comprador] Comprador encontrado
    */
    public static function buscarComprador($codigo){

        $compradorDAO=CompradorDAO::obtenerCompradorDAO(self::$conexionBD);
        $comprador=$compradorDAO->consultar($codigo);
        return $comprador;

    }


    /**
     * Crea un nuevo comprador 
     * @param Comprador Comprador a ingresar
     * @return void
     */
        public static function crearComprador($comprador){
            $compradorDAO=CompradorDAO::obtenerCompradorDAO(self::$conexionBD);
            $compradorDAO->crear($comprador);

        }
        
        /**
         * Lista todos los compradors  
         * @return Comprador[] Lista de todos los compradors de la base de datos
         */
        public  static function listarCompradors(){
            $compradorDAO=CompradorDAO::obtenerCompradorDAO(self::$conexionBD);
            $compradors=$compradorDAO->listarTodo();
            return $compradors;
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