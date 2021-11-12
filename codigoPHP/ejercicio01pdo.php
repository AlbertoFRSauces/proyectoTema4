<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <link href="../webroot/css/estiloejercicio.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="../webroot/css/img/home.png" type="image/x-icon">
        <title>Ejercicio 01 PDO</title>
        <style>
            .conexionRealizada{
                color: green;
            }
            table{
                border-collapse: collapse;
            }
            th{
                border: 1px solid black;
            }
            td{
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
            <?php
            /*
             * @author: Alberto Fernandez Ramirez
             * @version: v1.Realizacion del ejercicio
             * Created on: 03-Noviembre-2021
             * Ejercicio 1. (ProyectoTema4) Conexión a la base de datos con la cuenta usuario y tratamiento de errores.
             */
            
            //Incluyo las variables de la conexion
            require_once '../config/configDBPDO.php';
            
            try{
                echo '<a class="conexionRealizada">Conexion realizada.</a>';
                echo '<br>';
                //Hago la conexion con la base de datos
                $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                
                // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                $DAW207DBDepartamentos -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                //Creo el array con los atributos del PDO
                $aAtributosPDO=[
                    "AUTOCOMMIT",
                    "CASE",
                    "CLIENT_VERSION",
                    "CONNECTION_STATUS",
                    "DRIVER_NAME",
                    "ERRMODE",
                    "ORACLE_NULLS",
                    "PERSISTENT",
                    "SERVER_INFO",
                    "SERVER_VERSION"
                ];
                
                //Muestro los atributos declarados en el array de atributos uno a uno con un foreach
                echo "<table>";
                foreach($aAtributosPDO as $atributo){ //Bucle que recorre los distintos atributos de PDO del array de atributos
                    echo "<tr>";
                        echo "<td><span style='font-weight:bold;'>PDO::ATTR_$atributo: </span></td><td>" . $DAW207DBDepartamentos->getAttribute(constant("PDO::ATTR_$atributo")) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                
                //Utilizo el método getAttribute para obtener información de los atributos de la conexion
                $autocommit = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_AUTOCOMMIT);
                $case = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_CASE);
                $versionCliente = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_CLIENT_VERSION);
                $estadoConexion = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_CONNECTION_STATUS);
                $nombreDriver = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_DRIVER_NAME);
                $errorMode = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_ERRMODE);
                $nulls = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_ORACLE_NULLS);
                $persistent = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_PERSISTENT);
                $info = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_SERVER_INFO);
                $version = $DAW207DBDepartamentos->getAttribute(PDO::ATTR_SERVER_VERSION);

                //Muestro la informacion guardada en variables de la informacion de la conexion
                echo "<strong>AutoCommit: </strong>$autocommit";
                echo "<br>";
                echo "<strong>Case: </strong>$case";
                echo "<br>";
                echo "<strong>Version cliente: </strong>$versionCliente";
                echo "<br>";
                echo "<strong>Estado de la conexion: </strong>$estadoConexion";
                echo "<br>";
                echo "<strong>Nombre driver: </strong>$nombreDriver";
                echo "<br>";
                echo "<strong>Modo error: </strong>$errorMode";
                echo "<br>";
                echo "<strong>Nulls: </strong>$nulls";
                echo "<br>";
                echo "<strong>Persistent: </strong>$persistent";
                echo "<br>";
                echo "<strong>Info: </strong>$info";
                echo "<br>";
                echo "<strong>Versión: </strong>$version";
            
            }catch(PDOException $excepcion){//Codigo que se ejecuta si hay algun error
                $errorExcepcion = $excepcion->getCode();//Obtengo el codigo del error y lo almaceno en la variable errorException
                $mensajeException = $excepcion->getMessage();//Obtengo el mensaje del error y lo almaceno en la variable mensajeException
                
                echo "<p style='color: red'>Codigo del error: </p>" . $errorExcepcion;//Muestro el codigo del error
                echo "<p style='color: red'>Mensaje del error: </p>" . $mensajeException;//Muestro el mensaje del error
            }finally{
                //Cierro la conexion
                unset($DAW207DBDepartamentos);
            }
            ?>
        
        <footer class="piepagina">
            <a href="../indexProyectoTema4.php"><img src="../webroot/css/img/atras.png" class="imageatras" alt="IconoAtras" /></a>
            <a href="https://github.com/AlbertoFRSauces/proyectoTema4" target="_blank"><img src="../webroot/css/img/github.png" class="imagegithub" alt="IconoGitHub" /></a>
            <p><a>&copy;</a>Alberto Fernández Ramírez 29/09/2021 Todos los derechos reservados.</p>
            <p>Ultima actualización: 12/11/2021 10:26</p>
        </footer>
    </body>
</html>

