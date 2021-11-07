<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <title>Ejercicio 01 MySQLi</title>
    </head>
    <body>
        <main>
            <?php
            /*
             * @author: Alberto Fernandez Ramirez
             * @version: v1.Realizacion del ejercicio
             * Created on: 03-Noviembre-2021
             * Ejercicio 1. (ProyectoTema4) Conexión a la base de datos con la cuenta usuario y tratamiento de errores.
             */
            //HECHO DE MANERA CORRECTA
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

            //Muestro los datos de la conexion
            echo "<pre>";
            print_r($DAW207DBDepartamentos);
            echo "</pre>";

            //Valor que cuenta los posibles errores
            echo "<p>Errores:</p>";
            echo $error;

            //Cierro la conexion con la base de datos
            $DAW207DBDepartamentos->close();


            //HECHO CON UN ERROR
            //Incluyo las variables de la conexion
            require_once '../config/configDBMySQLi.php';
            
            //Utilizo el metodo connect para establecer la conexion y controlo si se produce un error finalizo la ejecucion
            $DAW207DBDepartamentos = mysqli_connect(HOST, USER, PASSWORD, DB);

            //Control de error
            $error = $DAW207DBDepartamentos->connect_errno;
            if ($error != null) {
                echo "<p>Error $error conectando a la base de datos: $DAW207DBDepartamentos->connect_error</p>";
                exit();
            }

            //Muestro los datos de la conexion
            echo "<pre>";
            print_r($DAW207DBDepartamentos);
            echo "</pre>";

            //Valor que cuenta los posibles errores
            echo "<p>Errores:</p>";
            echo $error;

            //Cierro la conexion con la base de datos
            $DAW207DBDepartamentos->close();
            ?>
        </main>
    </body>
</html>
