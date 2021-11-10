<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <title>Ejercicio 05 PDO</title>
        <style>
            p{
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
        <main>
            <?php
            /*
             * @author: Alberto Fernandez Ramirez
             * @version: v1.Realizacion del ejercicio
             * Created on: 08-Noviembre-2021
             * Ejercicio 5. Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, 
             * de tal forma que se añadan los tres registros o no se añada ninguno.
             */
            //Incluyo las variables de la conexion
            require_once '../config/configDBPDO.php';
            
            try{
                //Hago la conexion con la base de datos
                $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
            
                // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                $DAW207DBDepartamentos -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                
                
                //Consulta para realizar la insercion en la tabla Departamento
                $consulta = <<<CONSULTA
                            INSERT INTO Departamento(CodDepartamento,DescDepartamento,VolumenNegocio) VALUES
                                (:CodDepartamento1,:DescDepartamento1,:VolumenNegocio1),
                                (:CodDepartamento2,:DescDepartamento2,:VolumenNegocio2),
                                (:CodDepartamento3,:DescDepartamento3,:VolumenNegocio3);
                            CONSULTA;
                
                $resultadoConsulta=$DAW207DBDepartamentos->prepare($consulta); // Preparo la consulta antes de ejecutarla
                
                //Inserto en el array parametros los datos a insertar en la consulta
                $aParametros = [
                    ":CodDepartamento1" => "PRZ",
                    ":DescDepartamento1" => "Prueba z",
                    ":VolumenNegocio1" => 15.1,
                    ":CodDepartamento2" => "PRX",
                    ":DescDepartamento2" => "Prueba x",
                    ":VolumenNegocio2" => 25.2,
                    ":CodDepartamento3" => "PRC",
                    ":DescDepartamento3" => "Prueba c",
                    ":VolumenNegocio3" => 35.3,
                ];
                
                $DAW207DBDepartamentos ->beginTransaction();//Desabilito el commit
                $resultadoConsulta->execute($aParametros);//Ejecuto la consulta con el array de parametros
                $DAW207DBDepartamentos->commit();//Hago el commit
                
                echo "<p>Se han realizado los INSERT con exito en la tabla Departamento</p>";
                
                $consultaMostrar = "SELECT * FROM Departamento";//Almaceno la consulta
                $resultadoConsulta2=$DAW207DBDepartamentos->prepare($consultaMostrar);//Preparo la consulta
                $resultadoConsulta2->execute(); //Ejecuto la consulta
                
                //MUESTRO LA TABLA DEPARTAMENTO
                ?>
                <table>
                    <tr>
                        <th>CodDepartamento</th>
                        <th>DescDepartamento</th>
                        <th>FechaBaja</th>
                        <th>VolumenNegocio</th>
                    </tr>
                <?php 
                    $oDepartamento = $resultadoConsulta2->fetchObject(); // Obtengo el primer registro de la consulta como un objeto
                    while($oDepartamento) { // recorro los registros que devuelve la consulta de la consulta ?>
                    <tr>
                        <td><?php echo $oDepartamento->CodDepartamento; // obtengo el valor del codigo del departamento del registro actual ?></td>
                        <td><?php echo $oDepartamento->DescDepartamento; // obtengo el valor de la descripcion del departamento del registro actual ?></td>
                        <td><?php echo $oDepartamento->FechaBaja; // obtengo el valor de la fecha de baja del departamento del registro actual ?></td>
                        <td><?php echo $oDepartamento->VolumenNegocio; // obtengo el valor de la fecha de baja del departamento del registro actual ?></td>
                    </tr>
                        <?php 
                        $oDepartamento = $resultadoConsulta2->fetchObject(); // guardo el registro actual como un objeto y avanzo el puntero al siguiente registro de la consulta 
                    }
                    ?>
                </table>
            <?php
                
            }catch(PDOException $excepcion){//Codigo que se ejecuta si hay algun error
                $DAW207DBDepartamentos->rollBack();
                $errorExcepcion = $excepcion->getCode();//Obtengo el codigo del error y lo almaceno en la variable errorException
                $mensajeException = $excepcion->getMessage();//Obtengo el mensaje del error y lo almaceno en la variable mensajeException
                
                echo "<span style='color: red'>Codigo del error: </span>" . $errorExcepcion;//Muestro el codigo del error
                echo "<span style='color: red'>Mensaje del error: </span>" . $mensajeException;//Muestro el mensaje del error
            }finally{
                //Cierro la conexion
                unset($DAW207DBDepartamentos);
            }
            ?>
        </main>
    </body>
</html>
