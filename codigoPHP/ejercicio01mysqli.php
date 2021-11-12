<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <link href="../webroot/css/estiloejercicio.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="../webroot/css/img/home.png" type="image/x-icon">
        <title>Ejercicio 01 MySQLi</title>
    </head>
    <body>
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
        <footer class="piepagina">
            <a href="../indexProyectoTema4.php"><img src="../webroot/css/img/atras.png" class="imageatras" alt="IconoAtras" /></a>
            <a href="https://github.com/AlbertoFRSauces/proyectoTema4" target="_blank"><img src="../webroot/css/img/github.png" class="imagegithub" alt="IconoGitHub" /></a>
            <p><a>&copy;</a>Alberto Fernández Ramírez 29/09/2021 Todos los derechos reservados.</p>
            <p>Ultima actualización: 12/11/2021 10:26</p>
        </footer>
    </body>
</html>
