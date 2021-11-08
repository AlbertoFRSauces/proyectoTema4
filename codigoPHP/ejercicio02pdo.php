<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <title>Ejercicio 02 PDO</title>
        <style>
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
        <main>
            <?php
            /*
             * @author: Alberto Fernandez Ramirez
             * @version: v1.Realizacion del ejercicio
             * Created on: 04-Noviembre-2021
             * Ejercicio 2. Mostrar el contenido de la tabla Departamento y el número de registros.
             */
            //Incluyo las variables de la conexion
            require_once '../config/configDBPDO.php';
            
            
            try{
                echo 'Conexion realizada.';
                //Hago la conexion con la base de datos
                $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                
                // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                $DAW207DBDepartamentos -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //Creo la consulta de la tabla Departamentos y la ejecuto guardandola en una variable
                $querysql = "SELECT * FROM Departamento";
                $consulta = $DAW207DBDepartamentos->query($querysql);

                //Almaceno el resultado de fetchAll en una variable usando fetchAll que devuelve un array que contiene todas las filas del conjunto de resultados
                $oResultado = $consulta->fetchAll(PDO::FETCH_ASSOC);//FETCH_ASSOC devuelve un array indexado por los nombres de las columnas del conjunto de resultados.

                ?>
                <!--Creo la tabla para mostrar el contenido de Departamento-->
                <table >
                    <tr>
                       <th>CodDepartamento</th>
                       <th>DescDepartamento</th>
                       <th>FechaBaja</th>
                       <th>VolumenNegocio</th>
                    </tr>
                    <?php
                    //Recorro con un foreach la variable oResultado para mostrar su contenido
                      foreach($oResultado as $mostrar)
                      {
                        echo "<tr>";
                            echo "<td>".$mostrar["CodDepartamento"]."</td>";
                            echo "<td>".$mostrar["DescDepartamento"]."</td>";
                            echo "<td>".$mostrar["FechaBaja"]."</td>";
                            echo "<td>".$mostrar["VolumenNegocio"]."</td>";
                        echo "</tr>";
                      }
                    ?>
                </table>

                <?php

                $numRegistros = $consulta->rowCount();
                echo "<p>Hay ". $numRegistros." registros.</p>";
            
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
        </main>
    </body>
</html>

