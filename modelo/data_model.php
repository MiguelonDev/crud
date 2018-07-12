<?php


  /**
   * Obtiene la cadena de conexion de la base de datos
   * @return array $config
   */
  function dataConnect(){
       
      $config['db_conn_string'] = 'mysql:host=localhost;port=3306;dbname=miguelaguirre';
      $config['db_conn_user'] = 'root';
      $config['db_conn_pass'] = '';
       
      return $config;
  }
  
  
  /**
   * Crea el objeto PDO de conexión
   * 
   * @todo controlar erroes de conexión
   */
  function connect(){
      
      $config = dataConnect();
      
      $conn = null;
      
          $conn = new PDO(
              $config['db_conn_string'],
              $config['db_conn_user'],
              $config['db_conn_pass']
              );
    
      return $conn;
  }
  
  
  /**
   * Obtiene todas las filas de la tabla
   * 
   * @return Array asociativo con el resultSet
   */
  function getAllRows(PDO $conn) {
      
      $data = null;
     
      try {
          
          $stmnt = $conn->prepare("SELECT * FROM  tablaPrincipal;");
          $stmnt->execute();          
          
          //Se asume que son pocos datos y se cargan en memoria todos los registros
          $data = $stmnt->fetchAll();
          
      } catch (Exception $e) {
        //TODO: trazar
          die("Ha fallado {$e->getMessage()}");
      }
      
      return $data;
  }
  
  /**
   * Obtiene una fila a partir de un ID recibido por parámetros
   * 
   * @param PDO $conn
   * @param int $id
   * 
   * @return Array asociativo con el resultSet
   */
  function getById(PDO $conn, $id){
      $stmnt = $conn->prepare("SELECT * FROM  tablaPrincipal WHERE ID = ?");
      $stmnt->bindParam(1, $id);
      $stmnt->execute();
      $data = $stmnt->fetch();
      return $data;
      
  }
  
  /**
   * Actualiza un registro de la base de datos a partir de un 
   * ID recibido con los datos submitidos en el formulario
   * 
   * @param PDO $conn
   * @param int $id clave primaria de base de datos para identificar el registro a actualizar
   * @param string $nom parámetro correspondiente al campo Nombre de la tabla
   * @param string $ape parámetro correspondiente al campo Apellidos de la tabla
   * @param string $tel parámetro correspondiente al campo Telefono de la tabla
   */
  function updateRow(PDO $conn, $id, $nom, $ape, $tel) {
     
      $stmnt = $conn->prepare('SELECT * FROM tablaPrincipal WHERE ID = ?');
      $stmnt->bindParam(1, $id);
      $stmnt->execute();
      $data = $stmnt->fetch();

      if($data['Nombre'] === $nom && $data['Apellidos'] === $ape && $data['Telefono'] === $tel){
          return false; // Los datos son los mismos que había por lo que no se persiste en BBDD
      }else{
          $stmnt = $conn->prepare('UPDATE tablaPrincipal set Nombre = ? , Apellidos = ? , Telefono = ? WHERE ID = ?');
          
          $stmnt->bindParam(1, $nom);
          $stmnt->bindParam(2, $ape);
          $stmnt->bindParam(3, $tel);
          
          $stmnt->bindParam(4, $id);
          
          $result = $stmnt->execute();
          if (!$result) {
              return false; // No se han persistido los cambios
          }
          return true; // Se actualiza el registro
      }
      return false; // si no se ha encontrado el registro o hay problemas de conexion con BBDD
   
  }
  
  /**
   * Elimina de base de datos el registro segun la clave primaria recibida por parámetros
   * 
   * @param PDO $conn
   * @param int $id clave primaria de base de datos para identificar el registro a borrar
   * 
   * @return boolean se evita el borrado con clave primaria nula
   */
  function deleteRow(PDO $conn, $id){
      if($id != null){
          $stmnt = $conn->prepare('DELETE FROM tablaPrincipal WHERE ID = ?');
          $stmnt->bindParam(1, $id);
          $result = $stmnt->execute();
          return true;
      }
      return false;
  }
  
  /**
   * Inserta en BBDD los campos recibidos por parámetros
   * 
   * @param PDO $conn
   * @param string $nom parámetro correspondiente al campo Nombre de la tabla
   * @param string $ape parámetro correspondiente al campo Apellidos de la tabla
   * @param string $tel parámetro correspondiente al campo Telefono de la tabla
   */
  function insertRow(PDO $conn, $nom, $ape, $tel){
      
      $stmnt = $conn->prepare('INSERT INTO tablaprincipal (Nombre, Apellidos, Telefono) values (?,?,?)');
      $stmnt->bindParam(1, $nom);
      $stmnt->bindParam(2, $ape);
      $stmnt->bindParam(3, $tel);
      
      $result = $stmnt->execute();
      
      if (!$result) {
          echo '<script>';
          echo 'alert("Ha ocurrido un error insertando");';
          echo 'history.back();';
          echo '</script>';
      }
      
  }
  
  /**
   * Valida los datos introducidos en formulario para evitar inconsistencias de datos tales como 
   * nombre que contienen números, telefonos con letras en su interior y caracteres especiales en cualquier caso
   * Al tratarse de nombres, apellidos y teléfonos, se ha evaluado que se sustituirán los caracteres especiales
   * por espacios en blanco para asegurar la legibilidad (john's -> john s) y evitar confusion con plurales
   * 
   * @param string $nom parámetro correspondiente al campo Nombre de la tabla
   * @param string $ape parámetro correspondiente al campo Apellidos de la tabla
   * @param string $tel parámetro correspondiente al campo Telefono de la tabla
   * 
   * @return boolean resultado correcto o incorrecto de la validación
   */
  function validaDatos(&$nom, &$ape, &$tel){
      
      $err=0;
      // Se impide que haya alguno de los tres campos vacíos
      if(strlen($nom) == 0 || strlen($ape) == 0 || strlen($tel) == 0){
          $err++;
          
      }else{
          
          // Se eliminan espacios al principio y al final
          $nom = trim($nom);
          $ape = trim($ape);
          $tel = trim($tel);
          // Se evitan caracteres especiales en los literales y se sustituyen por un espacio
          $nom = str_replace(
              array("\'", "¨", "º", "-", "~","#", "@", "|", "!", "\"","·", "$", "%", "&", "/","(", ")", "?", "'", "¡",
                        "¿", "[", "^", "<code>", "]","+", "}", "{", "¨", "´",">", "< ", ";", ",", ":",".", " "),
                    ' ',
                    $nom
                    );
          
          $ape = str_replace(
              array("\'", "¨", "º", "-", "~","#", "@", "|", "!", "\"","·", "$", "%", "&", "/","(", ")", "?", "'", "¡",
                        "¿", "[", "^", "<code>", "]","+", "}", "{", "¨", "´",">", "< ", ";", ",", ":",".", " "),
                    ' ',
                    $ape
                    );
          // se eliminan espacios intermedios
          $tel = str_replace(' ', '', $tel);
     
          $regExpLit = "^[a-zA-Z]$^"; // expresión regular para literales
          $regExpNum = "^[0-9]$^";    // expresión regular para numerales
          // Se verifica que los campos tengan la longitud y el formato correcto
          if(((strlen($nom) >= 4) && strlen($nom) <= 20) && ((strlen($ape) >= 4) && strlen($ape) <= 20) && strlen($tel) == 9){
              
              if (!preg_match($regExpLit, $nom) || !preg_match($regExpLit, $ape) || !preg_match($regExpNum, $tel)){
                  $err++;
              }
              
          }else{
              $err++;
          }
          
      }
      
      // Devuelve el resultado en función de si han ocurrido errores o no
      if($err >=1){
          return false;
      }else{
          return true;
      }
      
  }
  











