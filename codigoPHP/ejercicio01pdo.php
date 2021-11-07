<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <title>Ejercicio 01 PDO</title>
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
            
            //Incluyo las variables de la conexion
            require_once '../config/configDBPDO.php';
            
            //Hago la conexion con la base de datos
            $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
            
            //Utilizo el método getAttribute para obtener información de los atributos de la conexion
            $autocommit = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_AUTOCOMMIT);
            $case = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_CASE);
            $versionCliente = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_CLIENT_VERSION);
            $estadoConexion = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_CONNECTION_STATUS);
            $nombreDriver = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_DRIVER_NAME);
            $errorMode = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_ERRMODE);
            $nulls = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_ORACLE_NULLS);
            $info = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_SERVER_INFO);
            $version = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_SERVER_VERSION);
            
            //Muestro la informacion guardada en variables de la informacion de la conexion
            echo "<strong>AutoCommit:</strong> $autocommit";
            echo "<br>";
            echo "<strong>Case:</strong> $case";
            echo "<br>";
            echo "<strong>Version cliente:</strong> $versionCliente";
            echo "<br>";
            echo "<strong>Version cliente:</strong> $estadoConexion";
            echo "<br>";
            echo "<strong>Nombre driver:</strong> $nombreDriver";
            echo "<br>";
            echo "<strong>Modo error:</strong> $errorMode";
            echo "<br>";
            echo "<strong>Nulls:</strong> $nulls";
            echo "<br>";
            echo "<strong>Info:</strong> $info";
            echo "<br>";
            echo "<strong>Versión:</strong> $version";
            
            //Cierro la conexion con la database
            unset($DAW207DBDepartamentos);
            ?>
        </main>
    </body>
</html>

