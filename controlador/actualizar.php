<?php

/*
 * Documento php que se invoca al pulsar el boton "actualizar" de cada fila y que 
 * cargar� en el formulario los datos del registro a actualizar
 * 
 * Al hacer las comprobaciones de actualizaci�n, se verificar� que al menos uno de 
 * los campos ha sido alterado compar�ndolo con el registro original
 * 
 * Se tendr�n en cuenta las longitudes de los campos y su contenido para mantener 
 * la l�gica de base de datos conforme a unos criterios b�sicos (los nombres y apellidos
 * no contienen numeros y los tel�fonos no contienen letras, as� como ninguno contiene otros caracteres)
 * 
 */


echo '
                <h1>ACTUALIZACI&OacuteN DE USUARIO</h1>
                <form method="post" action="'. $_SERVER['PHP_SELF'] . '">
            	<table class="tabla">
            		';

    include_once '../modelo/data_model.php';
    
    if(!isset($_POST['update'])){
        
        $conn = null;
        
        try {
            
            //Crea la conexi�n
            $conn = connect();
                       
            $data = getById($conn, $_GET['ID']);
          
            if($data != null){
                $idUpdate  = $data['ID'];
                $nomUpdate = $data['Nombre'];
                $dirUpdate = $data['Apellidos'];
                $telUpdate = $data['Telefono'];
                
                
                echo '
                
                            
                      <input type="hidden" name="id" id="id" value="' . $idUpdate . '"/>
                      <tr>
                           <td>Nombre</td>
                           <td><input name="nom" id="nom" type="text" value="' . $data['Nombre'] . '"></td>
                      </tr>
                      <tr>
                      <td>Apellidos</td>
                           <td><input name="ape" id="ape" type="text" value="' . $data['Apellidos'] . '"></td>
                      </tr>
                      <tr>
                      <td>Tel&eacutefono</td>
                           <td><input name="tel" id="tel" type="text" value="' . $data['Telefono'] . '"></td>
                      </tr>
                      <tr>
                           <td colspan=2 class="centrar"><input type="submit" class="boton" name="update" id="update" value="Aceptar"></td>
                      </tr>
                	
                </table>
            </form>
                        ';
                
            }else{
                echo "<tr><td class='error'>Ese usuario no existe</td></tr>";
            }

        }catch (Exception $e){
            // TODO excepcion trazar 
        }
        
        
    }else{
    
        $conn = connect();
        if(validaDatos($_POST['nom'], $_POST['ape'], $_POST['tel'])){
            $res = false;
            $res = updateRow($conn, $_POST['id'], $_POST['nom'], $_POST['ape'], $_POST['tel']);
            if($res === true){
                echo '<script>';
                echo 'alert("Se ha actualizado el registro");';
                echo 'window.location = "http://localhost/Crud/index.php";';
                echo '</script>';
            }else{
                
                echo '<script>';
                echo 'alert("No se han podido persistir los cambios por alguna de las siguientes razones:\n\n\t- El registro no ha cambiado\n\t- El registro actualizado no existe en BBDD\n\t- La conexi�n de BBDD ha fallado");';
                echo 'history.back();';
                echo '</script>';
            }
        }else{
            echo '<script>';
            echo 'alert("No se han podido persistir los cambios por alguna de las siguientes razones:\n\n\t- El registro no ha cambiado\n\t- El registro actualizado no existe en BBDD\n\t- La conexi�n de BBDD ha fallado");';
            echo 'history.back();';
            echo '</script>';
        }
    }
?>

