<?php

if(isset( $_GET["cod"]))
    {
        $cod = $_GET["cod"];
               $url="http://api.mercadopublico.cl/servicios/v1/publico/licitaciones.json?codigo=$cod&ticket=83D4D082-755A-41DC-8B28-1DDA010F765E";
           
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);  
                $data=json_decode($result);
    }
   
    else{
       ?>
        <script>
            location.href = "/prueba/licitaciones.php";
        </script>
       <?php
    }
?>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
table {
  border-collapse: collapse;
  margin-left:auto;margin-right:auto;
}

th, td {
  text-align: left;
  padding: 8px;
}

td:nth-child(even) {background-color: #f2f2f2;}
</style>

<table >
    
            <?php
           if (count($data->Listado)) {
               
            foreach ($data->Listado as $idx => $listado) {
                if($listado->Descripcion==Null){
                    $listado->Descripcion="N/A";
                }
                if($listado->Estado==Null){
                    $listado->Estado="N/A";
                }
                if($listado->Moneda==Null){
                    $listado->Moneda="N/A";
                }
                if($listado->CantidadReclamos==Null){
                    $listado->CantidadReclamos="N/A";
                }
                if($listado->NombreResponsablePago==Null){
                    $listado->NombreResponsablePago="N/A";
                }
                if($listado->EmailResponsablePago==Null){
                    $listado->EmailResponsablePago="N/A";
                }
                if($listado->NombreResponsableContrato==Null){
                    $listado->NombreResponsableContrato="N/A";
                }
                if($listado->EmailResponsableContrato==Null){
                    $listado->EmailResponsableContrato="N/A";
                }
                echo "<th colspan=2 style='background-color: grey;'><center>Licitación</center></th>";
                echo "
                <tr>
                <th><center>Código</center></th>
                <td><center>$listado->CodigoExterno</center></td>
                </tr>
                <tr>
                <th><center>Nombre</center></th>
                <td><center>$listado->Nombre</center></td>
                </tr> <tr>
                <th><center>Descioción</center></th>
                <td><center>$listado->Descripcion</center></th>
                </tr> <tr>
                <th><center>Estado</center></th>
                <td><center>$listado->Estado</center></td>
                </tr> <tr>
                <th><center>Moneda</center></th>
                <td><center>$listado->Moneda</center></td>
                </tr> <tr>
                <th><center>Cantidad de Reclamos</center></th>
                <td><center>$listado->CantidadReclamos</center></td>
                </tr> <tr>
                <th><center>Responsable de pago</center></th>
                <td><center>$listado->NombreResponsablePago</center></td>
                </tr> <tr>
                <th><center>Email Responsable de pago</center></th>
                <td><center>$listado->EmailResponsablePago</center></td>
                </tr> <tr>
                <th><center>Responsable de contrato</center></th>
                <td><center>$listado->NombreResponsableContrato</center></td>
                </tr> <tr>
                <th><center>Email Responsable de contrato</center></th>
                <td><center>$listado->EmailResponsableContrato</center></td>
                </tr>";
                foreach ($listado as $key => $value) {
                    if($key=="Comprador" && $value!=null){
                        if($value->NombreOrganismo==null){
                            $value->NombreOrganismo="N/A";
                        }
                        if($value->DireccionUnidad==null){
                            $value->DireccionUnidad="N/A";
                        }
                        if($value->NombreUsuario==null){
                            $value->NombreUsuario="N/A";
                        }
                        if($value->CargoUsuario==null){
                            $value->CargoUsuario="N/A";
                        }
                       echo "<th colspan=2 style='background-color: grey;'><center>Comprador</center></th>";
                       echo "
                       <tr>
                       <th><center>Nombre</center></th>
                       <td><center>$value->NombreOrganismo</center></td>
                       </tr>
                       <tr>
                       <th><center>Dirección</center></th>
                       <td><center>$value->DireccionUnidad</center></td>
                       </tr> <tr>
                       <th><center>Usuario</center></th>
                       <td><center>$value->NombreUsuario</center></td>
                       </tr> <tr>
                       <th><center>Cargo</center></th>
                       <td><center>$value->CargoUsuario</center></td>
                       </tr>";
                        echo "</tbody>";
                    
                    }
                    if($key=="Fechas" && $value!=null){
                       if($value->FechaCreacion==null){
                            $value->FechaCreacion="N/A";
                        }
                        if($value->FechaCierre==null){
                            $value->FechaCierre="N/A";
                        }
                        if($value->FechaPublicacion==null){
                            $value->FechaPublicacion="N/A";
                        }
                        if($value->FechaAdjudicacion==null){
                            $value->FechaAdjudicacion="N/A";
                        }
                        echo "<th colspan=2 style='background-color: grey;'><center>Fechas</center></th>";
                        echo "
                        <tr>
                        <th><center>Creación</center></th>
                        <td><center>$value->FechaCreacion</center></td>
                        </tr>
                        <tr>
                        <th><center>Cierre</center></th>
                        <td><center>$value->FechaCierre</center></td>
                        </tr> <tr>
                        <th><center>Publicación</center></th>
                        <td><center>$value->FechaPublicacion</center></td>
                        </tr> <tr>
                        <th><center>Adjudicación</center></th>
                        <td><center>$value->FechaAdjudicacion</center></td>
                        </tr>";
                         echo "</tbody>";
                     }
                     if($key=="Adjudicacion" && $value!=null){
                        
                        if($value->NumeroOferentes==null){
                            $value->NumeroOferentes="N/A";
                        }
                        if($value->UrlActa==null){
                            $value->UrlActa="N/A";
                        }
                        echo "<th colspan=2 style='background-color: grey;'><center>Adjudicacion</center></th>";
                        echo "
                        <tr>
                        </tr>
                        <tr>
                        <th><center>Número Oferentes</center></th>
                        <td><center>$value->NumeroOferentes</center></td>
                        </tr> <tr>
                        <th><center>Acta</center></th>
                        <td><center><a href='$value->UrlActa' target='_blank'>Ver acta</a></center></td>
                        </tr>";
                         echo "</tbody>";
                     }
                     if($key=="Items" && $value!=null){
                        
                        if($value->Cantidad==null){
                            $value->Cantidad="N/A";
                        }
                        echo "<th colspan=2 style='background-color: grey;'><center>Items</center></th>	";
                        echo "<tr>
                            <th><center>Cantidad de Productos</center></th>	
                            <td><center>$value->Cantidad</center></td>	
                            </tr>";
                         echo "</tbody>";
                     foreach ($value->Listado as $key => $value) {
                         
                        if($value->NombreProducto==null){
                            $value->NombreProducto="N/A";
                        }
                        if($value->Categoria==null){
                            $value->Categoria="N/A";
                        }
                        if($value->UnidadMedida==null){
                            $value->UnidadMedida="N/A";
                        }
                        if($value->Cantidad==null){
                            $value->Cantidad="N/A";
                        }
                        echo "
                        <tr>
                        </tr> <tr>
                        <th style='background-color: #9d9d9d;;'><center>Producto</center></th>
                        <td style='background-color: #9d9d9d;;'><center>$value->NombreProducto</center></td>
                        </tr> <tr>
                        <th><center>Categoria</center></th>
                        <td><center>$value->Categoria</center></td>
                        </tr> <tr>
                        <th><center>Unidad Medida</center></th>
                        <td><center>$value->UnidadMedida</center></td>
                        </tr> <tr>
                        <th><center>Cantidad</center></th>
                        <td><center>$value->Cantidad</center></td>
                        
                        </tr> <tr></tr>";
                     echo "</tbody>";
                      
                         }
                         
                     }
                }
            }
            
    
        }else{
            ?>
             <script>
                 location.href = "/prueba/licitaciones.php";
             </script>
            <?php
         }
        ?>
</table>



