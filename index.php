
<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/persistencia/util/Conexion.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/negocio/ManejoLicitacion.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/prueba/negocio/ManejoCategoria.php';


$obj=new Conexion();
$conexion=$obj->conectarBD();

ManejoCategoria::setConexionBD($conexion);
$name="";
$categorias=ManejoCategoria::listarCategoriasPorLicitacion();
$lici=0;
  



?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Licitaciones</title>

    <link rel="stylesheet"  type="application/javascript" href="/prueba/presentacion/css/bootstrap.min.js">
    <link rel="stylesheet" href="/prueba/presentacion/css/bootstrap.min.css">

</head>
<body>
<br>
<div>
<form action="tabla.php" method="POST">
<label>Busqueda por palabra clave:</label><br>
<label>Ingrese el termino a buscar en el nombre de la licitación</label><br>
<input type="text" id="nombre" placeholder="Ejemplo: covid-19" name="nombre" value="<?php echo $name;?>" required>

<input type="submit" value="Buscar" name="submit_btn"><br><br>
</form>

<form action="tabla.php" method="POST">
<label>Busqueda por actividad economica:</label><br>
 <select  style="width: 500px;" id="categoria" name="categoria" required>
 <option value="">Seleccione la categoria...</option>

<?php 
 foreach($categorias as $c){
      echo ' <option value="'.$c->getCodCategoria().'">'.$c->getNomCategoria().'</option>';
    }
  ?>
</select> 

<input type="submit" value="Buscar" name="submit_btn">
</form>
</div>
</body>

</html>