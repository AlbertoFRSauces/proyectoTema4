<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <link href="../webroot/css/estiloejercicio.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="../webroot/css/img/home.png" type="image/x-icon">
        <title>Ejercicio 07 PDO JSON</title>
        <style>
            .exitoInsercion{
                color: green;
            }
        </style>
    </head>
    <body>
            <?php
            /*
             * @author: Alberto Fernandez Ramirez
             * @version: v1.Realizacion del ejercicio
             * Created on: 10-Noviembre-2021
             * Ejercicio 7. Página web que toma datos (código y descripción) de un fichero xml y los añade a la tabla Departamento de nuestra base de datos. 
             * (IMPORTAR). El fichero importado se encuentra en el directorio .../tmp/ del servidor.
             */
            //Incluyo las variables de la conexion
            require_once '../config/configDBPDO.php';
            
            try{
                //Hago la conexion con la base de datos
                $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
            
                // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                $DAW207DBDepartamentos -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //Consulta para realizar la insercion de los datos a partir del archivo xml
                $consulta = <<<CONSULTA
                        INSERT INTO Departamento VALUES
                        (:CodDepartamento, :DescDepartamento, :FechaBaja, :VolumenNegocio);
                        CONSULTA;
                $resultadoConsulta=$DAW207DBDepartamentos->prepare($consulta);//Preparo la consulta antes de ejecutarla
                
                $DAW207DBDepartamentos -> beginTransaction();//Desabilito el commit
                
                $archivoJSON = file_get_contents('../tmp/jsonImportado.json');//Cargo el archivo con file_get_contents
                $aDepartamentos = json_decode($archivoJSON);//Decodifico el string en JSON a un array de arrays
                
                
                /*
                 * Por cada departamento, bind de los parámetros y ejecución
                 * del sql.
                 */
                foreach ($aDepartamentos as $valorDepartamento) {//Recorro el array de departamentos
                    $resultadoConsulta->bindParam(':CodDepartamento', $valorDepartamento->CodDepartamento);//Vinculo el parametro CodDepartamento al nombre de variable valorDepartamento->CodDepartamento con bindParam
                    $resultadoConsulta->bindParam(':DescDepartamento', $valorDepartamento->DescDepartamento);//Vinculo el parametro DescDepartamento al nombre de variable valorDepartamento->DescDepartamento con bindParam
                    $resultadoConsulta->bindParam(':FechaBaja', $valorDepartamento->FechaBaja);//Vinculo el parametro FechaBaja al nombre de variable valorDepartamento->FechaBaja con bindParam
                    $resultadoConsulta->bindParam(':VolumenNegocio', $valorDepartamento->VolumenNegocio);//Vinculo el parametro VolumenNegocio al nombre de variable valorDepartamento->VolumenNegocio con bindParam
                    
                    $resultadoConsulta->execute();//Ejecuto la consulta
                }
                
                $DAW207DBDepartamentos->commit();//Si todo ha funcionado hago commit
                
                echo '<a class="exitoInsercion">Se han introducido los datos con éxito.</a>';
                
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
            <p>Ultima actualización: 16/11/2021 20:26</p>
        </footer>
    </body>
</html>

