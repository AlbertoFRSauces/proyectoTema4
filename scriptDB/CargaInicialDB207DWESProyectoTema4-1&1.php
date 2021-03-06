<?php
/**
 * Author:  Alberto Fernandez Ramirez
 * Created: 3 nov. 2021
 * Script carga inicial de base de datos
 */
//Incluyo las variables de la conexion
require_once '../config/configDBPDO.php';

try {
    //Hago la conexion con la base de datos
    $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);

    // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
    $DAW207DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Consulta para realizar la insercion de los datos a partir del archivo xml
    $consulta = <<<CONSULTA
                USE dbs4868800;
                INSERT INTO Departamento (CodDepartamento, DescDepartamento, FechaBaja, VolumenNegocio) VALUES
                ('INF','Departamento de Informatica',null,1.5),
                ('BIO','Departamento de Biologia',null,2.5),
                ('ING','Departamento de Inglés',null,3.5),
                ('LEN','Departamento de Lengua',null,4.5),
                ('MUS','Departamento de Musica',null,1.5);
                CONSULTA;

    $DAW207DBDepartamentos->exec($consulta); //Ejecuto la consulta

    echo '<a class="exitoInsercion">Tabla cargada con éxito.</a>';
} catch (PDOException $excepcion) {//Codigo que se ejecuta si hay algun error
    $errorExcepcion = $excepcion->getCode(); //Obtengo el codigo del error y lo almaceno en la variable errorException
    $mensajeException = $excepcion->getMessage(); //Obtengo el mensaje del error y lo almaceno en la variable mensajeException
    echo "<span style='color: red'>Codigo del error: </span>" . $errorExcepcion; //Muestro el codigo del error
    echo "<span style='color: red'>Mensaje del error: </span>" . $mensajeException; //Muestro el mensaje del error
} finally {
    //Cierro la conexion
    unset($DAW207DBDepartamentos);
}
?>