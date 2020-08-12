<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.js">
  <title>Document</title>
</head>
<body>
<?php 
       
if(isset($_REQUEST['submit_btn']))
    {
        $name = $_POST["select"];
        $fecha = $_POST["fecha"];
        $fecha2= date_format(date_create($fecha), 'dmY');
        if($name=="Todos")  {
            
            $fileip = file_get_contents("http://api.mercadopublico.cl/servicios/v1/publico/licitaciones.json?fecha=$fecha2&ticket=83D4D082-755A-41DC-8B28-1DDA010F765E");
            $data=json_decode($fileip);
        }  
        else{
            $fileip = file_get_contents("http://api.mercadopublico.cl/servicios/v1/publico/licitaciones.json?fecha=$fecha2&estado=$name&ticket=83D4D082-755A-41DC-8B28-1DDA010F765E            ");
            $data=json_decode($fileip);
        }
    }else{
        $date=date("dmY"); 
        $fileip = file_get_contents("http://api.mercadopublico.cl/servicios/v1/publico/licitaciones.json?fecha=$date&ticket=83D4D082-755A-41DC-8B28-1DDA010F765E");
        $data=json_decode($fileip);
        
    }
?>
<style>
table, th, td {
  border: 1px solid black;
}
table {
  border-collapse: collapse;
 
  margin-left:auto;
  margin-right:auto;
 }

th {
  background-color: grey;
}

th, td {
  padding: 8px;
}

tr:nth-child(even) {background-color: #f2f2f2;}
</style>
<form action="" method="POST">
 <select id="select" name="select">
  <option value="Todos">Todos</option>
  <option value="Publicada">Publicada</option>
  <option value="Cerrada">Cerrada</option>
  <option value="Desierta">Desierta</option>
  <option value="Adjudicada">Adjudicada</option>
  <option value="Revocada">Revocada</option>
  <option value="Suspendida">Suspendida</option>
</select>  
<input type="date" id="fecha" name="fecha"
       value="<?php echo date("Y-m-d")?>"
       min="2000-01-01" max="<?php echo date("Y-m-d")?>">

<input type="submit" value="filtrar" name="submit_btn">
</form>
<table >
       <?php
           if (count($data->Listado)) {
                echo "<tr'>
                <th><center>Código Externo</center></th>	
                <th><center>Nombre</center></th>
                <th><center>Estado</center></th>
                <th><center>Fecha Cierre</center></th>
                <th><center>Acciones</center></th>
            </tr>";
 
            $estado="";
            foreach ($data->Listado as $idx => $listado) {
                if($listado->CodigoEstado==5){
                    $estado="Publicada";
                }elseif($listado->CodigoEstado==6){
                    $estado="Cerrada";
                }elseif($listado->CodigoEstado==7){
                    $estado="Desierta";
                }elseif($listado->CodigoEstado==8){
                    $estado="Adjuticada";
                }elseif($listado->CodigoEstado==18){
                    $estado="Revocada";
                }elseif($listado->CodigoEstado==19){
                    $estado="Suspendida";
                }
                echo "<tr>";
                echo "<td><center>$listado->CodigoExterno</center></td>";
                echo "<td><center>$listado->Nombre</center></td>";
                echo "<td><center>$estado</center></td>";
                $fecha="";
                if($listado->FechaCierre==null){
                    $fecha="N/A";
                }
                else{
                    $fecha=$listado->FechaCierre;
                }
                echo "<td><center>$fecha</center></td>";
                echo "<td><center><a href='detalles.php?cod=$listado->CodigoExterno' target='_blank'>Ver Detalles</a> </center></td>";
                echo "</tr>
                ";
                
            }
        }else{
            if($name=="Todos"){
                
                echo "<h3>No hay licitaciones en la fecha '$fecha'</h3>";
            }else{
                echo "<h3>No hay licitaciones con el estado '$name' y la fecha '$fecha'</h3>";
            }
        }
        ?>

</table>




</body>
</html>


