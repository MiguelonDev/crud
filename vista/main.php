<?php
/*
 * Documento principal de la aplicacion que contiene la estructura básica html y la tabla de consulta
 * de la base de datos con la que se trabaja
 * 
 * 
 * 
 */



    include_once './modelo/data_model.php';
?>
<!DOCTYPE html>

<html>

<head>
<meta charset="ISO-8859-1">
<title>CRUD</title>
<link rel="stylesheet" type="text/css" href="vista/css/estilo.css">
<script type="text/javascript" src="./js/jquery-3.3.1.js"></script>
<script>

/*
 * Función que se ejecuta al pulsar en un elemento de etiqueta "a"
 * y que carga en el "div" #accion el código correspondiente al
 * documento recibido en el parámetro "href"
 */

$(document).ready(
	function(){

		$("a").click(
			function(){
				var url=$(this).attr("href");
				$("#accion").load(url);
				return false;
			});
	
});

</script>
</head>
<body>
<?php
    $conn = null;

    try {
        
        //Crea la conexión
        $conn = connect();
        
        
        //Obtiene los datos de la tabla
        $rows = getAllRows($conn);
        
        //Pinta la tabla
        echo '<form method="post" action="controlador/insertar.php">
            
                <h1>Tabla de usuarios</h1>
                <table class="tabla">
                    <thead>
                        <tr>
                        
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Teléfono</th>
                            <th colspan=2>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>';
            // bucle que se encarga de crear la tabla de datos en función de los registros encontrados
            foreach ($rows as $row) {            
                echo '
                      <tr> 
                           <td>' . $row['Nombre'] . '</td> 
                           <td>' . $row['Apellidos'] . '</td> 
                           <td>' . $row['Telefono'] . '</td>
                           <td><a href="controlador/borrar.php?ID=' . $row['ID'] . '"><input type="button" class="boton" name="del" id="del" value="Borrar"></a></td>
                           <td><a href="controlador/actualizar.php?ID=' . $row['ID'] . '"><input type="button" class="boton" name="upd" id="upd" value="Actualizar"></a></td>
                      </tr>';            
            }
            
            echo     ' 
                      <tr>
                          <td><input type="text" name="nom" id="nom" placeholder="Nombre"></td>
                          <td><input type="text" name="ape" id="dir" placeholder="Apellidos"></td>
                          <td><input type="text" name="tel" id="tel" placeholder="Teléfono"></input></td>
                          <td><input class="boton" value="Insertar" type="submit"/></td>
                          <td><a id="ayuda" href="vista/ayuda.html"><input type="button" class="boton" name="ayuda" id="ayuda" value="Ayuda"></a></td>
                      </tr>
                    
                    </tbody>
                    
                 </table>

              </form>';

    } catch (Exception $e) {
        //TODO trazar, por ahora se mantiene con alert
        
            echo '<script>';
            echo 'alert("No se ha podido conectar con la BBDD");';
            echo 'window.location = "http://localhost/MiguelAguirre/index.php";';
            echo '</script>';
    }
?>

<div id="accion"></div>

<footer class="centrar">Desarrollado por: Miguel Aguirre Varela <br>  abril 2018</footer>
</body>
</html>