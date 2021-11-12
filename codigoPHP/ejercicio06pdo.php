<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <link href="../webroot/css/estiloejercicio.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="../webroot/css/img/home.png" type="image/x-icon">
        <title>Ejercicio 06 PDO</title>
        <style>
            .exitoInsercion{
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
             * Created on: 08-Noviembre-2021
             * Ejercicio 6. Pagina web que cargue registros en la tabla Departamento desde un array departamentosnuevos utilizando una consulta preparada. 
             * (Después de programar y entender este ejercicio, modificar los ejercicios anteriores para que utilicen consultas preparadas). 
             * Probar consultas preparadas sin bind, pasando los parámetros en un array a execute.
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
                            (:CodDepartamento,:DescDepartamento,:VolumenNegocio);
                            CONSULTA;
                
                $resultadoConsulta=$DAW207DBDepartamentos->prepare($consulta); // Preparo la consulta antes de ejecutarla
                
                //Inserto en el array parametros los datos a insertar en la consulta
                $aDepartamentosNuevos = [
                    ["CodDepartamento" => "RGT",
                    "DescDepartamento" => "Registro Tera",
                    "VolumenNegocio" => 1000.9],
                    ["CodDepartamento" => "RGS",
                    "DescDepartamento" => "Registro Stargate",
                    "VolumenNegocio" => 42.9],
                    ["CodDepartamento" => "RGV",
                    "DescDepartamento" => "Registro Aerial",
                    "VolumenNegocio" => 10.9]
                ];
            
                $DAW207DBDepartamentos ->beginTransaction();//Desabilito el commit
                
                foreach ($aDepartamentosNuevos as $departamento) {//Recorro los registros que voy a insertar
                    $parametrosConsulta =  [":CodDepartamento" => $departamento['CodDepartamento'],
                                            ":DescDepartamento" => $departamento['DescDepartamento'],
                                            ":VolumenNegocio" => $departamento['VolumenNegocio']];
                    $resultadoConsulta->execute($parametrosConsulta);//Ejecuto la consulta con los parametros
                }
                
                $DAW207DBDepartamentos->commit();//Si todo ha funcionado hago commit
                
                echo '<a class="exitoInsercion">Se han realizado los INSERT con exito en la tabla Departamento</a>';
                
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
                    while($oDepartamento) { //Recorro los registros que devuelve la consulta ?>
                    <tr>
                        <td><?php echo $oDepartamento->CodDepartamento; //Obtengo el valor del codigo del departamento ?></td>
                        <td><?php echo $oDepartamento->DescDepartamento; //Obtengo el valor de la descripcion del departamento ?></td>
                        <td><?php echo $oDepartamento->FechaBaja; //Obtengo el valor de la fecha de baja del departamento ?></td>
                        <td><?php echo $oDepartamento->VolumenNegocio; //Obtengo el valor de la fecha de baja del departamento ?></td>
                    </tr>
                        <?php 
                        $oDepartamento = $resultadoConsulta2->fetchObject(); //Guardo el registro actual como un objeto y avanzo el puntero al siguiente registro de la consulta 
                    }
                    ?>
                </table>
            <?php
            }catch(PDOException $excepcion){//Codigo que se ejecuta si hay algun error
                $DAW207DBDepartamentos->rollBack();//Si hay errores hago rollback
                $errorExcepcion = $excepcion->getCode();//Obtengo el codigo del error y lo almaceno en la variable errorException
                $mensajeException = $excepcion->getMessage();//Obtengo el mensaje del error y lo almaceno en la variable mensajeException
                
                echo "<span style='color: red'>Codigo del error: </span>" . $errorExcepcion;//Muestro el codigo del error
                echo "<span style='color: red'>Mensaje del error: </span>" . $mensajeException;//Muestro el mensaje del error
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

