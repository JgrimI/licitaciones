
<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/persistencia/util/Conexion.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/negocio/ManejoLicitacion.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/negocio/ManejoCategoria.php';

set_time_limit(1000);

$obj=new Conexion();
$conexion=$obj->conectarBD();

ManejoCategoria::setConexionBD($conexion);
ManejoLicitacion::setConexionBD($conexion);
$name="";
$categoria="";
    if(isset($_POST["nombre"]))
    {
        $name = $_POST["nombre"];
        $lici= ManejoLicitacion::listarPorNombreDado($name);
    } 
    elseif(isset($_POST["categoria"]))
    {
      
      $categoria = $_POST["categoria"];
      $lici= ManejoLicitacion::listarPorCategoriaDada($categoria);

    }else{
      header("Location: index.php"); /* Redirección del navegador */
      exit;
    }



?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Licitaciones</title>
  
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
    <script  type="application/javascript" src="/prueba/presentacion/datatable/jquery-3.5.1.js"></script>
    <script   type="application/javascript"src="/prueba/presentacion/datatable/jquery.dataTables.min.js"></script>

    <link rel="stylesheet"  type="application/javascript" href="/prueba/presentacion/css/bootstrap.min.js">
    <link rel="stylesheet" href="/prueba/presentacion/css/bootstrap.min.css">

    <link rel="stylesheet" href="/prueba/presentacion/css/bootstrapmodal.min.css">
    <script  type="application/javascript" src="/prueba/presentacion/css/bootstrapmodal.min.js"></script>
  
</head>
<body>
<a href="index.php">Regresar</a> 
<br>
<br>
<style>
#tablal{
  display:none;
}
table.dataTable thead th, table.dataTable thead td {
 ¿
    padding: 5px 80px;
    border-bottom: 1px solid #111;
}
.loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  display: block;
  margin-left: auto;
  margin-right: auto;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<br>
<?php
 $salida="";
 if($lici==0 ){

 }else{
?>
<div class="loader" id="loader"></div> 
<div id="message" style="text-align:center;">Cargando, por favor espera...</div>
<table id="tablal" class="display" style="width:100%">
    <thead>
            <tr>
            <?php
        if ($categoria==null) {
            echo '<th style="display: none;">Categoria</th>';
        }
       ?>
                <th><center>Código Licitación</center></th>
                <th><center>Nombre</center></th>
                <th><center>País</center></th>
                <th><center>Acciones</center></th>
            </tr>
        </thead>
        <tbody>
<?php
   
        $salida ="";    
      
        foreach($lici as $l){
          
            echo '<tr>';
                if ($categoria==null) {
                  $catego= ManejoCategoria::buscarCategoria($l->getCategoria());
                  echo '<td style="display: none;">'.$catego->getNomCategoria().'</td>';
                  }
                    echo '<td><center>'.$l->getCodLicitacion().'</center></td>
                    <td><center>'.$l->getNomLicitacion().'</center></td>
                    <td><center>'.$l->getPais().'</center></td>
                    <td><center><a  href="" data-href="prueba/presentacion/detalle.php?cod='.$l->getCodLicitacion().'&pais='.$l->getPais().'" class="modalShow" >Ver Detalles</a></center></td>									
                </tr>';
        
        }
        ?>
        </tbody>
        <?php
        if ($categoria==null) {
            $salida.="
                    <tfoot>
                    <tr>
                    <th style='border:0px solid red;'>Name</th>
                    </tr>           
                    </tfoot>";
        }
    
        echo $salida;
    }
      ?>

</table>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" ></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        Cargando...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default modalClos" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>
<script>
$(function(){
  $('.modalShow').click(function(e){
    e.preventDefault();
    var mymodal = $('#myModal');
    var dataURL = $(this).attr('data-href');
    mymodal.find('.modal-title').text('Detalles de la licitación');
    mymodal.find('.modal-body').load(dataURL);
    mymodal.modal('show');

  });
})
$(function(){
  $('.modalClos').click(function(e){
    e.preventDefault();
    var mymodal = $('#myModal');
    mymodal.find('.modal-title').text('Detalles de la licitación');
    mymodal.find('.modal-body').text("Cargando...");
    mymodal.modal('show');

  });
})
$(function(){
  $('.close').click(function(e){
    e.preventDefault();
    var mymodal = $('#myModal');
    mymodal.find('.modal-title').text('Detalles de la licitación');
    mymodal.find('.modal-body').text("Cargando...");
    mymodal.modal('show');

  });
})
$(document).ready(function() {
  $('#tablal').on('init.dt', function () {
    console.log('Table initialisation complete: ' + new Date().getTime());
    $('#message').hide();
    $('#loader').hide();
    $('#tablal').show();
}).DataTable({
        initComplete: function() {
            this.api().columns().every(function() {
                var column = this;
                var select = $('<select style="width: 250px;"><option value="">Seleccione la categoria...</option></select>')
                    .appendTo($(column.footer()).empty()).on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });
                column.data().unique().sort().each(function(d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        },"processing": true,
        "language": idioma_espanol,
        "order": []
        });
});
var idioma_espanol = {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Filtrar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    },
    "buttons": {
        "copy": "Copiar",
        "colvis": "Visibilidad"
    }
};
</script>
</body>

</html>