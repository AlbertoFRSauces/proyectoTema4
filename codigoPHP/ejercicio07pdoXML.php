<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <link href="../webroot/css/estiloejercicio.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="../webroot/css/img/home.png" type="image/x-icon">
        <title>Ejercicio 07 PDO XML</title>
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
                
                $archivoXML = new DOMDocument("1.0", "utf-8");//Creo el nuevo documento, y le asigno dos valores, la version y la codificacion XML
                $archivoXML -> formatOutput = true;//Le asigno la salida con formato
                
                $archivoXML->load('../tmp/xmlImportado.xml');//Cargo el archivo XML con load
                
                $departamento = $archivoXML->getElementsByTagName('departamento');//Creo el nodo departamento
                
                foreach ($departamento as $valorDepartamento) {
                    $CodDepartamento = $valorDepartamento->getElementsByTagName('codDepartamento')->item(0)->nodeValue;//Busco el elemento con el nombre de etiqueta local dado, una vez tengo el elemento lo almaceno en una variable
                    $DescDepartamento = $valorDepartamento->getElementsByTagName('descDepartamento')->item(0)->nodeValue;//Busco el elemento con el nombre de etiqueta local dado, una vez tengo el elemento lo almaceno en una variable
                    $FechaBaja = ($valorDepartamento->getElementsByTagName('fechaBaja')->item(0)->nodeValue)==''?null:$FechaBaja;//Busco el elemento con el nombre de etiqueta local dado, una vez tengo el elemento lo almaceno en una variable
                    $VolumenNegocio = $valorDepartamento->getElementsByTagName('volumenNegocio')->item(0)->nodeValue;//Busco el elemento con el nombre de etiqueta local dado, una vez tengo el elemento lo almaceno en una variable
                    
                    $resultadoConsulta->bindParam(':CodDepartamento', $CodDepartamento);//Vinculo el parametro CodDepartamento al nombre de variable $CodDepartamento con bindParam
                    $resultadoConsulta->bindParam(':DescDepartamento', $DescDepartamento);//Vinculo el parametro DescDepartamento al nombre de variable $DescDepartamento con bindParam
                    $resultadoConsulta->bindParam(':FechaBaja', $FechaBaja);//Vinculo el parametro FechaBaja al nombre de variable $FechaBaja con bindParam
                    $resultadoConsulta->bindParam(':VolumenNegocio', $VolumenNegocio);//Vinculo el parametro VolumenNegocio al nombre de variable $VolumenNegocio con bindParam
                    
                    $resultadoConsulta->execute();//Ejecuto el select
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
            <p>Ultima actualización: 12/11/2021 10:26</p>
        </footer>
    </body>
</html>

