<?php

/*
 * Documento php que se invoca al pulsar el boton "insertar" de la �ltima fila y que
 * insertar� los datos introducidos en los campos del formulario en la tabla de la base de datos
 *
 * Al hacer las comprobaciones previas a la inserci�n, se verificar� que las longitudes de los campos 
 * y su contenido son correctos para mantener la l�gica de base de datos conforme a unos criterios 
 * b�sicos (los nombres y apellidos no contienen numeros y los tel�fonos no contienen letras, 
 * as� como ninguno contiene otros caracteres)
 *
 */

include_once '../modelo/data_model.php';

$nom    = $_POST['nom'];
$ape    = $_POST['ape'];
$tel    = $_POST['tel'];

// condici�n de inserci�n
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

