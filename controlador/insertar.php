<?php

/*
 * Documento php que se invoca al pulsar el boton "insertar" de la última fila y que
 * insertará los datos introducidos en los campos del formulario en la tabla de la base de datos
 *
 * Al hacer las comprobaciones previas a la inserción, se verificará que las longitudes de los campos 
 * y su contenido son correctos para mantener la lógica de base de datos conforme a unos criterios 
 * básicos (los nombres y apellidos no contienen numeros y los teléfonos no contienen letras, 
 * así como ninguno contiene otros caracteres)
 *
 */

include_once '../modelo/data_model.php';

$nom    = $_POST['nom'];
$ape    = $_POST['ape'];
$tel    = $_POST['tel'];

// condición de inserción
if(validaDatos($nom, $ape, $tel)){
    
    $conn = null;
    $conn   = connect();
    
    insertRow($conn, $nom, $ape, $tel);
   
   header("location:../index.php");
    
}else{
    
    echo "<script>";
    echo 'alert("No se han podido persistir los cambios. Consulte la ayuda");';
    echo "history.back();";
    echo "</script>"; 
   
    
    
}

