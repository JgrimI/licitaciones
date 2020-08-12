<?php
//Crear for url 
set_time_limit(1000);
    $fileip = file_get_contents("https://apiocds.colombiacompra.gov.co:8443/apiCCE2.0/rest/releases/filters/tender.status,active");
    $data=json_decode($fileip);
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
            
    $fileip = file_get_contents("https://apiocds.colombiacompra.gov.co:8443/apiCCE2.0/rest/releases/filtersAnd/tender.procurementMethodDetails,Licitaci%C3%B3n%20P%C3%BAblica,tender.status,active");
    $data=json_decode($fileip);
    $data2=json_decode($fileip,true);
    if (count($data2)<2) {
      echo "errorsaso";
     } 
      else{
        
        $i2=0;
        $i=0;
        if (count($data2)<2) {
          echo "error";
         } 
        else{
        while ($data2['links']['next']!=null) {
            if (count($data->releases)) {
                $i++;
               
                $i3=0;
                foreach ($data->releases as $idx => $listado) {
                    echo $i2++."-- ".$i3++."--$i<br>";
                }
                $fileip = file_get_contents($data2['links']['next']);
                $data=json_decode($fileip);
                $data2=json_decode($fileip, true);
            }
        else{
            echo 'No hay nada';
        }
       }
      }
    }
      
        ?>
</table>



