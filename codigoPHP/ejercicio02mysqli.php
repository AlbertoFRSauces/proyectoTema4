<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <title>Ejercicio 02 MySQLi</title>
    </head>
    <body>
        <main>
            <?php
            /*
             * @author: Alberto Fernandez Ramirez
             * @version: v1.Realizacion del ejercicio
             * Created on: 04-Noviembre-2021
             * Ejercicio 2. Mostrar el contenido de la tabla Departamento y el número de registros.
             */
            //Incluyo las variables de la conexion
            require_once '../config/configDBMySQLi.php';
            
            //Utilizo el metodo connect para establecer la conexion y controlo si se produce un error finalizo la ejecucion
            $DAW207DBDepartamentos = mysqli_connect(HOST, USER, PASSWORD, DB);
            
            //Control de error
            $error = $DAW207DBDepartamentos->connect_error;
            if ($error != null) {
                echo "<p>Error $error conectando a la base de datos: $DAW207DBDepartamentos->connect_error</p>";
                exit();
            }
            
            //Definio la variable consulta
            $consulta = "SELECT * from Departamentos";
            
            //Ejecuto la consulta sobre la base de datos Departamentos
            $resultadoConsulta = $DAW207DBDepartamentos->query($consulta);
            
            echo 'La tabla Departamentos contiene: ' . $resultadoConsulta;
            
            ?>
        </main>
    </body>
</html>
