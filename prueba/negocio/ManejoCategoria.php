<?php
    /**
     * Importe de clases
     */
    require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/persistencia/util/Conexion.php';
    require_once ($_SERVER["DOCUMENT_ROOT"]).'/prueba/persistencia/CategoriaDAO.php';

    class ManejoCategoria{


    /**
     * Atributo para la conexión a la base de datos
     */
        private static $conexionBD;

        function __construct(){

        }

    /**
     * Obtiene un categoria
    * @param  [int] $codigo [Código del categoria a buscar]
    * @return [Categoria] Categoria encontrado
    */
    public static function buscarCategoria($codigo){

        $categoriaDAO=CategoriaDAO::obtenerCategoriaDAO(self::$conexionBD);
        $categoria=$categoriaDAO->consultar($codigo);
        return $categoria;

    }


    /**
     * Crea un nuevo categoria 
     * @param Categoria Categoria a ingresar
     * @return void
     */
        public static function crearCategoria($categoria){
            $categoriaDAO=CategoriaDAO::obtenerCategoriaDAO(self::$conexionBD);
            $categoriaDAO->crear($categoria);

        }
        
        /**
         * Lista todos los categorias  
         * @return Categoria[] Lista de todos los categorias de la base de datos
         */
        public  static function listarCategorias(){
            $categoriaDAO=CategoriaDAO::obtenerCategoriaDAO(self::$conexionBD);
            $categorias=$categoriaDAO->listarTodo();
            return $categorias;
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