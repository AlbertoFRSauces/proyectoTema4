<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <link href="../webroot/css/estiloejercicio.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="../webroot/css/img/home.png" type="image/x-icon">
        <title>Ejercicio 08 PDO JSON</title>
        <style>
            .exportadoCorrectamente{
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
             * Created on: 15-Noviembre-2021
             * Ejercicio 8. Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un fichero departamento.xml. 
             * (COPIA DE SEGURIDAD / EXPORTAR). El fichero exportado se encuentra en el directorio .../tmp/ del servidor. 
             * Si el alumno dispone de tiempo probar distintos formatos de importación - exportación: XML, JSON, CSV, TXT,... 
             * Si el alumno dispone de tiempo probar a exportar e importar a o desde un directorio (a elegir) en el equipo cliente.
             */
            //Incluyo las variables de la conexion
            require_once '../config/configDBPDO.php';
            
            //Consulta para realizar la creacion del archivo JSON a partir de la tabla Departamento
            $consulta = "SELECT * FROM Departamento";//Realizo la consulta a ejecutar
            
            try{
                //Hago la conexion con la base de datos
                $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
            
                // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                $DAW207DBDepartamentos -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $resultadoConsulta=$DAW207DBDepartamentos->prepare($consulta);//Preparo la consulta antes de ejecutarla
                $resultadoConsulta->execute();//Ejecuto la consulta;
                
                $aJson = [];
                
                $oResultado = $resultadoConsulta->fetchObject();//Guardo el primer registro como un objeto
                $numeroDepartamento = 0; //Creo un contador de departamentos
                while($oResultado){//Recorro los registros que devuelve la consulta y obtengo por cada valor su resultado
                    $aDepartamento[$numeroDepartamento]['CodDepartamento'] = $oResultado->CodDepartamento; //Obtengo el valor de CodDepartamento obtenido en la consulta y lo introduzco en el array Departamento
                    $aDepartamento[$numeroDepartamento]['DescDepartamento'] = $oResultado->DescDepartamento; //Obtengo el valor de DescDepartamento obtenido en la consulta y lo introduzco en el array Departamento
                    $aDepartamento[$numeroDepartamento]['FechaBaja'] = $oResultado->FechaBaja; //Obtengo el valor de FechaBaja obtenido en la consulta y lo introduzco en el array Departamento
                    $aDepartamento[$numeroDepartamento]['VolumenNegocio'] = $oResultado->VolumenNegocio; //Obtengo el valor de VolumenNegocio obtenido en la consulta y lo introduzco en el array Departamento
                                    
                    $numeroDepartamento++; //Incremento el contador de departamentos para almacenar informacion el la siguiente posicion
                    
                    $oResultado = $resultadoConsulta->fetchObject();//Guardo el registro actual y avanzo el puntero al siguiente registro que obtengo de la consulta
                }
                
                $json = json_encode($aDepartamento, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);//Codifico el array, JSON_PRETTY_PRINT: Utiliza espacios en blanco para formatear los datos devueltos y JSON_UNESCAPED_UNICODE: Codifica caracteres Unicode multibyte literalmente
                $puntero = fopen("../tmp/jsonExportado.json", "w+"); //Abro el fichero en el que voy a escribir, uso w+ para la apertura para lectura y escritura; coloca el puntero al fichero al principio del fichero y trunca el fichero a longitud cero. Si el fichero no existe se intenta crear.
                fwrite($puntero, $json); //Escribo el archivo en modo binario seguro, se le pasa el puntero que es el recurso y el string a escribir
                                
                echo '<a class="exportadoCorrectamente">Se ha exportado la base de datos en un archivo JSON correctamente.</a>';
                
            }catch(PDOException $excepcion){//Codigo que se ejecuta si hay algun error
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

