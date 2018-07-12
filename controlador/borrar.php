<?php

/*
 * Documento php que se invoca al pulsar el boton "borrar" de cada fila y que
 * cargará en el formulario los datos del registro a borrar
 * 
 * Una vez se pulse en el botón "Aceptar", se eliminará ese registro de la BBDD
 * mostrando un aviso al usuario mediante alerta JavaScript y volviendo a la pantalla principal
 */


include_once '../modelo/data_model.php';


$conn = null;


    
    if(!isset($_POST['delete'])){
        try {
            //Crea la conexión
        $conn = connect();
        
        
        $id = $_GET['ID'];
        
        $stmnt = $conn->prepare("SELECT * FROM tablaPrincipal WHERE ID = ?");
        $stmnt->bindParam(1, $id);
        $stmnt->execute();
        
        $data = $stmnt->fetch();
        
        echo '
             <h1>BORRADO DE USUARIO</h1>
		     <form method="post" action="'. $_SERVER['PHP_SELF'] . '">
	          <table class="tabla">
                <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Apellidos</th>
                      <th>Tel&eacutefono</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                      <input type="hidden" name="id" id="id" value="' . $data['ID'] . '">
                      <td>' . $data['Nombre'] . '</td>
                      <td>' . $data['Apellidos'] . '</td>
                      <td>' . $data['Telefono'] . '</td>                    
                    </tr>
                    <tr>
                      <td colspan=3 class="centrar"><input type="submit" class="boton" name="delete" id="delete" value="Aceptar"></td>
                    </tr>
              
                <tbody>
              </table>
             </form>                   
             ';
        }catch (Exception $e){
            echo 'alert("No se ha borrado por un fallo de conexión a base de datos")';
        }
        
    }else{
        $conn = connect();
        $resul = deleteRow($conn, $_POST['id']);
        if($resul){
            echo "<script>";
            echo 'alert("Se ha borrado el registro");';
            echo 'window.location = "http://localhost/MiguelAguirre/index.php";';
            echo "</script>";
        }else{
            echo "<script>";
            echo 'alert("Nada que borrar, seleccione un usuario válido mediante el formulario");';
            echo 'window.location = "http://localhost/MiguelAguirre/index.php";';
            echo "</script>";
        }
    }

?>


    
