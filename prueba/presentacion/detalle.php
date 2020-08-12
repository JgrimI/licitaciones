<?php 
    require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/persistencia/util/Conexion.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/negocio/ManejoLicitacion.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/negocio/ManejoListado.php';
if(!empty($_GET['cod'])){ 
    if ($_GET['pais']=="Chile") {
        $cod = $_GET["cod"];
        $obj=new Conexion();
        $conexion=$obj->conectarBD();

        ManejoLicitacion::setConexionBD($conexion);
        $lici= ManejoLicitacion::buscarLicitacion($cod);
        ManejoListado::setConexionBD($conexion);
        $prod= ManejoListado::buscarListado($cod);
        $productos= ManejoListado::listarProductosPorListado($prod->getCodListado());

        echo "
        <style>
                .tableD, .thD, .tdD {
                border: 1px solid black;
                border-collapse: collapse;
                }
                .tableD {
                border-collapse: collapse;
                margin-left:auto;margin-right:auto;
                }
                .thD, .tdD {
                text-align: left;
                padding: 8px;
                }

                .tdD:nth-child(even) {background-color: #f2f2f2;}
        </style>
        <table class='tableD'>
        <tbody>
                <th colspan=2 style='background-color: grey;'><center>Licitación</center></th>
                <tr>
                <th class='thD'><center>Código</center></th>
                <td class='tdD'><center>".$cod."</center></td>
                </tr><tr>
                <th class='thD'><center>Nombre</center></th>
                <td class='tdD'><center>".$lici->getNomLicitacion()."</center></td>
                </tr><tr>
                <th class='thD'><center>Descripción</center></th>
                <td class='tdD'><center>".$lici->getDescripcion()."</center></th>
                </tr> <tr>
                <th class='thD'><center>Categoria</center></th>
                <td class='tdD'><center>".$lici->getCategoria()."</center></td>
                </tr> <tr>
                <th class='thD'><center>País</center></th>
                <td class='tdD'><center>".$lici->getPais()."</center></td>
                </tr> <tr>
                <th colspan=2 style='background-color: grey;'><center>Items</center></th>
                </tr> <tr>
                <th class='thD'><center>Cantidad de Productos</center></th>
                <td class='tdD'><center>".$prod->getCantidad()."</center></td>
                </tr> <tr>";
                    $total=0;
                    while ($mostrar=mysqli_fetch_row($productos)) {
                        echo "
                    <th class='thD'><center>".$mostrar[0]."</center></th>
                    <td class='tdD'><center>".$mostrar[1]."</center></td>
                    </tr><tr>";
                        $total+=$mostrar[1];
                    }
                    echo "
                <th class='thD'><center>Cantidad Total</center></th>
                <td class='tdD'><strong><center>".$total."</center></strong></td>
                </tr>
            </tbody>
           </table> ";
    } 

    if ($_GET['pais']=="Colombia") {
        echo "Detalles en proceso... ";
    }

}else{ 
    echo 'Contenido no encontrado....'; 
} 
?>