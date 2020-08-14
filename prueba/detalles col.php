<?php
//Crear for url
set_time_limit(10000);
error_reporting(E_ALL & ~E_NOTICE);

$server = "35.184.25.215";
$user = "prueba";
$pass = "1234";

$bd = "licitaciones";
$port = "3306";
$conexion = mysqli_connect($server, $user, $pass,$bd,$port) 
or die("Ha sucedido un error inesperado en la conexion de la base de datos");
$conexion->set_charset("utf8");






    $fileip = file_get_contents("https://apiocds.colombiacompra.gov.co:8443/apiCCE2.0/rest/releases/filtersAnd/tender.procurementMethodDetails,Licitaci%C3%B3n%20P%C3%BAblica,tender.status,active");
    $data=json_decode($fileip);
    $data2=json_decode($fileip, true);
    if (count($data2)<2) {
        echo "errorsaso";
    } else {
          $i2=0;
          $i=0;
          if (count($data2)<2) {
              echo $data2['error'];
          } else {
              while ($data2['links']['next']!=null) {
                  if (count($data->releases)) {
                      $i++;
               
                      $i3=0;
                      foreach ($data->releases as $idx => $listado) {
                          sleep(1);
                          $cod_comprador="";
                          $nom_comprador="";
                 
                          if ($listado->parties[0]->id!=""||$listado->parties[0]->id) {
                              $cod_comprador= $listado->parties[0]->id;//cod_comprador
                          } else {
                              $cod_comprador= generateRandomString();
                              ;//cod_comprador
                          }
                 
                          if ($listado->parties[0]->contactPoint->name) {
                              $nom_comprador= $listado->parties[0]->contactPoint->name;//nom_comprador
                          } else {
                              $nom_comprador= $listado->parties[0]->additionalContactPoints[0]->name;//nom_comprador
                          }
                          $nom_comprador=preg_replace('/[0-9\.\,\"\?\¿\!\;\:\#\$\%\&\(\)\*\+\-\/\<\>\=\@\[\]\\\^\_\{\}\|\~\\]+/', '', $nom_comprador);
                 
                  
                          $nomOrnanismo=$listado->parties[0]->name;
                          $nomOrnanismo=preg_replace('/[\'\\]+/', ' ', $nomOrnanismo);
                 
                          $lic = mysqli_query($conexion, "SELECT * FROM comprador WHERE cod_comprador='$cod_comprador' or nom_comprador='$nom_comprador' and nom_organismo='$nomOrnanismo'");
                          if (mysqli_num_rows($lic) == 0) {
                              echo $i2++."-- ".$i3++."--$i<br>";
                              $sql = 'INSERT INTO comprador (cod_comprador,nom_comprador,nom_organismo) 
                              VALUES ("'.$cod_comprador.'","'.$nom_comprador.'","'.$nomOrnanismo.'")';
                              $insert = mysqli_query($conexion, $sql);
                              if ($insert) {
                              } else {
                                  echo $sql."<br>";
                              }
                          } else {
                              $row = mysqli_fetch_array($lic);
                              $cod_comprador=$row["cod_comprador"];
                          }
                          $nombre=$listado->tender->title;
                          $findme   = '.';
                          $findme2   = '-';
                          $pos = strpos($nombre, $findme);
                          $pos2 = strpos($nombre, $findme);

                          if (strlen($listado->tender->title)>24 && $pos === false ||$pos2 === false) {
                              $nombre=$listado->tender->title;
                              
                          } else {

                            if ($listado->tender->description) {

                            }else{
                              $listado->tender->description= $listado->tender->items[0]->description;
                            }
                            
                              $listado->tender->description =preg_replace('/[\t]+/', '', $listado->tender->description);
                              $nombre = mb_substr($listado->tender->description, 0, 250, 'UTF-8');//descripcion
                              if (strlen($nombre)>249) {
                                  $nombre.="...";
                              }
                          }
                 
                          $lic = mysqli_query($conexion, "SELECT * FROM licitacion WHERE cod_licitacion='$listado->id'");
                          if (mysqli_num_rows($lic) == 0) {
                              $descripcion=preg_replace('/[\t]+/', '', $listado->tender->description);
                              $descripcion=preg_replace('/[\"]+/', "'", $descripcion);
                              $nombre=preg_replace('/[\"]+/', "'", $nombre);
                              $sql = 'INSERT INTO licitacion (cod_licitacion,nom_licitacion,cod_comprador,pais,cod_categoria,descripcion) 
                              VALUES ("'.$listado->id.'","'.$nombre.'","'.$cod_comprador.'", "Colombia",2,"'.$descripcion.'")';
                              $insert = mysqli_query($conexion, $sql);
                     
                              if ($insert) {
                              } else {
                                  echo $sql."<br>";
                              }
                          }
                  
                          //fecha_cierre
                      }
                      $fileip = file_get_contents($data2['links']['next']);
                      $data=json_decode($fileip);
                      $data2=json_decode($fileip, true);
                  } else {
                      echo 'No hay nada';
                  }
              }
          }
      }
    function generateRandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)))), 1, $length);
    }
  
        ?>


