<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <link href="../webroot/css/estiloejercicio.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="../webroot/css/img/home.png" type="image/x-icon">
        <title>Ejercicio 02 MySQLi</title>
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
            <?php
            /*
             * @author: Alberto Fernandez Ramirez
             * @version: v1.Realizacion del ejercicio
             * Created on: 04-Noviembre-2021
             * Ejercicio 2. Mostrar el contenido de la tabla Departamento y el número de registros.
             */
            //Incluyo las variables de la conexion
            require_once '../config/configDBMySQLi.php';
            
            //Utilizo el metodo connect para establecer la conexion y controlo si se produce un error finalizo la ejecucion
            $DAW207DBDepartamentos = new mysqli();
            $DAW207DBDepartamentos->connect(HOST, USER, PASSWORD, DB);
            
            //Control de error
            $error = $DAW207DBDepartamentos->connect_errno;
            if ($error != 0) {
                echo "<p>Error $error conectando a la base de datos: $DAW207DBDepartamentos->connect_error</p>";
            }
            
            $consulta = 'SELECT * from Departamento';//Definio la variable consulta
            $resultadoConsulta = $DAW207DBDepartamentos->query($consulta);//Ejecuto la consulta sobre la base de datos Departamentos
            
            echo '<h2>Muestro el contenido con fetch_row</h2>';
            $aQuery = $resultadoConsulta->fetch_row();//Obtengo el primer registro de la consulta
            echo '<table>';
                echo '<tr>';
                    echo '<th>CodDepartamento</th>';
                    echo '<th>DescDepartamento</th>';
                    echo '<th>FechaBaja</th>';
                    echo '<th>VolumenNegocio</th>';
                echo '</tr>';
                while($aQuery) {
                    echo '<tr>';
                    foreach ($aQuery as $valor) {//Reccorro el array que contiene la primera consulta
                        echo "<td>$valor</td>";//Imprimo el valor obtenido del array
                    }
                    echo '</tr>';
                    $aQuery = $resultadoConsulta->fetch_row(); //Guardo el registro actual y avanzo el puntero al siguiente registro de la consulta 
                }
            echo '</table>';
            
            //Es necestario ejecutar otra vez la consulta, de lo contrario sale vacia la muestra con el fetch_all
            $resultadoConsulta = $DAW207DBDepartamentos->query($consulta);//Ejecuto la consulta sobre la base de datos Departamentos
            
            echo '<h2>Muestro el contenido con fetch_all</h2>';
            $aQuery = $resultadoConsulta->fetch_all();//Obtengo el primer registro de la consulta
            echo '<table>';
                echo '<tr>';
                    echo '<th>CodDepartamento</th>';
                    echo '<th>DescDepartamento</th>';
                    echo '<th>FechaBaja</th>';
                    echo '<th>VolumenNegocio</th>';
                echo '</tr>';
                foreach ($aQuery as $aFila) {
                    echo '<tr>';
                    foreach ($aFila as $valor) {//Reccorro el array que contiene la primera consulta
                        echo "<td>$valor</td>";//Imprimo el valor obtenido del array
                    }
                    echo '</tr>'; 
                }
            echo '</table>';
            
            echo '<h2>Muestro el total de registros con num_rows</h2>';
            echo '<p>La tabla Departamento contiene '.$resultadoConsulta->num_rows . ' registros.<p>';
            
            $DAW207DBDepartamentos->close();//Cierro la conexion con la base de datos
            ?>
        <footer class="piepagina">
            <a href="../indexProyectoTema4.php"><img src="../webroot/css/img/atras.png" class="imageatras" alt="IconoAtras" /></a>
            <a href="https://github.com/AlbertoFRSauces/proyectoTema4" target="_blank"><img src="../webroot/css/img/github.png" class="imagegithub" alt="IconoGitHub" /></a>
            <p><a>&copy;</a>Alberto Fernández Ramírez 29/09/2021 Todos los derechos reservados.</p>
            <p>Ultima actualización: 12/11/2021 10:26</p>
        </footer>
    </body>
</html>
