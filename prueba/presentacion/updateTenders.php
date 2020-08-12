<?php


        //Conexion a la base de datos
        $server = "remotemysql.com";
        $user = "6la5b2l945";
        $pass = "zppS1PyDVy";

        $bd = "6la5b2l945";
        $port = "3306";
    
        $conexion = mysqli_connect($server, $user, $pass,$bd,$port) 
        or die("Ha sucedido un error inesperado en la conexion de la base de datos");
        $conexion->set_charset("utf8");
    
        //Licitaciones Chile 
        //URL obtiene todas las licitaciones del dia actual
        $json = file_get_contents("http://api.mercadopublico.cl/servicios/v1/publico/licitaciones.json?ticket=83D4D082-755A-41DC-8B28-1DDA010F765E");
        $data=json_decode($json);
        foreach ($data->Listado as $idx => $listado) {
            $lic = mysqli_query($conexion, "SELECT * FROM licitacion WHERE cod_licitacion='$listado->CodigoExterno'");
            if (mysqli_num_rows($lic) == 0) {
                sleep(2);
                $url="http://api.mercadopublico.cl/servicios/v1/publico/licitaciones.json?codigo=$listado->CodigoExterno&ticket=83D4D082-755A-41DC-8B28-1DDA010F765E";
           
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);
       
                $data=json_decode($result);
                $data1=json_decode($result, true);
           
                if (count($data1)<3) {
                 echo "ds";
                } else {
                    foreach ($data->Listado as $idx2 => $listado2) {
              
                        $compra = mysqli_query($conexion, "SELECT * FROM comprador WHERE cod_comprador=".$listado2->Comprador->CodigoUsuario);
              
                        if (mysqli_num_rows($compra) == 0) {
              
                            $sql = "INSERT INTO comprador (cod_comprador,nom_comprador,cod_organismo,nom_organismo) VALUES (".$listado2->Comprador->CodigoUsuario.",'".$listado2->Comprador->NombreUsuario."', ".$listado2->Comprador->CodigoOrganismo.", '".$listado2->Comprador->NombreOrganismo."')";
                            $insert = mysqli_query($conexion, $sql);
                       
                            if ($insert) {
                                echo "Se agregaron comprador<br>";
                            } else {
                                echo $sql;
                                echo "f<br>";
                            }
                        }
              
                        $lic = mysqli_query($conexion, "SELECT * FROM licitacion WHERE cod_licitacion='$listado2->CodigoExterno'");
              
                        if (mysqli_num_rows($lic) == 0) {
              
                            echo '<br>';
                            $fecha =$listado2->Fechas->FechaCierre;
                            $sql = "INSERT INTO licitacion (cod_licitacion,nom_licitacion,cod_comprador, fecha_cierre,pais,cod_categoria,descripcion) VALUES ('$listado2->CodigoExterno','$listado2->Nombre',".$listado2->Comprador->CodigoUsuario.", '$fecha', 'Chile',1,'$listado2->Descripcion')";
                            $insert = mysqli_query($conexion, $sql);
                            $sql2 = "INSERT INTO listado (cod_licitacion,cantidad) VALUES ('$listado2->CodigoExterno',".$listado2->Items->Cantidad.")";
                            $insert2 = mysqli_query($conexion, $sql2);
                   
                            if ($insert) {
                                echo "Se agregaro licitacion<br>";
                            } else {
                                echo $sql;
                       
                                echo "f<br>";
                            }
                            //     $sql = "UPDATE LIC_CHILE SET codigo_estado =$listado2->CodigoEstado WHERE codigo_externo = '$listado2->CodigoExterno'";
                           //     $insert = mysqli_query($conexion, $sql);
                        }
                       
                        $lis = mysqli_query($conexion, "SELECT * FROM listado WHERE cod_licitacion='$listado2->CodigoExterno'");
                 
                        if (mysqli_num_rows($lis) == 1) {
                            $row = mysqli_fetch_array($lis);
                       
                            foreach ($listado2 as $idx3 => $listado3) {
                       
                                if ($idx3=="Items" && $listado3!=null) {
                       
                                    foreach ($listado3->Listado as $key => $value) {
                       
                                        $sql = "INSERT INTO detalle_listado (cod_listado,cod_producto,cantidad)
                                                VALUES (".$row['cod_listado'].",$value->CodigoProducto,".$value->Cantidad.")";
                                        $insert = mysqli_query($conexion, $sql);
                                        $sql2 = "INSERT INTO producto (cod_producto,nom_producto,cod_categoria) 
                                                 VALUES ($value->CodigoProducto,'$value->NombreProducto',$value->CodigoCategoria)";
                                        $insert2 = mysqli_query($conexion, $sql2);
                       
                                        if ($insert) {
                                            echo "Se agregaro listado <br>";
                                        } else {
                                            echo $sql;
                                            echo "f<br>";
                                        }if ($insert2) {
                                            echo "Se agrego p<br>";
                                        } else {
                                            echo $sql2;
                                            echo "f<br>";
                                        }
                                    }
                                }
                            }
                        } else {
                            echo 'ya esta';
                        }
                    }
                }
            }
        }




        //Licitaciones Colombia


