<?php 
    require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/persistencia/util/Conexion.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/negocio/ManejoLicitacion.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/negocio/ManejoComprador.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/negocio/ManejoListado.php';
if(!empty($_GET['cod'])){ 
    
    $cod = $_GET["cod"];
    $obj=new Conexion();
    $conexion=$obj->conectarBD();

    ManejoLicitacion::setConexionBD($conexion);
    $lici= ManejoLicitacion::buscarLicitacion($cod);
    ManejoComprador::setConexionBD($conexion);
    $comprador= ManejoComprador::buscarComprador($lici->getCodComprador());
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
    </style>";
    if ($_GET['pais']=="Chile") {
        echo "
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
                <th colspan=2 style='background-color: grey;'><center>Comprador</center></th>
                </tr> <tr>
                <th class='thD'><center>Nombre del comprador</center></th>
                <td class='tdD'><center>".$comprador->getNomComprador()."</center></td>
                </tr> <tr>
                <th class='thD'><center>Nombre de la entidad</center></th>
                <td class='tdD'><center>".$comprador->getNomOrganismo()."</center></td>
                </tr> <tr>
            </tbody>
           </table> ";
    } 

    if ($_GET['pais']=="Colombia") {
        echo "
        <table class='tableD'>
        <tbody>
                <th colspan=2 style='background-color: grey;'><center>Licitación</center></th>
                <tr>
                <th class='thD'><center>Código</center></th>
                <td class='tdD'><center>".$cod."</center></td>
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
                <th colspan=2 style='background-color: grey;'><center>Comprador</center></th>
                </tr> <tr>
                <th class='thD'><center>Nombre del comprador</center></th>
                <td class='tdD'><center>".$comprador->getNomComprador()."</center></td>
                </tr> <tr>
                <th class='thD'><center>Nombre de la entidad</center></th>
                <td class='tdD'><center>".$comprador->getNomOrganismo()."</center></td>
                </tr> <tr>
            </tbody>
           </table> ";
    }

}else{ 
    echo 'Contenido no encontrado....'; 
} 
?>