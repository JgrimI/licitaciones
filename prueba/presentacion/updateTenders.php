<?php

set_time_limit(2000);
        //Conexion a la base de datos
        $server = "35.184.25.215";
        $user = "prueba";
        $pass = "1234";

        $bd = "licitaciones";
        $port = "3306";
        $conexion = mysqli_connect($server, $user, $pass,$bd,$port) 
        or die("Ha sucedido un error inesperado en la conexion de la base de datos");
        $conexion->set_charset("utf8");
    
        $conexion = mysqli_connect($server, $user, $pass, $bd, $port)
        or die("Ha sucedido un error inesperado en la conexion de la base de datos");
        $conexion->set_charset("utf8");
    
        //Licitaciones Chile
        //URL obtiene todas las licitaciones del dia actual
        $url = "http://api.mercadopublico.cl/servicios/v1/publico/licitaciones.json?ticket=83D4D082-755A-41DC-8B28-1DDA010F765E";
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data=json_decode($result);
        $data1=json_decode($result, true);
           
        if (count($data1)<3) {
            var_dump($data);
            echo $data1['Mensaje'];
        } else {
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
                        echo $data1['Mensaje'];
                        echo $data->Mensaje;
                    } else {
                        foreach ($data->Listado as $idx2 => $listado2) {
                            $compra = mysqli_query($conexion, "SELECT * FROM comprador WHERE cod_comprador=".$listado2->Comprador->CodigoUsuario);
                            if (mysqli_num_rows($compra) == 0) {
                                $sql = 'INSERT INTO comprador (cod_comprador,nom_comprador,nom_organismo) VALUES ("'.$listado2->Comprador->CodigoUsuario.'","'.$listado2->Comprador->NombreUsuario.'",  "'.$listado2->Comprador->NombreOrganismo.'")';
                                $insert = mysqli_query($conexion, $sql);
                                if ($insert) {
                                } else {
                                    echo $sql;
                                    echo "f<br>";
                                }
                            }
                            $lic = mysqli_query($conexion, "SELECT * FROM licitacion WHERE cod_licitacion='$listado2->CodigoExterno'");
                            if (mysqli_num_rows($lic) == 0) {
                                echo '<br>';
                                $fecha =$listado2->Fechas->FechaCierre;
                                $codCompra=$listado2->Comprador->CodigoUsuario;
                                $codCate=categoria($listado2->Descripcion, $conexion);
                                $listado2->Descripcion=preg_replace('/[\'\\]+/', '"', $listado2->Descripcion);
                                $sql = "INSERT INTO licitacion (cod_licitacion,nom_licitacion,cod_comprador, fecha_cierre,pais,cod_categoria,descripcion) 
                                VALUES ('$listado2->CodigoExterno','$listado2->Nombre','$codCompra', '$fecha', 'Chile',$codCate,'$listado2->Descripcion')";
                                $insert = mysqli_query($conexion, $sql);
                                if ($insert) {
                                } else {
                                    echo $sql;
                                    echo "f<br>";
                                }
                                //     $sql = "UPDATE LIC_CHILE SET codigo_estado =$listado2->CodigoEstado WHERE codigo_externo = '$listado2->CodigoExterno'";
                           //     $insert = mysqli_query($conexion, $sql);
                            } else {
                                echo 'ya esta';
                            }
                        }
                    }
                }
            }
        }
        //Licitaciones Colombia


 //       if ($data->releases[0]->tender->description) {
   //     } else {
       //s     $data->releases[0]->tender->description= $data->releases[0]->tender->items[0]->description;
   //     }
     //   $detalle= $data->releases[0]->tender->description;













function categoria($descrip,$conexio)
{
    $sentencia="SELECT * FROM categoria";
    if (!$result = mysqli_query($conexio, $sentencia)) {
        die();
    }
    $categorias = array();
    while ($row = mysqli_fetch_array($result)) {
        $categorias[$row["cod_categoria"]]=0;
            
        $detalle = $descrip;
        $keywords=$row['keywords_categoria'];
        $keywords = mb_strtolower($keywords, 'UTF-8');
        $detalle = mb_strtolower($detalle, 'UTF-8');
        $keywords = preg_replace('/[0-9\.\,\"\?\¿\!\;\:\#\$\%\&\(\)\*\+\-\/\<\>\=\@\[\]\\\^\_\{\}\|\~]+/', '', $keywords);
        $detalle = preg_replace('/[0-9\.\,\"\?\¿\!\;\:\#\$\%\&\(\)\*\+\-\/\<\>\=\@\[\]\\\^\_\{\}\|\~]+/', '', $detalle);
        $keywords = remove_accents($keywords);
        $detalle = remove_accents($detalle);

        $a1=explode(' ', $keywords);
        $a2=explode(' ', $detalle);

        $a1=array_filter($a1, 'longenough');
        $a2=array_filter($a2, 'longenough');
        foreach ($a1 as $busca) {
            foreach ($a2 as $busca2) {
                $pos = strpos($busca2, $busca);
            
                if ($pos === false) {
                } else {
                    $categorias[$row["cod_categoria"]] +=1;
                }
            }
        }
    }
    $cate=23;
    if (max($categorias)==0) {
        $cate=23;
    } else {
        $cod_cate= array_keys($categorias, max($categorias));
        $cate= $cod_cate[0];
    }
    return $cate;
}
function longenough($word)
{
    return strlen($word) > 2;
}
 function remove_accents($string)
 {
     if (!preg_match('/[\x80-\xff]/', $string)) {
         return $string;
     }

     $chars = array(
  // Decompositions for Latin-1 Supplement
  chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
  chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
  chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
  chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
  chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
  chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
  chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
  chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
  chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
  chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
  chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
  chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
  chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
  chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
  chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
  chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
  chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
  chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
  chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
  chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
  chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
  chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
  chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
  chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
  chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
  chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
  chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
  chr(195).chr(191) => 'y',
  // Decompositions for Latin Extended-A
  chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
  chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
  chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
  chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
  chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
  chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
  chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
  chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
  chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
  chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
  chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
  chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
  chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
  chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
  chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
  chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
  chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
  chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
  chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
  chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
  chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
  chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
  chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
  chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
  chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
  chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
  chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
  chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
  chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
  chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
  chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
  chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
  chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
  chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
  chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
  chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
  chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
  chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
  chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
  chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
  chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
  chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
  chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
  chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
  chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
  chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
  chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
  chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
  chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
  chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
  chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
  chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
  chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
  chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
  chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
  chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
  chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
  chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
  chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
  chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
  chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
  chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
  chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
  chr(197).chr(190) => 'z', chr(197).chr(191) => 's'
  );

     $string = strtr($string, $chars);

     return $string;
 }
