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
            a{
                color: green;
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
                echo '<a>Conexion realizada.</a>';
                //Hago la conexion con la base de datos
                $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                
                // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                $DAW207DBDepartamentos -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //Creo la consulta de la tabla Departamentos y la guardo en una variable
                $consulta = "SELECT * FROM Departamento";
                $resultadoConsulta = $DAW207DBDepartamentos->prepare($consulta);//Preparo la consulta
                $resultadoConsulta->execute();//Ejecuto la consulta

                ?>
                
                <!--Creo la tabla para mostrar el contenido de Departamento con fetchObject-->
                <h2>Muestro el contenido con fetchObject</h2>
                <table>
                    <tr>
                        <th>CodDepartamento</th>
                        <th>DescDepartamento</th>
                        <th>FechaBaja</th>
                        <th>VolumenNegocio</th>
                    </tr>
                    <?php
                        $oDepartamento = $resultadoConsulta->fetchObject(); // Obtengo el primer registro de la consulta como un objeto
                        while($oDepartamento) { // Recorro los registros que devuelve la consulta 
                            echo "<tr>";
                                echo "<td>" . $oDepartamento->CodDepartamento . "</td>";// obtengo el valor de CodDepartamento
                                echo "<td>" . $oDepartamento->DescDepartamento . "</td>"; // obtengo el valor de DescDepartamento
                                echo "<td>" . $oDepartamento->FechaBaja . "</td>"; // obtengo el valor de FechaBaja
                                echo "<td>" . $oDepartamento->VolumenNegocio . "</td>"; // obtengo el valor de VolumenNegocio
                            echo "</tr>";
                        $oDepartamento = $resultadoConsulta->fetchObject(); // guardo el registro actual como un objeto y avanzo el puntero al siguiente registro de la consulta 
                        }
                    ?>
                </table>
            
                <?php
                //Hago la conexion con la base de datos
                $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                
                // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                $DAW207DBDepartamentos -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //Creo la consulta de la tabla Departamentos y la ejecuto guardandola en una variable
                $consulta = "SELECT * FROM Departamento";
                $resultadoConsulta2 = $DAW207DBDepartamentos->prepare($consulta);
                $resultadoConsulta2->execute();
                
                //Almaceno el resultado de fetchAll en una variable usando fetchAll que devuelve un array que contiene todas las filas del conjunto de resultados
                $aResultado = $resultadoConsulta2->fetchAll(PDO::FETCH_ASSOC);//FETCH_ASSOC devuelve un array indexado por los nombres de las columnas del conjunto de resultados.
                ?>
                
                <!--Creo la tabla para mostrar el contenido de Departamento con fetchAll-->
                <h2>Muestro el contenido con fetchAll</h2>
                <table>
                    <tr>
                       <th>CodDepartamento</th>
                       <th>DescDepartamento</th>
                       <th>FechaBaja</th>
                       <th>VolumenNegocio</th>
                    </tr>
                    <?php
                    //Recorro con un foreach la variable oResultado para mostrar su contenido
                      foreach($aResultado as $mostrar)
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
                echo '<h2>Muestro el total de registros con rowCount</h2>';
                $numRegistros = $resultadoConsulta2->rowCount();//rowCount() me devuelve el total de registros que se encuentran en la consulta que le he pasado
                echo "<p>Hay ". $numRegistros." registros.</p>";//Muestro los registros de la tabla Departamento
            
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

